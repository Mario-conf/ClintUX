<?php

namespace App\Services;

use App\Models\Audit;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(string $action, string $target = null, array $details = [])
    {
        try {
            Audit::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'target' => $target,
                'ip_address' => Request::ip(),
                'details' => $details,
            ]);
        } catch (\Exception $e) {
            // Fail silently or log to file to ensure app doesn't break if audit fails
            \Log::error('Audit log failed: ' . $e->getMessage());
        }
    }
}
