<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\DeployNpmInstallService;

use App\Models\Webspace;

class DeployNpmInstallJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $path,
        public int $webspaceId,
    ) {}

    public function handle(DeployNpmInstallService $deployNpmInstallService): void
    {
        
        $webspace = Webspace::findOrFail($this->webspaceId);

        $deployNpmInstallService->npminstal($this->path, $webspace);
    }
}