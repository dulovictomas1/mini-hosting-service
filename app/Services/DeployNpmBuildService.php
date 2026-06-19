<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;

class DeployNpmBuildService
{
    public function npmrun(string $path, Webspace $webspace)
    {
        $webspace->update([
            'deploy_status' => 'Proces NPM run build beží',
        ]);

        $process = new Process([
            'npm',
            'run',
            'build',            
        ], $path);
        
        $process->setTimeout(1800);

        $process->run();

        /*if (! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }*/

        $webspace->update([
            'deploy_status' => 'Proces Npm run build úspešne dokončený',            
        ]);
    }
}