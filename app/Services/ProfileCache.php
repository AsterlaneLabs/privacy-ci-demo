<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProfileCache
{
    public function warm($user): void
    {
        // Personal data leaving the database entirely. No migration describes
        // either of these.
        Cache::put("user:{$user->id}", $user->only(['name', 'email']), 3600);
        Storage::disk('local')->put("avatars/{$user->id}.png", '');
    }

    /** Keyed on an order, not a person. Should not be reported. */
    public function warmOrder($order): void
    {
        Cache::put("order:{$order->id}", $order->toArray(), 600);
    }
}
