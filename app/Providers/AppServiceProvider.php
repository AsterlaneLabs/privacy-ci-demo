<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Privacy CI announces the erasure lifecycle. Nothing in the package
        // writes to a log channel, so an application wires it to its own.
        foreach ([
            \PrivacyCI\Lifecycle\Events\DeletionRequested::class,
            \PrivacyCI\Lifecycle\Events\DeletionCancelled::class,
            \PrivacyCI\Lifecycle\Events\DeletionCompleted::class,
            \PrivacyCI\Lifecycle\Events\DeletionFailed::class,
        ] as $event) {
            \Illuminate\Support\Facades\Event::listen($event, \App\Listeners\LogPrivacyEvents::class);
        }

        //
    }
}
