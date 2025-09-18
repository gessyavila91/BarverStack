<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Baseline role definitions for the application.
     */
    public const ROLES = [
        'admin' => [
            'name' => 'Administrator',
            'permissions' => [
                'platform.*' => true,
            ],
        ],
        'manager' => [
            'name' => 'Manager',
            'permissions' => [
                'platform.systems.users' => true,
                'platform.systems.roles' => true,
                'platform.clients' => true,
                'platform.barbershops' => true,
                'platform.services' => true,
            ],
        ],
        'supervisor' => [
            'name' => 'Supervisor',
            'permissions' => [
                'platform.clients' => true,
                'platform.barbershops' => true,
                'platform.services' => true,
            ],
        ],
        'receptionist' => [
            'name' => 'Receptionist',
            'permissions' => [
                'platform.clients' => true,
                'platform.services' => true,
            ],
        ],
        'auditor' => [
            'name' => 'Auditor',
            'permissions' => [
                'platform.clients' => true,
                'platform.barbershops' => true,
                'platform.services' => true,
            ],
        ],
    ];

    /**
     * Seed the application's roles.
     */
    public function run(): void
    {
        foreach (self::ROLES as $slug => $definition) {
            Role::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $definition['name'],
                    'permissions' => $definition['permissions'],
                ],
            );
        }
    }
}
