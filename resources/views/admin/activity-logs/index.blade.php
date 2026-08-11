@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')

<style>
    .activity-page {
        max-width: 1600px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 18px;
        padding: 28px 30px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.12);
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .page-header p {
        margin: 0;
        color: #cbd5e1;
    }

    .header-actions .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 15px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
    }

    .summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .summary-title {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .summary-value {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 3px;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
        margin-bottom: 24px;
    }

    .filter-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-header h6 {
        margin: 0;
        font-weight: 700;
        color: #1e293b;
    }

    .filter-body {
        padding: 22px;
    }

    .form-label {
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 10px;
        border: 1px solid #dbe1e8;
        box-shadow: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
    }

    .search-input {
        position: relative;
    }

    .search-input i {
        position: absolute;
        left: 14px;
        top: 14px;
        color: #94a3b8;
        z-index: 5;
    }

    .search-input input {
        padding-left: 40px;
    }

    .filter-btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 600;
    }

    .logs-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .logs-header {
        padding: 20px 22px;
        border-bottom: 1px solid #eef2f7;
    }

    .logs-header h5 {
        font-weight: 700;
        color: #1e293b;
    }

    .result-badge {
        background: #eef2ff;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 10px;
        border-radius: 20px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .activity-table {
        margin: 0;
        min-width: 1100px;
    }

    .activity-table thead th {
        background: #f8fafc;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 700;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .activity-table tbody td {
        padding: 15px 16px;
        border-color: #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .activity-table tbody tr {
        transition: background .2s ease;
    }

    .activity-table tbody tr:hover {
        background: #f8fafc;
    }

    .log-id {
        font-weight: 700;
        color: #4f46e5;
        background: #eef2ff;
        border-radius: 7px;
        padding: 5px 8px;
        font-size: 12px;
    }

    .user-name {
        font-weight: 600;
        color: #1e293b;
    }

    .admin-badge {
        font-size: 10px;
        margin-left: 5px;
        border-radius: 20px;
    }

    .action-badge {
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .description {
        max-width: 300px;
        color: #475569;
    }

    .ip-address {
        font-family: monospace;
        font-size: 12px;
        color: #64748b;
        background: #f8fafc;
        padding: 5px 8px;
        border-radius: 6px;
    }

    .date-text {
        font-size: 12px;
        color: #64748b;
        white-space: nowrap;
    }

    .view-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        transition: all .2s ease;
    }

    .view-btn:hover {
        background: #2563eb;
        color: #fff;
        transform: translateY(-1px);
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #f1f5f9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #94a3b8;
        margin-bottom: 18px;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #eef2f7;
        display: flex;
        justify-content: center;
    }

    .pagination {
        margin: 0;
        gap: 5px;
    }

    .pagination .page-item .page-link {
        border: 0;
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-weight: 600;
        background: #f8fafc;
        transition: all .2s ease;
    }

    .pagination .page-item .page-link:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .pagination .page-item.active .page-link {
        background: #4f46e5;
        color: #fff;
        box-shadow: 0 4px 10px rgba(79, 70, 229, .25);
    }

    .clear-modal .modal-content {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
    }

    .clear-modal .modal-header {
        border-bottom: 1px solid #eef2f7;
    }

    .clear-modal .modal-footer {
        border-top: 1px solid #eef2f7;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 22px;
        }

        .header-actions {
            margin-top: 18px;
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .page-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .filter-body {
            padding: 18px;
        }
    }
</style>

<div class="activity-page">

    {{-- Page Header --}}
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h3>
                    <i class="fas fa-shield-alt me-2"></i>
                    Activity Logs
                </h3>

                <p>
                    Monitor, search and manage administrator activities.
                </p>
            </div>

            <div class="header-actions d-flex gap-2">

                <a href="{{ route('admin.activity-logs.export', request()->query()) }}"
                    class="btn btn-success">

                    <i class="fas fa-file-csv me-1"></i>
                    Export CSV

                </a>

                <button type="button"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#clearLogsModal">

                    <i class="fas fa-trash me-1"></i>
                    Clear Logs

                </button>

            </div>

        </div>

    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div class="summary-icon bg-primary-subtle text-primary me-3">
                        <i class="fas fa-list"></i>
                    </div>

                    <div>

                        <div class="summary-title">
                            Total Logs
                        </div>

                        <div class="summary-value">
                            {{ $logs->total() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div class="summary-icon bg-success-subtle text-success me-3">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>

                        <div class="summary-title">
                            Admin Users
                        </div>

                        <div class="summary-value">
                            {{ $users->count() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="summary-card">

                <div class="d-flex align-items-center">

                    <div class="summary-icon bg-warning-subtle text-warning me-3">
                        <i class="fas fa-filter"></i>
                    </div>

                    <div>

                        <div class="summary-title">
                            Current Page
                        </div>

                        <div class="summary-value">
                            {{ $logs->currentPage() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Filter Card --}}
    <div class="filter-card">

        <div class="filter-header">

            <h6>
                <i class="fas fa-sliders-h me-2 text-primary"></i>
                Search & Filters
            </h6>

            @if(request()->hasAny([
            'search',
            'user_id',
            'action',
            'date_from',
            'date_to'
            ]))

            <span class="badge bg-primary">
                Filters Applied
            </span>

            @endif

        </div>


        <div class="filter-body">

            <form method="GET"
                action="{{ route('admin.activity-logs.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-lg-4 col-md-6">

                        <label class="form-label">
                            Search Activity
                        </label>

                        <div class="search-input">

                            <i class="fas fa-search"></i>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Description, model, IP, URL..."
                                value="{{ request('search') }}">

                        </div>

                    </div>


                    {{-- User --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            User
                        </label>

                        <select name="user_id"
                            class="form-select">

                            <option value="">
                                All Users
                            </option>

                            @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ request('user_id') == $user->id ? 'selected' : '' }}>

                                {{ $user->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Action --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Action
                        </label>

                        <select name="action"
                            class="form-select">

                            <option value="">
                                All Actions
                            </option>

                            @foreach($actions as $action)

                            <option
                                value="{{ $action }}"
                                {{ request('action') == $action ? 'selected' : '' }}>

                                {{ ucfirst($action) }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- From --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            From Date
                        </label>

                        <input
                            type="date"
                            name="date_from"
                            class="form-control"
                            value="{{ request('date_from') }}">

                    </div>


                    {{-- To --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            To Date
                        </label>

                        <input
                            type="date"
                            name="date_to"
                            class="form-control"
                            value="{{ request('date_to') }}">

                    </div>


                    {{-- Buttons --}}
                    <div class="col-12">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                class="btn btn-primary filter-btn">

                                <i class="fas fa-search me-1"></i>
                                Apply Filters

                            </button>

                            <a href="{{ route('admin.activity-logs.index') }}"
                                class="btn btn-light border filter-btn">

                                <i class="fas fa-undo me-1"></i>
                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Logs Table --}}
    <div class="logs-card">

        <div class="logs-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Activity History
                    </h5>

                    <small class="text-muted">
                        Showing {{ $logs->firstItem() ?? 0 }}
                        to {{ $logs->lastItem() ?? 0 }}
                        of {{ $logs->total() }} records
                    </small>

                </div>

                <span class="result-badge">
                    {{ $logs->total() }} Results
                </span>

            </div>

        </div>


        <div class="table-wrapper">

            <table class="table activity-table">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>IP Address</th>
                        <th>Date / Time</th>
                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($logs as $log)

                    <tr>

                        <td>
                            <span class="log-id">
                                #{{ $log->id }}
                            </span>
                        </td>


                        <td>

                            <span class="user-name">
                                {{ $log->user->name ?? 'Unknown' }}
                            </span>

                            @if($log->user && $log->user->isAdmin())

                            <span class="badge bg-danger admin-badge">
                                Admin
                            </span>

                            @endif

                        </td>


                        <td>

                            <span class="badge bg-{{ $log->action_color }} action-badge">

                                {{ strtoupper($log->action) }}

                            </span>

                        </td>


                        <td>

                            <div class="description"
                                title="{{ $log->description }}">

                                {{ Str::limit($log->description, 60) }}

                            </div>

                        </td>


                        <td>

                            <span class="text-muted">
                                {{ $log->model_name ?: 'N/A' }}
                            </span>

                        </td>


                        <td>

                            <span class="text-muted">
                                {{ $log->model_id ?? 'N/A' }}
                            </span>

                        </td>


                        <td>

                            <span class="ip-address">
                                {{ $log->ip_address ?? 'N/A' }}
                            </span>

                        </td>


                        <td>

                            <span class="date-text">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin.activity-logs.show', $log) }}"
                                class="view-btn"
                                title="View Details">

                                <i class="fas fa-eye"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i class="fas fa-search"></i>
                                </div>

                                <h5 class="fw-bold">
                                    No Activity Logs Found
                                </h5>

                                <p class="mb-3">
                                    Try changing your search or filters.
                                </p>

                                <a
                                    href="{{ route('admin.activity-logs.index') }}"
                                    class="btn btn-secondary">

                                    <i class="fas fa-undo me-1"></i>
                                    Reset Filters

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Numeric Pagination Only --}}
        @if($logs->hasPages())

        <div class="pagination-wrapper">

            <ul class="pagination">

                @for ($page = 1; $page <= $logs->lastPage(); $page++)

                    <li class="page-item {{ $logs->currentPage() == $page ? 'active' : '' }}">

                        <a
                            class="page-link"
                            href="{{ $logs->appends(request()->query())->url($page) }}">

                            {{ $page }}

                        </a>

                    </li>

                    @endfor

            </ul>

        </div>

        @endif

    </div>


</div>

{{-- Clear Logs Modal --}}

<div class="modal fade clear-modal"
    id="clearLogsModal"
    tabindex="-1"
    aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>

                    Clear Activity Logs

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body p-4">

                <div class="alert alert-danger border-0">

                    <strong>
                        Are you sure?
                    </strong>

                    <p class="mb-0 mt-2">

                        This will permanently delete all
                        activity logs.

                        <br>

                        <strong>
                            This action cannot be undone.
                        </strong>

                    </p>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">

                    Cancel

                </button>


                <form
                    action="{{ route('admin.activity-logs.clear') }}"
                    method="POST">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="fas fa-trash me-1"></i>

                        Clear All Logs

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection