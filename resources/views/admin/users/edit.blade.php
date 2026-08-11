@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="mb-1">Edit User</h2>
        <p class="text-muted mb-0">
            Update user information and permissions.
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left me-1"></i>
        Back to Users

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">

            <i class="fas fa-user-edit me-2"></i>
            Edit User

        </h5>
    </div>


    <div class="card-body">

        <form action="{{ route('admin.users.update', $user) }}"
              method="POST">

            @csrf
            @method('PUT')


            {{-- Name --}}
            <div class="mb-3">

                <label for="name" class="form-label">
                    Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter user name"
                       required>

                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Email --}}
            <div class="mb-3">

                <label for="email" class="form-label">
                    Email <span class="text-danger">*</span>
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Enter email address"
                       required>

                @error('email')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- New Password --}}
            <div class="mb-3">

                <label for="password" class="form-label">
                    New Password
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Leave blank to keep current password">

                <small class="text-muted">
                    Leave this field empty if you do not want to change
                    the current password.
                </small>

                @error('password')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- Confirm Password --}}
            <div class="mb-3">

                <label for="password_confirmation" class="form-label">
                    Confirm New Password
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm new password">

            </div>


            {{-- Admin Role --}}
            <div class="mb-4">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="is_admin"
                           name="is_admin"
                           value="1"
                           {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>

                    <label class="form-check-label"
                           for="is_admin">

                        <i class="fas fa-user-shield me-1"></i>

                        Administrator

                    </label>

                </div>

            </div>


            {{-- Current User Warning --}}
            @if($user->id === auth()->id())

                <div class="alert alert-info">

                    <i class="fas fa-info-circle me-2"></i>

                    You are editing your own account.
                    Be careful when changing your administrator permissions.

                </div>

            @endif


            {{-- Buttons --}}
            <div class="d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save me-1"></i>

                    Update User

                </button>


                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection

