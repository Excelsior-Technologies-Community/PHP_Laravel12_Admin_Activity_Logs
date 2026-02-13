<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin user already exists
        $adminEmail = 'admin@example.com';
        
        $existingUser = User::where('email', $adminEmail)->first();
        
        if ($existingUser) {
            // Update existing user to be admin
            $existingUser->update([
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
            
            $this->command->info('Existing user updated to admin successfully!');
        } else {
            // Create new admin user
            User::create([
                'name' => 'Admin User',
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
        }
        
        // Show admin credentials
        $this->command->info('-----------------------------------');
        $this->command->info('Admin Login Credentials:');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->info('-----------------------------------');
        
        // Count total admins
        $adminCount = User::where('is_admin', true)->count();
        $this->command->info("Total admin users: {$adminCount}");
    }
}