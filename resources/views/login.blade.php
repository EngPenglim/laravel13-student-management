@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-center fw-bold text-secondary-emphasis mb-4">Login Form</h2>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary fw-semibold small">Email address</label>
                            <input 
                                type="email" 
                                class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', 'adminwoman@gmail.com') }}" 
                                placeholder="adminwoman@gmail.com" 
                                required 
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary fw-semibold small">Password</label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="•••••" 
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold">
                                Login
                            </button>
                        </div>

                        <div class="text-center text-secondary small">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Register here</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Demo Credentials helper box -->
            <div class="card border-0 bg-white shadow-sm rounded-3 mt-3">
                <div class="card-body p-3 text-center small text-muted">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle me-1">Demo Account</span>
                    Email: <strong>adminwoman@gmail.com</strong> | Password: <strong>password</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
