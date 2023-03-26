<?php

namespace Shroomok\DiscordPermission\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscordLoginSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * It should be model with method assignRole
     * In most cases it is a User model with hasRoles trait
     * @var object
     */
    public object $user;

    public int $discordUserId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(object $user, int $discordUserId)
    {
        $this->user = $user;
        $this->discordUserId = $discordUserId;
    }
}
