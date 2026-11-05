@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-center fw-bold text-secondary-emphasis mb-4">Register Form</h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary fw-semibold small">Name</label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                placeholder="please input your name" 
                                required 
                                autofocus
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary fw-semibold small">Email address</label>
                            <input 
                                type="email" 
                                class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="adminwoman@gmail.com" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
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

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label text-secondary fw-semibold small">Confirm Password</label>
                            <input 
                                type="password" 
                                class="form-control form-control-lg bg-light border-0" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="•••••" 
                                required
                            >
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold">
                                Register
                            </button>
                        </div>

                        <div class="text-center text-secondary small">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
