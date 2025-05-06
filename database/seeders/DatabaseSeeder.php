<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create NEBE admin account
        User::create([
            'name' => 'NEBE Admin',
            'email' => 'nebe@admin.com',
            'password' => bcrypt('admin123'), // Change this in production!
            'type' => 'nebe',
            'is_approved' => true
        ]);

        // You can add more seeders here if needed
    }
}