<?php
namespace Shroomok\DiscordPermission\Contracts;

interface CanCheckDiscordMemberRole
{
    /**
     * @param int $memberId
     * @param string $roleName
     * @return bool
     */
    public function memberHasRole(int $memberId, string $roleName): bool;
}
