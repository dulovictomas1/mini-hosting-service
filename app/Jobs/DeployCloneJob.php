<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\DeployCloneService;

use App\Models\Webspace;

class DeployCloneJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $path,
        public string $giturl,
        public int $webspaceId,
    ) {}

    public function handle(DeployCloneService $deployCloneService): void
    {
        
        $webspace = Webspace::findOrFail($this->webspaceId);

        $deployCloneService->clone($this->path, $this->giturl, $webspace);
    }
}