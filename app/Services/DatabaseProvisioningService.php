<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class DatabaseProvisioningService
{
    public function createDatabase( string $databaseName, string $databaseUser, string $databasePassword, string $charset, string $collation ): void {

        DB::statement("CREATE DATABASE `$databaseName` CHARACTER SET $charset COLLATE $collation");

        DB::statement("CREATE USER '$databaseUser'@'localhost' IDENTIFIED BY '$databasePassword'");

        DB::statement("GRANT ALL PRIVILEGES ON `$databaseName`.* TO '$databaseUser'@'localhost'");

        DB::statement("FLUSH PRIVILEGES");

    }

}