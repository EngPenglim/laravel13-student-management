<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of books with search, filters, and statistics.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');
        $sort = $request->input('sort', 'newest');

        $query = Book::with('category');

        // Search by book title, author, isbn, or category name
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('category_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Category
        if (!empty($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        // Filter by Status
        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        // Sorting
        switch ($sort) {
            case 'oldest':
                $query->orderBy('book_id', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('book_id', 'desc');
                break;
        }

        $books = $query->paginate(10)->withQueryString();

        // Calculate statistics
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $availableBooks = Book::where('status', 'Available')->count();

        $categories = Category::orderBy('category_name')->get();

        return view('books.index', compact(
            'books',
            'categories',
            'totalBooks',
            'totalCategories',
            'availableBooks',
            'search',
            'categoryId',
            'status',
            'sort'
        ));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'published_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Available,Borrowed,Reserved'],
            'copies' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,category_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book registered in library successfully!');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load('category');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('category_name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'published_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Available,Borrowed,Reserved'],
            'copies' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,category_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book details updated successfully!');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book)
    {
        $title = $book->title;
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', "Book '{$title}' removed from library successfully!");
    }
}
