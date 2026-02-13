@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Users</h6>
                        <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Admins</h6>
                        <h2 class="mb-0">{{ $stats['total_admins'] }}</h2>
                    </div>
                    <i class="fas fa-user-shield fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Activities</h6>
                        <h2 class="mb-0">{{ $stats['total_activities'] }}</h2>
                    </div>
                    <i class="fas fa-history fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Today's Activities</h6>
                        <h2 class="mb-0">{{ $stats['today_activities'] }}</h2>
                    </div>
                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Activity Chart (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <canvas id="activityChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-eye"></i> View All Logs
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100 mb-2">
                    <i class="fas fa-user-plus"></i> Add New User
                </a>
                <a href="{{ route('admin.activity-logs.export') }}" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-download"></i> Export Logs
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Recent Activities</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>IP Address</th>
                        <th>Date/Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities as $log)
                    <tr>
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
                        <td>{{ $log->ip_address ?? 'N/A' }}</td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No activities found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    const chartData = @json($activityChart);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.date),
            datasets: [{
                label: 'Activities',
                data: chartData.map(item => item.count),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush