<?php
namespace Shroomok\DiscordPermission\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Shroomok\DiscordPermission\Events\DiscordLoginSuccess;
use Shroomok\DiscordPermission\Listeners\SyncDiscordRoles;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DiscordLoginSuccess::class => [
            SyncDiscordRoles::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
