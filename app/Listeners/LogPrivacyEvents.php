<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

/** Shows the events reaching an application's own logging. */
class LogPrivacyEvents
{
    public function handle(object $event): void
    {
        Log::info(class_basename($event), [
            'subject' => $event->request->subjectType.':'.$event->request->subjectId,
            'status' => $event->request->status->value,
            'policy' => $event->request->policyFingerprint,
        ]);
    }
}
