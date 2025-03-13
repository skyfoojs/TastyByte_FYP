-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-03-13 16:25:18
-- 服务器版本： 5.7.44-log
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `www_tastybyte_my`
--

-- --------------------------------------------------------
CREATE DATABASE tastybyte_pos;

use tastybyte_pos;
--
-- 表的结构 `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `categoryID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`categoryID`, `name`, `status`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'Food', 'Available', '1', '2025-01-07 12:27:43', '2025-02-18 18:05:55'),
(2, 'Beverage', 'Available', '3', NULL, '2025-03-08 16:15:30'),
(3, 'Combo Set', 'Available', '2', '2025-03-08 15:41:10', '2025-03-08 16:15:23');

-- --------------------------------------------------------

--
-- 表的结构 `customizablecategory`
--

CREATE TABLE `customizablecategory` (
  `customizeCategoryID` bigint(20) UNSIGNED NOT NULL,
  `productID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singleChoose` tinyint(1) NOT NULL,
  `isRequired` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `customizablecategory`
--

INSERT INTO `customizablecategory` (`customizeCategoryID`, `productID`, `name`, `status`, `sort`, `singleChoose`, `isRequired`, `created_at`, `updated_at`) VALUES
(6, 9, 'Chicken Type', 'Available', '1', 1, 0, '2025-03-08 15:20:47', '2025-03-10 01:35:29'),
(7, 9, 'Spicy Level', 'Available', '1', 1, 0, '2025-03-08 15:20:47', '2025-03-10 06:46:58'),
(8, 10, 'Chicken Type', 'Available', '1', 1, 0, '2025-03-08 15:27:10', '2025-03-10 01:35:39'),
(9, 11, 'Spread Type', 'Available', '1', 1, 1, '2025-03-08 15:30:21', '2025-03-10 01:35:18'),
(10, 12, 'Cooking Level', 'Available', '1', 1, 0, '2025-03-08 15:34:36', '2025-03-10 01:35:48'),
(11, 13, 'Bread Spread Type', 'Available', '1', 1, 0, '2025-03-08 15:41:10', '2025-03-10 01:35:58'),
(12, 13, 'Egg Cooking Level', 'Available', '2', 1, 0, '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(13, 14, 'Spicy Level', 'Available', '1', 1, 0, '2025-03-08 15:45:13', '2025-03-10 01:36:06'),
(14, 15, 'Noodle Type', 'Available', '1', 1, 0, '2025-03-08 15:49:57', '2025-03-10 01:36:19'),
(15, 16, 'Spicy Level', 'Available', '1', 1, 0, '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(16, 16, 'Noodle Type', 'Available', '1', 1, 0, '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(17, 17, 'Type', 'Available', '1', 1, 1, '2025-03-08 16:14:26', '2025-03-08 16:14:26'),
(18, 18, 'Type', 'Available', '1', 1, 1, '2025-03-08 16:17:20', '2025-03-08 16:17:20'),
(19, 19, 'Type', 'Available', '1', 1, 1, '2025-03-08 16:18:37', '2025-03-08 16:18:37'),
(20, 20, 'Spicy Level', 'Available', '1', 1, 0, '2025-03-10 01:28:40', '2025-03-10 01:28:40');

-- --------------------------------------------------------

--
-- 表的结构 `customizableoptions`
--

CREATE TABLE `customizableoptions` (
  `customizeOptionsID` bigint(20) UNSIGNED NOT NULL,
  `customizeCategoryID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxAmount` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `customizableoptions`
--

INSERT INTO `customizableoptions` (`customizeOptionsID`, `customizeCategoryID`, `name`, `maxAmount`, `status`, `sort`, `created_at`, `updated_at`) VALUES
(10, 6, 'Thigh', 10, 'Available', '1', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(11, 6, 'Breast', 10, 'Available', '2', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(12, 6, 'Drumstick', 10, 'Available', '3', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(13, 6, 'Wings', 10, 'Available', '4', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(14, 7, 'More Spicy', 10, 'Available', '1', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(15, 7, 'Less Spicy', 10, 'Available', '2', '2025-03-08 15:20:47', '2025-03-08 15:20:47'),
(16, 8, 'Thigh', 10, 'Available', '1', '2025-03-08 15:27:10', '2025-03-08 15:27:10'),
(17, 8, 'Breast', 10, 'Available', '2', '2025-03-08 15:27:10', '2025-03-08 15:27:10'),
(18, 8, 'Drumstick', 10, 'Available', '2', '2025-03-08 15:27:10', '2025-03-08 15:27:10'),
(19, 8, 'Wings', 10, 'Available', '2', '2025-03-08 15:27:10', '2025-03-08 15:27:10'),
(20, 9, 'Kaya', 10, 'Available', '1', '2025-03-08 15:30:21', '2025-03-08 15:30:21'),
(21, 9, 'Butter', 10, 'Available', '2', '2025-03-08 15:30:21', '2025-03-08 15:30:21'),
(22, 10, '50%', 10, 'Available', '1', '2025-03-08 15:34:36', '2025-03-08 15:34:36'),
(23, 10, '75%', 10, 'Available', '2', '2025-03-08 15:34:36', '2025-03-08 15:34:36'),
(24, 10, '100%', 10, 'Available', '4', '2025-03-08 15:34:36', '2025-03-08 15:34:36'),
(25, 11, 'Kaya', 10, 'Available', '1', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(26, 11, 'Butter', 10, 'Available', '2', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(27, 12, '50%', 10, 'Available', '1', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(28, 12, '75%', 10, 'Available', '2', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(29, 12, '100%', 10, 'Available', '3', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(30, 13, 'More Spicy', 10, 'Available', '4', '2025-03-08 15:45:13', '2025-03-08 15:45:13'),
(31, 13, 'Less Spicy', 10, 'Available', '2', '2025-03-08 15:45:13', '2025-03-08 15:45:13'),
(32, 14, 'Yellow Mee', 10, 'Available', '1', '2025-03-08 15:49:57', '2025-03-08 15:49:57'),
(33, 14, 'Kuey Teow', 10, 'Available', '2', '2025-03-08 15:49:57', '2025-03-08 15:49:57'),
(34, 14, 'Bee Hoon', 10, 'Available', '3', '2025-03-08 15:49:57', '2025-03-08 15:49:57'),
(35, 15, 'More Spicy', 10, 'Available', '1', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(36, 15, 'Less Spicy', 10, 'Available', '2', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(37, 16, 'Yellow Mee', 10, 'Available', '1', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(38, 16, 'Kuey Teow', 10, 'Available', '2', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(39, 16, 'Bee Hoon', 10, 'Available', '3', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(40, 17, 'Hot', 10, 'Available', '1', '2025-03-08 16:14:26', '2025-03-08 16:14:26'),
(41, 17, 'Cold', 10, 'Available', '2', '2025-03-08 16:14:26', '2025-03-08 16:14:26'),
(42, 18, 'Hot', 10, 'Available', '1', '2025-03-08 16:17:20', '2025-03-08 16:17:20'),
(43, 18, 'Cold', 10, 'Available', '2', '2025-03-08 16:17:20', '2025-03-08 16:17:20'),
(44, 19, 'Hot', 10, 'Available', '1', '2025-03-08 16:18:37', '2025-03-08 16:18:37'),
(45, 19, 'Cold', 10, 'Available', '2', '2025-03-08 16:18:37', '2025-03-08 16:18:37'),
(46, 20, 'More Spicy', 10, 'Available', '1', '2025-03-10 01:28:40', '2025-03-10 01:28:40'),
(47, 20, 'Less Spciy', 10, 'Available', '1', '2025-03-10 01:28:40', '2025-03-10 01:28:40');

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `inventory`
--

CREATE TABLE `inventory` (
  `inventoryID` bigint(20) UNSIGNED NOT NULL,
  `stockLevel` int(11) NOT NULL,
  `minLevel` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `inventory`
--

INSERT INTO `inventory` (`inventoryID`, `stockLevel`, `minLevel`, `name`, `created_at`, `updated_at`) VALUES
(6, 12, 20, 'Chicken Thigh', '2025-03-08 16:41:49', '2025-03-12 00:03:13'),
(7, 30, 20, 'Chicken Breast', '2025-03-08 16:42:02', '2025-03-10 08:00:54'),
(8, 35, 20, 'Chicken Drumsticks', '2025-03-08 16:42:23', '2025-03-08 16:42:23'),
(9, 22, 20, 'Chicken Wing', '2025-03-08 16:42:41', '2025-03-08 16:42:41'),
(10, 11, 20, 'Fish Ball', '2025-03-08 16:43:18', '2025-03-12 00:02:58'),
(11, 36, 20, 'Yellow Mee', '2025-03-08 16:45:30', '2025-03-08 16:45:30'),
(12, 5, 20, 'Kuey Teow', '2025-03-08 16:45:40', '2025-03-08 16:45:40'),
(13, 36, 20, 'Kampung Egg', '2025-03-10 01:29:15', '2025-03-10 01:29:15');

-- --------------------------------------------------------

--
-- 表的结构 `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_08_012327_create_category_product_inventory_tables', 1),
(5, '2025_01_08_025615_create_orderitems_orders_table', 1),
(6, '2025_01_10_070238_create_customizable_category_options_tables', 1),
(7, '2025_02_04_072650_create_vouchers_table', 1),
(8, '2025_02_17_083537_create_payment_table', 1);

-- --------------------------------------------------------

--
-- 表的结构 `orderitems`
--

CREATE TABLE `orderitems` (
  `orderItemID` bigint(20) UNSIGNED NOT NULL,
  `productID` bigint(20) UNSIGNED NOT NULL,
  `orderID` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `orderitems`
--

INSERT INTO `orderitems` (`orderItemID`, `productID`, `orderID`, `quantity`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(17, 13, 13, 1, '{\"options\":{\"Bread Spread Type\":[\"Kaya\"],\"Egg Cooking Level\":[\"50%\"]},\"takeaway\":false}', 'Completed', '2025-03-08 16:49:31', '2025-03-09 08:10:16'),
(18, 10, 13, 1, '{\"options\":{\"Chicken Type\":[\"Drumstick\"]},\"takeaway\":false}', 'Completed', '2025-03-08 16:49:31', '2025-03-09 08:10:22'),
(19, 18, 13, 1, '{\"options\":{\"Type\":[\"Hot\"]},\"takeaway\":false}', 'Completed', '2025-03-08 16:49:31', '2025-03-10 01:30:54'),
(20, 9, 14, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":true}', 'Completed', '2025-03-08 16:54:48', '2025-03-09 08:10:10'),
(21, 14, 14, 1, '{\"options\":{\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":true}', 'Completed', '2025-03-08 16:54:48', '2025-03-09 08:10:12'),
(22, 15, 14, 1, '{\"options\":{\"Noodle Type\":[\"Kuey Teow\"]},\"takeaway\":true}', 'Completed', '2025-03-08 16:54:48', '2025-03-09 08:10:14'),
(29, 9, 20, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"]},\"takeaway\":true}', 'Completed', '2025-03-10 01:20:03', '2025-03-10 03:57:40'),
(30, 11, 20, 1, '{\"options\":{\"Spread Type\":[\"Kaya\"]},\"takeaway\":false}', 'Completed', '2025-03-10 01:20:03', '2025-03-10 01:33:13'),
(31, 9, 21, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 01:34:15', '2025-03-10 06:49:27'),
(32, 10, 21, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"]},\"takeaway\":true}', 'Completed', '2025-03-10 01:34:15', '2025-03-10 06:49:24'),
(33, 9, 22, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 02:52:05', '2025-03-10 07:04:46'),
(34, 9, 23, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 02:53:10', '2025-03-10 07:04:51'),
(35, 9, 24, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 03:03:06', '2025-03-10 07:04:52'),
(36, 10, 25, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 03:08:38', '2025-03-10 07:04:56'),
(37, 11, 26, 1, '{\"options\":{\"Spread Type\":[\"Kaya\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:09:50', '2025-03-10 03:11:05'),
(38, 10, 27, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:13:35', '2025-03-10 03:36:53'),
(39, 10, 28, 1, '{\"options\":{\"Chicken Type\":[\"Breast\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:15:28', '2025-03-10 03:16:12'),
(40, 17, 28, 1, '{\"options\":{\"Type\":[\"Cold\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:15:28', '2025-03-10 03:17:37'),
(41, 9, 29, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:54:39', '2025-03-10 06:49:38'),
(42, 17, 29, 1, '{\"options\":{\"Type\":[\"Cold\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:54:39', '2025-03-10 06:49:42'),
(43, 9, 30, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:57:26', '2025-03-10 06:49:37'),
(44, 12, 30, 1, '{\"options\":{\"Cooking Level\":[\"75%\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:57:26', '2025-03-10 03:58:11'),
(45, 17, 30, 1, '{\"options\":{\"Type\":[\"Cold\"]},\"takeaway\":false}', 'Completed', '2025-03-10 03:57:26', '2025-03-10 03:57:45'),
(46, 10, 31, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 05:14:07', '2025-03-10 06:49:33'),
(47, 11, 31, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 05:14:07', '2025-03-10 06:49:34'),
(48, 19, 31, 1, '{\"options\":[],\"takeaway\":true}', 'Completed', '2025-03-10 05:14:07', '2025-03-10 06:49:35'),
(49, 9, 32, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 05:15:02', '2025-03-10 05:15:13'),
(50, 11, 33, 1, '{\"options\":[],\"takeaway\":false}', 'Completed', '2025-03-10 06:42:45', '2025-03-10 06:49:31'),
(51, 9, 34, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"Less Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 06:49:03', '2025-03-10 06:49:30'),
(52, 13, 35, 1, '{\"options\":{\"Bread Spread Type\":[\"Kaya\"],\"Egg Cooking Level\":[\"50%\"]},\"takeaway\":false}', 'Completed', '2025-03-10 06:53:32', '2025-03-10 07:04:47'),
(53, 19, 35, 1, '{\"options\":{\"Type\":[\"Hot\"]},\"takeaway\":false}', 'Completed', '2025-03-10 06:53:32', '2025-03-10 07:04:49'),
(54, 17, 36, 1, '{\"options\":{\"Type\":[\"Hot\"]},\"takeaway\":false}', 'Completed', '2025-03-10 07:45:04', '2025-03-10 07:56:24'),
(55, 9, 36, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 07:45:04', '2025-03-10 07:45:32'),
(56, 9, 37, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Completed', '2025-03-10 07:57:24', '2025-03-10 07:57:40'),
(57, 12, 37, 1, '{\"options\":{\"Cooking Level\":[\"50%\"]},\"takeaway\":true}', 'Completed', '2025-03-10 07:57:24', '2025-03-10 07:57:34'),
(58, 9, 38, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":true}', 'Pending', '2025-03-10 07:59:06', '2025-03-10 07:59:06'),
(59, 9, 39, 1, '{\"options\":{\"Chicken Type\":[\"Breast\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Pending', '2025-03-11 23:51:51', '2025-03-11 23:51:51'),
(60, 17, 39, 1, '{\"options\":{\"Type\":[\"Cold\"]},\"takeaway\":true}', 'Pending', '2025-03-11 23:51:51', '2025-03-11 23:51:51'),
(61, 9, 40, 1, '{\"options\":{\"Chicken Type\":[\"Breast\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Pending', '2025-03-11 23:53:00', '2025-03-11 23:53:00'),
(62, 17, 40, 1, '{\"options\":{\"Type\":[\"Cold\"]},\"takeaway\":true}', 'Pending', '2025-03-11 23:53:00', '2025-03-11 23:53:00'),
(63, 9, 41, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Pending', '2025-03-11 23:54:56', '2025-03-11 23:54:56'),
(64, 13, 41, 1, '{\"options\":{\"Bread Spread Type\":[\"Kaya\"],\"Egg Cooking Level\":[\"50%\"]},\"takeaway\":false}', 'Pending', '2025-03-11 23:54:56', '2025-03-11 23:54:56'),
(65, 20, 41, 1, '{\"options\":{\"Spicy Level\":[\"Less Spciy\"]},\"takeaway\":true}', 'Pending', '2025-03-11 23:54:56', '2025-03-11 23:54:56'),
(66, 9, 42, 1, '{\"options\":{\"Chicken Type\":[\"Thigh\"],\"Spicy Level\":[\"More Spicy\"]},\"takeaway\":false}', 'Pending', '2025-03-12 00:41:21', '2025-03-12 00:41:21'),
(67, 13, 42, 1, '{\"options\":{\"Bread Spread Type\":[\"Kaya\"],\"Egg Cooking Level\":[\"50%\"]},\"takeaway\":false}', 'Pending', '2025-03-12 00:41:21', '2025-03-12 00:41:21'),
(68, 19, 42, 1, '{\"options\":{\"Type\":[\"Hot\"]},\"takeaway\":false}', 'Pending', '2025-03-12 00:41:21', '2025-03-12 00:41:21');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `orderID` bigint(20) UNSIGNED NOT NULL,
  `userID` bigint(20) UNSIGNED NOT NULL,
  `tableNo` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalAmount` decimal(9,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orderID`, `userID`, `tableNo`, `status`, `totalAmount`, `created_at`, `updated_at`) VALUES
(13, 6, 10, 'Pending', '26.97', '2025-03-08 16:49:31', '2025-03-08 16:49:31'),
(14, 6, 2, 'Completed', '38.97', '2025-03-08 16:54:48', '2025-03-08 17:20:10'),
(20, 6, 1, 'Pending', '20.98', '2025-03-10 01:20:03', '2025-03-10 01:20:03'),
(21, 8, 10, 'Pending', '28.98', '2025-03-10 01:34:15', '2025-03-10 01:34:15'),
(22, 6, 5, 'Pending', '15.99', '2025-03-10 02:52:05', '2025-03-10 02:52:05'),
(23, 6, 10, 'Pending', '15.99', '2025-03-10 02:53:10', '2025-03-10 02:53:10'),
(24, 6, 10, 'Pending', '15.99', '2025-03-10 03:03:06', '2025-03-10 03:03:06'),
(25, 6, 8, 'Completed', '12.99', '2025-03-10 03:08:38', '2025-03-10 03:10:10'),
(26, 8, 19, 'Completed', '4.99', '2025-03-10 03:09:50', '2025-03-10 03:10:04'),
(27, 6, 1, 'Pending', '12.99', '2025-03-10 03:13:35', '2025-03-10 03:13:35'),
(28, 8, 1, 'Completed', '17.98', '2025-03-10 03:15:28', '2025-03-10 03:15:41'),
(29, 8, 5, 'Completed', '20.98', '2025-03-10 03:54:39', '2025-03-10 03:54:54'),
(30, 6, 10, 'Pending', '25.97', '2025-03-10 03:57:26', '2025-03-10 03:57:26'),
(31, 6, 1, 'Pending', '22.97', '2025-03-10 05:14:07', '2025-03-10 05:14:07'),
(32, 8, 5, 'Completed', '15.99', '2025-03-10 05:15:02', '2025-03-10 05:15:26'),
(33, 8, 4, 'Pending', '4.99', '2025-03-10 06:42:45', '2025-03-10 06:42:45'),
(34, 8, 3, 'Completed', '15.99', '2025-03-10 06:49:03', '2025-03-10 06:49:12'),
(35, 6, 10, 'Pending', '13.98', '2025-03-10 06:53:32', '2025-03-10 06:53:32'),
(36, 8, 4, 'Completed', '20.98', '2025-03-10 07:45:04', '2025-03-10 07:46:11'),
(37, 8, 4, 'Completed', '20.98', '2025-03-10 07:57:24', '2025-03-10 07:57:59'),
(38, 6, 10, 'Pending', '15.99', '2025-03-10 07:59:06', '2025-03-10 07:59:06'),
(39, 8, 5, 'Completed', '20.98', '2025-03-11 23:51:51', '2025-03-11 23:57:20'),
(40, 8, 5, 'Completed', '20.98', '2025-03-11 23:53:00', '2025-03-11 23:56:06'),
(41, 6, 10, 'Pending', '35.97', '2025-03-11 23:54:56', '2025-03-11 23:54:56'),
(42, 6, 10, 'Pending', '29.97', '2025-03-12 00:41:21', '2025-03-12 00:41:21');

-- --------------------------------------------------------

--
-- 表的结构 `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `paymentID` bigint(20) UNSIGNED NOT NULL,
  `orderID` bigint(20) UNSIGNED NOT NULL,
  `voucherID` bigint(20) UNSIGNED DEFAULT NULL,
  `totalAmount` double NOT NULL,
  `paymentMethod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`paymentID`, `orderID`, `voucherID`, `totalAmount`, `paymentMethod`, `status`, `created_at`, `updated_at`) VALUES
(11, 13, NULL, 26.97, 'cash', 'Completed', '2025-03-08 16:50:42', '2025-03-08 16:50:42'),
(12, 14, NULL, 38.97, 'cash', 'Completed', '2025-03-09 04:48:09', '2025-03-09 04:48:09'),
(15, 20, 5, 20.98, 'cash', 'Completed', '2025-03-10 01:20:12', '2025-03-10 01:20:12'),
(16, 23, NULL, 15.99, 'cash', 'Completed', '2025-03-10 03:00:07', '2025-03-10 03:00:07'),
(17, 21, NULL, 28.98, 'cash', 'Completed', '2025-03-10 03:00:25', '2025-03-10 03:00:25'),
(18, 24, 5, 15.99, 'cash', 'Completed', '2025-03-10 03:03:48', '2025-03-10 03:03:48'),
(19, 25, NULL, 12.99, 'cash', 'Completed', '2025-03-10 03:08:49', '2025-03-10 03:08:49'),
(20, 27, NULL, 12.99, 'cash', 'Completed', '2025-03-10 03:13:38', '2025-03-10 03:13:38'),
(21, 29, 6, 20.98, 'cash', 'Completed', '2025-03-10 03:55:41', '2025-03-10 03:55:41'),
(22, 22, NULL, 15.99, 'cash', 'Completed', '2025-03-10 03:56:32', '2025-03-10 03:56:32'),
(23, 30, NULL, 25.97, 'cash', 'Completed', '2025-03-10 04:04:49', '2025-03-10 04:04:49'),
(24, 31, NULL, 22.97, 'cash', 'Completed', '2025-03-10 05:14:16', '2025-03-10 05:14:16'),
(25, 26, 5, 4.99, 'cash', 'Completed', '2025-03-10 05:15:28', '2025-03-10 05:15:28'),
(26, 33, NULL, 4.99, 'cash', 'Completed', '2025-03-10 06:43:06', '2025-03-10 06:43:06'),
(27, 34, NULL, 15.99, 'cash', 'Completed', '2025-03-10 06:49:32', '2025-03-10 06:49:32'),
(28, 35, 5, 13.98, 'cash', 'Completed', '2025-03-10 06:54:03', '2025-03-10 06:54:03'),
(29, 28, NULL, 17.98, 'cash', 'Completed', '2025-03-10 06:54:17', '2025-03-10 06:54:17'),
(30, 32, NULL, 15.99, 'cash', 'Completed', '2025-03-10 06:54:45', '2025-03-10 06:54:45'),
(31, 36, 5, 20.98, 'cash', 'Completed', '2025-03-10 07:47:01', '2025-03-10 07:47:01'),
(32, 38, 5, 15.99, 'cash', 'Completed', '2025-03-10 07:59:26', '2025-03-10 07:59:26'),
(33, 37, NULL, 20.98, 'cash', 'Completed', '2025-03-10 08:00:27', '2025-03-10 08:00:27'),
(34, 41, 6, 35.97, 'cash', 'Completed', '2025-03-11 23:55:25', '2025-03-11 23:55:25'),
(35, 42, 6, 29.97, 'cash', 'Completed', '2025-03-12 00:41:28', '2025-03-12 00:41:28');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `productID` bigint(20) UNSIGNED NOT NULL,
  `categoryID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`productID`, `categoryID`, `name`, `price`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(9, 1, 'Nasi Lemak Fried Chicken', '15.99', 'Spicy than your girl friend', 'Available', 'uploads/1741447394.jpg', '2025-03-08 15:20:47', '2025-03-08 15:23:14'),
(10, 1, 'Chicken Rice', '12.99', 'Confirm every Malaysian man like this', 'Not Available', 'uploads/1741447630.jpg', '2025-03-08 15:27:10', '2025-03-11 23:39:31'),
(11, 1, 'Roti Bakar', '4.99', 'Simple, classic, shiok', 'Available', 'uploads/1741447821.png', '2025-03-08 15:30:21', '2025-03-08 15:30:21'),
(12, 1, 'Half-Boiled Eggs', '4.99', 'The most eggcellent choices', 'Available', 'uploads/1741448076.jpg', '2025-03-08 15:34:36', '2025-03-08 15:34:36'),
(13, 3, 'Roti Bakar & Half-Boiled Eggs', '8.99', 'Kopitiam best choices', 'Available', 'uploads/1741448470.jpg', '2025-03-08 15:41:10', '2025-03-08 15:41:10'),
(14, 1, 'Penang Prawn Mee', '14.99', 'This one is Prawn mee lah, not Hokien Mee', 'Available', 'uploads/1741448713.jpg', '2025-03-08 15:45:13', '2025-03-08 15:45:13'),
(15, 1, 'Fish Ball Noodles', '7.99', 'Classic kopitiam vibes', 'Available', 'uploads/1741448997.jpg', '2025-03-08 15:49:57', '2025-03-08 15:49:57'),
(16, 1, 'Curry Mee', '7.99', 'Just a normal curry mee', 'Available', 'uploads/1741449555.jpg', '2025-03-08 15:59:15', '2025-03-08 15:59:15'),
(17, 2, 'Milo', '4.99', 'Everyone like milo, especially milo ais', 'Available', 'uploads/1741450466.png', '2025-03-08 16:14:26', '2025-03-08 16:14:26'),
(18, 2, 'Teh C', '4.99', 'Underrated star of kopitiam drinks', 'Available', 'uploads/1741450640.jpg', '2025-03-08 16:17:20', '2025-03-08 16:17:20'),
(19, 2, 'Teh Tarik', '4.99', 'The king of Malaysian drinks', 'Available', 'uploads/1741450717.png', '2025-03-08 16:18:37', '2025-03-08 16:18:37'),
(20, 1, 'Mee Siam', '10.99', 'Malaysian favourite mee siam', 'Available', 'uploads/1741570120.jpg', '2025-03-10 01:28:40', '2025-03-10 01:28:40');

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('04TcONS2mnNltNDxN18VzS9CHXoVI7Q1Picdt4Nd', NULL, '127.0.0.1', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDlHUmh0dG1kVjhlZm1UUGtFck80VDdPNkpMSlpCSEtYUzl3RlkzOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly93d3cudGFzdHlieXRlLm15Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741789494),
('3KYrDNm0Kuv7Eamg2bQLjmtiC4MeFmENOwmIrqbx', NULL, '45.82.79.27', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWlGV3NlNkhNbkRUMnI1RjBoOHpwbHphTDFBRkQzYUFRZzlDVFZqSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741822163),
('4nPrCR7j8yIoDeMC6XtCuPMNbS1v2PY6GHsgVjLG', NULL, '205.210.31.228', 'curl/7.68.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMndkZFd2eGJLaW45d1lGR2FIQ1JZdG9KdGVobXo4ck5ia212bEFyWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741833499),
('5WBBkq90OxZyzk0RwRgC7LDFK3Rs2AmNaSpEgb1R', NULL, '59.22.30.67', 'curl/7.88.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoielkwMUdUVHRXNE5BdmljUUUxOVcybHp5djZKQTllMnR2SlBpZTk1NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741828162),
('8Fh7dbY9H9JjG6RwHVfgoU5XHyi7LmX46bugWDG0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHE0YTV4dDgxdzFPUzZSOFUzemlGa0xUcjhFYkNCN1FyQkVwSVdQMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly90YXN0eWJ5dGUubXkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741788003),
('9sCIF9EpStlGkx0t1YQLQsQ95h0IM0o3O2kHkoOz', NULL, '125.228.34.112', 'curl/7.88.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYWk4ZGZmd0pVNjJHcXdCUmZLQ2xNSkpGdktDTmViUTlLMEF2Q3BXNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741789658),
('bRLbhGHsG2rPIZQ57z6aZoaYx5ABab0l9M4Sa1rj', NULL, '188.11.108.206', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2hONW9PaDRDMVdaR09TWGg3eWRYZUNFcXExQUQweWh4TXlmRkk2VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741840244),
('buEWX32rfWV8A18yEYF4rl8SlG2ZwdWB0zZHQ2Wo', NULL, '34.79.118.200', 'python-requests/2.32.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTk0OTk1RW5FOVlaV2NjSmh4SVJPR0N5VFIxRGd1WmlBMjFaa3hNUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741792105),
('dquIJMcjPWwiKezPdI64LyFEPlkMrXVprKEt7wXP', NULL, '205.210.31.164', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnY2SFRtU2x0RFIzUUlOSksyaTlweHFuZWhVemdZeEZaZ1F2SnBYTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741826705),
('dzH8POt4VXaKp7vYZE0w9rYVmoZhgSCA136JJkYH', NULL, '167.94.145.96', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUZQMlhjN2Q4WXZ4WGVWODk4V1ZpYjV1U2ZRY1VXUlBtWTNheExFdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741829381),
('GYxGZ646Rrg4PaC4vmDeX1OjtCWnukpZ2x6wIDtM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoielZVU0dYSDlBNzlGMUo5V09US1B3RVpWTkFsY0lzVjdvVmxGazVQNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly93d3cudGFzdHlieXRlLm15Ijt9fQ==', 1741849508),
('hDjs6UQtbHQeOGRVzsCJq74CsoyuXivFCfgO2UGP', NULL, '127.0.0.1', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzNRQlZXNXMwOUt4MEJlaHNKVHVKc3ZER1c1Q0NSM2ZIVXBibmI3ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly93d3cudGFzdHlieXRlLm15Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741808774),
('hTwhc6FtyQDR9y7Vsmrcsu8UEowWHiVC9qWkUqJA', NULL, '127.0.0.1', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic21QQ3FqZkdtNEVWQktaUzJTQm1ocEhSUTRyanM3N1hvSzZDT0JtMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly93d3cudGFzdHlieXRlLm15Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741778696),
('iMk9cOiRX9CzyFvRfLBfjPmrMxsGzORN0h5sMtCT', NULL, '8.222.160.69', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXhXTnh3dFc1WVA4SE9BTFJKQ2FUZkJvR2tKOEJsYWV4djZJSGNYdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741784432),
('j1aHyiniyzc1VvaV8wdLCjaly6fRoYBUJsY95X8G', NULL, '45.156.130.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36 ', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY293dlNRRjdGVE5zcng2OG83eUw1eGlCejdIN01NOGtXc0w3V21DbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741840617),
('KYVdfODzLe3ovLsKKPtubrTnHR8ClTyB1YqZoYg2', NULL, '143.198.231.127', 'Mozilla/5.0 (compatible)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXU1VHZEN1VMTnpoeEtNc1pmOVByQVg2bGNMNHAwYlo1b3pleTdOayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741834603),
('lJoAb3TAMWiWtn02RefTfYiJM4hAP9u0OCF423OO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnNMNkNIUER5YVM2RExqenlNckU3Y1VCR0VLazdPb3Z5MUZlanZGQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly90YXN0eWJ5dGUubXkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741775562),
('NwC7Q3B0gM8ZldUb08PtoJWxZ6xx0fMYKGd47Deo', NULL, '52.167.144.138', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWd0MHpVTUtSQTBzZVAxRE1iUEQyd3R0ZVdUcGhBS05BYVd0VWt4WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741786541),
('Rpgak1i1WwRjco5anaqSYwSfynhvidFjAvbuQBwD', NULL, '204.188.228.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlVLNHBxamtIdUllNUdxVjdQWnFxSzljelhsa1Y0TGJSYUNPMXR3RiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741809955),
('UeHXydKpdfW3MKekB2rqybXPrF2KQRvdm2qCeJGI', NULL, '167.94.145.96', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlYyTDFhajlkemx6RHQ2aE9XZzZkV0ppeGZob2IzdWJESmxSYnl1TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741829389),
('UXIcEu3UfyLJpOPJUnlppCjuJ3nenqQJym1oer8X', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MzoiaHR0cDovL3d3dy50YXN0eWJ5dGUubXkva2l0Y2hlbi9vcmRlci1pdGVtcy1kYXRhP2ZpbHRlcj1wZW5kaW5nIjt9czo2OiJfdG9rZW4iO3M6NDA6IldOeHRWcEZvZThWejM2cGF3V1ZyYlZkZUt5YVZZa0xqZUlqc2htUWsiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7czo4OiJ1c2VybmFtZSI7czo3OiJraXRjaGVuIjtzOjY6InVzZXJJRCI7aTo3O30=', 1741782033),
('y978thBTiKxTXZ4sjKPDvFCavutsy3yHHMPDXeqV', NULL, '45.82.79.27', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEFqaVlnY1Z4QWxXSFZ6czRDZDVzN2JoTlFqcFBwMVJQblRkSkk3NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741822161),
('YOhplIA7yViNJRctufXf2yPVUBC1USUqh8kYdUZw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTR0NkV0MkZUTGlHRk1GRFh5NUVrYTd0aXdFWnRWd3FJdDdvRDB1RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly90YXN0eWJ5dGUubXkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741775429),
('z3vnGpWYx9mWmRRRNo8wnOMnxtYwSa2euEIOKhkr', NULL, '8.222.160.69', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkpySnJRaFVUNnI5alpxTXo4V3k4NGpIV0gyaHI5N3loQk9ZTWdWMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741784432),
('zalsp3s87yDYztCHHnvU3HuzFqeyv6LkZEg5nxQZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN05VUU1MS25sMTEyQlJsamU5Y1RGZG5GeHNCYlVlRVpsNmQybXV3RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly90YXN0eWJ5dGUubXkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741775429),
('zSu3vnLHs5eB6FHFdIqa64MMUlIUsenuN9AcWpZW', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo2OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovL3d3dy50YXN0eWJ5dGUubXkvdHJhY2stb3JkZXIiO31zOjY6Il90b2tlbiI7czo0MDoiQkt0RGt2aklwbkozbGxaNUxIbTNtNE5EVnFzUGFieTMwVklNWndtZCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjg6InVzZXJuYW1lIjtzOjc6ImNhc2hpZXIiO3M6NjoidXNlcklEIjtpOjY7fQ==', 1741780512),
('zXoYD64S5EVtAXlwWXUiO4SK7LvTIVsEqPrXh5gk', NULL, '205.210.31.233', 'curl/7.68.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnl2c1ZNWDhCdnpEamdBcW1wWXU4S2FkM3EwempCOTlzUmtMMXoybyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xNTYuMjQ0LjcuMTE4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741786746);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `userID` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOfBirth` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `username`, `nickname`, `role`, `gender`, `dateOfBirth`, `email`, `phoneNo`, `password`, `status`, `created_at`, `updated_at`) VALUES
(5, 'TastyByte', 'Admin', 'admin', 'admin', 'Admin', 'Other', '2000-01-01', 'admin@tastybyte.my', '0123456789', '$2y$12$2zFR3uTWP5M5f6S.jJsFiOu5OEDfBVu//gzt1Q6PrtsnLlymD3Nkm', 'Active', '2025-02-09 10:19:52', '2025-03-10 00:39:00'),
(6, 'TastyByte', 'Cashier', 'cashier', 'cashier', 'Cashier', 'Other', '2000-01-01', 'cashier@tastybyte.my', '0123456781', '$2y$12$QsOfJNBvxJoYHg.Qxt/b0OUdNHtcMDvogFw0fGFv8gmZIJw/z6V9u', 'Active', '2025-03-03 04:25:25', '2025-03-10 00:39:29'),
(7, 'TastyByte', 'Kitchen', 'kitchen', 'kitchen', 'Kitchen', 'Other', '2000-01-01', 'kitchen@tastybyte.my', '0134567891', '$2y$12$aYtB/J6PFKszFfKe/yHC..xg4.5JHlnUK3Smv72YkDHPAL9.SgyUW', 'Active', '2025-03-03 04:26:06', '2025-03-10 00:39:43'),
(8, 'TastyByte', 'Waiter', 'waiter', 'waiter', 'Waiter', 'Other', '2000-01-01', 'waiter@tastybyte.my', '0145678912', '$2y$12$eCaT.34697b6u8IV4.lk4epsxEi/22udEzq7siv2GgonR3jzmTslW', 'Active', '2025-03-10 00:33:09', '2025-03-10 00:37:03'),
(9, 'Isaac', 'Yeow Ming', 'iZ', 'Zack', 'Waiter', 'Other', '1995-06-06', 'izack@gmail.com', '0172551238', '$2y$12$UvpiIGMGxMYmAAkHONS0De7PZeUxsPG1rwfvNW2JoL0mvo07SW.T2', 'Active', '2025-03-12 00:31:30', '2025-03-12 00:31:30');

-- --------------------------------------------------------

--
-- 表的结构 `vouchers`
--

CREATE TABLE `vouchers` (
  `voucherID` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singleUse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `startedOn` datetime NOT NULL,
  `expiredOn` datetime NOT NULL,
  `usedCount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `vouchers`
--

INSERT INTO `vouchers` (`voucherID`, `code`, `type`, `singleUse`, `usage`, `value`, `startedOn`, `expiredOn`, `usedCount`, `created_at`, `updated_at`) VALUES
(5, 'RAMADAN2025', 'Percentage', 'False', '100', '10.00', '2025-03-09 08:30:00', '2025-03-15 22:30:00', 5, '2025-03-08 16:47:15', '2025-03-10 07:59:26'),
(6, 'RAMADAN', 'Amount', 'True', '100', '8.88', '2025-03-10 09:30:00', '2025-03-20 09:30:00', 3, '2025-03-10 01:30:24', '2025-03-12 00:41:28'),
(7, 'TASTYBYTE', 'Amount', 'True', '100', '6.66', '2025-03-13 09:37:00', '2025-10-10 09:37:00', 0, '2025-03-10 01:37:49', '2025-03-12 00:03:40');

--
-- 转储表的索引
--

--
-- 表的索引 `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- 表的索引 `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- 表的索引 `customizablecategory`
--
ALTER TABLE `customizablecategory`
  ADD PRIMARY KEY (`customizeCategoryID`),
  ADD KEY `customizablecategory_productid_foreign` (`productID`);

--
-- 表的索引 `customizableoptions`
--
ALTER TABLE `customizableoptions`
  ADD PRIMARY KEY (`customizeOptionsID`),
  ADD KEY `customizableoptions_customizecategoryid_foreign` (`customizeCategoryID`);

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- 表的索引 `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryID`);

--
-- 表的索引 `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- 表的索引 `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `orderitems_productid_foreign` (`productID`),
  ADD KEY `orderitems_orderid_foreign` (`orderID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `orders_userid_foreign` (`userID`);

--
-- 表的索引 `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `payment_orderid_foreign` (`orderID`),
  ADD KEY `payment_voucherid_foreign` (`voucherID`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `product_categoryid_foreign` (`categoryID`);

--
-- 表的索引 `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 表的索引 `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucherID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `customizablecategory`
--
ALTER TABLE `customizablecategory`
  MODIFY `customizeCategoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `customizableoptions`
--
ALTER TABLE `customizableoptions`
  MODIFY `customizeOptionsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `orderItemID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- 使用表AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `productID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `userID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucherID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 限制导出的表
--

--
-- 限制表 `customizablecategory`
--
ALTER TABLE `customizablecategory`
  ADD CONSTRAINT `customizablecategory_productid_foreign` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;

--
-- 限制表 `customizableoptions`
--
ALTER TABLE `customizableoptions`
  ADD CONSTRAINT `customizableoptions_customizecategoryid_foreign` FOREIGN KEY (`customizeCategoryID`) REFERENCES `customizablecategory` (`customizeCategoryID`) ON DELETE CASCADE;

--
-- 限制表 `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_orderid_foreign` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitems_productid_foreign` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_orderid_foreign` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_voucherid_foreign` FOREIGN KEY (`voucherID`) REFERENCES `vouchers` (`voucherID`) ON DELETE CASCADE;

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_categoryid_foreign` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
