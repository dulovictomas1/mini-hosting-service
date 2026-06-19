<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\DeployNpmBuildService;

use App\Models\Webspace;

class DeployNpmBuildJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $path,
        public int $webspaceId,
    ) {}

    public function handle(DeployNpmBuildService $deployNpmBuildService): void
    {
        
        $webspace = Webspace::findOrFail($this->webspaceId);

        $deployNpmBuildService->npmrun($this->path, $webspace);
    }
}