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

        return back()->with('success', $result['message'] ?? 'Action completed.');
    }
}
