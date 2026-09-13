<?php

declare(strict_types=1);

namespace App\Privacy;

use App\Models\AuditEntry;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use PrivacyCI\Policy\PrivacyPolicy;

/**
 * Hand written, not generated. `privacy:make-policy` produced the first draft
 * and refuses to overwrite this without --force.
 */
final class UserPrivacyPolicy extends PrivacyPolicy
{
    public function configure(): void
    {
        $this->subject(User::class);

        // Mask the person out of the row instead of deleting it, so orders and
        // comments keep pointing somewhere.
        // Masked to placeholders, not to null: these columns are NOT NULL, and
        // email is unique, so every erased subject needs a distinct value.
        $this->anonymize(User::class, [
            'name' => 'Deleted user',
            'email' => 'deleted@example.invalid',
            'password' => '',
            'remember_token' => '',
        ]);
        $this->delete('legacy_profiles');
        $this->delete('recommendation_events');
        $this->delete('sessions');
        $this->delete('password_reset_tokens');

        $this->anonymize(Comment::class, ['user_id' => null, 'author_ip' => null]);
        $this->anonymize(AuditEntry::class, ['actor_id' => null]);

        // The order is kept for accounting. The link to the person is not,
        // which is anonymisation rather than retention.
        $this->anonymize(Order::class, ['user_id' => null])
            ->reason('order retained for statutory accounting, 7 years; buyer link removed');

        $this->ignore('newsletter_signups')
            ->reason('marketing list with its own consent lifecycle');

        $this->deleteCache('user:{id}');
        $this->deleteStorage('avatars/{id}.png', disk: 'local');
    }
}
