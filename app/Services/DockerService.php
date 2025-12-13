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

    public function create(string $image, string $name = null, string $ports = null): array
    {
        try {
            // "image" "name" "ports"
            $args = [
                'create',
                $image,
                $name ?: '_',
                $ports ?: '_'
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
