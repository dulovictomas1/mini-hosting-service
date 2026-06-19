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
    //Nastavenie ENV súboru a KEY
    public function setup( string $dbname, string $dbuser, string $dbpassword, string $path)
    {       
        $envPath = $path . '/.env';
        $envExamplePath = $path . '/.env.example';

        if (! File::exists($envPath)) {
            File::copy($envExamplePath, $envPath);
        }

        $env = File::get($envPath);

        if (! str_contains($env, 'APP_KEY=')) {
            $env = "APP_KEY=\n" . $env;
        }


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

        $env = str_replace(
            'CACHE_STORE=database',
            'CACHE_STORE=file',
            $env
        );

        File::put(
            $envPath,
            $env
        );


        $clear = new Process([
            'php',
            'artisan',
            'optimize:clear',
        ], $path);

        $clear->run();

        $process = new Process([
            'php',
            'artisan',
            'key:generate',
            '--show',
        ], $path);

        $process->run();

        //$process->setTimeout(600);

        $key = trim($process->getOutput());

        $env = preg_replace('/^APP_KEY=.*/m', 'APP_KEY=' . $key, $env);
        File::put($envPath, $env);        

        if (! $process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }
        
    }

    //Spustenie migrácii
    /*public function migrate(string $path)
    {

        $clear = new Process([
            'php',
            'artisan',
            'optimize:clear',
        ], $path);

        $clear->setTimeout(600);

        $clear->run();

        $process = new Process([
            'php',
            'artisan',
            'migrate:status',
        ], $path);

        $process->setTimeout(600);

        $process->run();

        $proces2 = new Process([
            'php',
            'artisan',
            'migrate',
            '--force',
        ], $path);

        $proces2->setTimeout(600);

        $proces2->run();


        //dd($process->getOutput());

        if (! $process->isSuccessful()) {
            throw new Exception(
                $process->getOutput() . "\n" . $process->getErrorOutput()
            );
        }

        if (! $proces2->isSuccessful()) {
            throw new Exception(
                $proces2->getOutput() . "\n" . $proces2->getErrorOutput()
            );
        }

        return $proces2->getOutput();

    }*/

        public function migrate(string $path)

{

    $status = new Process([

        'php',

        'artisan',

        'migrate:status',

    ], $path);

    $status->run();

    $migrate = new Process([

        'php',

        'artisan',

        'migrate',

        '--force',

        '-vvv',

    ], $path);

    $migrate->setTimeout(600);

    $migrate->run();

    $statusAfter = new Process([

        'php',

        'artisan',

        'migrate:status',

    ], $path);

    $statusAfter->run();

    dd(

        'PATH: ' . $path,

        'STATUS BEFORE OUTPUT:',

        $status->getOutput(),

        'STATUS BEFORE ERROR:',

        $status->getErrorOutput(),

        'MIGRATE OUTPUT:',

        $migrate->getOutput(),

        'MIGRATE ERROR:',

        $migrate->getErrorOutput(),

        'STATUS AFTER OUTPUT:',

        $statusAfter->getOutput(),

        'STATUS AFTER ERROR:',

        $statusAfter->getErrorOutput(),

    );

}
}