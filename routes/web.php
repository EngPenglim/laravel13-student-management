<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Library Management System
|--------------------------------------------------------------------------
*/

// Home redirects to library book directory or login
Route::get('/', function () {
    return redirect()->route('books.index');
});

// Authentication Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Books Resource CRUD (Index, Create, Store, Show, Edit, Update, Destroy)
    Route::resource('books', BookController::class);

    // Categories Resource CRUD
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
});
