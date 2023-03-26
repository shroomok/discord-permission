<?php
namespace Shroomok\DiscordPermission;

use RestCord\DiscordClient;
use RestCord\Model\Permissions\Role;
use RestCord\Model\Guild\GuildMember;
use Shroomok\DiscordPermission\Contracts\CanCheckDiscordMemberRole;

class DiscordMembers implements CanCheckDiscordMemberRole
{
    /** @var DiscordClient */
    protected DiscordClient $client;

    /** @var Role[] */
    protected array $roles = [];

    /** @var GuildMember[] */
    protected array $members = [];

    /**
     * @var int Discord Guild ID
     */
    protected int $guildId;

    /**
     * @param DiscordClient $client
     */
    public function __construct(DiscordClient $client, int $guildId)
    {
        $this->client = $client;
        $this->guildId = $guildId;
    }

    /**
     * @param int $memberId
     * @param string $roleName
     * @return bool
     */
    public function memberHasRole(int $memberId, string $roleName): bool
    {
        $member = $this->getGuildMemberById($memberId);
        $roleId = $this->getRoleIdByName($roleName);

        if (!$roleId) {
            return false;
        }

        if (in_array($roleId, $member->roles)) {
            return true;
        }

        return false;
    }


    /**
     * @param $roleName
     * @return int|null
     */
    protected function getRoleIdByName($roleName): ?int
    {
        $roles = $this->getGuildRoles();
        foreach($roles as $roleObject) {
            if (strtolower($roleName) === strtolower($roleObject->name)) {
                return $roleObject->id;
            }
        }
        return null;
    }

    /**
     * @param false $toReload
     * @return Role[]
     */
    protected function getGuildRoles(bool $toReload = false): array
    {
        if (!$this->roles || $toReload) {
            $this->roles = $this->client->guild->getGuildRoles(['guild.id' => $this->guildId]);
        }
        return $this->roles;
    }

    /**
     * @param int $memberId
     * @param bool $toReload
     * @return GuildMember
     */
    protected function getGuildMemberById(int $memberId, bool $toReload = false): GuildMember
    {
        if (!isset($this->members[$memberId]) || $toReload) {
            $this->members[$memberId] = $this->client->guild->getGuildMember(
                ['guild.id' => $this->guildId, 'user.id' => $memberId]
            );
        }
        return $this->members[$memberId];
    }
}
