@extends('layouts.app')

@section('title', 'Book Details - ' . $book->title)

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Header Card -->
            <div class="header-gradient-card text-center mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle p-3 mb-2 shadow-sm border border-white border-opacity-25">
                    <i class="bi bi-book-half fs-2 text-warning"></i>
                </div>
                <h3 class="fw-bold mb-1 brand-font text-white">{{ $book->title }}</h3>
                <p class="mb-0 text-white-50">Catalog ID #{{ str_pad($book->book_id, 3, '0', STR_PAD_LEFT) }} &bull; By {{ $book->author }}</p>
            </div>

            <!-- Details Card -->
            <div class="content-card p-4 p-md-5" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
                <div class="list-group list-group-flush mb-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-book me-2 text-success"></i> Full Title</span>
                        <span class="fw-bold text-dark text-end ms-3">{{ $book->title }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-person me-2 text-success"></i> Author</span>
                        <span class="text-dark fw-medium">{{ $book->author }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-upc-scan me-2 text-success"></i> ISBN Code</span>
                        <span class="text-secondary font-monospace">{{ $book->isbn ?: 'N/A' }}</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-tag me-2 text-success"></i> Category</span>
                        <span class="category-badge">
                            <i class="bi bi-tag-fill"></i>
                            {{ $book->category->category_name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-geo-alt me-2 text-success"></i> Shelf & Floor</span>
                        <span class="text-dark">{{ $book->category->shelf_location ?? 'Main Stacks' }} (Floor {{ $book->category->floor_no ?? 1 }})</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-bookmark-check me-2 text-success"></i> Status & Stock</span>
                        <div>
                            <span class="badge {{ $book->status === 'Available' ? 'status-badge-available' : ($book->status === 'Borrowed' ? 'status-badge-borrowed' : 'status-badge-reserved') }} rounded-pill px-3 py-2">
                                {{ $book->status }}
                            </span>
                            <span class="badge bg-light text-secondary border ms-1 py-2 px-3 rounded-pill">{{ $book->copies }} Copies</span>
                        </div>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary fw-semibold"><i class="bi bi-calendar-event me-2 text-success"></i> Published Date</span>
                        <span>{{ $book->published_date ? $book->published_date->format('M d, Y') : 'N/A' }} ({{ $book->published_age }})</span>
                    </div>

                    <div class="list-group-item py-3">
                        <div class="text-secondary fw-semibold mb-2"><i class="bi bi-file-earmark-text me-2 text-success"></i> Book Summary / Notes</div>
                        <div class="p-3 bg-light rounded-3 text-muted">
                            {{ $book->description ?: 'No additional description provided.' }}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to Catalog
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-warning rounded-pill px-4 text-dark fw-bold">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('books.destroy', $book->book_id) }}" onsubmit="return confirm('Delete this book?');" class="m-0">
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
