<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class NginxProvisioningService
{
    public function createVirtualHost(string $domain, string $rootPath): void
    {

        $configPath = "/var/www/html/nginx-sites/{$domain}.conf";

        $config = <<<NGINX
server {

    listen 80;

    server_name {$domain};

    root {$rootPath};

    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.5-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
NGINX;

        if (! File::exists('/var/www/html/nginx-sites')) {
            File::makeDirectory('/var/www/html/nginx-sites', 0755, true);
        }

        File::put($configPath, $config);
    }
}