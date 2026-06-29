<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@fashion.test'],
            [
                'name' => 'Admin',
                'email' => 'admin@fashion.test',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created: admin@fashion.test / password');
    }
}
