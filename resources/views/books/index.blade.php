@extends('layouts.app')

@section('title', 'Library Book Directory - LMS')

@section('content')
<div class="container py-2">
    <!-- Header Banner with Statistics (Slide 7 Style) -->
    <div class="header-gradient-card mb-4">
        <div class="row align-items-center g-4">
            <!-- Title & Subtitle -->
            <div class="col-lg-6 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-2">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2 px-3">
                        <i class="bi bi-book-half fs-3 text-white"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0 text-white">Library Book Directory</h2>
                        <p class="mb-0 text-white-50 small">Browse, search and manage all cataloged books</p>
                    </div>
                </div>
            </div>

            <!-- 3 Glass Stats Cards -->
            <div class="col-lg-6">
                <div class="row g-2 justify-content-center justify-content-lg-end">
                    <!-- Total Books -->
                    <div class="col-4 col-sm-3">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $totalBooks }}</div>
                            <div class="stat-label">Total Books</div>
                        </div>
                    </div>
                    <!-- Categories -->
                    <div class="col-4 col-sm-3">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $totalCategories }}</div>
                            <div class="stat-label">Categories</div>
                        </div>
                    </div>
                    <!-- Available Books -->
                    <div class="col-4 col-sm-4">
                        <div class="stat-glass-card">
                            <div class="stat-number">{{ $availableBooks }}</div>
                            <div class="stat-label">Available</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="content-card p-4">
        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-4" id="filterForm">
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
                        placeholder="Search books by title, author, ISBN, or category..."
                    >
                    @if(!empty($search) || !empty($categoryId) || !empty($status) || ($sort !== 'newest'))
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Clear Filters">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                    <button class="btn btn-primary px-4 fw-semibold" type="submit">Search</button>
                </div>
            </div>

            <!-- Dropdown Filters Row -->
            <div class="row g-2">
                <!-- Category Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary border-end-0">
                            <i class="bi bi-funnel"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="category_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($categoryId) || $categoryId === 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}" {{ $categoryId == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
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
                            <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                            <option value="title_desc" {{ $sort === 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-primary border-end-0">
                            <i class="bi bi-bookmark-check"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="status" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="Available" {{ $status === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Borrowed" {{ $status === 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="Reserved" {{ $status === 'Reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <!-- HTML Table of Books -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Book & Author</th>
                        <th>ISBN & Copies</th>
                        <th>Published Date</th>
                        <th>Category</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <!-- ID -->
                            <td class="fw-bold text-secondary">#{{ $book->book_id }}</td>

                            <!-- Book Title & Author -->
                            <td>
                                <div class="fw-bold text-dark">{{ $book->title }}</div>
                                <div class="small text-muted"><i class="bi bi-pen me-1"></i>{{ $book->author }}</div>
                            </td>

                            <!-- ISBN & Copies -->
                            <td>
                                <div class="d-flex align-items-center gap-1 text-primary small">
                                    <i class="bi bi-upc"></i>
                                    <span>{{ $book->isbn ?: 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small text-muted">
                                    <i class="bi bi-stack"></i>
                                    <span>{{ $book->copies }} {{ Str::plural('copy', $book->copies) }}</span>
                                    <span class="badge ms-1 {{ $book->status === 'Available' ? 'bg-success-subtle text-success' : ($book->status === 'Borrowed' ? 'bg-warning-subtle text-warning' : 'bg-info-subtle text-info') }}">
                                        {{ $book->status }}
                                    </span>
                                </div>
                            </td>

                            <!-- Publication Date -->
                            <td>
                                <div class="d-flex align-items-center gap-1 small text-dark">
                                    <i class="bi bi-calendar-event text-primary"></i>
                                    <span>{{ $book->published_date ? $book->published_date->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small text-muted">
                                    <i class="bi bi-clock-history text-secondary"></i>
                                    <span>{{ $book->published_age }}</span>
                                </div>
                            </td>

                            <!-- Category -->
                            <td>
                                <span class="category-badge">
                                    <i class="bi bi-tag"></i>
                                    {{ $book->category->category_name ?? 'Unassigned' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <!-- View Trigger -->
                                    <a href="{{ route('books.show', $book->book_id) }}" class="action-btn btn-view" title="View Book Details">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Edit Trigger -->
                                    <a href="{{ route('books.edit', $book->book_id) }}" class="action-btn btn-edit" title="Edit Book">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- Delete Trigger -->
                                    <button 
                                        type="button" 
                                        class="action-btn btn-delete" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $book->book_id }}" 
                                        title="Delete Book"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade text-start" id="deleteModal{{ $book->book_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Confirm Delete
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Are you sure you want to delete book <strong>{{ $book->title }}</strong> (ID: {{ $book->book_id }})? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('books.destroy', $book->book_id) }}" class="m-0">
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
                                <div class="fw-semibold">No books found matching your search criteria.</div>
                                <a href="{{ route('books.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill">
                                    <i class="bi bi-plus-square me-1"></i> Register New Book
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Counts -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
            <div class="text-secondary small">
                Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }} of {{ $books->total() }} entries
            </div>
            <div>
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Back to Book Form Button -->
        <div class="d-grid mt-4">
            <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg rounded-3 fw-semibold py-2 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> + Back to Book Form
            </a>
        </div>
    </div>
</div>
@endsection
