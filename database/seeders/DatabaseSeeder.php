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
        // Create Roles
        $adminRole = \App\Models\Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'description' => 'Full control over the system']
        );

        $devRole = \App\Models\Role::firstOrCreate(
            ['slug' => 'dev'],
            ['name' => 'Developer', 'description' => 'Access to apps and logs']
        );

        $viewerRole = \App\Models\Role::firstOrCreate(
            ['slug' => 'viewer'],
            ['name' => 'Viewer', 'description' => 'Read-only access']
        );

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ensure you change this!
            'role_id' => $adminRole->id,
            'active' => true,
        ]);
    }
}
