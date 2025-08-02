<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'admin' => [
                'name' => 'Administrator',
                'permissions' => ['platform.*' => true],
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
            'operator' => [
                'name' => 'Operator',
                'permissions' => [
                    'platform.clients' => true,
                    'platform.barbershops' => true,
                    'platform.services' => true,
                ],
            ],
            'maintenance' => [
                'name' => 'Maintenance',
                'permissions' => [
                    'platform.clients' => true,
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            Role::firstOrCreate(['slug' => $slug], [
                'name' => $data['name'],
                'permissions' => $data['permissions'],
            ]);
        }

        User::factory()->create([
            'name' => 'Main Admin',
            'email' => 'admin@yourapp.com',
        ])->addRole('admin');

        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@yourapp.com',
        ])->addRole('manager');

        User::factory()->create([
            'name' => 'Operator User',
            'email' => 'operator@yourapp.com',
        ])->addRole('operator');

        User::factory()->create([
            'name' => 'Maintenance User',
            'email' => 'maintenance@yourapp.com',
        ])->addRole('maintenance');

        $this->call([
            ClientSeeder::class,
            BarbershopSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
