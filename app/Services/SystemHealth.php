<?php

namespace App\Services;

class SystemHealth
{
    protected PythonBridge $bridge;

    public function __construct(PythonBridge $bridge)
    {
        $this->bridge = $bridge;
    }

    public function getStats(): array
    {
        try {
            return $this->bridge->run('monitor.py');
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'cpu_percent' => 0,
                'memory_percent' => 0,
                'disk_percent' => 0
            ];
        }
    }
}
