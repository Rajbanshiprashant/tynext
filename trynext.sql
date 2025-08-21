-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 09:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trynext`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(8, 'admin', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'T-Shirt'),
(2, 'Hoodie'),
(3, 'Jersey');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `order_date`, `payment_status`, `full_name`, `phone`, `shipping_address`) VALUES
(1, 2, 1000.00, 'Cancelled', '2025-06-17 07:57:20', 'Pending', NULL, NULL, NULL),
(2, 2, 1000.00, 'Cancelled', '2025-06-17 08:12:17', 'Pending', NULL, NULL, NULL),
(3, 2, 1000.00, 'Cancelled', '2025-06-17 08:26:18', 'Pending', NULL, NULL, NULL),
(4, 2, 1000.00, 'Processing', '2025-06-17 08:52:44', 'Cash on Delivery', NULL, NULL, NULL),
(5, 2, 3000.00, 'Processing', '2025-06-17 09:09:36', 'Cash on Delivery', NULL, NULL, NULL),
(6, 2, 1500.00, 'Processing', '2025-06-17 10:38:10', 'Cash on Delivery', NULL, NULL, NULL),
(7, 2, 1000.00, 'Cancelled', '2025-06-18 01:54:47', 'Cash on Delivery', NULL, NULL, NULL),
(8, 2, 1000.00, 'Cancelled', '2025-06-18 01:58:04', 'Cash on Delivery', NULL, NULL, NULL),
(9, 2, 1000.00, 'Cancelled', '2025-06-22 08:20:06', 'Cash on Delivery', NULL, NULL, NULL),
(10, 2, 1000.00, 'Cancelled', '2025-06-22 08:27:33', 'Cash on Delivery', NULL, NULL, NULL),
(11, 2, 1000.00, 'Cancelled', '2025-06-22 08:33:55', 'Cash on Delivery', NULL, NULL, NULL),
(12, 2, 1500.00, 'Pending', '2025-06-22 08:41:35', 'Cash on Delivery', 'Mandeep Pariyar', '9766909144', 'Bhimsengola,kathmandu'),
(13, 3, 1000.00, 'Cancelled', '2025-08-20 09:11:40', 'Cash on Delivery', 'Mandeep Pariyar', '9749404111', 'motichowk, lalitput'),
(14, 3, 1000.00, 'Pending', '2025-08-20 11:19:30', 'Cash on Delivery', 'aaksh', '9837634323', 'bhimsengola'),
(17, 4, 6000.00, 'Pending', '2025-08-21 17:47:52', 'Cash on Delivery', '', '', ''),
(18, 4, 6000.00, 'Pending', '2025-08-21 17:55:41', 'Cash on Delivery', '', '', ''),
(19, 4, 3000.00, 'Pending', '2025-08-21 17:59:12', 'Cash on Delivery', '', '', ''),
(20, 4, 1500.00, 'Pending', '2025-08-21 18:00:14', 'Cash on Delivery', '', '', ''),
(21, 4, 1600.00, 'Pending', '2025-08-21 18:03:12', 'Cash on Delivery', '', '', ''),
(22, 4, 1600.00, 'Pending', '2025-08-21 18:04:27', 'Cash on Delivery', '', '', ''),
(23, 4, 1600.00, 'Pending', '2025-08-21 18:04:31', 'Cash on Delivery', '', '', ''),
(24, 4, 1600.00, 'Pending', '2025-08-21 18:04:48', 'Cash on Delivery', '', '', ''),
(25, 4, 1600.00, 'Pending', '2025-08-21 18:05:53', 'Cash on Delivery', '', '', ''),
(26, 4, 1600.00, 'Pending', '2025-08-21 18:06:37', 'Cash on Delivery', '', '', ''),
(27, 4, 5000.00, 'Pending', '2025-08-21 18:06:57', 'Cash on Delivery', '', '', ''),
(28, 4, 5000.00, 'Pending', '2025-08-21 18:07:04', 'Cash on Delivery', '', '', ''),
(29, 4, 5000.00, 'Pending', '2025-08-21 18:10:24', 'Cash on Delivery', '', '', ''),
(30, 4, 5000.00, 'Pending', '2025-08-21 18:14:57', 'Cash on Delivery', '', '9826953695', 'dhulabari'),
(31, 4, 3500.00, 'Pending', '2025-08-21 18:15:33', 'Cash on Delivery', '', '9826953695', 'dhulabari'),
(32, 4, 3500.00, 'Pending', '2025-08-21 18:15:41', 'Cash on Delivery', '', '9826953695', 'dhulabari'),
(33, 4, 3500.00, 'Pending', '2025-08-21 18:17:06', 'Cash on Delivery', '', '9826953695', 'dhulabari'),
(34, 4, 3500.00, 'Pending', '2025-08-21 18:18:19', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(35, 4, 3500.00, 'Pending', '2025-08-21 18:18:59', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(36, 4, 3500.00, 'Pending', '2025-08-21 18:20:43', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(37, 4, 3600.00, 'Pending', '2025-08-21 18:21:15', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(38, 4, 3600.00, 'Pending', '2025-08-21 18:22:34', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(39, 4, 3600.00, 'Pending', '2025-08-21 18:23:36', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(40, 4, 1500.00, 'Pending', '2025-08-21 18:32:45', 'Cash on Delivery', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(41, 4, 1600.00, 'Paid', '2025-08-21 18:35:25', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(42, 4, 1000.00, 'Paid', '2025-08-21 18:38:50', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(43, 4, 1000.00, 'Pending', '2025-08-21 18:40:01', 'Cash on Delivery', 'saca', '9826953695', 'dhdhdh'),
(44, 4, 2000.00, 'Paid', '2025-08-21 18:42:31', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(45, 4, 2000.00, 'Paid', '2025-08-21 18:46:03', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(46, 4, 2000.00, 'Paid', '2025-08-21 18:47:28', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(47, 4, 1500.00, 'Paid', '2025-08-21 18:58:40', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari'),
(49, 4, 1000.00, 'Paid', '2025-08-21 19:21:47', 'khalti', 'prashantrajbanshi@gmail.com', '9826953695', 'dhulabari');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 14, 1, 1000.00),
(2, 2, 14, 1, 1000.00),
(3, 3, 14, 1, 1000.00),
(5, 4, 14, 1, 1000.00),
(6, 5, 15, 2, 1500.00),
(7, 6, 15, 1, 1500.00),
(8, 7, 14, 1, 1000.00),
(9, 8, 14, 1, 1000.00),
(10, 9, 14, 1, 1000.00),
(11, 10, 14, 1, 1000.00),
(12, 11, 14, 1, 1000.00),
(13, 12, 15, 1, 1500.00),
(14, 13, 14, 1, 1000.00),
(18, 17, 21, 4, 1500.00),
(19, 18, 21, 4, 1500.00),
(20, 19, 21, 2, 1500.00),
(21, 20, 21, 1, 1500.00),
(22, 21, 22, 1, 1600.00),
(23, 22, 22, 1, 1600.00),
(24, 23, 22, 1, 1600.00),
(25, 24, 22, 1, 1600.00),
(26, 25, 22, 1, 1600.00),
(27, 26, 22, 1, 1600.00),
(28, 27, 17, 2, 2500.00),
(29, 28, 17, 2, 2500.00),
(30, 29, 17, 2, 2500.00),
(31, 30, 17, 2, 2500.00),
(32, 31, 24, 1, 3500.00),
(33, 32, 24, 1, 3500.00),
(34, 33, 24, 1, 3500.00),
(35, 34, 24, 1, 3500.00),
(36, 35, 24, 1, 3500.00),
(37, 36, 24, 1, 3500.00),
(38, 37, 26, 1, 3600.00),
(39, 38, 26, 1, 3600.00),
(40, 39, 26, 1, 3600.00),
(41, 40, 29, 1, 1500.00),
(42, 41, 31, 1, 1600.00),
(43, 42, 14, 1, 1000.00),
(44, 43, 14, 1, 1000.00),
(45, 44, 14, 2, 1000.00),
(46, 45, 14, 2, 1000.00),
(47, 46, 14, 2, 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `price`, `stock`, `image`, `created_at`) VALUES
(14, 'Black Oversized T-Shirt ', 'Premium TryNext Black Oversized Tshirt', 1, 1000.00, 88, NULL, '2025-06-17 03:37:27'),
(15, 'TryNext White Half Sleeve T-shirt', 'Premium TryNext Quality Half T-Shirt|| White\r\nWinner Club Edition', 1, 1500.00, 99, NULL, '2025-06-17 05:11:52'),
(16, 'TryNext  Half Sleeve T-Shirt', 'Premium TryNext Half-Sleeve T-Shirt in Smoke Grey', 1, 1500.00, 150, NULL, '2025-08-20 07:50:18'),
(17, 'TryNext White Hoodie ', 'Premium TryNext Hoodie in White', 2, 2500.00, 200, NULL, '2025-08-20 07:53:31'),
(19, 'TryNext X Travis Scott T-Shirt', 'TryNext X Cactus Jack  Black Edition \r\nLimited Edition !!!!!', 1, 2000.00, 100, NULL, '2025-08-20 08:20:43'),
(20, 'TryNext X John Rai Hoodie', 'TryNext x John and The Local Edition in Black', 1, 3500.00, 100, NULL, '2025-08-20 08:32:26'),
(21, 'TryNext X Eskecy  Half sleeve T-Shirt || Black', 'TryNext X Sushant KC \r\nParkhana Edition  in Black ', 1, 1500.00, 150, NULL, '2025-08-20 11:25:21'),
(22, 'TryNext X Jordan Half-Sleeve T-shirt || White', 'TryNext X Jordan \r\nExclusive White Edition !!!!', 1, 1600.00, 200, NULL, '2025-08-20 11:43:39'),
(23, 'TryNext X Nike Half-sleeve Tshirt || White', 'Premium Half sleeve Tshirt in White \r\nTryNext X Nike !!!', 1, 1700.00, 200, NULL, '2025-08-20 11:58:56'),
(24, 'Dark Matter Essential Hoodie ||  TryNext X Eskecy', 'TryNext X Eskecy \r\nPremium Hoodie !!!', 2, 3500.00, 100, NULL, '2025-08-20 12:04:27'),
(25, 'Travis Scott AstroWorld Hoodie || TryNext X Astroworld', 'Limited Edition !!!\r\n', 2, 3000.00, 100, NULL, '2025-08-20 12:13:19'),
(26, 'Nike Black/White Swoosh Tech Fleece Pullover Hoodie || TryNext X Nike', 'Limited Stock\r\nHurry Up!!!!', 2, 3600.00, 150, NULL, '2025-08-20 12:18:22'),
(27, 'Jordan Essentials Baseline Fleece Hoodie || Black', 'TryNext X Jorban Edition in Black ', 2, 3400.00, 100, NULL, '2025-08-20 12:32:10'),
(28, 'Cactus Jack X Air Jordan Edition || Green', 'TryNext X Travis Scott !!!\r\nHighest In The Room Edition !!!\r\nLimited Edition....!!', 2, 3600.00, 98, NULL, '2025-08-20 12:35:35'),
(29, 'Real Madrid Adidas Home Jersey 2025/26 || Long Sleeve', 'Real Madrid Home Jersey 25/26 \r\nLong Sleeve Edition...!!!', 3, 1500.00, 100, NULL, '2025-08-20 12:51:10'),
(30, 'Real Madrid 2025/26 Away Kit ', 'TryNext X Real Madrid\r\nTribute to Santiago Bernabeu...!!!\r\nLimited Edition', 3, 1500.00, 96, NULL, '2025-08-20 12:55:56'),
(31, 'Liverpool Home Kit 2056/26', 'TryNext X Liverpool', 3, 1600.00, 100, NULL, '2025-08-20 13:03:04'),
(32, 'Liverpool Away Kit 2025/26', 'TryNext X Liverpool', 3, 1500.00, 100, NULL, '2025-08-20 13:04:03'),
(33, 'Travis Scott X Barcelona Kit', 'Travis scott X Barcelona', 3, 100.00, 100, NULL, '2025-08-20 13:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(10, 14, 'TshirtBlackback.png'),
(11, 14, 'TshirtBlackboth.png'),
(12, 14, 'TshirtBlackfront.png'),
(13, 15, 'TshirtWhiteback.png'),
(14, 15, 'TshirtWhitefront.png'),
(15, 16, 'white1front.png'),
(16, 16, 'white1back.png'),
(17, 17, 'WhiteHoodies.png'),
(25, 19, 'cactus.PNG'),
(28, 20, 'john.PNG'),
(30, 21, 'sushant.PNG'),
(31, 21, 'sushantk.PNG'),
(33, 19, 'cakf.PNG'),
(34, 22, 'jorda1.PNG'),
(35, 22, 'jorda2.PNG'),
(36, 22, 'jorda3.PNG'),
(37, 23, 'nike1.PNG'),
(38, 23, 'nike2.PNG'),
(40, 24, 'hsusnat2.png'),
(41, 24, 'hsushant1.PNG'),
(42, 25, 'astro1.PNG'),
(43, 25, 'astro2.PNG'),
(44, 26, 'nikeh1.PNG'),
(45, 26, 'nikhe2.PNG'),
(46, 27, 'jordanh1.PNG'),
(47, 27, 'jordan2.PNG'),
(48, 28, 'airxtravis1.PNG'),
(49, 28, 'airxtravis2.PNG'),
(51, 29, 'rml11.PNG'),
(52, 29, 'rml2.png'),
(53, 30, 'rmaway2.png'),
(54, 30, 'rmaway1.PNG'),
(55, 31, 'livh1.PNG'),
(56, 31, 'livh2.PNG'),
(57, 32, 'liva1.PNG'),
(58, 32, 'liva2.PNG'),
(61, 33, 'barcatt.png'),
(62, 33, 'barcat1.png'),
(63, 33, 'barcat2.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`) VALUES
(25, 14, 'S'),
(26, 14, 'M'),
(27, 14, 'L'),
(28, 14, 'XL'),
(29, 15, 'S'),
(30, 15, 'M'),
(31, 15, 'L'),
(32, 15, 'XL'),
(33, 16, 'S'),
(34, 16, 'M'),
(35, 16, 'L'),
(36, 16, 'XL'),
(37, 17, 'S'),
(38, 17, 'M'),
(39, 17, 'L'),
(40, 17, 'XL'),
(45, 19, 'S'),
(46, 19, 'M'),
(47, 19, 'L'),
(48, 19, 'XL'),
(49, 20, 'S'),
(50, 20, 'M'),
(51, 20, 'L'),
(52, 20, 'XL'),
(53, 21, 'S'),
(54, 21, 'M'),
(55, 21, 'L'),
(56, 21, 'XL'),
(57, 22, 'S'),
(58, 22, 'M'),
(59, 22, 'L'),
(60, 22, 'XL'),
(61, 23, 'S'),
(62, 23, 'M'),
(63, 23, 'L'),
(64, 23, 'XL'),
(65, 24, 'S'),
(66, 24, 'M'),
(67, 24, 'L'),
(68, 24, 'XL'),
(69, 25, 'S'),
(70, 25, 'M'),
(71, 25, 'L'),
(72, 25, 'XL'),
(73, 26, 'S'),
(74, 26, 'M'),
(75, 26, 'L'),
(76, 26, 'XL'),
(77, 27, 'S'),
(78, 27, 'M'),
(79, 27, 'L'),
(80, 27, 'XL'),
(81, 28, 'S'),
(82, 28, 'M'),
(83, 28, 'L'),
(84, 28, 'XL'),
(85, 29, 'S'),
(86, 29, 'M'),
(87, 29, 'L'),
(88, 29, 'XL'),
(89, 30, 'S'),
(90, 30, 'M'),
(91, 30, 'L'),
(92, 30, 'XL'),
(93, 30, 'XXL'),
(94, 31, 'S'),
(95, 31, 'M'),
(96, 31, 'L'),
(97, 31, 'XL'),
(98, 31, 'XXL'),
(99, 32, 'S'),
(100, 32, 'M'),
(101, 32, 'L'),
(102, 32, 'XL'),
(103, 32, 'XXL'),
(104, 33, 'S'),
(105, 33, 'M'),
(106, 33, 'L'),
(107, 33, 'XL'),
(108, 33, 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `phone`, `created_at`) VALUES
(1, 'Mandeep Pariyar', 'mandeepbca2022@gmail.com', '$2y$10$VG/sRvc8wZ.kQYxcEiVJpeBoIptNm/pRAKmhxx29Cvl8iySH9R9R.', 'Motichowk, Tikathali', '9766909144', '2025-05-20 06:36:04'),
(2, 'mandeep', 'genjikin580@gmail.com', '$2y$10$SqznMJxCT4wR.nToNohB5OmRxjH.wesrCefSZUi9YUyNJwek9g2Iy', 'Motichowk, Tikathali', '9766909145 ', '2025-06-14 05:24:17'),
(3, 'mandeep', 'mandip@gmail.com', '$2y$10$iXlJAlrygPQq.CxxXx4swOwLd9oGAxG/44XFF4bh221vYqy9IK.La', 'Motichowk, Tikathali', '9766909144', '2025-08-20 09:00:14'),
(4, 'prashant', 'prashantrajbanshi@gmail.com', '$2y$10$Y3/LOXs6rY8Y68Pg2ckzhOrlMuq6ISpKyCkxze72mli7ibjVCVVM.', 'dhulabari', '9826953695', '2025-08-21 15:57:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
