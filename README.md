# Library Management System - Final Project Exam (Laravel 13)

A complete **Library Management System** developed in **Laravel 13** according to the SETIC Final Exam requirements (Topic #3 from the exam topics list).

---

## 📋 Exam Requirements Compliance Checklist

| No | Requirement | Implementation Status | Notes |
|:---|:---|:---:|:---|
| 1 | **Laravel Login & Register Form** | ✅ Complete | Clean centered UI (`views/login.blade.php`, `views/register.blade.php`) matching slide designs |
| 2 | **Migration Relationship Tables & Model Connection** | ✅ Complete | `categories` (PK: `category_id`) 1:N `books` (FK: `category_id`) with full Eloquent relations |
| 3 | **Database Seeding** | ✅ Complete | Seeds realistic academic & CS books, categories, and librarian user account |
| 4 | **CRUD Operations System** | ✅ Complete | Create, Read, Update, Delete for Books & Categories |
| 5 | **Search & Filtering** | ✅ Complete | Live search by title/author/ISBN/category; Filter by category & status; Sorting |
| 6 | **HTML Table & Directory UI** | ✅ Complete | Gradient header, 3 glass stat cards, badges, and action buttons |
| 7 | **GitHub & Submission Package** | ✅ Complete | Ready for Git repository push & submission zip file |

---

## 🗄️ Database Schema & Relational Design

### 1. `categories` Table
* `category_id` (BIGINT UNSIGNED, Primary Key, Auto Increment)
* `category_name` (VARCHAR(255))
* `shelf_location` (VARCHAR(100), Nullable - e.g. "Shelf CS-1")
* `floor_no` (INT UNSIGNED, Default: 1)
* `created_at`, `updated_at` (Timestamps)

### 2. `books` Table
* `book_id` (BIGINT UNSIGNED, Primary Key, Auto Increment)
* `title` (VARCHAR(255))
* `author` (VARCHAR(255))
* `isbn` (VARCHAR(50), Nullable - e.g. "978-0132350884")
* `published_date` (DATE)
* `status` (VARCHAR(30) - 'Available', 'Borrowed', 'Reserved')
* `copies` (INT UNSIGNED, Default: 1)
* `description` (TEXT, Nullable)
* `category_id` (BIGINT UNSIGNED, Foreign Key -> `categories.category_id`, Cascade on Delete)
* `created_at`, `updated_at` (Timestamps)

---

## 👥 Seed Data & Default Logins

### Default Credentials:
* **Librarian Email:** `librarian@gmail.com`
* **Admin Email:** `adminwoman@gmail.com`
* **Password:** `password`

### Categories:
1. `Computer Science` (Shelf: `Shelf CS-1`, Floor: 2)
2. `Software Engineering` (Shelf: `Shelf SE-2`, Floor: 2)
3. `Database & Cloud Systems` (Shelf: `Shelf DB-3`, Floor: 3)
4. `General Literature & Research` (Shelf: `Shelf GL-1`, Floor: 1)

### Sample Books:
1. **Clean Code: A Handbook of Agile Software Craftsmanship** – Robert C. Martin – Status: `Available`
2. **Design Patterns: Elements of Reusable Object-Oriented Software** – Gang of Four – Status: `Available`
3. **Database System Concepts** – Abraham Silberschatz & Henry Korth – Status: `Borrowed`
4. **Laravel: Up & Running** – Matt Stauffer – Status: `Available`
5. **The Pragmatic Programmer** – Andrew Hunt & David Thomas – Status: `Reserved`

---

## 🚀 Getting Started

```bash
# 1. Start the Laravel development server
php artisan serve

# 2. Access in your browser:
http://127.0.0.1:8000
```

---

## 🧪 Automated Tests

Run the test suite:
```bash
php artisan test
```
All 10 tests pass covering Authentication, Model Relationships, Book CRUD, Search, and Filtering.

---

## 📁 MySQL / dbForge Studio Import
A ready-to-run SQL script is available at:
`database/library_management_dump.sql`
