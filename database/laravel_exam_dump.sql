-- ========================================================
-- SETIC FINAL PROJECT EXAM LARAVEL 13
-- Database SQL Dump for MySQL / dbForge Studio / MariaDB
-- Database: laravel
-- ========================================================

CREATE DATABASE IF NOT EXISTS `laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laravel`;

-- --------------------------------------------------------
-- Table structure for table `departments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `dept_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(255) NOT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `departments`
-- --------------------------------------------------------
INSERT INTO `departments` (`dept_id`, `dept_name`, `manager_id`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 'Management Information System', 101, 1, NOW(), NOW()),
(2, 'Design', 102, 2, NOW(), NOW()),
(3, 'Computer Science', 103, 3, NOW(), NOW());

-- --------------------------------------------------------
-- Table structure for table `students`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `student_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL DEFAULT 'Male',
  `dob` date DEFAULT NULL,
  `enrollment` varchar(100) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `students_department_id_foreign` (`department_id`),
  CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`dept_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `students`
-- --------------------------------------------------------
INSERT INTO `students` (`student_id`, `student_name`, `email`, `gender`, `dob`, `enrollment`, `enrollment_date`, `description`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Kong Sopheak', 'kongsopheak@gmail.com', 'Male', '2002-05-15', '3.905874077043 years', '2022-01-01', NULL, 1, NOW(), NOW()),
(2, 'Ly Chhailin', 'lin@gmail.com', 'Female', '2003-08-20', '3.905874077043 years', '2022-01-01', NULL, 2, NOW(), NOW()),
(3, 'Pov Nita', 'povnita@gmail.com', 'Female', '2003-12-10', '2.6319014749248 years', '2023-04-11', 'OK', 1, NOW(), NOW()),
(4, 'Leng Makara', 'lengmakara@gmail.com', 'Male', '2004-03-25', '1.0729973653153 years', '2024-11-01', NULL, 2, NOW(), NOW());

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
-- Default login: adminwoman@gmail.com / password
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin Woman', 'adminwoman@gmail.com', NOW(), '$2y$12$4L1P3jB9bT37NlZ6Kk38xeuM2hG1E9.3M1V9Wp7p7L8b7I7oQ7xSy', NOW(), NOW());
