<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\Database;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Crypt;

class DeployLaravelsetupService
{
    public function setup( string $dbname, string $dbuser, string $dbpassword, string $path)
    {        
        copy(
            $path . '/.env.example',
            $path . '/.env'
        );

        $env = file_get_contents($path . '/.env');

        $env = str_replace(
            'DB_DATABASE=laravel',
            'DB_DATABASE=' . $dbname,
            $env
        );

        $env = str_replace(
            'DB_USERNAME=root',
            'DB_USERNAME=' . $dbuser,
            $env
        );

        $env = str_replace(
            'DB_PASSWORD=',
            'DB_PASSWORD=' . Crypt::decryptString($dbpassword),
            $env
        );

        $env = file_put_contents(
            $path . '/.env',
            $env
        );
        

        $process = new Process([            
            'php',
            'artisan',            
            'key:generate',
        ], $path);

        $process->setTimeout(600);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }
        
    }
}