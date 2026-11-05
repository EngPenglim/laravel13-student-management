@extends('layouts.app')

@section('title', 'Library Staff Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Top Brand Strip -->
                <div class="p-4 text-center" style="background: linear-gradient(135deg, #064e3b, #047857); color: white;">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle p-3 mb-2 shadow-sm">
                        <i class="bi bi-person-plus-fill fs-2 text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1 brand-font">Register Form</h3>
                    <p class="mb-0 text-white-50 small">Library Staff &bull; Create an account</p>
                </div>

                <div class="card-body p-4 p-md-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary fw-semibold small">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg bg-light border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter your full name" 
                                    required 
                                    autofocus
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary fw-semibold small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-envelope-at"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control form-control-lg bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="staff@library.edu" 
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-secondary fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control form-control-lg bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="••••••••" 
                                    required
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label text-secondary fw-semibold small">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-check2-circle"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control form-control-lg bg-light border-start-0 ps-0" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="••••••••" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold py-2">
                                <i class="bi bi-person-check-fill me-1"></i> Create Account
                            </button>
                        </div>

                        <div class="text-center text-secondary small">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-success text-decoration-none fw-bold">Sign In here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
