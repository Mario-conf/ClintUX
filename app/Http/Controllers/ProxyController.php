<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function __invoke(Request $request, $slug, $path = null)
    {
        $app = App::where('slug', $slug)->firstOrFail();

        // 1. Authorization Gate
        if (!$app->active) {
            abort(404);
        }

        if ($app->role_id) {
            // If app has role restriction, user must have that role
            if (! $request->user()->active || $request->user()->role_id !== $app->role_id) {
                // Alternatively check if user is admin?
                // For now, strict match or Admin override
                if (!$request->user()->isAdmin()) {
                    abort(403);
                }
            }
        }

        // 2. Construct Target URL
        // $path comes from route parameter, but might be empty or missing query params
        $targetUrl = rtrim($app->url, '/') . '/' . ($path ?? '');

        // Append query string if any
        if ($request->getQueryString()) {
            $targetUrl .= '?' . $request->getQueryString();
        }

        // 3. Forward Request
        // We use Laravel Http Client. Note: This is simple forwarding.
        // Complex apps (websockets, absolute path assets) might break without URL rewriting.

        $method = $request->method();
        $headers = $request->header();

        // Filter headers to avoid conflicts (Host, etc)
        $headersToForward = collect($headers)->only(['content-type', 'user-agent', 'accept'])->toArray();

        try {
            $response = Http::withHeaders($headersToForward)
                ->send($method, $targetUrl, [
                    'body' => $request->getContent(),
                    // 'allow_redirects' => false, // Let client handle redirects?
                ]);

            return response($response->body(), $response->status())
                ->withHeaders($response->headers());
        } catch (\Exception $e) {
            // If internal service is down
            return response()->view('errors.proxy_error', ['message' => $e->getMessage()], 502);
        }
    }
}
