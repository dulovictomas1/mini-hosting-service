<?php

namespace App\Services;

use App\Models\User;
use App\Models\Webspace;
use Illuminate\Support\Str;

class WebspaceService
{
    public function __construct(
        protected WebspaceProvisioningService $webspaceprovisioningservice
    )
    {
        //
    }

    public function createForUser(User $user, string $domain)
    {
        $slug = Str::slug(str_replace('.', '-', $domain), '_');

        $path = '/Applications/XAMPP/xamppfiles/htdocs/clients/user_' . $user->id . '/' . $slug;

        $this->webspaceprovisioningservice->createDirectory($path);

        return Webspace::create([
            'user_id' => $user->id,
            'domain' => $domain,
            'path' => $path,
            'status' => 'active',
        ]);
    }
}