<?php
namespace Shroomok\DiscordPermission\Exceptions;

use InvalidArgumentException;

class ObjectHasNoMethod extends InvalidArgumentException
{
    public static function create(object $givenModel, string $method)
    {
        return new static("The given object `" . get_class($givenModel) . "` should have `$method` method, 
                                    i.e. use HasRoles trait from spatie/laravel-permission package");
    }
}
