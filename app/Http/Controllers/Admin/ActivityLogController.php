<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(15)->withQueryString();
        
        $users = User::where('is_admin', true)->get();
        $actions = ['create', 'update', 'delete', 'login', 'logout'];

        return view('admin.activity-logs.index', compact('logs', 'users', 'actions'));
    }

    public function show(ActivityLog $log)
    {
        $log->load('user');
        return view('admin.activity-logs.show', compact('log'));
    }

    public function export(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->get();

        $filename = 'activity-logs-' . now()->format('Y-m-d-His') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, ['ID', 'User', 'Action', 'Description', 'Model', 'Model ID', 'IP Address', 'Date/Time']);

        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->id,
                $log->user->name ?? 'Unknown',
                $log->action,
                $log->description,
                $log->model_name,
                $log->model_id,
                $log->ip_address,
                $log->created_at->format('Y-m-d H:i:s')
            ]);
        }

        fclose($handle);
        exit;
    }

    public function clear()
    {
        $count = ActivityLog::count();
        
        if ($count > 0) {
            ActivityLog::truncate();
            return redirect()->route('admin.activity-logs.index')
                ->with('success', "{$count} activity logs have been cleared successfully.");
        }

        return redirect()->route('admin.activity-logs.index')
            ->with('info', 'No logs to clear.');
    }
}