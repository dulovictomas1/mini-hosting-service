<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\DeployCloneService;

class DeployCloneJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $path,
        public string $giturl,
    ) {}

    public function handle(DeployCloneService $deployCloneService): void
    {
        $deployCloneService->clone($this->path, $this->giturl);
    }
}