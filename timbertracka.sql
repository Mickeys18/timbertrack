-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 12:40 PM
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
-- Database: `timbertrack_a`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `last_login`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tracking_code` varchar(20) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `total_amount_ksh` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','M-Pesa','Pending') DEFAULT 'Pending',
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `product_id`, `tracking_code`, `customer_name`, `customer_phone`, `total_amount_ksh`, `payment_method`, `status`, `created_at`) VALUES
(1, 0, 'TMB-4735', 'michael', '0704447767', 29250.00, 'Pending', 'Confirmed', '2026-03-21 02:24:29'),
(2, 0, 'TMB-5959', 'michael', '0704447767', 5850.00, 'Pending', 'Confirmed', '2026-03-22 19:40:00'),
(4, 0, 'TMB-6575', 'michael', '0704447767', 250.00, 'Pending', 'Confirmed', '2026-03-24 09:25:31'),
(5, 0, 'TMB-5419', 'michael', '0704447767', 1200.00, 'Pending', 'Confirmed', '2026-03-24 09:48:01'),
(6, 0, 'TMB-4976', 'michael', '0704447767', 1200.00, 'M-Pesa', 'Confirmed', '2026-03-24 09:58:50'),
(7, 0, 'TMB-1857', 'michael', '0704447767', 1200.00, 'Cash', 'Confirmed', '2026-03-25 04:25:35'),
(8, 0, 'TMB-3222', 'michael', '0704447767', 1200.00, 'Cash', 'Confirmed', '2026-03-25 12:56:36'),
(9, 0, 'TMB-7099', 'michael', '0704447767', 19250.00, 'M-Pesa', 'Confirmed', '2026-03-30 14:53:57'),
(10, 0, 'TMB-9918', 'michael', '0704447767', 25000.00, 'Cash', 'Confirmed', '2026-04-08 16:55:36'),
(11, 0, 'TMB-4779', 'michael', '0704447767', 50000.00, 'M-Pesa', 'Confirmed', '2026-04-26 19:11:56'),
(12, 0, 'TMB-3904', 'michael', '0704447767', 168000.00, 'Pending', 'Pending', '2026-04-26 19:14:45'),
(13, 0, 'TMB-7530', 'michael', '0704447767', 80000.00, 'M-Pesa', 'Confirmed', '2026-04-27 02:14:37'),
(14, 0, 'TMB-7023', 'michael', '0704447767', 40000.00, 'M-Pesa', 'Confirmed', '2026-04-27 02:41:07'),
(15, 0, 'TMB-4320', 'michael', '0704447767', 4000.00, 'M-Pesa', 'Confirmed', '2026-04-27 02:42:11'),
(16, 0, 'TMB-3961', 'michael', '0704447767', 22000.00, 'M-Pesa', 'Confirmed', '2026-04-27 02:44:46'),
(17, 0, 'TMB-1453', 'michael', '0704447767', 2000.00, 'Cash', 'Confirmed', '2026-04-27 02:55:15'),
(18, 0, 'TMB-8300', 'michael', '0704447767', 2250000.00, 'M-Pesa', 'Confirmed', '2026-04-27 09:08:35'),
(19, 0, 'TMB-8402', 'michael', '0704447767', 120000.00, 'M-Pesa', 'Confirmed', '2026-04-27 12:02:28'),
(20, 0, 'TMB-9608', 'michael', '0704447767', 96000.00, 'Cash', 'Confirmed', '2026-04-27 12:04:08'),
(21, 0, 'TMB-6657', 'michael', '0704447767', 36000.00, 'M-Pesa', 'Confirmed', '2026-04-27 12:05:33'),
(22, 0, 'TMB-6625', 'michael', '0704447767', 45000.00, 'M-Pesa', 'Confirmed', '2026-04-27 12:08:07'),
(23, 0, 'TMB-8080', 'michael', '0704447767', 3000.00, 'Pending', 'Pending', '2026-04-27 18:39:48'),
(24, 0, 'TMB-7930', 'michael', '0704447767', 15000.00, 'Cash', 'Confirmed', '2026-04-27 18:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `booking_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 5.00),
(2, 2, 1, 1.00),
(4, 4, 6, 1.00),
(5, 5, 5, 1.00),
(6, 6, 5, 1.00),
(7, 7, 5, 1.00),
(8, 8, 5, 1.00),
(9, 9, 6, 77.00),
(10, 10, 6, 100.00),
(11, 11, 6, 200.00),
(12, 12, 5, 140.00),
(13, 13, 7, 100.00),
(14, 14, 7, 50.00),
(15, 15, 7, 5.00),
(16, 16, 8, 110.00),
(17, 17, 8, 10.00),
(18, 18, 4, 50.00),
(19, 19, 5, 100.00),
(20, 20, 5, 80.00),
(21, 21, 5, 30.00),
(22, 22, 9, 150.00),
(23, 23, 9, 10.00),
(24, 24, 9, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `wood_type` enum('Cypress','Pine','Bluegum','Grevillea','Mahogany') NOT NULL,
  `product_category` enum('Frames','Cladding','Steps','Spindles','Doors','Beds','Boards','Lipping Cuttings','Raw Timber') NOT NULL,
  `description` text DEFAULT NULL,
  `price_ksh` decimal(10,2) NOT NULL,
  `measurement_unit` varchar(50) DEFAULT 'feet',
  `stock_status` enum('In Stock','Low Stock','Out of Stock') DEFAULT 'In Stock',
  `stock_quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `wood_type`, `product_category`, `description`, `price_ksh`, `measurement_unit`, `stock_status`, `stock_quantity`) VALUES
(1, 'Mahogany', '', 'Premium quality oak beams for structural support', 5850.00, 'feet', 'In Stock', 200),
(2, 'Pine', '', 'Affordable pine beams for general construction', 3640.00, 'feet', 'In Stock', 200),
(3, 'Cypress', '', 'Elegant cypress wood interior door', 15000.00, 'pieces', 'In Stock', 200),
(4, 'Mahogany', 'Beds', 'Luxury mahogany frame king-size bed', 45000.00, 'pieces', 'In Stock', 150),
(5, 'Bluegum', '', 'Durable bluegum window and door frames', 1200.00, 'feet', 'Low Stock', -10),
(6, 'Grevillea', '', 'Smooth finished grevillea wood for staircases', 250.00, 'feet', 'Out of Stock', 0),
(7, 'Cypress', '', 'Hardwood', 800.00, 'pieces ', 'In Stock', 45),
(8, 'Cypress', 'Cladding', 'best', 200.00, 'feet', 'In Stock', 80),
(9, 'Cypress', 'Cladding', '', 300.00, 'feet', 'In Stock', -50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_code` (`tracking_code`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
