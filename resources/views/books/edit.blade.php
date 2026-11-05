@extends('layouts.app')

@section('title', 'Edit Book - ' . $book->title)

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Banner -->
            <div class="header-gradient-card text-center mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle p-3 mb-2 shadow-sm border border-white border-opacity-25">
                    <i class="bi bi-pencil-square fs-2 text-warning"></i>
                </div>
                <h3 class="fw-bold mb-1 brand-font text-white">Edit Book Details</h3>
                <p class="mb-0 text-white-50">Update catalog info for Book #{{ $book->book_id }}</p>
            </div>

            <!-- Edit Form Card -->
            <div class="content-card p-4 p-md-5" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
                <form method="POST" action="{{ route('books.update', $book->book_id) }}" id="bookEditForm">
                    @csrf
                    @method('PUT')

                    <!-- 1. Book Details Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-success text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-journal-bookmark fs-5"></i> 1. Book Details
                        </h6>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Book Title</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-book"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control bg-light border-start-0 ps-0 @error('title') is-invalid @enderror" 
                                    name="title" 
                                    value="{{ old('title', $book->title) }}" 
                                    required
                                >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Author / Writer</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-pen"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control bg-light border-start-0 ps-0 @error('author') is-invalid @enderror" 
                                    name="author" 
                                    value="{{ old('author', $book->author) }}" 
                                    required
                                >
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ISBN -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">ISBN Code</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-success">
                                    <i class="bi bi-upc-scan"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control bg-light border-start-0 ps-0 @error('isbn') is-invalid @enderror" 
                                    name="isbn" 
                                    value="{{ old('isbn', $book->isbn) }}"
                                >
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 2. Catalog Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-success text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-archive fs-5"></i> 2. Catalog & Shelf Information
                        </h6>

                        <div class="row g-3 mb-3">
                            <!-- Published Date -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Publication Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        class="form-control bg-light border-start-0 ps-0 @error('published_date') is-invalid @enderror" 
                                        name="published_date" 
                                        value="{{ old('published_date', $book->published_date ? $book->published_date->format('Y-m-d') : '') }}" 
                                        required
                                    >
                                    @error('published_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Copies Available -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Total Copies</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-stack"></i>
                                    </span>
                                    <input 
                                        type="number" 
                                        class="form-control bg-light border-start-0 ps-0 @error('copies') is-invalid @enderror" 
                                        name="copies" 
                                        value="{{ old('copies', $book->copies) }}" 
                                        min="1" 
                                        required
                                    >
                                    @error('copies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Category Selection -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Category / Shelf</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-tag"></i>
                                    </span>
                                    <select class="form-select bg-light border-start-0 ps-0 @error('category_id') is-invalid @enderror" name="category_id" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->category_id }}" {{ old('category_id', $book->category_id) == $cat->category_id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Selection -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-bookmark-check"></i>
                                    </span>
                                    <select class="form-select bg-light border-start-0 ps-0 @error('status') is-invalid @enderror" name="status" required>
                                        <option value="Available" {{ old('status', $book->status) == 'Available' ? 'selected' : '' }}>Available (On Shelf)</option>
                                        <option value="Borrowed" {{ old('status', $book->status) == 'Borrowed' ? 'selected' : '' }}>Borrowed (Checked Out)</option>
                                        <option value="Reserved" {{ old('status', $book->status) == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Additional Information Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-success text-uppercase letter-spacing-1 d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-file-earmark-text fs-5"></i> 3. Summary & Description
                        </h6>

                        <div class="mb-3">
                            <textarea 
                                class="form-control bg-light @error('description') is-invalid @enderror" 
                                name="description" 
                                rows="3"
                            >{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-3 shadow-sm">
                            <i class="bi bi-check-lg"></i> Update Book Details
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
