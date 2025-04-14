-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 04:26 AM
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
  `employee_address` varchar(255) NOT NULL,
  `employee_dob` varchar(255) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_fname`, `employee_lname`, `employee_address`, `employee_dob`, `role`) VALUES
(1, 'Henry', 'Hagrid', 'America', 'January 1, 1990', 'Owner'),
(2, 'Jackson', 'David', 'Canada', 'Febuary 1, 1989', 'Staff'),
(5, 'Micheal', 'Angelo', 'Los Angeles', 'March 1, 1988', 'Owner'),
(6, 'Maria', 'Lambo', 'London', 'April 1, 1987', 'Staff');

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
  `Product_image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_id`, `Product_name`, `Product_brand`, `Product_desc`, `Product_quantity`, `Product_price`, `Category_id`, `Barcode_id`, `Product_image_name`, `Product_image_path`) VALUES
(51, 'iPhone 16 Pro Max', 'Apple', 'Apples new release', 10, 70000.00, 2, '480005100051', '67f7205d0a5e9-Apple iPhone 16 Pro Max.jpg', 'uploads/67f7205d0a5e9-Apple iPhone 16 Pro Max.jpg'),
(52, 'Galaxy S25+', 'Samsung', 'A samsung phone', 10, 50000.00, 2, '480005200052', '67f7209874f10-Galaxy S25+.jpg', 'uploads/67f7209874f10-Galaxy S25+.jpg'),
(53, 'Infinix ZERO 40 5G', 'Infinix', 'A Infinix phone', 10, 15000.00, 2, '480005300053', '67f720e3ed082-Infinix ZERO 40 5G.jpg', 'uploads/67f720e3ed082-Infinix ZERO 40 5G.jpg'),
(54, 'Macbook Air M1', 'Apple', 'A apple laptop', 9, 400000.00, 1, '480005400054', '67f721e09b39a-Macbook Air M1.jpg', 'uploads/67f721e09b39a-Macbook Air M1.jpg'),
(55, 'Toshiba Dynabook', 'Toshiba', 'A toshiba laptop', 10, 11000.00, 1, '480005500055', '67f72216adc02-Toshiba Dynabook Satellite.jpg', 'uploads/67f72216adc02-Toshiba Dynabook Satellite.jpg'),
(56, 'Razerblade 15', 'Razer', 'a razer laptop', 10, 100000.00, 1, '480005600056', '67f7224f147e7-Razer Blade 15.jpg', 'uploads/67f7224f147e7-Razer Blade 15.jpg'),
(57, 'Logitech G Pro', 'Logitech', 'a logitech mouse', 10, 5000.00, 3, '480005700057', '67f722c94c9da-Logitech G Pro.png', 'uploads/67f722c94c9da-Logitech G Pro.png'),
(58, 'Razer Death', 'Razer', 'a razer mouse', 10, 3000.00, 3, '480005800058', '67f7230578e77-Razer DeathAdder.png', 'uploads/67f7230578e77-Razer DeathAdder.png'),
(59, 'Magic Mouse', 'Apple', 'a apple mouse', 10, 3500.00, 3, '480005900059', '67f7232d781e0-Magic Mouse.png', 'uploads/67f7232d781e0-Magic Mouse.png'),
(60, 'Ajazz AK820', 'Ajazz', 'a ajazz keyboard', 10, 2000.00, 4, '480006000060', '67f72384e79c1-Epomaker Ajazz AK820.png', 'uploads/67f72384e79c1-Epomaker Ajazz AK820.png'),
(61, 'Logitech KB', 'Logitech', 'a logitech keyboard', 10, 5000.00, 4, '480006100061', '67f723b2021c7-Logitech G pro Keyboard.png', 'uploads/67f723b2021c7-Logitech G pro Keyboard.png'),
(62, 'Razer Huntsman', 'Razer', 'a razer keyboard', 10, 5000.00, 4, '480006200062', '67f723e934746-Razer Huntsman V3.png', 'uploads/67f723e934746-Razer Huntsman V3.png'),
(63, 'AOC 27B376H', 'AOC', 'a aoc monitor', 10, 11000.00, 5, '480006300063', '67f724391189d-AOC 27B376H.png', 'uploads/67f724391189d-AOC 27B376H.png'),
(64, 'Samsung 32 Class', 'Samsung', 'a samsung monitor', 10, 25000.00, 5, '480006400064', '67f724636145a-Samsung 32 Class Curved.png', 'uploads/67f724636145a-Samsung 32 Class Curved.png'),
(65, 'LG UltraGear', 'LG', 'a LG monitor', 10, 20000.00, 5, '480006500065', '67f7248957fcc-UltraGear LG.png', 'uploads/67f7248957fcc-UltraGear LG.png');

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
(1, 'Owner', 'the one who owns'),
(2, 'staff', 'the hired ones');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(7) NOT NULL,
  `purchase_list` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(10) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `purchase_list`, `total_amount`, `payment_method`, `transaction_date`) VALUES
('8954169', 'Laptop 1 (x2), laptop 2 (x1)', 34970.00, 'cash', '2025-04-10 01:15:10'),
('2174613', 'Macbook Air M1 (x1)', 520000.00, 'cash', '2025-04-10 01:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rank_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `rank_id`) VALUES
(1, 'admin', '$2y$10$h1xrhJ3w.16omaoPahNMeeyXQe2XhV77Q8OElp0uiBSc.mwohjhKu', 'admin@admin.com', 1),
(2, 'staff', '$2y$10$iLs.zoP6i8HbfrewNJRjV.NKzbIOhL1AClcpdbtu6PgbAASzzd6Se', '', 2);

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
  ADD KEY `rank_id_fk` (`rank_id`);

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
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `users_to_employees_fk` FOREIGN KEY (`user_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `users_to_rank_fk` FOREIGN KEY (`rank_id`) REFERENCES `ranks` (`rank_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
