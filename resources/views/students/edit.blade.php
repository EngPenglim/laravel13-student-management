@extends('layouts.app')

@section('title', 'Edit Student - ' . $student->student_name)

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Banner -->
            <div class="header-gradient-card text-center mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-circle p-3 mb-2">
                    <i class="bi bi-pencil-square fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Student Information</h3>
                <p class="mb-0 text-white-50">Update student #{{ $student->student_id }}: {{ $student->student_name }}</p>
            </div>

            <!-- Edit Form Card -->
            <div class="content-card p-4 p-md-5" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
                <form method="POST" action="{{ route('students.update', $student->student_id) }}" id="studentEditForm">
                    @csrf
                    @method('PUT')

                    <!-- 1. Personal Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-person-circle fs-5"></i> Personal Information
                        </h6>

                        <!-- Student Name -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Student Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control bg-light border-start-0 ps-0 @error('student_name') is-invalid @enderror" 
                                    name="student_name" 
                                    value="{{ old('student_name', $student->student_name) }}" 
                                    required
                                >
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email', $student->email) }}" 
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Gender</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </span>
                                <select class="form-select bg-light border-start-0 ps-0 @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 2. Academic Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-bank fs-5"></i> Academic Information
                        </h6>

                        <div class="row g-3 mb-3">
                            <!-- Enrollment Date -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Enrollment Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-secondary">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        class="form-control bg-light border-start-0 ps-0 @error('enrollment_date') is-invalid @enderror" 
                                        name="enrollment_date" 
                                        id="enrollment_date" 
                                        value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" 
                                        required
                                    >
                                    @error('enrollment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Years Enrolled -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Years Enrolled</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-secondary">
                                        <i class="bi bi-clock-history"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        class="form-control bg-light border-start-0 ps-0" 
                                        name="enrollment" 
                                        id="enrollment" 
                                        value="{{ old('enrollment', $student->enrollment) }}" 
                                        placeholder="e.g. 2.5 years"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Department Selection -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Department</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary">
                                    <i class="bi bi-building"></i>
                                </span>
                                <select class="form-select bg-light border-start-0 ps-0 @error('department_id') is-invalid @enderror" name="department_id" required>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->dept_id }}" {{ old('department_id', $student->department_id) == $dept->dept_id ? 'selected' : '' }}>
                                            {{ $dept->dept_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 3. Additional Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-file-text fs-5"></i> Additional Information
                        </h6>

                        <div class="mb-3">
                            <textarea 
                                class="form-control bg-light @error('description') is-invalid @enderror" 
                                name="description" 
                                rows="3"
                            >{{ old('description', $student->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3 shadow-sm">
                            <i class="bi bi-check-lg"></i> Update Student
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
