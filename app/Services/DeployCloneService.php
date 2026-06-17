<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;

class DeployCloneService
{
    public function clone(string $path, string $giturl)
    {
        $process = new Process([
            'git',
            'clone',
            $giturl,
            '.',
        ], $path);

        $process->setTimeout(600);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}