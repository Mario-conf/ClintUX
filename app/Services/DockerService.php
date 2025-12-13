<?php

namespace App\Services;

class DockerService
{
    protected PythonBridge $bridge;

    public function __construct(PythonBridge $bridge)
    {
        $this->bridge = $bridge;
    }

    public function listContainers(): array
    {
        try {
            return $this->bridge->run('docker_manager.py');
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'containers' => []
            ];
        }
    }
}
