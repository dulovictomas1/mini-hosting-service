<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\DeployComposerService;

use App\Models\Webspace;

class DeployComposerJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $path,
        public int $webspaceId,
    ) {}

    public function handle(DeployComposerService $deployComposerService): void
    {
        
        $webspace = Webspace::findOrFail($this->webspaceId);

        $deployComposerService->composer($this->path, $webspace);
    }
}