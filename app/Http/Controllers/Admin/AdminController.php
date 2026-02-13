<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('is_admin', true)->count(),
            'total_activities' => ActivityLog::count(),
            'today_activities' => ActivityLog::whereDate('created_at', today())->count(),
        ];

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $activityChart = ActivityLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActivities', 'activityChart'));
    }
}