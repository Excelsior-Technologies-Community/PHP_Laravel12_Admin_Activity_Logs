@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Activity Logs</h5>
        <div>
            <a href="{{ route('admin.activity-logs.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-download"></i> Export CSV
            </a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
                <i class="fas fa-trash"></i> Clear All
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>IP Address</th>
                        <th>Date/Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>
                            {{ $log->user->name ?? 'Unknown' }}
                            @if($log->user && $log->user->isAdmin())
                                <span class="badge bg-danger">Admin</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $log->action_color }} badge-action">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($log->description, 50) }}</td>
                        <td>{{ $log->model_name }}</td>
                        <td>{{ $log->model_id ?? 'N/A' }}</td>
                        <td>{{ $log->ip_address ?? 'N/A' }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No activity logs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Clear Logs Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clear All Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to clear all activity logs? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.activity-logs.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Clear All Logs</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection