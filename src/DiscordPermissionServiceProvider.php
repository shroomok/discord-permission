<?php
namespace Shroomok\DiscordPermission;

use RestCord\DiscordClient;
use Illuminate\Support\ServiceProvider;
use Shroomok\DiscordPermission\Contracts\CanCheckDiscordMemberRole;
use Shroomok\DiscordPermission\Models\DiscordRolesCollection;
use Shroomok\DiscordPermission\Providers\EventServiceProvider;

class DiscordPermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);

    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/discord_permission.php' => config_path('discord_permission.php'),
            ], 'config');
        }

        $this->app->singleton(DiscordRolesCollection::class, function() {
            return DiscordRolesCollection::fromArray(config('discord_permission.roles_map') ?? []);
        });

        $this->app->singleton(CanCheckDiscordMemberRole::class, function(){
            return new DiscordMembers($this->app->get(DiscordClient::class), (int)config('discord_permission.guild_id'));
        });
    }

}
