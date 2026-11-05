@extends('layouts.app')

@section('title', 'Book Registration - Library Management System')

@section('content')
<div class="container py-3">
    <!-- Page Super Header -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark mb-1 brand-font">Library Management System</h2>
        <p class="text-muted small">SETIC Final Project Exam &bull; Laravel 13 &bull; Candidate: <strong>Noun Sinat</strong></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Banner -->
            <div class="header-gradient-card text-center mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle p-3 mb-2 shadow-sm border border-white border-opacity-25">
                    <i class="bi bi-book-half fs-2 text-warning"></i>
                </div>
                <h3 class="fw-bold mb-1 brand-font text-white">Book Registration</h3>
                <p class="mb-0 text-white-50">Complete the form below to catalog a new book into the collection</p>
            </div>

            <!-- Registration Form Card -->
            <div class="content-card p-4 p-md-5" style="border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
                <form method="POST" action="{{ route('books.store') }}" id="bookForm">
                    @csrf

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
                                    value="{{ old('title') }}" 
                                    placeholder="e.g. Clean Code: A Handbook of Agile Software Craftsmanship" 
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
                                    value="{{ old('author') }}" 
                                    placeholder="e.g. Robert C. Martin" 
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
                                    value="{{ old('isbn') }}" 
                                    placeholder="e.g. 978-0132350884"
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
                                        value="{{ old('published_date') }}" 
                                        required
                                    >
                                    @error('published_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Copies Available -->
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-semibold">Total Physical Copies</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-stack"></i>
                                    </span>
                                    <input 
                                        type="number" 
                                        class="form-control bg-light border-start-0 ps-0 @error('copies') is-invalid @enderror" 
                                        name="copies" 
                                        value="{{ old('copies', 1) }}" 
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
                                <label class="form-label text-secondary small fw-semibold">Book Category / Shelf</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-tag"></i>
                                    </span>
                                    <select class="form-select bg-light border-start-0 ps-0 @error('category_id') is-invalid @enderror" name="category_id" required>
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                                                {{ $cat->category_name }} ({{ $cat->shelf_location ?? 'Floor ' . $cat->floor_no }})
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
                                <label class="form-label text-secondary small fw-semibold">Loan Status</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-bookmark-check"></i>
                                    </span>
                                    <select class="form-select bg-light border-start-0 ps-0 @error('status') is-invalid @enderror" name="status" required>
                                        <option value="Available" {{ old('status', 'Available') == 'Available' ? 'selected' : '' }}>Available (On Shelf)</option>
                                        <option value="Borrowed" {{ old('status') == 'Borrowed' ? 'selected' : '' }}>Borrowed (Checked Out)</option>
                                        <option value="Reserved" {{ old('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
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
                            <i class="bi bi-file-earmark-text fs-5"></i> 3. Summary & Synopsis
                        </h6>

                        <div class="mb-3">
                            <textarea 
                                class="form-control bg-light @error('description') is-invalid @enderror" 
                                name="description" 
                                rows="3" 
                                placeholder="Enter summary, topics covered, or notes about this book"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-3 shadow-sm">
                            <i class="bi bi-check-circle-fill"></i> Submit Registration
                        </button>
                        <button type="reset" class="btn btn-outline-secondary px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-success text-white px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-3 ms-auto shadow-sm">
                            <i class="bi bi-journal-bookmark-fill"></i> View Book Catalog
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
