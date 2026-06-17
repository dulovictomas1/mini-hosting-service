<?php

namespace App\Services;

use App\Models\User;
use App\Models\Webspace;
use Illuminate\Support\Str;

class WebspaceService
{
    public function __construct(
        protected WebspaceProvisioningService $webspaceprovisioningservice,
        protected NginxProvisioningService $nginxprovisioningservice,
    )
    {
        //
    }

    public function createForUser(User $user, string $domain, string $type)
    {
        $slug = Str::slug(str_replace('.', '-', $domain), '_');

        $path = '/var/www/html/clients/user_' . $user->id . '/' . $slug;

        if ($type === 'laravelapp') {
            $path .= '/public';
        }

        $this->webspaceprovisioningservice->createDirectory($path);

        $this->nginxprovisioningservice->createVirtualHost(
            domain: $domain,
            rootPath: $path,
        );

        $this->nginxprovisioningservice->enableVirtualHost($domain);

        return Webspace::create([
            'user_id' => $user->id,
            'domain' => $domain,
            'path' => $path,
            'type' => $type,
            'status' => 'active',
        ]);
    }
}