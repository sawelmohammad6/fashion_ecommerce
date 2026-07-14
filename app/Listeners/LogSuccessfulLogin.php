<?php

namespace App\Listeners;

use App\Services\ActivityLoggerService;

class LogSuccessfulLogin
{
    public function handle(object $event): void
    {
        app(ActivityLoggerService::class)->logLogin();
    }
}
