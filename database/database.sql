CREATE TABLE `products` (
  `id` INT(100) PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) DEFAULT NULL,
  `quantity` INT(50) DEFAULT NULL,
  `price` INT(50) DEFAULT NULL,
  `image` VARCHAR(50) DEFAULT NULL,
  `category` ENUM('Fruit', 'Vegetable', 'Meat', 'Dry Fruits') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT 0,
  `verification_code` varchar(100) NOT NULL,
  `verification_status` int(2) NOT NULL DEFAULT 0,
  `sOTP` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `cart` (
   `id` INT(100) PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT(100) NOT NULL,
  `product_id` INT(100) NOT NULL,
  `quantity` INT(50) DEFAULT NULL,
  `total_price` INT(50) DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `finalorder` (
  `id` INT(100) PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT(100) NOT NULL,
  `product_id` INT(100) NOT NULL,
  `quantity` INT(50) DEFAULT NULL,
  `total_price` INT(50) DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- orders=cart
-- addproduct=products
