<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test 1: Auth pages can be rendered.
     */
    public function test_auth_pages_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login Form');

        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register Form');
    }

    /**
     * Test 2: User can register a new account.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Assistant Librarian',
            'email' => 'assistant@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/books');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'assistant@example.com']);
    }

    /**
     * Test 3: User can login with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'librarian@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/books');
        $this->assertAuthenticated();
    }

    /**
     * Test 4: Relationship between Category and Book works.
     */
    public function test_category_and_book_relationship(): void
    {
        $cat = Category::where('category_name', 'Software Engineering')->first();
        $this->assertNotNull($cat);

        $book = $cat->books()->first();
        $this->assertNotNull($book);
        $this->assertEquals($cat->category_id, $book->category->category_id);
    }

    /**
     * Test 5: CRUD - Create new book.
     */
    public function test_can_create_new_book(): void
    {
        $user = User::first();
        $cat = Category::first();

        $response = $this->actingAs($user)->post('/books', [
            'title' => 'Refactoring: Improving the Design of Existing Code',
            'author' => 'Martin Fowler',
            'isbn' => '978-0134757599',
            'published_date' => '2018-11-20',
            'status' => 'Available',
            'copies' => 4,
            'category_id' => $cat->category_id,
            'description' => 'A guide to refactoring patterns and clean code.',
        ]);

        $response->assertRedirect('/books');
        $this->assertDatabaseHas('books', [
            'title' => 'Refactoring: Improving the Design of Existing Code',
            'author' => 'Martin Fowler',
            'category_id' => $cat->category_id,
        ]);
    }

    /**
     * Test 6: Search and filter books.
     */
    public function test_search_and_filter_books(): void
    {
        $user = User::first();

        // Search for 'Clean Code'
        $response = $this->actingAs($user)->get('/books?search=Clean+Code');
        $response->assertStatus(200);
        $response->assertSee('Clean Code');
        $response->assertDontSee('Database System Concepts');

        // Filter by Status Borrowed
        $response = $this->actingAs($user)->get('/books?status=Borrowed');
        $response->assertStatus(200);
        $response->assertSee('Database System Concepts');
        $response->assertDontSee('Laravel: Up & Running');
    }

    /**
     * Test 7: CRUD - Update book.
     */
    public function test_can_update_book(): void
    {
        $user = User::first();
        $book = Book::first();
        $cat = Category::latest('category_id')->first();

        $response = $this->actingAs($user)->put("/books/{$book->book_id}", [
            'title' => 'Updated Book Title',
            'author' => 'Updated Author',
            'isbn' => '123-4567890',
            'published_date' => '2020-01-01',
            'status' => 'Reserved',
            'copies' => 10,
            'category_id' => $cat->category_id,
            'description' => 'Updated description.',
        ]);

        $response->assertRedirect('/books');
        $this->assertDatabaseHas('books', [
            'book_id' => $book->book_id,
            'title' => 'Updated Book Title',
            'category_id' => $cat->category_id,
        ]);
    }

    /**
     * Test 8: CRUD - Delete book.
     */
    public function test_can_delete_book(): void
    {
        $user = User::first();
        $book = Book::latest('book_id')->first();
        $id = $book->book_id;

        $response = $this->actingAs($user)->delete("/books/{$id}");
        $response->assertRedirect('/books');
        $this->assertDatabaseMissing('books', ['book_id' => $id]);
    }
}
