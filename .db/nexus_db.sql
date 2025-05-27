-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 08:11 AM
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
-- Database: `nexus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_id` int(11) NOT NULL,
  `Category_name` varchar(255) NOT NULL,
  `Category_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_id`, `Category_name`, `Category_desc`) VALUES
(1, 'Laptops', 'Mobile Computers'),
(2, 'Smartphones', 'Handheld computers'),
(3, 'Mouse', 'the thing you use on computer to point stuff'),
(4, 'Keyboards', 'typing stuff'),
(5, 'Monitors', 'Screens and screens');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_fname` varchar(255) NOT NULL,
  `employee_lname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_address` varchar(255) NOT NULL,
  `employee_dob` varchar(255) NOT NULL,
  `role` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `has_account` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_fname`, `employee_lname`, `phone`, `employee_email`, `employee_address`, `employee_dob`, `role`, `status`, `has_account`) VALUES
(17, 'test', 'test', '123456789', 'test@test.com', '', '2025-05-27', 'Admin', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Product_id` int(11) NOT NULL,
  `Product_name` varchar(255) NOT NULL,
  `Product_brand` text NOT NULL,
  `Product_desc` text NOT NULL,
  `Product_quantity` int(11) NOT NULL,
  `Product_price` decimal(11,2) NOT NULL,
  `Category_id` int(11) NOT NULL,
  `Barcode_id` varchar(12) NOT NULL,
  `Product_image_name` text NOT NULL,
  `Product_image_path` text NOT NULL,
  `Items_sold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_id`, `Product_name`, `Product_brand`, `Product_desc`, `Product_quantity`, `Product_price`, `Category_id`, `Barcode_id`, `Product_image_name`, `Product_image_path`, `Items_sold`) VALUES
(99, 'test2', 'test', '', 2, 123.00, 1, '480009900099', 'attachment.gif', '683428dbb9964.gif', 1),
(100, 'test', 'test', 'test', 123, 123.00, 1, '480010000100', '', '683426bd93901.jpg', 9),
(101, 'test3', 'test3', 'test', 123, 123.00, 4, '480010100101', '', '683480d370083.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `Day` varchar(255) NOT NULL,
  `Profits` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`Day`, `Profits`) VALUES
('Monday', 984),
('Tuesday', 492),
('Wednesday', 0),
('Thursday', 0),
('Friday', 0),
('Saturday', 0),
('Sunday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `rank_id` int(11) NOT NULL,
  `rank_name` text NOT NULL,
  `rank_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`rank_id`, `rank_name`, `rank_desc`) VALUES
(1, 'Admin', 'the one who owns'),
(2, 'Staff', 'the hired ones'),
(3, 'Customer', 'The costumer');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(7) NOT NULL,
  `purchase_list` text NOT NULL,
  `subtotal_amount` decimal(10,2) NOT NULL,
  `cash_amount` decimal(10,2) NOT NULL,
  `change_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(10) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `purchase_list`, `subtotal_amount`, `cash_amount`, `change_amount`, `total_amount`, `payment_method`, `transaction_date`) VALUES
('FAMT0VO', 'test (x1)', 123.00, 200.00, 62.24, 137.76, 'Cash', '2025-05-26 08:28:15'),
('01N5V4W', 'test (x1)', 123.00, 200.00, 62.24, 137.76, 'Cash', '2025-05-26 08:45:23'),
('8E4KD1B', 'test (x1)', 123.00, 299.00, 161.24, 137.76, 'Cash', '2025-05-26 08:45:40'),
('N8402CO', 'test (x1)', 123.00, 200.00, 62.24, 137.76, 'Cash', '2025-05-26 08:46:30'),
('EVGM7JT', 'test (x1)', 123.00, 500.00, 362.24, 137.76, 'Cash', '2025-05-26 08:47:07'),
('KQZAMEO', 'test (x1)', 123.00, 300.00, 162.24, 137.76, 'Cash', '2025-05-26 08:47:21'),
('BI9W385', 'test (x1)', 123.00, 500.00, 362.24, 137.76, 'Cash', '2025-05-26 08:48:46'),
('YLCPOF0', 'test (x1)', 123.00, 2000.00, 1862.24, 137.76, 'Cash', '2025-05-26 08:50:31'),
('X7CMTHO', 'test3 (x1)', 123.00, 200.00, 62.24, 137.76, 'Cash', '2025-05-26 20:40:03'),
('UMD5Y14', 'test2 (x1), test (x1), test3 (x1)', 369.00, 500.00, 86.72, 413.28, 'Cash', '2025-05-26 20:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `email`, `rank_id`, `employee_id`) VALUES
(1, '', '', 'admin', '$2y$10$eOr2HwlSx33M5RZMd255QeBDq4yzmsl0KP8gzdpXukbPjrdx9fVFS', 'admin@admin.com', 1, NULL),
(5, '', '', 'staff2', '$2y$10$SaWJMu/ZYT30D8HLzUDwdOgvTp23QarK/E4GYwuK/a9ZSgQAr..oK', 'staff2@staff.com', 2, NULL),
(36, 'test', 'test', 'test', '$2y$10$y3zFvMczUpW8ZhOIB764luRa2kDEb2E7GLuYGR1Te.UdN3s2z.AfS', 'test@test.com', 1, 17);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_id`),
  ADD KEY `Category_id_fk` (`Category_id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `rank_id_fk` (`rank_id`),
  ADD KEY `fk_users_employee` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categories_fk` FOREIGN KEY (`Category_id`) REFERENCES `categories` (`Category_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_to_rank_fk` FOREIGN KEY (`rank_id`) REFERENCES `ranks` (`rank_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
