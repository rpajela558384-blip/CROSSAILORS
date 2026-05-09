<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@crossailors.com'],
            [
                'name'              => 'Admin',
                'password'          => bcrypt('123'),
                'role'              => 'admin',
                'is_protected'      => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
