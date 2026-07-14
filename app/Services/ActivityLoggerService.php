<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLoggerService
{
    public function log(string $action, string $module, ?string $description = null): ActivityLog
    {
        $request = request();

        return ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'module'     => $module,
            'description'=> $description,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    public function logLogin(): void
    {
        $this->log('Login', 'Authentication', auth()->user()?->name . ' logged in.');
    }

    public function logLogout(): void
    {
        $this->log('Logout', 'Authentication', auth()->user()?->name . ' logged out.');
    }
}
