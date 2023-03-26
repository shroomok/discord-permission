<?php

namespace Shroomok\DiscordPermission\Listeners;

use Shroomok\DiscordPermission\Contracts\CanCheckDiscordMemberRole;
use Shroomok\DiscordPermission\Events\DiscordLoginSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Shroomok\DiscordPermission\Exceptions\ObjectHasNoMethod;
use Shroomok\DiscordPermission\Models\DiscordRolesCollection;

class SyncDiscordRoles implements ShouldQueue
{
    protected CanCheckDiscordMemberRole $discordRoleChecker;

    protected DiscordRolesCollection $discordRoles;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CanCheckDiscordMemberRole $discordRoleChecker, DiscordRolesCollection $discordRoles)
    {
        $this->discordRoleChecker = $discordRoleChecker;
        $this->discordRoles = $discordRoles;
    }

    /**
     * Handle the event.
     *
     * @param  DiscordLoginSuccess  $event
     * @return void
     */
    public function handle(DiscordLoginSuccess $event)
    {
        $user = $event->user;

        if (!method_exists($user, 'assignRole')) {
            throw new ObjectHasNoMethod($user, 'assignRole');
        }
        if (!method_exists($user, 'givePermissionTo')) {
            throw new ObjectHasNoMethod($user, 'givePermissionTo');
        }

        if (!$this->discordRoles->count()) {
            return;
        }

        foreach($this->discordRoles as $discordRole)
        {
            if (!$this->discordRoleChecker->memberHasRole($event->discordUserId, $discordRole->getName())) {
                continue;
            }

            if ($discordRole->getLaravelRoles()) {
                foreach($discordRole->getLaravelRoles() as $role) {
                    $user->assignRole($role);
                }
            }

            if ($discordRole->getLaravelPermissions()) {
                foreach($discordRole->getLaravelPermissions() as $permission) {
                    $user->givePermissionTo($permission);
                }
            }
        }
    }
}
