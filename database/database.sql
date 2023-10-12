-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 05:02 AM
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
-- Database: `farmerspoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(50) DEFAULT NULL,
  `total_price` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `total_price`) VALUES
(1, 2, 2, 5, 1050),
(2, 2, 3, 4, 600),
(3, 2, 5, 3, 300),
(4, 2, 7, 3, 1230);

-- --------------------------------------------------------

--
-- Table structure for table `finalorder`
--

CREATE TABLE `finalorder` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(50) DEFAULT NULL,
  `total_price` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finalorder`
--

INSERT INTO `finalorder` (`id`, `user_id`, `product_id`, `quantity`, `total_price`) VALUES
(1, 2, 2, 5, 1050),
(2, 2, 1, 2, 300),
(3, 2, 7, 2, 820),
(4, 2, 8, 1, 300),
(5, 3, 3, 5, 750),
(6, 3, 14, 2, 70),
(7, 3, 12, 3, 450);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `quantity` int(225) DEFAULT NULL,
  `price` int(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `category` enum('Fruit','Vegetable','Meat','Dry Fruits') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `price`, `image`, `category`) VALUES
(1, 'Banana', 123, 150, 'download (7).jpg', 'Fruit'),
(2, 'Apple', 95, 210, 'apple.jpg', 'Fruit'),
(3, 'Dagon fruits', 70, 150, 'abc.png', 'Fruit'),
(4, 'Lady finger', 50, 40, 'ladiesfinger.jpg', 'Vegetable'),
(5, 'Kiwi', 45, 100, 'istockphoto-482728017-612x612.jpg', 'Fruit'),
(6, 'Pumpkin', 35, 50, 'pumkinseeds.jpg', 'Vegetable'),
(7, 'Chicken', 73, 410, 'download.jpg', 'Meat'),
(8, 'Beef', 34, 300, 'download (1).jpg', 'Meat'),
(9, 'Mutton', 75, 1300, 'mutton.jpg', 'Meat'),
(10, 'Fish', 35, 500, 'download (2).jpg', 'Meat'),
(11, 'Spinach', 25, 55, 'download (3).jpg', 'Vegetable'),
(12, 'Watermelon', 52, 150, 'download (8).jpg', 'Fruit'),
(13, 'Long beans', 45, 65, 'download (5).jpg', 'Vegetable'),
(14, 'Luffa Gourd', 33, 35, 'download (4).jpg', 'Vegetable'),
(15, 'Grapes', 75, 175, 'download (6).jpg', 'Fruit'),
(16, 'Tomato', 100, 115, 'tomatoes-1296x728-feature.jpg', 'Vegetable'),
(17, 'Capsicum', 65, 40, 'istockphoto-480931380-612x612.jpg', 'Vegetable'),
(18, 'Cucumber', 50, 75, 'pexels-lo-2329440.jpg', 'Vegetable'),
(19, 'Brinjal ', 30, 50, '2471-1.jpg', 'Vegetable');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT 0,
  `verification_code` varchar(100) NOT NULL,
  `verification_status` int(2) NOT NULL DEFAULT 0,
  `sOTP` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `isAdmin`, `verification_code`, `verification_status`, `sOTP`) VALUES
(1, 'admin', 'admin@admin.com', '9860370086', 'Kathmandu', '$2y$10$nWw6HTKNd1c7/SxfUQco1epIbIc3IDgVdOKtFusq/Lju8l5Pg8936', 1, '89ec11828086f7c6674b03ae91bf5d7d', 1, ''),
(2, 'Sandeep', 'sundeepgiri2@gmail.com', '9861979509', 'Sindhupalchok', '$2y$10$CgwwDvxZP.iNmXDs/pdYCe.X3dTQ8amdrDv/J5lNyzWzZNi40RJza', 0, 'bb10729c58ba3a24cb3a99edf4892a7f', 1, ''),
(3, 'Sushil', 'khadkasushil555@gmail.com', '9865135040', 'Sindhupalchok', '$2y$10$WVD38PHOOXYXZ0QmxqOFbO2QeWuHwF2/aYzt6H7.Hin0Bv61Drg3y', 0, '8c472cc89ec21cdb2f23d9b01e89a3e0', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `finalorder`
--
ALTER TABLE `finalorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `finalorder`
--
ALTER TABLE `finalorder`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `finalorder`
--
ALTER TABLE `finalorder`
  ADD CONSTRAINT `finalorder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `finalorder_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
