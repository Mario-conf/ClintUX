<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PythonBridge;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditLogger;

class SystemController extends Controller
{
    protected PythonBridge $python;

    public function __construct(PythonBridge $python)
    {
        $this->python = $python;
    }

    public function power(Request $request, $action)
    {
        // 1. Authorize: Admin only
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // 2. Confirm Password
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect password.'],
            ]);
        }

        if (!in_array($action, ['shutdown', 'reboot'])) {
            abort(400);
        }

        // 3. Execute Script
        $result = $this->python->run('power.py', [$action]);

        // 4. Log Action
        AuditLogger::log("system.{$action}", "Host Server");

        if (isset($result['error'])) {
            return back()->with('error', 'System Error: ' . $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
