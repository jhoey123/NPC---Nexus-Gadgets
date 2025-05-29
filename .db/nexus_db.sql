-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 06:02 AM
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
(17, 'test', 'test', '123456789', 'test@test.com', '', '2025-05-27', 'Admin', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `items_ordered` varchar(255) NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `name`, `email`, `shipping_address`, `phone`, `order_date`, `items_ordered`, `order_total`, `payment_method`) VALUES
(17, 'ORD-96829', 'TEST', 'test@test.com', 'test', 'test', '2025-05-29', 'Redragon K552 x1', 1699.00, 'PayPal');

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
(103, 'Xiaomi Redmi 9A', 'Xiaomi', 'Released 2020, July 07', 100, 3999.00, 2, '480010300103', 'CP1.png', '6837102e86128.png', 2),
(104, 'Infinix Hot 40 Pro', 'Infinix', 'Released 2023, December', 100, 2599.00, 2, '480010400104', 'CP2.png', '683710c2ce6c1.png', 1),
(105, 'Realme 9 Pro+', 'Realme', 'Released 2022, February 21', 100, 11599.00, 2, '480010500105', 'CP3.png', '6837112de0c4d.png', 1),
(106, 'Infinix GT 20 Pro', 'Infinix', 'Available. Released 2024, April 26', 100, 16599.00, 2, '480010600106', 'CP4.png', '68371177b9985.png', 1),
(107, 'Itel P65', 'Itel', 'Released 2024, August 08', 100, 3499.00, 2, '480010700107', 'CP5.png', '6837120fcc088.png', 1),
(108, 'Redragon K552', 'Redragon', 'A redragon keyboard', 100, 1699.00, 4, '480010800108', 'KB1.png', '683715e68b081.png', 2),
(109, 'MageGee Mechanical Gaming Keyboard', 'MageGee', 'A MageGee Mechanical Keyboard', 100, 1999.00, 4, '480010900109', 'KB2.png', '68371a43affb2.png', 1),
(110, 'Redragon Mitra Rgb', 'Redragon', 'A redragon keyboard', 100, 1999.00, 4, '480011000110', 'KB3.png', '68371ab5b9d10.png', 1),
(111, 'Keychron K2', 'Keychron', 'A keychron k2 keyboard', 100, 3800.00, 4, '480011100111', 'KB4.png', '68371b18cb5ff.png', 1),
(112, 'Attack Shark M87', 'AttackShark', 'A attack shark m87 keyboard', 100, 3599.00, 4, '480011200112', 'KB5.png', '68371b5b527b1.png', 1),
(113, 'ACER Aspire A315-59-570Z', 'ACER', 'Intel® Core™ i5-1235U processor\r\n8GB RAM\r\n512GB SSD\r\n15.6\" display with Full HD 1920 x 1080\r\nWindows 11 Home\r\nUltra-slim design\r\nMercury free, environment friendly\r\n2 Years Warranty\r\n\r\n', 100, 30999.00, 1, '480011300113', 'LT1.png', '68371e980f29c.png', 1),
(114, 'ASUS FA506NC-HN011W', 'ASUS', 'ASUS FA506NC-HN011W TUF GAMING A15 GRAPHITE BLACK (90NR0JF7-M003T0) AMD RYZEN 5-7535HS/8GB DDR5 4800MHZ/512GB M.2 NVME PCIE SSD/NVIDIA GEFORCE RTX3050 4GB GDDR6/15.6\" FHD 144HZ/WINDOWS 11 HOME SL 64BIT/WEBCAM/RGB BACKLIT KB/WIFI/BT/LAN/AUDIO PORT/USB PORT', 100, 51999.00, 1, '480011400114', 'LT2.png', '68371f76d8cda.png', 1),
(115, 'DELL Inspiron 15 3520-I71255U', 'DELL', 'DELL INSPIRON 15 3520-I71255U PLATINUM SILVER INTEL CORE I7 1255U/16GB DDR4/512GB M.2 PCIE NVME SSD/INTEL UHD GRAPHICS/WINDOWS 11 HOME SL 64BIT/MS OFFICE HOME & STUDENT 2021/15.6\" FHD/WEBCAM/WIFI/BT/AUDIO PORT/CARD READER/USB PORT/HDMI/LAPTOP', 100, 48990.00, 1, '480011500115', 'LT3.png', '68372046d699e.png', 0),
(116, 'HP 14-EM0105AU', 'HP', 'HP\r\n14-EM0105AU (983L7PA) NATURAL SILVER AMD RYZEN 5-7520U/8GB LPDDR5/256GB M.2\r\nPCIE NVME SSD/AMD RADEON GRAPHICS/14\" FHD/WINDOWS 11 HOME SL\r\n64BIT/WEBCAM/WIFI/BT/AUDIO PORT/CARD READER/USB 3.0/USB TYPE-C/HDMI/LAPTOP', 100, 26999.00, 1, '480011600116', 'LT4.png', '683720b647299.png', 0),
(117, 'LENOVO LOQ 15IRX9', 'Lenovo', 'LENOVO LOQ 15IRX9 (83DV00QWPH) LUNA GREY INTEL CORE I7-13650HX/24GB DDR5 4800MHZ/512GB M.2 2280 PCIE NVME SSD/NVIDIA GEFORCE RTX4060 8GB GDDR6/15.6\" FHD/WINDOWS 11 HOME SL 64BIT/MS OFFICE HOME & STUDENT 2021/WEBCAM/BACKLIT KB/WIFI/BT/LAN/AUDIO PORT/USB PORT', 100, 80499.00, 1, '480011700117', 'LT5.png', '68372141c8b97.png', 0),
(118, 'ACER 27\" KA272 G0BI', 'ACER', '    27\" ZeroFrame FHD IPS (1920x1080)\r\n    Refresh Rate: 120Hz\r\n    Response Time: 1 ms \r\n    Brightness: 250nits\r\n    Contrast Ratio: 1000:1\r\n    VGA & HDMI\r\n    Viewing Angle: 178°(H), 178°(V)\r\n    AdaptiveSync', 100, 6300.00, 5, '480011800118', 'MT1.png', '68372261d5b7d.png', 0),
(119, 'AOC 23.8\" 24B1XH2/71', 'AOC', '24B1XH2 is a 23.8 inch monitor with IPS Wide Viewing Angle, 3-sided Frameless Design, Ultra Slim Stylish Design and Flicker Free Eye Protection. You can view your spreadsheets or weekend movies from virtually any angle without compromising color uniformity.', 100, 4800.00, 5, '480011900119', 'MT2.png', '68372335bdfdc.png', 0),
(120, 'AOPEN 27\" 27SA3 G0BI', 'AOPEN', 'The 27SA3 is a sleek 27-inch IPS monitor designed for smooth performance and vibrant visuals. Featuring a Full HD resolution of 1920x1080, it supports up to 75Hz via VGA and 120Hz via HDMI, delivering fluid motion for both work and play. With a rapid 1ms (TVR) response time, it minimizes blur and ghosting in fast-paced scenes.\r\n\r\nThis monitor boasts a high contrast ratio of 100,000,000:1 and a brightness level of 250 cd/m², ensuring sharp images with rich color depth. It supports 16.7 million colors, covers 72% of the NTSC color gamut, and utilizes 6-bit + FRC technology for improved color gradation.\r\n\r\nDesigned for versatile connectivity, the 27SA3 includes VGA and HDMI 1.4 inputs, along with integrated speakers (1W x2), audio in, and audio out for multimedia convenience. The monitor supports 100x100mm VESA wall mounting and offers ergonomic tilt adjustment from -5° to 15°. Power is supplied via an external adapter (100–240V).\r\n\r\nFinished in classic black, the 27SA3 is ideal for users seeking reliable performance, vibrant visuals, and essential multimedia features in a modern display.', 100, 5200.00, 5, '480012000120', 'MT3.png', '683723b5e2085.png', 0),
(121, 'ASUS 27\" PA278CV', 'ASUS', 'ProArt Display PA278CV is a 27-inch monitor designed to satisfy the needs of creative professionals, from photo and video editing to graphic design. ProArt Display PA278CV is factory calibrated and Calman Verified to deliver superb color accuracy (∆E < 2). It also provides industry-standard 100% sRGB / 100% Rec. 709 color space coverage. The integrated USB-C port supports data transfers, DisplayPort and also support 65W power delivery via one cable provides convenient solution and keep your desk area tidy. PA278CV makes it easy to achieve the exact look you desire quickly, easily and precisely.', 100, 24300.00, 5, '480012100121', 'MT4.png', '683724289dfb6.png', 0),
(122, 'MSI 27\" OPTIX G27C4X', 'MSI', 'MSI Gaming monitors use a curved display panel that has a curvature rate of 1500R, which is the most comfortable and suitable for a wide range of applications from general computing to gaming. Curved panels also help with gameplay immersion, making you feel more connected to the entire experience.', 100, 14750.00, 5, '480012200122', 'MT5.png', '6837248e6d8cd.png', 0),
(123, 'GPRO X SUPERLIGHT', 'Logitech', 'Less than 63 grams. Advanced low-latency LIGHTSPEED wireless. Sub-micron precision with HERO 25K sensor. Remove all obstacles with our lightest and fastest PRO mouse ever.', 100, 6999.00, 3, '480012300123', '', '68373046648a5.png', 0),
(124, 'Razer Viper V2 Pro', 'Razer', 'Esports has a new apex predator. As successor to the award-winning Razer Viper Ultimate, our latest evolution is more than 20% lighter and armed with all-round upgrades for enhanced performance. With one of the lightest wireless gaming mice ever, there’s now nothing holding you back.', 100, 6300.00, 3, '480012400124', '', '6837316a7a7fa.png', 0),
(125, 'Model O 2 Wireless Mouse ', 'Glorious', 'Our legendary gaming mouse—enhanced in every way. Model O is a fusion of lightweight design and game-changing accuracy. Victory has never looked so good.', 100, 5000.00, 3, '480012500125', '', '6837325ce1cf2.png', 0),
(126, 'KATAR PRO XT', 'Corsair', 'Experience lightweight design and heavy-weight performance with the CORSAIR KATAR PRO XT Ultra-Light Gaming Mouse, weighing in at just 73g with a compact symmetric shape and a high-precision 18,000 DPI optical sensor.', 100, 1799.00, 3, '480012600126', '', '6837331acc51f.png', 0),
(127, 'Redragon M616 TRIDENT', 'Redragon', 'Pentakill, 5 DPI Levels\r\n\r\nGeared with 5 redefinable DPI levels (default as: 800/1200/1600/2400/10000), easy to switch between different game needs. Dedicated demand of DPI options between 100-10000 is also available to be processed by software.\r\n\r\nAny Button is Reassignable\r\n\r\n6 programmable buttons are all editable with customizable tactical keybinds in whatever game or work you are engaging. 2 side macro buttons offer you a better gaming and working experience.\r\n\r\nComfort Grip with Details\r\n\r\nThe skin-friendly frosted coating is the main comfort grip of the mouse surface, which offers you the most enjoyable fingerprint-free tactility. The left side equipped with rubber texture strengthened the friction and made the mouse easier to control.\r\n\r\n8 Decent Backlit Modes\r\n\r\nTurn the backlit on and make some kills in your gaming battlefield. The hyped dynamic RGB backlit vibe will never let you down when decorating your gaming space, it would be better with other Redragon accessories with lights on.\r\n\r\nFatigue Killer with Ergonomic Design\r\n\r\nSolid frame with a streamlined and general claw-grip design offers each gamer a satisfying and comfortable gaming experience with less fatigue even though after hours of use.\r\n', 100, 799.00, 3, '480012700127', '', '683733b387e04.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` int(11) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `Profits` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`id`, `Day`, `Profits`) VALUES
(1, 'Monday', 0),
(2, 'Tuesday', 0),
(3, 'Wednesday', 0),
(4, 'Thursday', 140087),
(5, 'Friday', 0),
(6, 'Saturday', 0),
(7, 'Sunday', 0);

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
  `id` int(11) NOT NULL,
  `cashier_name` varchar(255) NOT NULL,
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

INSERT INTO `transactions` (`id`, `cashier_name`, `transaction_id`, `purchase_list`, `subtotal_amount`, `cash_amount`, `change_amount`, `total_amount`, `payment_method`, `transaction_date`) VALUES
(24, 'test test', 'VLYKUTR', 'Xiaomi Redmi 9A (x1)', 3999.00, 5000.00, 521.12, 4478.88, 'Cash', '2025-05-28 21:14:46'),
(25, 'test test', '3M6JHQB', 'Xiaomi Redmi 9A (x1), Infinix Hot 40 Pro (x1), Realme 9 Pro+ (x1), Infinix GT 20 Pro (x1), Itel P65 (x1), Redragon K552 (x1), MageGee Mechanical Gaming Keyboard (x1), Redragon Mitra Rgb (x1), Keychron K2 (x1), Attack Shark M87 (x1), ACER Aspire A315-59-570Z (x1), ASUS FA506NC-HN011W (x1)', 134389.00, 150515.68, 0.00, 150515.68, 'GCash', '2025-05-28 21:15:18');

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
(1, '', '', 'admin', '$2y$10$7xgeJUqZ4AlLKfsvcwOhp.Vo0GWpGnFfnP1ObHOpUKwbkc8UZ6TtO', 'admin@admin.com', 1, NULL),
(5, 'test', 'test', 'staff2', '$2y$10$SaWJMu/ZYT30D8HLzUDwdOgvTp23QarK/E4GYwuK/a9ZSgQAr..oK', 'staff2@staff.com', 2, NULL),
(42, 'testfirstname', 'testinglastname', 'hahalol', '$2y$10$9K2nSDnHQ5LXbuAaPmBQRO6XbIUx7n2dSI6VKbKOqg9KC/CKYcYzK', 'testtest@test.com', 3, NULL);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_id`),
  ADD KEY `Category_id_fk` (`Category_id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
