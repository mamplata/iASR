<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a specific admin account
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'), // Always hash passwords
            'status'   => 1, // Active status
        ]);

        // Optionally, create more specific users if needed
        User::create([
            'name'     => 'Inactive Admin',
            'email'    => 'inactiveadmin@example.com',
            'password' => Hash::make('password'),
            'status'   => 0, // Inactive status
        ]);

        // Create additional random users using the factory
        // This assumes you have a UserFactory defined
        User::factory()->count(20)->create();
    }
}
