<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        foreach (range(1, 50) as $i) {
            $user = $users->random();
            $action = ['create', 'update', 'delete', 'login', 'logout'][rand(0, 4)];
            
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'model' => 'App\Models\User',
                'model_id' => $user->id,
                'description' => "Sample activity log entry #{$i}",
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Test Agent)',
                'url' => '/admin/dashboard',
                'method' => 'GET',
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }
        
        $this->command->info('50 sample activity logs created!');
    }
}