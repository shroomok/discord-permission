<?php
return [
    'guild_id' => env('DISCORD_GUILD'),

    /* EXAMPLE
    |--------------------------------------------------------------------------
    |  'roles_map' => [
    |        [
    |            'discord_role' => 'writer',
    |            'laravel_roles' => ['writer'],
    |            'laravel_permissions' => ['edit own articles']
    |        ],
    |        [
    |            'discord_role' => 'moderator',
    |            'laravel_roles' => [],
    |            'laravel_permissions' => ['ban users', 'edit messages']
    |        ]
    |    ]
    */
    'roles_map' => []
];
