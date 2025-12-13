<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DockerService;

class DockerController extends Controller
{
    protected DockerService $docker;

    public function __construct(DockerService $docker)
    {
        $this->docker = $docker;
    }

    public function action(Request $request, $id, $action)
    {
        // Permission check? 
        // For now restrict to Admin or Dev
        if (!auth()->user()->isAdmin() && !auth()->user()->hasRole('dev')) {
            abort(403);
        }

        if (!in_array($action, ['start', 'stop', 'restart'])) {
            abort(400, 'Invalid action');
        }

        $result = $this->docker->manage($id, $action);

        if (isset($result['error'])) {
            return back()->with('error', 'Docker Error: ' . $result['message']);
        }

        \App\Services\AuditLogger::log("docker.{$action}", "Container: {$id}");

        return back()->with('success', $result['message'] ?? 'Action completed.');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->hasRole('dev')) {
            abort(403);
        }

        $validated = $request->validate([
            'image' => 'required|string',
            'name' => 'nullable|string',
            'ports' => 'nullable|string|regex:/^\d+:\d+$/', // e.g. 8080:80
        ]);

        $result = $this->docker->create(
            $validated['image'],
            $validated['name'],
            $validated['ports']
        );

        if (isset($result['error'])) {
            return back()->with('error', 'Docker Error: ' . $result['message']);
        }

        \App\Services\AuditLogger::log("docker.create", "Image: {$validated['image']}");

        return back()->with('success', $result['message']);
    }
}
