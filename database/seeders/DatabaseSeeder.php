<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for Library Management System.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin & Librarian)
        User::updateOrCreate(
            ['email' => 'librarian@gmail.com'],
            [
                'name' => 'Head Librarian',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'adminwoman@gmail.com'],
            [
                'name' => 'Admin Woman',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Seed Categories
        $cs = Category::updateOrCreate(
            ['category_id' => 1],
            [
                'category_name' => 'Computer Science',
                'shelf_location' => 'Shelf CS-1',
                'floor_no' => 2,
            ]
        );

        $se = Category::updateOrCreate(
            ['category_id' => 2],
            [
                'category_name' => 'Software Engineering',
                'shelf_location' => 'Shelf SE-2',
                'floor_no' => 2,
            ]
        );

        $db = Category::updateOrCreate(
            ['category_id' => 3],
            [
                'category_name' => 'Database & Cloud Systems',
                'shelf_location' => 'Shelf DB-3',
                'floor_no' => 3,
            ]
        );

        $lit = Category::updateOrCreate(
            ['category_id' => 4],
            [
                'category_name' => 'General Literature & Research',
                'shelf_location' => 'Shelf GL-1',
                'floor_no' => 1,
            ]
        );

        // 3. Seed Books
        Book::updateOrCreate(
            ['book_id' => 1],
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0132350884',
                'published_date' => '2008-08-01',
                'status' => 'Available',
                'copies' => 5,
                'description' => 'A handbook of agile craftsmanship focusing on best software engineering principles and readable code.',
                'category_id' => $se->category_id,
            ]
        );

        Book::updateOrCreate(
            ['book_id' => 2],
            [
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'author' => 'Gang of Four (Erich Gamma, et al.)',
                'isbn' => '978-0201633610',
                'published_date' => '1994-10-21',
                'status' => 'Available',
                'copies' => 3,
                'description' => 'Classic text introducing 23 foundational design patterns for object-oriented architecture.',
                'category_id' => $se->category_id,
            ]
        );

        Book::updateOrCreate(
            ['book_id' => 3],
            [
                'title' => 'Database System Concepts',
                'author' => 'Abraham Silberschatz & Henry Korth',
                'isbn' => '978-0078022159',
                'published_date' => '2019-02-28',
                'status' => 'Borrowed',
                'copies' => 2,
                'description' => 'Comprehensive fundamentals of database management systems, relational algebra, SQL, and indexing.',
                'category_id' => $db->category_id,
            ]
        );

        Book::updateOrCreate(
            ['book_id' => 4],
            [
                'title' => 'Laravel: Up & Running: A Framework for Building Modern PHP Apps',
                'author' => 'Matt Stauffer',
                'isbn' => '978-1492041214',
                'published_date' => '2023-05-15',
                'status' => 'Available',
                'copies' => 6,
                'description' => 'Definitive guide covering the entire Laravel ecosystem, Eloquent ORM, Blade, and modern web APIs.',
                'category_id' => $cs->category_id,
            ]
        );

        Book::updateOrCreate(
            ['book_id' => 5],
            [
                'title' => 'The Pragmatic Programmer: Your Journey to Mastery',
                'author' => 'Andrew Hunt & David Thomas',
                'isbn' => '978-0135957059',
                'published_date' => '2019-09-13',
                'status' => 'Reserved',
                'copies' => 1,
                'description' => 'Timeless career insights, pragmatic practices, and coding craft for software developers.',
                'category_id' => $se->category_id,
            ]
        );
    }
}
