<?php

namespace Modules\Pdf2HtmlModule\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConversionService
{

    protected $pythonPath;
    protected $scriptPath;
    protected $venvPath;
    protected $base_path;

    public function __construct()
    {
        $this->base_path = app()->basePath('./converters');
        $this->venvPath = app()->basePath('./converters/venv');
        $venvBinPath = 'bin';
        $this->pythonPath = $this->venvPath . DIRECTORY_SEPARATOR . $venvBinPath . DIRECTORY_SEPARATOR . 'python';
        $this->scriptPath = $this->base_path . DIRECTORY_SEPARATOR . 'pdf2html.py';
    }

    public function performAction($params = null)
    {
        $arguments = [$params['path'], $params['output']];

        if (!file_exists($this->venvPath)) {
            $setupResult = $this->setupVirtualEnv();
            if (!$setupResult['success']) {
                return $setupResult;
            }
        }

        $command = array_merge([$this->pythonPath, $this->scriptPath], $arguments);

        $process = new Process($command);
        $process->setWorkingDirectory($this->base_path);
        $process->setTimeout(null);

        $env = $this->getEnvironmentVars();
        $process->setEnv($env);

        try {
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            return [
                'success' => true,
                'output' => $process->getOutput(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'output' => $process->getErrorOutput(),
            ];

        }
    }

    protected function setupVirtualEnv()
    {
        try {
            // Crear el entorno virtual
            $process = new Process(['python3', '-m', 'venv', 'venv']);
            $process->setWorkingDirectory($this->base_path);
            $process->setTimeout(null); // Las instalaciones pueden llevar tiempo
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Instalar dependencias
            $pipPath = $this->venvPath . DIRECTORY_SEPARATOR .
                      (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'Scripts' : 'bin') .
                      DIRECTORY_SEPARATOR . 'pip';

            $process = new Process([$pipPath, 'install', '-r', $this->base_path  . DIRECTORY_SEPARATOR .'requirements.txt']);
            $process->setWorkingDirectory($this->base_path);
            $process->setTimeout(null);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return [
                'success' => true,
                'message' => 'Virtual environment created and dependencies installed',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => "Error setting up virtual environment: " . $e->getMessage(),
            ];
        }
    }

    protected function getEnvironmentVars()
    {
        $env = getenv();

        $pathSeparator = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? ';' : ':';
        $venvBinPath = $this->venvPath . DIRECTORY_SEPARATOR .
                       (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'Scripts' : 'bin');

        $env['PATH'] = $venvBinPath . $pathSeparator . ($env['PATH'] ?? '');
        $env['VIRTUAL_ENV'] = $this->venvPath;

        return $env;
    }
}
