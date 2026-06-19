<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;

class DeployComposerService
{
    public function composer(string $path, Webspace $webspace)
    {
        $webspace->update([
            'deploy_status' => 'Proces beží',
        ]);

        $process = new Process([            
            'composer',
            'install',            
            '--no-dev',
        ]);

        //$process->setTimeout(600);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $webspace->update([
            'deploy_status' => 'Proces úspešne dokončený',
        ]);
    }
}