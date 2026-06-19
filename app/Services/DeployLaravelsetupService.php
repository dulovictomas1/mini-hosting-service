<?php

namespace App\Services;
use App\Models\Webspace;
use App\Models\Database;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class DeployLaravelsetupService
{
    public function setup( string $dbname, string $dbuser, string $dbpassword, string $path)
    {       
        $envPath = $path . '/.env';
        $envExamplePath = $path . '/.env.example';

        if (! File::exists($envPath)) {
            File::copy($envExamplePath, $envPath);
        }

        $env = File::get($envPath);


        $env = str_replace(
            '# DB_HOST=127.0.0.1',
            'DB_HOST=127.0.0.1',
            $env
        );

        $env = str_replace(
            '# DB_PORT=3306',
            'DB_PORT=3306',
            $env
        );

        $env = str_replace(
            'DB_CONNECTION=sqlite',
            'DB_CONNECTION=' . 'mysql',
            $env
        );

        $env = str_replace(
            '# DB_DATABASE=laravel',
            'DB_DATABASE=' . $dbname,
            $env
        );

        $env = str_replace(
            '# DB_USERNAME=root',
            'DB_USERNAME=' . $dbuser,
            $env
        );

        $env = str_replace(
            '# DB_PASSWORD=',
            'DB_PASSWORD=' . Crypt::decryptString($dbpassword),
            $env
        );

        File::put(
            $envPath,
            $env
        );
        

        $process = new Process([                   
            'php',
            'artisan',            
            'key:generate',
            '--force',
        ], $path);

        //$process->setTimeout(600);

        $process->run();

        dd(
            $process->getOutput(),
            $process->getErrorOutput()
        );

        if (! $process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }
        
    }
}