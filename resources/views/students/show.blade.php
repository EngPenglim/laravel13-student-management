@extends('layouts.app')

@section('title', 'Student Details - ' . $student->student_name)

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Header Card -->
            <div class="header-gradient-card text-center mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-circle p-3 mb-2">
                    <i class="bi bi-person-badge fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $student->student_name }}</h3>
                <p class="mb-0 text-white-50">Student ID #{{ $student->student_id }} &bull; {{ $student->department->dept_name ?? 'Unassigned' }}</p>
            </div>

            <!-- Details Card -->
            <div class="content-card p-4 p-md-5" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
                <div class="list-group list-group-flush mb-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-person me-2 text-primary"></i> Full Name</span>
                        <span class="fw-bold text-dark">{{ $student->student_name }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-envelope me-2 text-primary"></i> Email Address</span>
                        <span class="text-primary">{{ $student->email }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-gender-ambiguous me-2 text-primary"></i> Gender</span>
                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">{{ $student->gender }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-building me-2 text-primary"></i> Department</span>
                        <span class="dept-badge">
                            <i class="bi bi-building"></i>
                            {{ $student->department->dept_name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-calendar-event me-2 text-primary"></i> Enrollment Date</span>
                        <span>{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i> Years Enrolled</span>
                        <span class="fw-semibold text-success">{{ $student->years_enrolled }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <div class="text-secondary fw-semibold mb-2"><i class="bi bi-chat-left-text me-2 text-primary"></i> Description / Additional Notes</div>
                        <div class="p-3 bg-light rounded-3 text-muted">
                            {{ $student->description ?: 'No additional notes provided.' }}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to Directory
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-warning rounded-pill px-4 text-white">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('students.destroy', $student->student_id) }}" onsubmit="return confirm('Delete this student?');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="bi bi-trash3 me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
