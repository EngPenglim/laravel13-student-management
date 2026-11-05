@extends('layouts.app')

@section('title', 'Categories Management - LMS')

@section('content')
<div class="container py-2">
    <!-- Header Banner -->
    <div class="header-gradient-card mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-25 rounded-circle p-2 px-3">
                    <i class="bi bi-tags fs-3 text-white"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-white">Book Categories</h2>
                    <p class="mb-0 text-white-50 small">Manage library genres, sections & shelf locations</p>
                </div>
            </div>
            <button class="btn btn-light rounded-pill px-4 fw-semibold text-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createCatModal">
                <i class="bi bi-plus-circle me-1"></i> Add Category
            </button>
        </div>
    </div>

    <!-- Categories Table Card -->
    <div class="content-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th style="width: 80px;">Cat ID</th>
                        <th>Category Name</th>
                        <th>Shelf Location</th>
                        <th>Floor No</th>
                        <th>Cataloged Books</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td class="fw-bold text-secondary">#{{ $cat->category_id }}</td>
                            <td>
                                <span class="category-badge fs-6">
                                    <i class="bi bi-tag"></i>
                                    {{ $cat->category_name }}
                                </span>
                            </td>
                            <td class="text-secondary">{{ $cat->shelf_location ?: 'N/A' }}</td>
                            <td class="text-secondary">Floor {{ $cat->floor_no }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                                    <i class="bi bi-journal-bookmark me-1"></i> {{ $cat->books_count }} Books
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <!-- Edit Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCatModal{{ $cat->category_id }}" 
                                        title="Edit Category"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Delete Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteCatModal{{ $cat->category_id }}" 
                                        title="Delete Category"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade text-start" id="editCatModal{{ $cat->category_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form method="POST" action="{{ route('categories.update', $cat->category_id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="bi bi-pencil-square text-primary me-1"></i> Edit Category
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small fw-semibold">Category Name</label>
                                                        <input type="text" class="form-control" name="category_name" value="{{ $cat->category_name }}" required>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small fw-semibold">Shelf Location</label>
                                                            <input type="text" class="form-control" name="shelf_location" value="{{ $cat->shelf_location }}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small fw-semibold">Floor No</label>
                                                            <input type="number" class="form-control" name="floor_no" value="{{ $cat->floor_no }}" min="1">
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
                                <div class="modal fade text-start" id="deleteCatModal{{ $cat->category_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Confirm Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Are you sure you want to delete category <strong>{{ $cat->category_name }}</strong>?
                                                @if($cat->books_count > 0)
                                                    <div class="alert alert-warning mt-2 small mb-0">
                                                        <i class="bi bi-info-circle me-1"></i> Notice: This category contains <strong>{{ $cat->books_count }}</strong> cataloged book(s). Deleting will cascade.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('categories.destroy', $cat->category_id) }}" class="m-0">
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
                            <td colspan="6" class="text-center py-4 text-muted">No categories created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="createCatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="bi bi-plus-circle-fill text-primary me-1"></i> Add New Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Category Name</label>
                        <input type="text" class="form-control" name="category_name" placeholder="e.g. Artificial Intelligence" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-semibold">Shelf Location</label>
                            <input type="text" class="form-control" name="shelf_location" placeholder="e.g. Shelf AI-1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-semibold">Floor No</label>
                            <input type="number" class="form-control" name="floor_no" value="1" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
