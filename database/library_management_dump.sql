-- ========================================================
-- SETIC FINAL PROJECT EXAM LARAVEL 13
-- TOPIC 3: LIBRARY MANAGEMENT SYSTEM
-- Database SQL Dump for MySQL / dbForge Studio / MariaDB
-- Database: laravel
-- ========================================================

CREATE DATABASE IF NOT EXISTS `laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laravel`;

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `shelf_location` varchar(100) DEFAULT NULL,
  `floor_no` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `categories`
-- --------------------------------------------------------
INSERT INTO `categories` (`category_id`, `category_name`, `shelf_location`, `floor_no`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science', 'Shelf CS-1', 2, NOW(), NOW()),
(2, 'Software Engineering', 'Shelf SE-2', 2, NOW(), NOW()),
(3, 'Database & Cloud Systems', 'Shelf DB-3', 3, NOW(), NOW()),
(4, 'General Literature & Research', 'Shelf GL-1', 1, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `books`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `published_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Available',
  `copies` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `books_category_id_foreign` (`category_id`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `books`
-- --------------------------------------------------------
INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `published_date`, `status`, `copies`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Robert C. Martin', '978-0132350884', '2008-08-01', 'Available', 5, 'A handbook of agile craftsmanship focusing on best software engineering principles and readable code.', 2, NOW(), NOW()),
(2, 'Design Patterns: Elements of Reusable Object-Oriented Software', 'Gang of Four (Erich Gamma, et al.)', '978-0201633610', '1994-10-21', 'Available', 3, 'Classic text introducing 23 foundational design patterns for object-oriented architecture.', 2, NOW(), NOW()),
(3, 'Database System Concepts', 'Abraham Silberschatz & Henry Korth', '978-0078022159', '2019-02-28', 'Borrowed', 2, 'Comprehensive fundamentals of database management systems, relational algebra, SQL, and indexing.', 3, NOW(), NOW()),
(4, 'Laravel: Up & Running: A Framework for Building Modern PHP Apps', 'Matt Stauffer', '978-1492041214', '2023-05-15', 'Available', 6, 'Definitive guide covering the entire Laravel ecosystem, Eloquent ORM, Blade, and modern web APIs.', 1, NOW(), NOW()),
(5, 'The Pragmatic Programmer: Your Journey to Mastery', 'Andrew Hunt & David Thomas', '978-0135957059', '2019-09-13', 'Reserved', 1, 'Timeless career insights, pragmatic practices, and coding craft for software developers.', 2, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `users`
-- Default logins: librarian@gmail.com / password
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Head Librarian', 'librarian@gmail.com', NOW(), '$2y$12$4L1P3jB9bT37NlZ6Kk38xeuM2hG1E9.3M1V9Wp7p7L8b7I7oQ7xSy', NOW(), NOW()),
(2, 'Admin Woman', 'adminwoman@gmail.com', NOW(), '$2y$12$4L1P3jB9bT37NlZ6Kk38xeuM2hG1E9.3M1V9Wp7p7L8b7I7oQ7xSy', NOW(), NOW());
