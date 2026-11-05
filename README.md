# Student Management System - Final Project Exam (Laravel 13)

A complete **Student Management System** developed in **Laravel 13** according to the SETIC Final Exam requirements.

---

## 📋 Exam Requirements Compliance Checklist

| No | Requirement | Implementation Status | Notes |
|:---|:---|:---:|:---|
| 1 | **Laravel Login & Register Form** | ✅ Complete | Centered UI matching slides (`views/login.blade.php`, `views/register.blade.php`) |
| 2 | **Migration Relationship Tables & Model Connection** | ✅ Complete | `departments` (PK: `dept_id`) 1:N `students` (FK: `department_id`) with Eloquent relationships |
| 3 | **Database Seeding** | ✅ Complete | Seeds exact sample data from exam slides (4 students, 3 departments, demo admin) |
| 4 | **CRUD Operations System** | ✅ Complete | Create, Read, Update, Delete for Students & Departments |
| 5 | **Search & Filtering** | ✅ Complete | Search by name/email/dept; Filter by Department; Filter by Gender; Sorting |
| 6 | **HTML Table & Directory UI** | ✅ Complete | Exact layout from slide 7 with stats counters, badges, and action buttons |
| 7 | **GitHub & Submission Package** | ✅ Complete | Ready for Git repository push & submission zip file |

---

## 🗄️ Database Schema & Relational Design

### 1. `departments` Table
* `dept_id` (BIGINT UNSIGNED, Primary Key, Auto Increment)
* `dept_name` (VARCHAR(255))
* `manager_id` (BIGINT UNSIGNED, Nullable)
* `location_id` (BIGINT UNSIGNED, Nullable)
* `created_at`, `updated_at` (Timestamps)

### 2. `students` Table
* `student_id` (BIGINT UNSIGNED, Primary Key, Auto Increment)
* `student_name` (VARCHAR(255))
* `email` (VARCHAR(255))
* `gender` (VARCHAR(20) - 'Male', 'Female', 'Other')
* `dob` (DATE, Nullable)
* `enrollment` (VARCHAR(100), Nullable - e.g. "3.905874077043 years")
* `enrollment_date` (DATE)
* `description` (TEXT, Nullable)
* `department_id` (BIGINT UNSIGNED, Foreign Key -> `departments.dept_id`, Cascade on Delete)
* `created_at`, `updated_at` (Timestamps)

---

## 👥 Seed Data (Matching Exam Slides 7 & 8)

### Default Admin Credentials:
* **Email:** `adminwoman@gmail.com`
* **Password:** `password`

### Departments:
1. `Management Information System` (Manager ID: 101, Location ID: 1)
2. `Design` (Manager ID: 102, Location ID: 2)
3. `Computer Science` (Manager ID: 103, Location ID: 3)

### Students:
1. **Kong Sopheak** - `kongsopheak@gmail.com` - Male - Enrolled: `2022-01-01` - Department: `Management Information System`
2. **Ly Chhailin** - `lin@gmail.com` - Female - Enrolled: `2022-01-01` - Department: `Design`
3. **Pov Nita** - `povnita@gmail.com` - Female - Enrolled: `2023-04-11` - Department: `Management Information System` (Note: `OK`)
4. **Leng Makara** - `lengmakara@gmail.com` - Male - Enrolled: `2024-11-01` - Department: `Design`

---

## 🚀 Getting Started

### 1. Prerequisites
* PHP >= 8.2 (PHP 8.3 recommended)
* Composer
* SQLite or MySQL

### 2. Setup Project
```bash
# Clone the repository
git clone <your-repository-url>
cd Web_final

# Install dependencies (if not already installed)
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Run Migrations and Seed Data
php artisan migrate:fresh --seed

# Start the Development Server
php artisan serve
```

Access the application in your web browser at:
`http://127.0.0.1:8000`

---

## 🧪 Running Automated Tests

```bash
php artisan test
```
All 10 feature & unit test assertions pass covering authentication, models, relationships, CRUD, search, and filtering.

---

## 📁 MySQL / dbForge Studio Import (Optional)
A ready-to-run SQL script matching slide 8 is available at:
`database/laravel_exam_dump.sql`
