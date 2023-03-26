<?php
namespace Shroomok\DiscordPermission\Models;

final class DiscordRole
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string[]
     */
    private array $laravelRoles;
    /**
     * @var string[]
     */
    private array $laravelPermissions;

    /**
     * @param string $name
     * @param array $laravelRoles
     * @param array $laravelPermissions
     */
    public function __construct(string $name, array $laravelRoles = [], array $laravelPermissions = [])
    {
        $this->name = $name;
        $this->laravelRoles = $laravelRoles;
        $this->laravelPermissions = $laravelPermissions;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getLaravelRoles(): array
    {
        return $this->laravelRoles;
    }

    /**
     * @return string[]
     */
    public function getLaravelPermissions(): array
    {
        return $this->laravelPermissions;
    }
}