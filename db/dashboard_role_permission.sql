-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 07:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dashboard_role_permission`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_sections`
--

CREATE TABLE `app_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `button1_text` varchar(255) DEFAULT NULL,
  `button1_link` varchar(255) DEFAULT NULL,
  `button2_text` varchar(255) DEFAULT NULL,
  `button2_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_sections`
--

INSERT INTO `app_sections` (`id`, `project_id`, `title`, `subtitle`, `short_description`, `button1_text`, `button1_link`, `button2_text`, `button2_link`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Integrate with Human Resource Management App', 'An Automation Assistance For HR Manager', 'The most important advantage of this software is that you can use it on any type of smart device. Moreover, you can operate the entire system anytime and anywhere. So, using this feature, you can operate the system easily and smoothly.', 'Contact Us', 'www.facebook.com', 'Install Now', 'www.facebook.com', 'banner_1746249306_6815a65a62116.webp', '2025-05-02 23:15:06', '2025-05-02 23:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `button1_text` varchar(255) DEFAULT NULL,
  `button1_link` varchar(255) DEFAULT NULL,
  `button2_text` varchar(255) DEFAULT NULL,
  `button2_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `project_id`, `title`, `subtitle`, `short_description`, `button1_text`, `button1_link`, `button2_text`, `button2_link`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Integrate with Human Resource Management App', 'An Automation Assistance For HR Manager', 'The most important advantage of this software is that you can use it on any type of smart device. Moreover, you can operate the entire system anytime and anywhere. So, using this feature, you can operate the system easily and smoothly.  To learn details about this, please visit our app section.', 'Contact Us', 'www.facebook.com', 'Install Now', 'www.facebook.com', 'banners_1746441106_68189392eed6c.webp', '2025-04-28 05:56:34', '2025-05-05 04:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `project_id`, `category`, `title`, `slug`, `description`, `image`, `author`, `published_date`, `created_at`, `updated_at`) VALUES
(3, 1, 'Human Resource Management System', 'Types Of Fringe Benefits In HRM: Policy To Retain Motivation', NULL, 'I think almost every organisation deals with unproductive, lazy employees or employees with no motivation. And to avoid this kind of situation, every now and then, organisations have to work', 'blog_1746428713_6818632953fe2.webp', 'Pranto das', '2025-05-05', '2025-05-05 01:05:13', '2025-05-05 01:05:13'),
(4, 1, 'Human Resource Management', 'Employee Benefits in HRM: Policy', NULL, 'Human resources of an organisation are equally important as office premises. I think every organisation must treat employees like valuable assets of an organisation. And to do that, the organisation must introduce employee benefits in HRM policy, which will be favourable specially for employees. Every job-holder invests their valuable 9 to 10 hours in exchange for an agreeable remuneration every month. Employees do the same old monotonous tasks daily, resulting in boredom for almost every employee.', 'blog_1746428713_68186329556fb.webp', 'prantos', '2025-05-05', '2025-05-05 01:05:13', '2025-05-05 01:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Ict', 'banner_1746698598_681c81662878c.png', '2025-05-08 03:51:29', '2025-05-08 04:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp_no` varchar(255) DEFAULT NULL,
  `secondary_whatsapp_no` varchar(255) DEFAULT NULL,
  `telegram_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `whatsapp_no`, `secondary_whatsapp_no`, `telegram_no`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '+8801830701422', '+8801857675727', '+8801857675727', '2025-05-05 02:45:59', '2025-05-05 02:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `customer_messages`
--

CREATE TABLE `customer_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `requirements` longtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_messages`
--

INSERT INTO `customer_messages` (`id`, `name`, `email`, `phone`, `country`, `requirements`, `attachment`, `created_at`, `updated_at`) VALUES
(2, 'Pranto Das', 'prantochandrodas@gmail.com', '01724928794', 'Bangladesh', 'sdfsf', NULL, '2025-05-09 21:19:46', '2025-05-09 21:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `quesation` varchar(255) DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `project_id`, `quesation`, `answer`, `created_at`, `updated_at`) VALUES
(3, 1, 'What is HRMS software?', '<p><span style=\"color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 16px;\">HRMS Software or Human Resource Management system, is an automation technology solution that helps organisations manage various HR functions and operational activities. It automates processes related to employee management, recruitment, payroll, performance evaluation, and more.</span></p>', '2025-05-05 00:12:36', '2025-05-05 00:12:36'),
(4, 1, 'How does the Human Resource Management system benefit organisations?', '<p>sdfsf</p>', '2025-05-05 00:12:36', '2025-05-05 00:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `project_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Key Features of HRMS Software', 'HRMS software is the best solution for managing the human capital of any organisation. Because human resources software has lots of excellent time-saving features, in this section, we will point out those features:', '2025-04-29 02:02:26', '2025-04-29 02:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `features_details`
--

CREATE TABLE `features_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `features_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features_details`
--

INSERT INTO `features_details` (`id`, `features_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(4, 1, 'Attendance Form & Log', 'features_1745913746_68108792b5faf.webp', '2025-04-29 02:12:48', '2025-04-29 02:12:48'),
(5, 1, 'Department Management', 'features_1745913888_6810882068aa5.webp', '2025-04-29 02:12:48', '2025-04-29 02:12:48'),
(6, 1, 'Performance Appraisal Record', 'features_1745914368_68108a004485c.webp', '2025-04-29 02:12:48', '2025-04-29 02:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT 'logo.png',
  `favicon` varchar(255) DEFAULT 'favicon.png',
  `primary_color` varchar(255) NOT NULL,
  `secondary_color` varchar(255) NOT NULL,
  `primary_hover_color` varchar(255) NOT NULL,
  `secondary_hover_color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `name`, `email`, `phone`, `meta_description`, `meta_keywords`, `logo`, `favicon`, `primary_color`, `secondary_color`, `primary_hover_color`, `secondary_hover_color`, `created_at`, `updated_at`) VALUES
(1, 'Founder King', 'support@founderking.com', '01777777777', 'Founder King', 'Founder King', 'logo_1746702043_681c8edbcfa6c.png', 'favicon_1746701524_681c8cd427e51.png', '#10b981', '#6366f1', '#059669', '#4f46e5', '2025-04-28 01:54:25', '2025-05-08 05:00:43'),
(2, 'Founder King', 'support@founderking.com', '01777777777', 'Founder King', 'Founder King', 'logo.png', 'favicon.png', '#10B981', '#6366F1', '#059669', '#4F46E5', '2025-04-28 02:50:17', '2025-04-28 02:50:17'),
(3, 'Founder King', 'support@founderking.com', '01777777777', 'Founder King', 'Founder King', 'logo.png', 'favicon.png', '#10B981', '#6366F1', '#059669', '#4F46E5', '2025-04-28 05:22:39', '2025-04-28 05:22:39'),
(4, 'Founder King', 'support@founderking.com', '01777777777', 'Founder King', 'Founder King', 'logo.png', 'favicon.png', '#10B981', '#6366F1', '#059669', '#4F46E5', '2025-04-28 22:47:26', '2025-04-28 22:47:26'),
(5, 'Founder King', 'support@founderking.com', '01777777777', 'Founder King', 'Founder King', 'logo.png', 'favicon.png', '#10B981', '#6366F1', '#059669', '#4F46E5', '2025-05-05 02:38:35', '2025-05-05 02:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(2, 'FinTech', 'industry_1746704821_681c99b59e9f0.png', '2025-05-08 05:47:01', '2025-05-08 05:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_11_033442_create_permission_tables', 1),
(6, '2025_02_11_052818_create_general_settings_table', 1),
(7, '2025_02_22_043114_create_sliders_table', 1),
(8, '2025_04_28_082504_create_projects_table', 2),
(10, '2025_04_28_104525_create_banners_table', 3),
(11, '2025_04_29_043241_create_objectives_table', 4),
(12, '2025_04_29_043623_create_objective_details_table', 5),
(15, '2025_04_29_073032_create_features_table', 6),
(16, '2025_04_29_073048_create_features_details_table', 6),
(17, '2025_04_29_085556_create_organizations_table', 7),
(18, '2025_04_29_085613_create_organization_posts_table', 7),
(25, '2025_04_29_095830_create_modules_table', 8),
(26, '2025_04_29_095957_create_module_details_table', 8),
(27, '2025_05_03_044807_create_app_sections_table', 9),
(29, '2025_05_05_052002_create_faqs_table', 10),
(30, '2025_05_05_061904_create_blogs_table', 11),
(31, '2025_05_05_073722_create_contacts_table', 12),
(32, '2025_05_06_102818_create_customer_messages_table', 13),
(33, '2025_05_08_033643_add_logo_project', 14),
(34, '2025_05_08_065713_create_website_banners_table', 15),
(35, '2025_05_08_084345_create_industries_table', 16),
(36, '2025_05_08_093124_create_clients_table', 17),
(37, '2025_05_08_100627_create_service_infos_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `project_id`, `heading`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Modules Of Human Resource Management System', 'HRMS software is full of excellent modules, which help make all the tasks easier for an HR. With the assistance of a human capital management system, an HR can operate the entire system smoothly and bug-free.', '2025-04-29 06:03:28', '2025-04-29 06:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `module_details`
--

CREATE TABLE `module_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_details`
--

INSERT INTO `module_details` (`id`, `module_id`, `title`, `image`, `description`, `created_at`, `updated_at`) VALUES
(4, 1, 'Employee Retention', 'module_1745928208_6810c01008109.webp', '<h3 class=\"fw-semibold text-black tab_title\" style=\"margin-top: 0px; margin-bottom: 0.5rem; line-height: 30px; font-size: 20px; color: rgb(47, 47, 47); font-family: Poppins, sans-serif; font-weight: 600 !important;\">Employee Management</h3><p class=\"fs-16 fw-normal my-3\" style=\"font-size: 16px; color: rgb(33, 37, 41); font-family: Poppins, sans-serif; margin-top: 1rem !important; margin-bottom: 1rem !important;\">The employee management module helps HR manage or add any employee to the organisation\'s track record. HR can use this module to record the promotion/ demotion graph, and performance of an employee, so that at year-end it gets easier to evaluate that employee.</p><p class=\"fw-bold fs-18\" style=\"margin-bottom: 1rem; font-size: 18px; color: rgb(33, 37, 41); font-family: Poppins, sans-serif;\">Submodule of Employee Management</p><ul style=\"margin-bottom: 1rem; color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 16px;\"><li>Promotion &amp; demotion track</li><li>Add Employee</li><li>Manage Employee</li><li>Employee Performance</li></ul>', '2025-05-02 22:40:04', '2025-05-02 22:40:04'),
(5, 1, 'Payroll Management', 'module_1746247204_68159e2473fc2.webp', '<div class=\"col-md-6 px-4\" style=\"width: 365.328px; max-width: 100%; margin-top: 0px; color: rgb(33, 37, 41); font-family: Poppins, sans-serif; font-size: 16px; padding-right: 1.5rem !important; padding-left: 1.5rem !important;\"><h3 class=\"fw-semibold text-black tab_title\" style=\"margin-top: 0px; margin-bottom: 0.5rem; line-height: 30px; font-size: 20px; color: rgb(47, 47, 47); font-weight: 600 !important;\">Payroll Management</h3><p class=\"fs-16 fw-normal my-3\" style=\"margin-top: 1rem !important; margin-bottom: 1rem !important;\">Using this module, an HR can maintain all the employees\' salary-related activities. Moreover, HR can add, manage and set up the range of salary.</p><p class=\"fw-bold fs-18\" style=\"margin-bottom: 1rem; font-size: 18px;\">Submodule of Payroll system:</p><ul style=\"margin-bottom: 1rem;\"><li>Salary Advance</li><li>Salary Generate</li><li>Manage Employee Salary</li></ul><a href=\"file:///C:/Users/STITBD%2083/Downloads/hrm/contact.html\" target=\"_blank\" class=\"btn btn_getTouch px-5 py-3 text-center text-white\" style=\"line-height: 1.5; border-width: 1px; border-style: solid; border-color: transparent; font-size: 1rem; border-radius: 5px; background-image: linear-gradient(to right, rgb(43, 206, 112), rgb(61, 229, 135) 64%, rgb(44, 206, 114)); color: rgb(255, 255, 255) !important; padding: 1rem 3rem !important;\">Request for Demo</a></div><div><br></div>', '2025-05-02 22:40:04', '2025-05-02 22:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `objectives`
--

CREATE TABLE `objectives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `objectives`
--

INSERT INTO `objectives` (`id`, `project_id`, `title`, `description`, `button_text`, `button_url`, `created_at`, `updated_at`) VALUES
(2, 1, 'HRMS Software', 'This section will highlight all the main goals of integrating HRMS software in your organisation. The most general objective of having human resource software is to ensure a flawless working environment & experience for all the employees associated with the organisational goal.', 'Get in Touch', 'www.facebook.com', '2025-04-28 23:24:44', '2025-04-28 23:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `objective_details`
--

CREATE TABLE `objective_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `objective_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `objective_details`
--

INSERT INTO `objective_details` (`id`, `objective_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(30, 2, 'Reaching Organisational Goals', 'objectives_1745910799_68107c0fe5ea3.webp', '2025-04-29 01:14:50', '2025-04-29 01:14:50'),
(31, 2, 'Data Analysis and Compliance', 'objectives_1745910799_68107c0fe72e7.webp', '2025-04-29 01:14:50', '2025-04-29 01:14:50'),
(32, 2, 'Healthy Working Culture', 'objectives_1745910890_68107c6ac8e4d.webp', '2025-04-29 01:14:50', '2025-04-29 01:14:50'),
(33, 3, 'Employee Retention', 'objectives_1745915043_68108ca3c1e06.webp', '2025-04-29 02:24:03', '2025-04-29 02:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `project_id`, `heading`, `created_at`, `updated_at`) VALUES
(1, 1, 'HRMS Software Will Be Your Organization Data Warehouse', '2025-04-29 03:45:45', '2025-04-29 03:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `organization_posts`
--

CREATE TABLE `organization_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_posts`
--

INSERT INTO `organization_posts` (`id`, `organization_id`, `title`, `short_description`, `image`, `created_at`, `updated_at`) VALUES
(8, 1, 'Employee Personal & Performance Data', 'Only with HRMS software can HR create & record all the essential details about an employee in the employee profile module.', 'organization_1745919945_68109fc9174f4.webp', '2025-04-29 03:55:26', '2025-04-29 03:55:26'),
(9, 1, 'Recruiters Data', 'With human resource software, HR can record the recruiters\' resumes, the recruitment process, results, interview dates, and performance.', 'organization_1745919945_68109fc918993.webp', '2025-04-29 03:55:26', '2025-04-29 03:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'web', 'dashboard', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(2, 'user.list', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(3, 'user.create', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(4, 'user.edit', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(5, 'user.delete', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(6, 'user.profile', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(7, 'user.profile.update', 'web', 'user', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(8, 'project.list', 'web', 'project', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(9, 'project.create', 'web', 'project', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(10, 'project.edit', 'web', 'project', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(11, 'project.delete', 'web', 'project', '2025-05-05 02:38:35', '2025-05-05 02:38:35'),
(12, 'project.profile', 'web', 'project', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(13, 'project.profile.update', 'web', 'project', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(14, 'project.banner.create', 'web', 'project', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(15, 'project.objective.create', 'web', 'project', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(16, 'role.list', 'web', 'role', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(17, 'role.create', 'web', 'role', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(18, 'role.edit', 'web', 'role', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(19, 'role.delete', 'web', 'role', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(20, 'role.permissions', 'web', 'role', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(21, 'general.settings', 'web', 'settings', '2025-05-05 02:38:36', '2025-05-05 02:38:36'),
(22, 'slider.update', 'web', 'settings', '2025-05-05 02:38:36', '2025-05-05 02:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `logo`, `slug`, `description`, `status`, `url`, `created_at`, `updated_at`) VALUES
(1, 'HRMS Software', 'logo_1746704495_681c986f335f9.png', 'hrms-software', 'A web-based system designed to manage employee records, attendance, leave requests, salary processing, and performance tracking. Helps HR departments streamline daily operations and improve workforce management.', 1, 'https://youtube.com/shorts/G3r9y0xY4MY?feature=sharesssss', '2025-04-28 03:48:28', '2025-05-08 05:41:35'),
(2, 'courier software', 'logo_1746704548_681c98a4c20b3.png', 'courier-software', 'A platform that handles parcel booking, real-time tracking, delivery management, rider assignments, and branch coordination. Useful for managing both local and national courier services efficiently.', 1, 'https://www.stitbd.com', '2025-04-29 02:14:08', '2025-05-08 05:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-05-05 02:38:35', '2025-05-05 02:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_infos`
--

CREATE TABLE `service_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_infos`
--

INSERT INTO `service_infos` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Transform Your Vision Into Reality Design Any Customized Software', 'stitbd, Inc. focuses on the exact requirements of the clients. We design and develop the best and most advanced software for all types of businesses.', '2025-05-08 04:20:50', '2025-05-08 04:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_end` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `bg_color` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `button_details` varchar(255) NOT NULL,
  `button_text` varchar(255) NOT NULL,
  `button_url` varchar(255) NOT NULL DEFAULT '#',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `title_end`, `bio`, `bg_color`, `video_url`, `button_details`, `button_text`, `button_url`, `created_at`, `updated_at`) VALUES
(1, 'Create Leads, Sell Products, Run Courses, and Create High Converting', 'Sales Funnels', 'All Without Coding!', '#111827', 'https://www.youtube.com/watch?v=W6BlwzAhJ88', 'From Grabbing Visitors\' Attention To Converting Them Into Leads And Sales…', 'Get Started With Founder King', '#', '2025-04-28 01:54:26', '2025-04-28 01:54:26'),
(2, 'Create Leads, Sell Products, Run Courses, and Create High Converting', 'Sales Funnels', 'All Without Coding!', '#111827', 'https://www.youtube.com/watch?v=W6BlwzAhJ88', 'From Grabbing Visitors\' Attention To Converting Them Into Leads And Sales…', 'Get Started With Founder King', '#', '2025-04-28 02:50:18', '2025-04-28 02:50:18'),
(3, 'Create Leads, Sell Products, Run Courses, and Create High Converting', 'Sales Funnels', 'All Without Coding!', '#111827', 'https://www.youtube.com/watch?v=W6BlwzAhJ88', 'From Grabbing Visitors\' Attention To Converting Them Into Leads And Sales…', 'Get Started With Founder King', '#', '2025-04-28 05:22:40', '2025-04-28 05:22:40'),
(4, 'Create Leads, Sell Products, Run Courses, and Create High Converting', 'Sales Funnels', 'All Without Coding!', '#111827', 'https://www.youtube.com/watch?v=W6BlwzAhJ88', 'From Grabbing Visitors\' Attention To Converting Them Into Leads And Sales…', 'Get Started With Founder King', '#', '2025-04-28 22:47:27', '2025-04-28 22:47:27'),
(5, 'Create Leads, Sell Products, Run Courses, and Create High Converting', 'Sales Funnels', 'All Without Coding!', '#111827', 'https://www.youtube.com/watch?v=W6BlwzAhJ88', 'From Grabbing Visitors\' Attention To Converting Them Into Leads And Sales…', 'Get Started With Founder King', '#', '2025-05-05 02:38:36', '2025-05-05 02:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'photo.png',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2025-04-28 01:54:25', '$2y$12$.dpv8Q3Q1AS0On7oRbYjHupkdRoLOK0q0Af2S/SXH3Qt6yPJAQSDC', 'user_1745841766.jpg', '5lrYz78QYA', '2025-04-28 01:54:25', '2025-04-28 06:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `website_banners`
--

CREATE TABLE `website_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `website_banners`
--

INSERT INTO `website_banners` (`id`, `title`, `subtitle`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Our Services', 'Best Offshore Software, Application, Digital & IT Solution', 'At stitbd, we prioritize innovation, reliability, and client satisfaction. Let\'s accelerate together to your goal with our best software & IT service today.', 'banner_1746692566_681c69d6aa461.webp', '2025-05-08 02:12:14', '2025-05-08 02:22:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_sections`
--
ALTER TABLE `app_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_messages`
--
ALTER TABLE `customer_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features_details`
--
ALTER TABLE `features_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_details`
--
ALTER TABLE `module_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objectives`
--
ALTER TABLE `objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objective_details`
--
ALTER TABLE `objective_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_posts`
--
ALTER TABLE `organization_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `service_infos`
--
ALTER TABLE `service_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `website_banners`
--
ALTER TABLE `website_banners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_sections`
--
ALTER TABLE `app_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_messages`
--
ALTER TABLE `customer_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `features_details`
--
ALTER TABLE `features_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_details`
--
ALTER TABLE `module_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `objectives`
--
ALTER TABLE `objectives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `objective_details`
--
ALTER TABLE `objective_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization_posts`
--
ALTER TABLE `organization_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_infos`
--
ALTER TABLE `service_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `website_banners`
--
ALTER TABLE `website_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
