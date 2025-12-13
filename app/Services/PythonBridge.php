<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonBridge
{
    protected string $scriptsPath;

    public function __construct()
    {
        $this->scriptsPath = base_path('server_scripts');
    }

    public function run(string $scriptName, array $args = []): array
    {
        $command = array_merge(['python3', $this->scriptsPath . '/' . $scriptName], $args);
        
        // Use 'python' instead of 'python3' if on Windows/Laragon for dev
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
             $command[0] = 'python';
        }

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();
        return json_decode($output, true) ?? ['error' => 'Invalid JSON output'];
    }
}
