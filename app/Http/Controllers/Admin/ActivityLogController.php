<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs with search, filters and pagination.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->oldest();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        |
        | Search by:
        | - Description
        | - Model
        | - Model ID
        | - IP Address
        | - URL
        |
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('model_id', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        /*
        |--------------------------------------------------------------------------
        | Date From Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        /*
        |--------------------------------------------------------------------------
        | Date To Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        |
        | 15 records per page.
        | withQueryString() keeps search/filter values
        | while changing pages.
        |
        */
        $logs = $query
            ->paginate(6)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */
        $users = User::orderBy('name')->get();

        $actions = [
            'create',
            'update',
            'delete',
            'login',
            'logout',
        ];

        return view(
            'admin.activity-logs.index',
            compact('logs', 'users', 'actions')
        );
    }

    /**
     * Display a single activity log.
     */
    public function show(ActivityLog $log)
    {
        $log->load('user');

        return view(
            'admin.activity-logs.show',
            compact('log')
        );
    }

    /**
     * Export filtered activity logs as CSV.
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with('user');

        /*
        |--------------------------------------------------------------------------
        | Same Search Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('model_id', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | User Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Filtered Logs
        |--------------------------------------------------------------------------
        */
        $logs = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CSV Filename
        |--------------------------------------------------------------------------
        */
        $filename = 'activity-logs-' . now()->format('Y-m-d-H-i-s') . '.csv';

        /*
        |--------------------------------------------------------------------------
        | CSV Download
        |--------------------------------------------------------------------------
        */
        return response()->streamDownload(function () use ($logs) {

            $handle = fopen('php://output', 'w');

            /*
            | CSV Header
            */
            fputcsv($handle, [
                'ID',
                'User',
                'Action',
                'Description',
                'Model',
                'Model ID',
                'IP Address',
                'URL',
                'HTTP Method',
                'Date/Time',
            ]);

            /*
            | CSV Rows
            */
            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->user->name ?? 'Unknown',
                    strtoupper($log->action),
                    $log->description,
                    $log->model_name,
                    $log->model_id ?? 'N/A',
                    $log->ip_address ?? 'N/A',
                    $log->url ?? 'N/A',
                    $log->method ?? 'N/A',
                    optional($log->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Clear all activity logs.
     */
    public function clear()
    {
        $count = ActivityLog::count();

        if ($count > 0) {
            ActivityLog::truncate();

            return redirect()
                ->route('admin.activity-logs.index')
                ->with(
                    'success',
                    "{$count} activity logs have been cleared successfully."
                );
        }

        return redirect()
            ->route('admin.activity-logs.index')
            ->with(
                'info',
                'No logs to clear.'
            );
    }
}
