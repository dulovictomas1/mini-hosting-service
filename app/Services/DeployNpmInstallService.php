<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;

class DeployNpmInstallService
{
    public function npminstal(string $path, Webspace $webspace)
    {
        $webspace->update([
            'deploy_status' => 'Proces NPM install beží',
        ]);

        $process = new Process([
            'npm',
            'install',
            '--cache',
            '/var/www/.npm',
        ], $path);
        $process->setTimeout(1800);

        $process->run();

        /*if (! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }*/

        $webspace->update([
            'deploy_status' => 'Proces Npm install úspešne dokončený',            
        ]);
    }
}