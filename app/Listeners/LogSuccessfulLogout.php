<?php

namespace App\Listeners;

use App\Services\ActivityLoggerService;

class LogSuccessfulLogout
{
    public function handle(object $event): void
    {
        app(ActivityLoggerService::class)->logLogout();
    }
}
