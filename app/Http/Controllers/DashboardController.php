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

        return view('dashboard.index', compact('stats', 'containers'));
    }
}
