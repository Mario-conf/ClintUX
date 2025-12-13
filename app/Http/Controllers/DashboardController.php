<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SystemHealth;
use App\Services\DockerService;

class DashboardController extends Controller
{
    protected SystemHealth $health;
    protected DockerService $docker;

    public function __construct(SystemHealth $health, DockerService $docker)
    {
        $this->health = $health;
        $this->docker = $docker;
    }

    public function index()
    {
        $stats = $this->health->getStats();
        $containers = $this->docker->listContainers();
        if (isset($containers['error'])) {
            $containers = [];
        }

        // Get apps visible to user
        $user = auth()->user();
        $apps = \App\Models\App::where('active', true)
            ->where(function ($query) use ($user) {
                $query->whereNull('role_id')
                    ->orWhere('role_id', $user->role_id);
                // If user is admin, show all? Or stick to role?
                if ($user->isAdmin()) {
                    $query->orWhereNotNull('role_id');
                }
            })
            ->get();

        return view('dashboard.index', compact('stats', 'containers', 'apps'));
    }
}
