-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26 مايو 2025 الساعة 23:26
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taj_restaurant`
--

-- --------------------------------------------------------

--
-- بنية الجدول `about_info`
--

CREATE TABLE `about_info` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `paragraph1` text DEFAULT NULL,
  `paragraph2` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `about_info`
--

INSERT INTO `about_info` (`id`, `title`, `subtitle`, `paragraph1`, `paragraph2`, `image`) VALUES
(1, 'The TAJ history', 'More than 10 years of experiance', 'Founded in the heart of Taiz, Taj Restaurant has been a staple in the local dining scene, celebrated for its authentic Yemeni and Middle Eastern cuisine. Established over ten years ago', 'Taj quickly gained popularity for its commitment to traditional flavors and high-quality ingredients. Known for its welcoming atmosphere and warm hospitality, the restaurant has become a beloved spot for both locals and visitors. Taj Restaurant offers a diverse menu featuring classic Yemeni dishes such as mandi, fahsa, and salta, along with other Middle Eastern specialties. Through the years, it has evolved to accommodate a wider range of tastes while maintaining its traditional roots, making it a cherished culinary landmark in Taiz.', 'as.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `available_times`
--

CREATE TABLE `available_times` (
  `id` int(11) NOT NULL,
  `meal` varchar(50) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `available_times`
--

INSERT INTO `available_times` (`id`, `meal`, `start_time`, `end_time`, `image`) VALUES
(1, 'BREAKFAST', '7:00 AM', '11:00 AM', 'loog.png'),
(2, 'LUNCH', '12:00 PM', '3:30 PM', 'loog.png'),
(3, 'DINNER', '7:00 PM', '11:00 PM', 'loog.png');

-- --------------------------------------------------------

--
-- بنية الجدول `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `image_path`, `alt_text`) VALUES
(1, 'a.jpg', '1'),
(2, 'b.jpg', '2'),
(3, 'c.png', '3'),
(4, 'd.jpg', '4'),
(5, 'e.jpg', '5'),
(6, 'f.jpg', '6');

-- --------------------------------------------------------

--
-- بنية الجدول `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(5,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `price`, `description`, `image`) VALUES
(1, 'pizza', 9.00, 'A round flatbread topped with tomato sauce, cheese, and various', 'pi.jpg'),
(2, 'grilled CHECKEN', 10.00, 'Is a popular dish made by marianating chicken in a mixture of herbs.', 'CH.png'),
(3, 'pasta', 5.00, 'Is a traditional italian dish made from durum wheat dough.', 'sp.jpeg'),
(4, 'taccos', 8.00, 'Is a traditional mexican dish consisting of a folder or rolled tortilla.', 'wa.jpg'),
(5, 'SHRIMP', 15.00, 'Is a tender shellfish popular in many cuisines around the world.', 'ja.jpg'),
(6, 'FRIED CHECKEN', 12.00, 'Is a crispy and golden fried chicken, typically seasond with spicy', 'bb.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `sent_at`) VALUES
(1, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:32:36'),
(2, 'taj_restuarant', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:32:54'),
(3, 'taj_restuarant', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:32:54'),
(4, 'roaa', 'roaa2002@gmail.com', 'a;vh', '2025-05-14 19:33:03'),
(5, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:33:26'),
(6, 'roaa', 'roaa2002@gmail.com', 'a;vh', '2025-05-14 19:33:37'),
(7, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:50:05'),
(8, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:55:39'),
(9, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:57:30'),
(10, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 19:59:13'),
(11, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:03:43'),
(12, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:03:54'),
(13, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:08:38'),
(14, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:11:51'),
(15, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:12:24'),
(16, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:15:12'),
(17, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 20:56:49'),
(18, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:02:52'),
(19, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:04:38'),
(20, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:05:55'),
(21, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:06:28'),
(22, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:06:45'),
(23, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:08:04'),
(24, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:08:25'),
(25, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:08:49'),
(26, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-14 21:09:32'),
(27, 'alaa', 'roaa2002@gmail.com', 'شكرا', '2025-05-16 21:56:07'),
(28, 'aisha', 'aisha@gmail.com', 'delicious', '2025-05-16 21:56:56'),
(29, 'alaa', 'roaa2002@gmail.com', 'مخهلفغعبغفيفق', '2025-05-17 06:03:18'),
(30, 'roaa', 'roaa2002@gmail.com', 'ماعبغؤ', '2025-05-17 06:04:17'),
(31, 'alaa', 'roaa2002@gmail.com', 'شش', '2025-05-17 08:37:59'),
(32, 'remi', 'roaa2@gmail.com', '1', '2025-05-18 11:13:29'),
(33, 'lol', 'alaa@gmail.com', 'k,,', '2025-05-18 17:04:18'),
(34, 'Roaa Ja&#039;afer Ali Slim', 'kajwmysama9@gmail.com', 'k,,', '2025-05-21 20:32:12'),
(35, 'Roaa Ja&#039;afer Ali Slim', 'kajwmysama9@gmail.com', 'anun', '2025-05-26 17:06:53');

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `order_time` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`id`, `item_name`, `item_description`, `item_price`, `order_time`, `user_id`) VALUES
(26, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-18 14:41:53', 11),
(27, 'FRIED CHICKEN', 'A crispy and golden fried chicken, typically seasoned with spices.', 13.00, '2025-05-18 14:41:58', 11),
(28, 'BURGER', 'A beef patty, sometimes chicken or veggie, served in a bun with lettuce.', 5.00, '2025-05-18 14:42:01', 11),
(29, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-18 15:06:35', 4),
(30, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-18 19:35:59', 10),
(31, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-18 20:04:01', 10),
(32, 'FRIED CHICKEN', 'A crispy and golden fried chicken, typically seasoned with spices.', 13.00, '2025-05-18 21:15:36', 13),
(33, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-19 09:38:21', 12),
(34, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-19 09:39:25', 12),
(35, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-19 09:55:33', 10),
(36, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-19 09:56:19', 10),
(37, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-21 23:32:25', 10),
(38, 'KABAB', 'Grilled skewers of seasoned meat, often beef, chicken, or lamb, served with vegetables.', 10.00, '2025-05-22 14:22:23', 12),
(39, 'pasta', 'Is a traditional italian dish made from durum wheat dough.', 5.00, '2025-05-26 20:06:18', 12),
(40, 'grilled CHECKEN', 'Is a popular dish made by marianating chicken in a mixture of herbs.', 10.00, '2025-05-26 21:49:28', 12);

-- --------------------------------------------------------

--
-- بنية الجدول `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `table_number` varchar(50) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `reservation_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `reservations`
--

INSERT INTO `reservations` (`id`, `table_number`, `guest_count`, `reservation_time`, `created_at`, `user_id`) VALUES
(1, 'Table 1', 1, '2025-05-26 20:07:00', '2025-05-13 17:08:22', NULL),
(5, 'Table 1', 1, '2025-05-26 20:47:00', '2025-05-13 17:49:52', NULL),
(6, 'Table 1', 1, '2025-05-26 20:50:00', '2025-05-13 17:50:07', NULL),
(7, 'Table 1', 1, '2025-05-26 20:50:00', '2025-05-13 17:58:39', NULL),
(8, 'Table 1', 1, '2025-05-26 20:58:00', '2025-05-13 17:58:53', NULL),
(9, 'Table 1', 1, '2025-05-26 20:58:00', '2025-05-13 18:02:54', NULL),
(10, 'Table 1', 1, '2025-05-26 21:03:00', '2025-05-13 18:03:06', NULL),
(11, 'Table 1', 1, '2025-05-26 21:03:00', '2025-05-13 18:03:19', NULL),
(12, 'Table 1', 1, '2025-05-26 21:03:00', '2025-05-13 18:05:31', NULL),
(13, 'Table 1', 1, '2025-05-26 21:05:00', '2025-05-13 18:05:44', NULL),
(14, 'Table 1', 1, '2025-05-26 21:05:00', '2025-05-13 18:05:55', NULL),
(15, 'Table 1', 1, '2025-05-26 21:05:00', '2025-05-13 18:12:35', NULL),
(16, 'Table 1', 1, '2025-05-26 21:12:00', '2025-05-13 18:12:50', NULL),
(17, 'Table 1', 1, '2025-05-26 21:12:00', '2025-05-13 18:15:15', NULL),
(18, 'Table 2', 1, '2025-05-26 21:15:00', '2025-05-13 18:15:35', NULL),
(19, 'Table 2', 2, '2025-05-26 21:15:00', '2025-05-13 18:15:47', NULL),
(23, 'Table 2', 1, '2025-05-26 20:25:00', '2025-05-14 17:25:47', NULL),
(24, '1', 1, '2025-05-26 20:46:00', '2025-05-14 17:46:45', NULL),
(25, 'Table 1', 1, '2025-05-26 20:53:00', '2025-05-14 17:53:18', NULL),
(26, 'Table 1', 3, '2025-05-26 21:06:00', '2025-05-14 18:06:41', NULL),
(27, 'Table 2', 2, '2025-05-26 21:07:00', '2025-05-14 18:07:29', NULL),
(30, 'Table 1', 1, '2025-05-26 21:17:00', '2025-05-14 18:17:54', NULL),
(31, 'Table 1', 2, '2025-05-26 21:18:00', '2025-05-14 18:18:12', NULL),
(34, '2', 2, '2025-05-26 11:16:00', '2025-05-15 08:16:11', NULL),
(35, '4', 3, '2025-05-26 11:17:00', '2025-05-15 08:17:21', NULL),
(36, '6', 3, '2025-05-26 11:17:00', '2025-05-15 08:17:54', NULL),
(37, '3', 2, '2025-05-26 11:24:00', '2025-05-15 08:24:13', NULL),
(38, '1', 2, '2025-05-26 11:38:00', '2025-05-15 08:38:21', 2),
(39, '3', 3, '2025-05-26 11:39:00', '2025-05-15 08:39:34', 2),
(40, '4', 4, '2025-05-26 11:39:00', '2025-05-15 08:40:00', 2),
(41, '2', 2, '2025-05-26 11:46:00', '2025-05-15 08:46:32', 2),
(42, '4', 6, '2025-05-26 11:47:00', '2025-05-15 08:47:07', 2),
(43, '1', 3, '2025-05-26 11:49:00', '2025-05-15 08:49:29', 3),
(44, '1', 2, '2025-05-26 11:55:00', '2025-05-15 08:55:10', 3),
(45, '2', 2, '2025-05-26 11:57:00', '2025-05-15 08:57:48', 3),
(46, '2', 2, '2025-05-26 12:06:00', '2025-05-15 09:07:00', 3),
(47, '2', 2, '2025-05-26 12:12:00', '2025-05-15 09:12:26', 3),
(48, '3', 2, '2025-05-26 12:12:00', '2025-05-15 09:12:49', 3),
(49, '2', 2, '2025-05-26 00:55:00', '2025-05-16 21:55:57', 4),
(50, '1', 3, '2025-05-26 11:29:00', '2025-05-17 08:29:19', 4),
(52, '2', 2, '2025-05-26 00:47:00', '2025-05-17 21:47:16', 4),
(53, '2', 3, '2025-05-26 00:48:00', '2025-05-17 21:48:30', 10),
(54, '2', 3, '2025-05-26 14:12:00', '2025-05-18 11:12:44', 11),
(55, '4', 3, '2025-05-26 19:35:00', '2025-05-18 16:35:17', 10),
(56, '3', 3, '2025-05-26 20:04:00', '2025-05-18 17:04:37', 10),
(58, '1', 2, '2025-05-26 00:55:00', '2025-05-21 21:55:54', 15),
(59, '3', 3, '2025-05-26 01:26:00', '2025-05-21 22:26:23', 15),
(60, '2', 3, '2025-05-26 13:49:00', '2025-05-22 10:49:30', 12),
(61, '3', 3, '2025-05-26 14:21:00', '2025-05-22 11:21:44', 12),
(62, '2', 3, '2025-05-26 20:12:00', '2025-05-26 17:12:38', 12),
(63, '3', 3, '2025-05-26 20:51:00', '2025-05-26 17:51:15', 12),
(64, '3', 2, '2025-05-26 20:52:00', '2025-05-26 17:52:54', 12),
(65, '1', 2, '2025-05-26 21:07:00', '2025-05-26 18:07:03', 12),
(66, '2', 4, '2025-05-28 21:16:00', '2025-05-26 18:16:57', 12);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'roaa', 'roaa2002@gmail.com', '$2y$10$nY52GVevrTRHeLlOeOeES.4tD1/DxqDp6IVat6gNIG0U/wXDElOiy', '2025-05-13 19:11:50', 'user'),
(2, 'alaa', 'alaa@gmail.com', '$2y$10$CEasKILI5WuwlWuysg5cJOv.83SJ8jxisIVkTzJINgOUfb2OjYewO', '2025-05-13 19:23:50', 'user'),
(3, 'lol', 'lol@gmail.com', '$2y$10$fDKUesR6kNksWoeYAbmMFeVPRfwIAsv1anhIztHli/5UdF12fJ6zm', '2025-05-15 08:49:03', 'user'),
(4, 'roa', 'roaa@gmail.com', '$2y$10$MjqotL30lx6bgHYNF0ovruqSalRArqdhvFmCXRPJv2oKZmyk1JP2S', '2025-05-16 16:23:40', 'user'),
(5, 'رؤى', 'roaa1@gmail.com', '$2y$10$fy7oV/mDIDJizkjDaJGZeOtuMf61G7NbVJ4.0gVWtx1XLCWYKY3P.', '2025-05-16 17:08:15', 'user'),
(7, 'mera', 'mera@gmail.com', '$2y$10$SUj0X/svclU/Kb6IQ5O3ied4sfIlh8dCBeHsM2iX0DbKTSzkRvdY6', '2025-05-16 18:16:56', 'user'),
(8, 'noor', 'nooor@gmail.com', '$2y$10$qAk3xS1x1nse2kW5bWd9ru7sjnFGsxUdDZnjD.L.lcTtr9hMl0uPC', '2025-05-16 18:24:03', 'user'),
(9, '1roaa', 'roaa2@gmail.com', '$2y$10$BckMzzZcpyHBHHwROYvYReyrtwFUWNnPmJlq.m4bCvC.UslSdPpCa', '2025-05-16 19:29:56', 'user'),
(10, 'aisha', 'aisha@gmail.com', '$2y$10$toi0POlkYtLT4w4KUDQVpuZ9WLteTbP8hJ9ems2Af5wVhhgmwSFbm', '2025-05-16 21:59:59', 'user'),
(11, 'remi', 'roaa3@gmail.com', '$2y$10$Gm20JVhh4nehdiDFPS.lXuWCvUhjTavh9k1IXjSORoYsjUwyFkkFm', '2025-05-18 11:12:32', 'user'),
(12, 'roaa1', 'alaaahmedmohad@example.com', '$2y$10$FayCFTG.7o1QCZaeYxyds.Hlrf5f395nyQEtkQMWw3gNwlGdoHfei', '2025-05-18 17:19:40', 'admin'),
(13, 'aisha1', 'alaaahmedmohad1@example.com', '$2y$10$HHjeo49QtdEJHWO7/asSWOSMhAZo9OYh0z8pESaNtBqD9GJsUPvD.', '2025-05-18 18:14:42', 'admin'),
(14, 'رؤى1', 'IU@example.com', '$2y$10$af8QtdMP5rhJORCluNNVcOJgWL0IDu1JpMx0w08.LgFHZxqLabWZK', '2025-05-18 18:52:02', 'user'),
(15, 'aiosh', 'aiosh@example.com', '$2y$10$Eo.PCdo6zLeXVMi96pqtr.U1ItTJokC.MjATAu5imB05dljKiba1K', '2025-05-21 21:27:16', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_info`
--
ALTER TABLE `about_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `available_times`
--
ALTER TABLE `available_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_info`
--
ALTER TABLE `about_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `available_times`
--
ALTER TABLE `available_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
