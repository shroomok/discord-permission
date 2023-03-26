<?php
namespace Shroomok\DiscordPermission\Models;

final class DiscordRolesCollection implements \Iterator
{
    private int $position = 0;

    /**
     * @var DiscordRole[]
     */
    private array $items = [];

    /**
     * @param array $roles
     * @return DiscordRolesCollection
     */
    public static function fromArray(array $roles)
    {
        $collection = new self();
        if ($roles) {
            foreach($roles as $role) {
                $collection->add(new DiscordRole(
                    $role['discord_role'],
                    $role['laravel_roles'] ?? [],
                    $role['laravel_permissions'] ?? []
                ));
            }
        }
        return $collection;
    }

    public function add(DiscordRole $role)
    {
        $this->items[] = $role;
    }


    public function count(): int
    {
        return count($this->items);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->position < count($this->items);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): DiscordRole
    {
        return $this->items[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }
}
