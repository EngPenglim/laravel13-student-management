@extends('layouts.app')

@section('title', 'Student Directory - Student Management System')

@section('content')
<div class="container py-2">
    <!-- Super Header Banner with Statistics (Slide 7) -->
    <div class="header-gradient-card mb-4">
        <div class="row align-items-center g-4">
            <!-- Directory Title & Subtitle -->
            <div class="col-lg-6 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-2">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2 px-3">
                        <i class="bi bi-mortarboard-fill fs-3 text-white"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0 text-white">Student Directory</h2>
                        <p class="mb-0 text-white-50 small">Browse and manage all registered students</p>
                    </div>
                </div>
            </div>

            <!-- 3 Glass Stats Cards matching Slide 7 -->
            <div class="col-lg-6">
                <div class="row g-2 justify-content-center justify-content-lg-end">
                    <!-- Total Students -->
                    <div class="col-4 col-sm-3">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $totalStudents }}</div>
                            <div class="stat-label">Total Students</div>
                        </div>
                    </div>
                    <!-- Departments -->
                    <div class="col-4 col-sm-3">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $totalDepartments }}</div>
                            <div class="stat-label">Departments</div>
                        </div>
                    </div>
                    <!-- Avg Enrollment -->
                    <div class="col-4 col-sm-4">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $avgEnrollment }}</div>
                            <div class="stat-label">Avg. Enrollment</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="content-card p-4">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('students.index') }}" class="mb-4" id="filterForm">
            <!-- Search bar -->
            <div class="mb-3">
                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control border-start-0 ps-2" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Search students by name, email, or department..."
                    >
                    @if(!empty($search) || !empty($departmentId) || !empty($gender) || ($sort !== 'newest'))
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Clear Filters">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                    <button class="btn btn-primary px-4 fw-semibold" type="submit">Search</button>
                </div>
            </div>

            <!-- Dropdown Filters Row (matching slide 7) -->
            <div class="row g-2">
                <!-- Department Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary border-end-0">
                            <i class="bi bi-funnel"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="department_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($departmentId) || $departmentId === 'all' ? 'selected' : '' }}>All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->dept_id }}" {{ $departmentId == $dept->dept_id ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary border-end-0">
                            <i class="bi bi-arrow-down-up"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="sort" onchange="document.getElementById('filterForm').submit()">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Gender Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary border-end-0">
                            <i class="bi bi-gender-ambiguous"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="gender" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($gender) || $gender === 'all' ? 'selected' : '' }}>All Genders</option>
                            <option value="Male" {{ $gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $gender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <!-- HTML Table of Students (Slide 7) -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Student</th>
                        <th>Contact</th>
                        <th>Enrollment</th>
                        <th>Department</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <!-- ID -->
                            <td class="fw-bold text-secondary">{{ $student->student_id }}</td>

                            <!-- Student Column (Name & Gender) -->
                            <td>
                                <div class="fw-bold text-dark">{{ $student->student_name }}</div>
                                <div class="small text-muted">{{ $student->gender }}</div>
                            </td>

                            <!-- Contact Column (Email & Description) -->
                            <td>
                                <div class="d-flex align-items-center gap-1 text-primary small">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ $student->email }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small text-muted">
                                    <i class="bi bi-chat-left-text"></i>
                                    <span>{{ $student->description ?: 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Enrollment Column (Date & Calculated Years) -->
                            <td>
                                <div class="d-flex align-items-center gap-1 small text-dark">
                                    <i class="bi bi-calendar-event text-primary"></i>
                                    <span>{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small text-muted">
                                    <i class="bi bi-clock-history text-secondary"></i>
                                    <span>{{ $student->years_enrolled }}</span>
                                </div>
                            </td>

                            <!-- Department Column -->
                            <td>
                                <span class="dept-badge">
                                    <i class="bi bi-building"></i>
                                    {{ $student->department->dept_name ?? 'Unassigned' }}
                                </span>
                            </td>

                            <!-- Actions Column (View, Edit, Delete) -->
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <!-- View Modal Trigger -->
                                    <a href="{{ route('students.show', $student->student_id) }}" class="action-btn btn-view" title="View Student">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('students.edit', $student->student_id) }}" class="action-btn btn-edit" title="Edit Student">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- Delete Button with Modal Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $student->student_id }}" 
                                        title="Delete Student"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteModal{{ $student->student_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Confirm Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Are you sure you want to delete student <strong>{{ $student->student_name }}</strong> (ID: {{ $student->student_id }})? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('students.destroy', $student->student_id) }}" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                <div class="fw-semibold">No students found matching your search criteria.</div>
                                <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">
                                    <i class="bi bi-person-plus me-1"></i> Register New Student
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Counts (Slide 7) -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
            <div class="text-secondary small">
                Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries
            </div>
            <div>
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Back to Student Form Button (Slide 7 bottom) -->
        <div class="d-grid mt-4">
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg rounded-3 fw-semibold py-2 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-person-plus-fill"></i> + Back to Student Form
            </a>
        </div>
    </div>
</div>
@endsection
