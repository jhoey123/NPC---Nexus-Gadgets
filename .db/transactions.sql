-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 07:52 PM
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
('1589883', 'ako ra i check kung asa kutob ang text na ma display sa item name ug unsay mahitabo sa taas ra kaayo na name (x1), mouse Pro max 200 (x1), Keyboard Pro max 200 (x1), Keyboards22 (x1)', 791.70, 'cash', '2025-04-09 17:08:07'),
('4630630', 'Keyboard Pro max 200 (x2), Keyboards22 (x1), ako ra i check kung asa kutob ang text na ma display sa item name ug unsay mahitabo sa taas ra kaayo na name (x1), brick pro max (x1), McNoteBook (x1), Keyboards24 (x1), Keyboard max Pro 20 (x1), Keyboards29 (x1)', 1827.80, 'card', '2025-04-09 16:52:46'),
('6811983', 'brick pro max (x2), McNoteBook (x1), ako ra i check kung asa kutob ang text na ma display sa item name ug unsay mahitabo sa taas ra kaayo na name (x1), mouse Pro max 200 (x1), Keyboard Pro max 200 (x1), Keyboards22 (x1), Keyboard Pro min 20000 (x1), Keyboards24 (x1), Keyboard max Pro 20 (x1), Keyboards29 (x1), Monitor maxpro  (x1), Monitor pro min 1 (x1), Monitor pro max (x1)', 6377.80, 'cash', '2025-04-09 16:13:37'),
('7885666', 'Keyboards22 (x2), mouse Pro max 200 (x1), Keyboard Pro max 200 (x1), Monitor pro min 1 (x1)', 1232.40, 'cash', '2025-04-09 17:50:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
