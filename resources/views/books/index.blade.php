@extends('layouts.app')

@section('title', 'Library Book Directory - LMS')

@section('content')
<div class="container py-2">
    <!-- Emerald & Gold Header Banner with Statistics (Distinct Library Style) -->
    <div class="header-gradient-card mb-4">
        <div class="row align-items-center g-4">
            <!-- Title & Subtitle -->
            <div class="col-lg-6 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2 px-3 shadow-sm border border-white border-opacity-25">
                        <i class="bi bi-book-half fs-3 text-warning"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0 text-white brand-font">Library Catalog</h2>
                        <p class="mb-0 text-white-50 small">Browse, search and manage cataloged books & publications</p>
                    </div>
                </div>
            </div>

            <!-- 3 Glass Stats Cards with Gold Accents -->
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
                    <span class="input-group-text bg-white border-end-0 text-success ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control border-start-0 ps-2" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Search books by title, author, ISBN code, or category..."
                    >
                    @if(!empty($search) || !empty($categoryId) || !empty($status) || ($sort !== 'newest'))
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary d-flex align-items-center" title="Clear Filters">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                    <button class="btn btn-primary px-4 fw-bold" type="submit">
                        <i class="bi bi-filter me-1"></i> Filter Catalog
                    </button>
                </div>
            </div>

            <!-- Dropdown Filters Row -->
            <div class="row g-2">
                <!-- Category Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-success border-end-0">
                            <i class="bi bi-tags"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="category_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($categoryId) || $categoryId === 'all' ? 'selected' : '' }}>All Book Categories</option>
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
                        <span class="input-group-text bg-light text-success border-end-0">
                            <i class="bi bi-arrow-down-up"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="sort" onchange="document.getElementById('filterForm').submit()">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest In Catalog</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest In Catalog</option>
                            <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>Title (A - Z)</option>
                            <option value="title_desc" {{ $sort === 'title_desc' ? 'selected' : '' }}>Title (Z - A)</option>
                        </select>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-success border-end-0">
                            <i class="bi bi-bookmark-check"></i>
                        </span>
                        <select class="form-select bg-light border-start-0" name="status" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>All Loan Statuses</option>
                            <option value="Available" {{ $status === 'Available' ? 'selected' : '' }}>Available (In Stock)</option>
                            <option value="Borrowed" {{ $status === 'Borrowed' ? 'selected' : '' }}>Borrowed (On Loan)</option>
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
                        <th>Book Title & Author</th>
                        <th>ISBN & Copies</th>
                        <th>Published Date</th>
                        <th>Shelf & Category</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <!-- ID -->
                            <td class="fw-bold text-success font-monospace">#{{ str_pad($book->book_id, 3, '0', STR_PAD_LEFT) }}</td>

                            <!-- Book Title & Author -->
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $book->title }}</div>
                                <div class="small text-muted"><i class="bi bi-pen me-1 text-success"></i>{{ $book->author }}</div>
                            </td>

                            <!-- ISBN & Copies -->
                            <td>
                                <div class="d-flex align-items-center gap-1 font-monospace small text-secondary">
                                    <i class="bi bi-upc-scan text-muted"></i>
                                    <span>{{ $book->isbn ?: 'No ISBN' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small mt-1">
                                    <span class="badge {{ $book->status === 'Available' ? 'status-badge-available' : ($book->status === 'Borrowed' ? 'status-badge-borrowed' : 'status-badge-reserved') }} px-2 py-1 rounded-pill">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.45rem;"></i>{{ $book->status }}
                                    </span>
                                    <span class="badge bg-light text-secondary border ms-1">
                                        <i class="bi bi-stack me-1"></i>{{ $book->copies }} {{ Str::plural('copy', $book->copies) }}
                                    </span>
                                </div>
                            </td>

                            <!-- Publication Date -->
                            <td>
                                <div class="d-flex align-items-center gap-1 small text-dark">
                                    <i class="bi bi-calendar-event text-success"></i>
                                    <span>{{ $book->published_date ? $book->published_date->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 small text-muted">
                                    <i class="bi bi-hourglass-split text-secondary"></i>
                                    <span>{{ $book->published_age }}</span>
                                </div>
                            </td>

                            <!-- Category & Shelf -->
                            <td>
                                <span class="category-badge mb-1">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ $book->category->category_name ?? 'Unassigned' }}
                                </span>
                                <div class="small text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $book->category->shelf_location ?? 'Main Stacks' }}
                                </div>
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
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Remove Book
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                Are you sure you want to remove <strong>{{ $book->title }}</strong> (ID: #{{ $book->book_id }}) from the library catalog?
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
                                <i class="bi bi-book fs-1 d-block mb-2 text-success opacity-50"></i>
                                <div class="fw-semibold">No books found matching your search criteria.</div>
                                <a href="{{ route('books.create') }}" class="btn btn-sm btn-primary mt-2 rounded-pill px-3">
                                    <i class="bi bi-plus-circle me-1"></i> Register New Book
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
                Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }} of {{ $books->total() }} cataloged books
            </div>
            <div>
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Back to Book Form Button -->
        <div class="d-grid mt-4">
            <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg rounded-3 fw-bold py-2 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> + Register New Book to Library
            </a>
        </div>
    </div>
</div>
@endsection
