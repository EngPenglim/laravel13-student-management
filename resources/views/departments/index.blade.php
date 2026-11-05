@extends('layouts.app')

@section('title', 'Departments Management')

@section('content')
<div class="container py-2">
    <!-- Header Banner -->
    <div class="header-gradient-card mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-25 rounded-circle p-2 px-3">
                    <i class="bi bi-building fs-3 text-white"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-white">Departments Management</h2>
                    <p class="mb-0 text-white-50 small">Manage academic departments & relations</p>
                </div>
            </div>
            <button class="btn btn-light rounded-pill px-4 fw-semibold text-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createDeptModal">
                <i class="bi bi-plus-circle me-1"></i> Add Department
            </button>
        </div>
    </div>

    <!-- Departments Table Card -->
    <div class="content-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th style="width: 80px;">Dept ID</th>
                        <th>Department Name</th>
                        <th>Manager ID</th>
                        <th>Location ID</th>
                        <th>Enrolled Students</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                        <tr>
                            <td class="fw-bold text-secondary">#{{ $dept->dept_id }}</td>
                            <td>
                                <span class="dept-badge fs-6">
                                    <i class="bi bi-building"></i>
                                    {{ $dept->dept_name }}
                                </span>
                            </td>
                            <td class="text-secondary">{{ $dept->manager_id ?: 'N/A' }}</td>
                            <td class="text-secondary">{{ $dept->location_id ?: 'N/A' }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                                    <i class="bi bi-people me-1"></i> {{ $dept->students_count }} Students
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <!-- Edit Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editDeptModal{{ $dept->dept_id }}" 
                                        title="Edit Department"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Delete Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteDeptModal{{ $dept->dept_id }}" 
                                        title="Delete Department"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade text-start" id="editDeptModal{{ $dept->dept_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form method="POST" action="{{ route('departments.update', $dept->dept_id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="bi bi-pencil-square text-primary me-1"></i> Edit Department
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small fw-semibold">Department Name</label>
                                                        <input type="text" class="form-control" name="dept_name" value="{{ $dept->dept_name }}" required>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small fw-semibold">Manager ID</label>
                                                            <input type="number" class="form-control" name="manager_id" value="{{ $dept->manager_id }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small fw-semibold">Location ID</label>
                                                            <input type="number" class="form-control" name="location_id" value="{{ $dept->location_id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade text-start" id="deleteDeptModal{{ $dept->dept_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Confirm Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Are you sure you want to delete department <strong>{{ $dept->dept_name }}</strong>?
                                                @if($dept->students_count > 0)
                                                    <div class="alert alert-warning mt-2 small mb-0">
                                                        <i class="bi bi-info-circle me-1"></i> Notice: This department currently has <strong>{{ $dept->students_count }}</strong> assigned student(s). Deleting will cascade.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('departments.destroy', $dept->dept_id) }}" class="m-0">
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
                            <td colspan="6" class="text-center py-4 text-muted">No departments created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="createDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="bi bi-plus-circle-fill text-primary me-1"></i> Add New Department
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Department Name</label>
                        <input type="text" class="form-control" name="dept_name" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-semibold">Manager ID</label>
                            <input type="number" class="form-control" name="manager_id" placeholder="e.g. 101">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-semibold">Location ID</label>
                            <input type="number" class="form-control" name="location_id" placeholder="e.g. 1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
