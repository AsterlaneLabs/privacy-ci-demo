<?php

namespace App\Privacy;

use App\Models\AuditEntry;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use PrivacyCI\Policy\PrivacyPolicy;

class UserPrivacyPolicy extends PrivacyPolicy
{
    public function configure(): void
    {
        $this->subject(User::class);

        $this->delete(User::class);
        $this->anonymize(Comment::class, ['user_id' => null, 'author_ip' => null]);
        $this->anonymize(AuditEntry::class, ['actor_id' => null]);
        // The order itself is kept for accounting. The link to the person is
        // not, which is anonymisation rather than retention.
        $this->anonymize(Order::class, ['user_id' => null])
            ->reason('order retained for statutory accounting, 7 years; buyer link removed');
        $this->delete('legacy_profiles');
        $this->delete('recommendation_events');
        $this->delete('sessions');
        $this->delete('password_reset_tokens');

        $this->ignore('newsletter_signups')
            ->reason('marketing list with its own consent lifecycle');

        $this->deleteCache('user:{id}');
        $this->deleteStorage('avatars/{id}.png', disk: 'local');
    }
}
