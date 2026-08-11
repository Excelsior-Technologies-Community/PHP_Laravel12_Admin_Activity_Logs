@extends('layouts.admin')


@section('title', 'Dashboard')


@section('content')

{{-- ============================================================= --}}
{{-- Dashboard Statistics --}}
{{-- ============================================================= --}}

<div class="row">

    {{-- Total Users --}}
    <div class="col-md-3 mb-4">

        <div class="card stat-card bg-primary text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="card-title">
                            Total Users
                        </h6>

                        <h2 class="mb-0">
                            {{ $stats['total_users'] }}
                        </h2>

                    </div>

                    <i class="fas fa-users fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- Total Admins --}}
    <div class="col-md-3 mb-4">

        <div class="card stat-card bg-success text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="card-title">
                            Total Admins
                        </h6>

                        <h2 class="mb-0">
                            {{ $stats['total_admins'] }}
                        </h2>

                    </div>

                    <i class="fas fa-user-shield fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- Total Activities --}}
    <div class="col-md-3 mb-4">

        <div class="card stat-card bg-info text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="card-title">
                            Total Activities
                        </h6>

                        <h2 class="mb-0">
                            {{ $stats['total_activities'] }}
                        </h2>

                    </div>

                    <i class="fas fa-history fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- Today's Activities --}}
    <div class="col-md-3 mb-4">

        <div class="card stat-card bg-warning text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="card-title">
                            Today's Activities
                        </h6>

                        <h2 class="mb-0">
                            {{ $stats['today_activities'] }}
                        </h2>

                    </div>

                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- Existing Activity Chart + Quick Actions --}}
{{-- ============================================================= --}}

<div class="row">

    {{-- Activity Chart --}}
    <div class="col-md-8 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <h5 class="mb-0">
                    Activity Chart (Last 7 Days)
                </h5>

            </div>

            <div class="card-body">

                <canvas
                    id="activityChart"
                    height="300"
                ></canvas>

            </div>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div class="col-md-4 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <h5 class="mb-0">
                    Quick Actions
                </h5>

            </div>

            <div class="card-body">

                <a
                    href="{{ route('admin.activity-logs.index') }}"
                    class="btn btn-primary w-100 mb-2"
                >
                    <i class="fas fa-eye"></i>
                    View All Logs
                </a>


                <a
                    href="{{ route('admin.users.create') }}"
                    class="btn btn-success w-100 mb-2"
                >
                    <i class="fas fa-user-plus"></i>
                    Add New User
                </a>


                <a
                    href="{{ route('admin.activity-logs.export') }}"
                    class="btn btn-info w-100 mb-2"
                >
                    <i class="fas fa-download"></i>
                    Export Logs
                </a>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- NEW FEATURES --}}
{{-- Activity By Action + Top Active Users --}}
{{-- ============================================================= --}}

<div class="row">

    {{-- ========================================================= --}}
    {{-- Activity By Action --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <h5 class="mb-0">
                    Activity by Action
                </h5>

            </div>

            <div class="card-body">

                @if($activityByAction->count())

                    <div style="height: 320px;">

                        <canvas id="actionChart"></canvas>

                    </div>

                @else

                    <div class="text-center text-muted py-5">

                        <i class="fas fa-chart-pie fa-3x mb-3"></i>

                        <p class="mb-0">
                            No activity data available.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Top Active Users --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <h5 class="mb-0">
                    Top Active Users
                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Role
                                </th>

                                <th>
                                    Activities
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($topActiveUsers as $index => $activity)

                                <tr>

                                    {{-- Rank --}}
                                    <td>

                                        @if($index === 0)

                                            <span class="badge bg-warning text-dark">
                                                1
                                            </span>

                                        @elseif($index === 1)

                                            <span class="badge bg-secondary">
                                                2
                                            </span>

                                        @elseif($index === 2)

                                            <span class="badge bg-info">
                                                3
                                            </span>

                                        @else

                                            <span class="badge bg-light text-dark">
                                                {{ $index + 1 }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- User --}}
                                    <td>

                                        {{ $activity->user->name ?? 'Unknown' }}

                                    </td>


                                    {{-- Role --}}
                                    <td>

                                        @if($activity->user && $activity->user->isAdmin())

                                            <span class="badge bg-danger">
                                                Admin
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                User
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Activity Count --}}
                                    <td>

                                        <span class="badge bg-primary">
                                            {{ $activity->count }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center text-muted py-4"
                                    >

                                        No activity data found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- Recent Activities --}}
{{-- ============================================================= --}}

<div class="card">

    <div class="card-header">

        <h5 class="mb-0">
            Recent Activities
        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            User
                        </th>

                        <th>
                            Action
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Model
                        </th>

                        <th>
                            IP Address
                        </th>

                        <th>
                            Date/Time
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($recentActivities as $log)

                        <tr>

                            {{-- User --}}
                            <td>

                                {{ $log->user->name ?? 'Unknown' }}

                                @if($log->user && $log->user->isAdmin())

                                    <span class="badge bg-danger">
                                        Admin
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td>

                                <span
                                    class="badge bg-{{ $log->action_color }} badge-action"
                                >
                                    {{ strtoupper($log->action) }}
                                </span>

                            </td>


                            {{-- Description --}}
                            <td>

                                {{ Str::limit($log->description, 50) }}

                            </td>


                            {{-- Model --}}
                            <td>

                                {{ $log->model_name }}

                            </td>


                            {{-- IP Address --}}
                            <td>

                                {{ $log->ip_address ?? 'N/A' }}

                            </td>


                            {{-- Date --}}
                            <td>

                                {{ $log->created_at->diffForHumans() }}

                            </td>


                            {{-- View --}}
                            <td>

                                <a
                                    href="{{ route('admin.activity-logs.show', $log) }}"
                                    class="btn btn-sm btn-info"
                                    title="View Activity"
                                >

                                    <i class="fas fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted py-4"
                            >

                                No activities found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


{{-- ============================================================= --}}
{{-- Dashboard JavaScript --}}
{{-- ============================================================= --}}

@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | Activity Chart - Last 7 Days
    |--------------------------------------------------------------------------
    */

    const activityChartElement =
        document.getElementById('activityChart');

    if (activityChartElement) {

        const ctx =
            activityChartElement.getContext('2d');

        const chartData =
            @json($activityChart);

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: chartData.map(
                    item => item.date
                ),

                datasets: [{

                    label: 'Activities',

                    data: chartData.map(
                        item => item.count
                    ),

                    borderColor:
                        'rgb(75, 192, 192)',

                    backgroundColor:
                        'rgba(75, 192, 192, 0.2)',

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

    }


    /*
    |--------------------------------------------------------------------------
    | NEW: Activity By Action Chart
    |--------------------------------------------------------------------------
    */

    const actionChartElement =
        document.getElementById('actionChart');

    if (actionChartElement) {

        const actionCtx =
            actionChartElement.getContext('2d');

        const actionData =
            @json($activityByAction);

        new Chart(actionCtx, {

            type: 'doughnut',

            data: {

                labels: actionData.map(
                    item => item.action.toUpperCase()
                ),

                datasets: [{

                    label: 'Activities',

                    data: actionData.map(
                        item => item.count
                    )

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        position: 'bottom'

                    }

                }

            }

        });

    }

</script>

@endpush