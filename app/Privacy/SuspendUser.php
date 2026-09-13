<?php

namespace App\Privacy;

use App\Models\User;
use PrivacyCI\Lifecycle\DeletionRequest;
use PrivacyCI\Lifecycle\SubjectSuspender;

class SuspendUser implements SubjectSuspender
{
    public function suspend(DeletionRequest $request): void
    {
        User::whereKey($request->subjectId)->update(['name' => '[closing]']);
        // A real application would also revoke sessions, hide the profile and
        // drop the subject from marketing sends and search indexes.
    }

    public function reactivate(DeletionRequest $request): void
    {
        User::whereKey($request->subjectId)->update(['name' => 'Restored']);
    }
}
