@extends('layouts.admin')

@section('title', 'Create User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Create User</h2>
        <p class="text-muted mb-0">
            Add a new user to the system.
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Users
    </a>
</div>

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-user-plus me-2"></i>
            User Information
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.users.store') }}" method="POST">

            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">
                    Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
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
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Enter email address"
                       required>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">
                    Password <span class="text-danger">*</span>
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimum 8 characters"
                       required>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    Confirm Password <span class="text-danger">*</span>
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm password"
                       required>
            </div>

            {{-- Admin --}}
            <div class="mb-4">
                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="is_admin"
                           name="is_admin"
                           value="1"
                           {{ old('is_admin') ? 'checked' : '' }}>

                    <label class="form-check-label" for="is_admin">
                        <i class="fas fa-user-shield me-1"></i>
                        Make this user an administrator
                    </label>

                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Create User
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


