-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 06:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alegriya2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `size_id` int(11) DEFAULT NULL,
  `sugar_level_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `has_size` tinyint(1) DEFAULT 0,
  `has_sugar_level` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `user_id`, `category_name`, `description`, `has_size`, `has_sugar_level`) VALUES
(61, NULL, 'Bombaclat', '', 1, 1),
(62, NULL, 'Ibol', '', 1, 0),
(64, NULL, 'My orders', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `order_id`, `archived_at`) VALUES
(1, 114, '2024-11-13 05:28:43'),
(2, 118, '2024-11-13 05:45:59');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(114, 1, '2024-11-11 11:15:07', 188.00, ''),
(118, 1, '2024-11-13 05:39:16', 386.00, 'Pending'),
(119, 1, '2024-11-13 05:39:20', 366.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `size_name` varchar(50) DEFAULT NULL,
  `sugar_level_id` int(11) DEFAULT NULL,
  `sugar_level_name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `user_id`, `product_name`, `quantity`, `size_id`, `size_name`, `sugar_level_id`, `sugar_level_name`, `price`) VALUES
(42, 114, 33, 1, 'Bombaclat', 1, 20, 'Medium', 24, '25', 89.00),
(43, 114, 34, 1, 'My Idol', 1, 21, 'Large', 25, '', 99.00),
(48, 118, 33, 1, 'Bombaclat', 1, 20, 'Medium', 24, '25', 89.00),
(49, 118, 34, 1, 'My Idol', 3, 21, 'Large', 25, '', 99.00),
(50, 119, 33, 1, 'Bombaclat', 3, 20, 'Medium', 24, '25', 89.00),
(51, 119, 34, 1, 'My Idol', 1, 21, 'Large', 25, '', 99.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `user_id`, `category_id`, `product_name`, `price`, `description`, `image`) VALUES
(33, NULL, 61, 'Bombaclat', 89.00, '', 'uploads/Bomb137.png'),
(34, NULL, 62, 'My Idol', 99.00, '', 'uploads/eh paano kung.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `size_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `size` varchar(50) NOT NULL,
  `price_modifier` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`size_id`, `product_id`, `user_id`, `size`, `price_modifier`) VALUES
(20, 33, NULL, 'Medium', 0.00),
(21, 34, NULL, 'Large', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_sugar_level`
--

CREATE TABLE `product_sugar_level` (
  `sugar_level_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sugar_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sugar_level`
--

INSERT INTO `product_sugar_level` (`sugar_level_id`, `product_id`, `user_id`, `sugar_level`) VALUES
(24, 33, NULL, '25'),
(25, 34, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','cashier') DEFAULT 'cashier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$Dnq5tcHDWCNHen.dRPiPte3lDIQoqsal9ZscWp8Z0mc/H9DYKoqmG', 'admin@gmail.com', '2024-11-01 20:01:18', 'admin'),
(2, 'cashier', '$2y$10$t1uD5KsfntnfC9bSqPNDb.3fj0u/TXvXV99FnywSOd2ztkGuinLui', 'cashier@gmail.com', '2024-11-01 20:03:29', 'cashier'),
(3, 'cashier2', '$2y$10$xSg/n1Y/ZUOrTxMTzRwIlegTUdvlo087g2FrZ9GxNyHtrWf8W7yj.', 'cashier2@gmail.com', '2024-11-01 20:05:28', 'cashier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `sugar_level_id` (`sugar_level_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `sugar_level_id` (`sugar_level_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_items_ibfk_1` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_product_size` (`product_id`);

--
-- Indexes for table `product_sugar_level`
--
ALTER TABLE `product_sugar_level`
  ADD PRIMARY KEY (`sugar_level_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_product_sugar_level` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_sugar_level`
--
ALTER TABLE `product_sugar_level`
  MODIFY `sugar_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `product_size` (`size_id`),
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`sugar_level_id`) REFERENCES `product_sugar_level` (`sugar_level_id`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `product_size` (`size_id`),
  ADD CONSTRAINT `order_items_ibfk_4` FOREIGN KEY (`sugar_level_id`) REFERENCES `product_sugar_level` (`sugar_level_id`),
  ADD CONSTRAINT `order_items_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_size` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `product_size_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `product_sugar_level`
--
ALTER TABLE `product_sugar_level`
  ADD CONSTRAINT `fk_product_sugar_level` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_sugar_level_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
