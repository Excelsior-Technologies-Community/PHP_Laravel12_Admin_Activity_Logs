@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Users Management</h2>
        <p class="text-muted mb-0">
            Manage users and administrator accounts.
        </p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-1"></i>
        Add New User
    </a>
</div>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users me-2"></i>
            All Users
        </h5>

        <span class="badge bg-secondary">
            {{ $users->total() }} Users
        </span>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- ID --}}
                            <td>
                                {{ $user->id }}
                            </td>

                            {{-- User --}}
                            <td>
                                <div class="d-flex align-items-center">

                                    <div class="bg-primary text-white rounded-circle
                                                d-flex align-items-center justify-content-center me-2"
                                         style="width: 40px; height: 40px;">

                                        {{ strtoupper(substr($user->name, 0, 1)) }}

                                    </div>

                                    <div>
                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info ms-1">
                                                You
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </td>

                            {{-- Email --}}
                            <td>
                                {{ $user->email }}
                            </td>

                            {{-- Role --}}
                            <td>

                                @if($user->isAdmin())

                                    <span class="badge bg-danger">
                                        <i class="fas fa-user-shield me-1"></i>
                                        Admin
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        <i class="fas fa-user me-1"></i>
                                        User
                                    </span>

                                @endif

                            </td>

                            {{-- Created --}}
                            <td>
                                {{ $user->created_at?->format('d M Y') }}

                                <small class="d-block text-muted">
                                    {{ $user->created_at?->diffForHumans() }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td class="text-end">

                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Edit User">

                                    <i class="fas fa-edit"></i>

                                </a>

                                @if($user->id !== auth()->id())

                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete User">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                @else

                                    <button type="button"
                                            class="btn btn-sm btn-secondary"
                                            disabled
                                            title="You cannot delete your own account">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="fas fa-users fa-3x mb-3"></i>

                                    <h5>No Users Found</h5>

                                    <p class="mb-3">
                                        There are currently no users in the system.
                                    </p>

                                    <a href="{{ route('admin.users.create') }}"
                                       class="btn btn-primary">

                                        <i class="fas fa-user-plus me-1"></i>
                                        Create First User

                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    @if($users->hasPages())

        <div class="card-footer">

            <div class="d-flex justify-content-between align-items-center">

                <div class="text-muted">
                    Showing
                    <strong>{{ $users->firstItem() }}</strong>
                    to
                    <strong>{{ $users->lastItem() }}</strong>
                    of
                    <strong>{{ $users->total() }}</strong>
                    users
                </div>

                <div>
                    {{ $users->links() }}
                </div>

            </div>

        </div>

    @endif

</div>

@endsection

