-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 11:08 AM
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

INSERT INTO `bookings` (`id`, `tracking_code`, `customer_name`, `customer_phone`, `total_amount_ksh`, `payment_method`, `status`, `created_at`) VALUES
(1, 'TMB-4735', 'michael', '0704447767', 29250.00, 'Pending', 'Confirmed', '2026-03-21 02:24:29'),
(2, 'TMB-5959', 'michael', '0704447767', 5850.00, 'Pending', 'Confirmed', '2026-03-22 19:40:00'),
(4, 'TMB-6575', 'michael', '0704447767', 250.00, 'Pending', 'Confirmed', '2026-03-24 09:25:31'),
(5, 'TMB-5419', 'michael', '0704447767', 1200.00, 'Pending', 'Confirmed', '2026-03-24 09:48:01'),
(6, 'TMB-4976', 'michael', '0704447767', 1200.00, 'M-Pesa', 'Confirmed', '2026-03-24 09:58:50');

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
(6, 6, 5, 1.00);

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
  `stock_status` enum('In Stock','Low Stock','Out of Stock') DEFAULT 'In Stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `wood_type`, `product_category`, `description`, `price_ksh`, `measurement_unit`, `stock_status`) VALUES
(1, '', '', 'Premium quality oak beams for structural support', 5850.00, 'feet', 'In Stock'),
(2, 'Pine', '', 'Affordable pine beams for general construction', 3640.00, 'feet', 'In Stock'),
(3, 'Cypress', 'Doors', 'Elegant cypress wood interior door', 15000.00, 'pieces', 'In Stock'),
(4, 'Mahogany', 'Beds', 'Luxury mahogany frame king-size bed', 45000.00, 'pieces', 'In Stock'),
(5, 'Bluegum', 'Frames', 'Durable bluegum window and door frames', 1200.00, 'feet', 'Low Stock'),
(6, 'Grevillea', 'Steps', 'Smooth finished grevillea wood for staircases', 250.00, 'feet', 'Out of Stock');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
