@extends('layouts.admin')

@section('title', 'Log Details #' . $log->id)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Activity Log Details #{{ $log->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">ID</th>
                                <td>{{ $log->id }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>
                                    {{ $log->user->name ?? 'Unknown' }}
                                    @if($log->user)
                                        <br>
                                        <small>{{ $log->user->email }}</small>
                                        @if($log->user->isAdmin())
                                            <span class="badge bg-danger">Admin</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>
                                    <span class="badge bg-{{ $log->action_color }} badge-action">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $log->model }}</td>
                            </tr>
                            <tr>
                                <th>Model ID</th>
                                <td>{{ $log->model_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $log->description }}</td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>
                                    <small class="text-muted">{{ $log->user_agent ?? 'N/A' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>URL</th>
                                <td>
                                    <small class="text-muted">{{ $log->url ?? 'N/A' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Method</th>
                                <td>
                                    @if($log->method)
                                        <span class="badge bg-secondary">{{ $log->method }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $log->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($log->old_values)
                        <div class="card mb-3">
                            <div class="card-header bg-warning text-white">
                                <h6 class="mb-0">Old Values</h6>
                            </div>
                            <div class="card-body">
                                <pre class="mb-0" style="max-height: 300px; overflow: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif

                        @if($log->new_values)
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">New Values</h6>
                            </div>
                            <div class="card-body">
                                <pre class="mb-0" style="max-height: 300px; overflow: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif

                        @if(!$log->old_values && !$log->new_values)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No additional data available for this log entry.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Logs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection