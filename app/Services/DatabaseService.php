<?php

namespace App\Services;
use App\Models\Database;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Crypt;

class DatabaseService
{
    public function __construct(
        protected DatabaseProvisioningService $databaseprovisioningservice
    )
    {
        //
    }


    public function createForUser(User $user, string $name, string $charset, string $collation): array
    {
        if (! $user->plan) {
            throw new Exception('Používateľ nemá zvolený plán.');
        }

        if ($user->databases()->count() >= $user->plan->database_limit) {
            throw new Exception('Dosiahli ste limit databáz pre váš plán.');
        }

        $normalizedName = Str::lower($name);
        $databaseName = 'db_' . $user->id . '_' . $normalizedName;
        $databaseUser = 'usr_' . $user->id . '_' . $normalizedName;

        $databasePassword = Str::password(16);

        $this->databaseprovisioningservice->createDatabase(
            $databaseName,
            $databaseUser,
            $databasePassword,
            $charset,
            $collation
        );

        //Add crypt pass for next use
        $database = Database::create([
            'user_id' => $user->id,
            'database_name' => $databaseName,
            'database_user' => $databaseUser,
            'charset' => $charset,
            'collation' => $collation,
            'database_password' => Crypt::encryptString($databasePassword),
            'status' => 'active',
        ]);

        return [
            'database' => $database,
            'password' => $databasePassword,
        ];
    }
}