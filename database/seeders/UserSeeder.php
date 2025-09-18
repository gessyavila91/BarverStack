<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Demo users and their associated role slugs.
     */
    private const USERS = [
        [
            'name' => 'System Administrator',
            'email' => 'admin@barverstack.test',
            'role' => 'admin',
        ],
        [
            'name' => 'Operations Manager',
            'email' => 'manager@barverstack.test',
            'role' => 'manager',
        ],
        [
            'name' => 'Floor Supervisor',
            'email' => 'supervisor@barverstack.test',
            'role' => 'supervisor',
        ],
        [
            'name' => 'Front Desk Receptionist',
            'email' => 'reception@barverstack.test',
            'role' => 'receptionist',
        ],
        [
            'name' => 'Quality Auditor',
            'email' => 'auditor@barverstack.test',
            'role' => 'auditor',
        ],
    ];

    /**
     * Seed the application's demo users.
     */
    public function run(): void
    {
        foreach (self::USERS as $userDefinition) {
            $user = User::query()->firstOrNew(['email' => $userDefinition['email']]);

            if (! $user->exists) {
                $user->password = Hash::make('password');
                $user->email_verified_at = now();
                $user->remember_token = Str::random(10);
            }

            $user->name = $userDefinition['name'];
            $user->save();

            $role = Role::query()->firstWhere('slug', $userDefinition['role']);

            if ($role !== null) {
                $user->roles()->sync([$role->getKey()]);
            }
        }
    }
}
