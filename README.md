# Discord Permission for Laravel

This package automatically grants permissions to Laravel users based on their roles in Discord Guild (Server).

## Requirements
- PHP >= 8.1
- Laravel >= 9.0
- [spatie/laravel-permissions](https://github.com/spatie/laravel-permission) >= 5.9
- [restcord/restcord](https://github.com/restcord/restcord)

## Installation

```shell
composer require shroomok/discord-permission
```

### .env
```
DISCORD_GUILD=<ID OF YOUR DISCORD GUILD (SERVER)>
```

### Configure mapping between Discord roles and Laravel permissions/roles: config/discord_permission.php

```shell
php artisan vendor:publish --provider="Shroomok\DiscordPermission\DiscordPermissionServiceProvider" --tag="config"
```

```php
'roles_map' => [
        [
            'discord_role' => 'moderator',
            'laravel_roles' => ['moderator', 'editor']
        ],
        [
            'discord_role' => 'donator',
            'laravel_permissions' => ['access premium content']
        ]
    ]
```

### Finally, register DiscordClient dependency in app/Providers/AppServiceProvider.php 
```php
namespace App\Providers;
...
use RestCord\DiscordClient;

class AppServiceProvider extends ServiceProvider
{
      ...
      
      public function register()
      {
          $this->app->singleton(DiscordClient::class, function(){
              // token definitely better to retrieve from config like: 'token' => config('services.discord.bot_token')
              return new DiscordClient(['token' => 'DISCORD BOT TOKEN']);
          });
      }
      
      ...
}
```

## Queued Event Listener
Synchronization with discord happens within `SyncDiscordRoles` listener which is queueable. Don't forget to start worker `php artisan queue:work` if your `QUEUE_CONNECTION` is not `sync`

## Usecase
For example, you are running web application based on Laravel framework. Also, you have Discord community related to this website. And you've already implemented login via Discord OAuth. Users, who have Discord account, are able to sign in into your web app. Now you want to share with your Community members something special. But with specific users only. Or these users are moderators in your Discord Guild already, and it would be nice to grant them same permissions in Laravel app... At this point DiscordPermission package can make your life easier! 

## How it works
It interacts with Discord API to get data about specific guild, members, and their roles via [restcord/restcord](https://github.com/restcord/restcord).

Manipulations with roles and permissions within Laravel app are done via [spatie/laravel-permissions](https://github.com/spatie/laravel-permission)

Main logic consists of `DiscordLoginSuccess event` and `SyncDiscordRoles listener`. 

`DiscordLoginSuccess event` should be dispatched when User finished authentication via Discord and application retrieved discord_id.

`SyncDiscordRoles listener` interacts with Discord API to check the role of passed User and then assign (or not) Laravel roles and/or permissions. It implements `ShouldQueue` interface to make it possible to run it as a worker in background and not not overwhelm user during login.

User object could be any object with `assignRole(string $role)` and `givePermissionTo(string $permission)` methods. 

Basically, it must use 'HasRoles' trait from [spatie/laravel-permissions](https://github.com/spatie/laravel-permission) package.

## Credits

Built with love by [Shroomok](https://shroomok.com)

<a href="https://www.buymeacoffee.com/shroomok" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-blue.png" alt="Buy Me A Coffee" style="height: 41px !important;width: 174px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" ></a>

Peace 🍄

