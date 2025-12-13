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
            return $this->bridge->run('docker_manager.py', ['list']);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'containers' => []
            ];
        }
    }

    public function manage(string $id, string $action): array
    {
        try {
            return $this->bridge->run('docker_manager.py', [$action, $id]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function create(string $image, string $name = null, string $ports = null, string $restart = 'no'): array
    {
        try {
            // "image" "name" "ports" "restart"
            $args = [
                'create',
                $image,
                $name ?: '_',
                $ports ?: '_',
                $restart ?: 'no'
            ];
            return $this->bridge->run('docker_manager.py', $args);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
