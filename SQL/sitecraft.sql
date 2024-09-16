-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 06:22 AM
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
-- Database: `sitecraft`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `cost` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`name`, `image`, `price`, `cost`, `quantity`, `store_id`, `placed_at`, `status`) VALUES
('watch', 'http://localhost/Aptech_Vision/Product_images/product_img_66c792b28b8d4.jpg', 20, 0, 0, 42, '2024-08-23 16:41:05', 0),
('Logo', 'http://localhost/Aptech_Vision/Product_images/product_img_66c8f30edca4e.png', 3, 1.99, 1, 42, '2024-08-24 01:00:00', 0),
('Dribble', 'http://localhost/Aptech_Vision/Product_images/product_img_66c93ec17f937.png', 3, 0, 1, 44, '2024-08-24 02:20:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` double DEFAULT NULL,
  `cost` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `store_id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `quantity`, `price`, `cost`, `image`, `store_id`, `owner_id`, `created_at`) VALUES
(5, 'Wireless Noise-Cancelling Headphones', 'Premium headphones with active noise-cancellation.', '', 0, 249.99, 0, 'https://fakeimg.pl/500x500/ff6600', 0, 0, '2024-07-25 18:00:48'),
(6, 'Gaming Console', 'Immerse yourself in gaming with the latest console.', '', 0, 399.99, 0, 'https://fakeimg.pl/500x500/ff3399', 0, 0, '2024-07-25 18:00:48'),
(7, 'Wireless Charging Pad', 'Charge your devices wirelessly with this sleek charging pad.', '', 0, 39.99, 0, 'https://fakeimg.pl/500x500/ffcc00', 0, 0, '2024-07-25 18:00:48'),
(8, 'Robot Vacuum Cleaner', 'Keep your floors clean with this smart robot vacuum.', '', 0, 299.99, 0, 'https://fakeimg.pl/500x500/66cc66', 0, 0, '2024-07-25 18:00:48'),
(9, 'Fitness Tracker Watch', 'Monitor your health and activity with this smartwatch.', '', 0, 89.99, 0, 'https://fakeimg.pl/500x500/0099cc', 0, 0, '2024-07-25 18:00:48'),
(10, 'Ultrabook Laptop', 'Slim and lightweight laptop for productivity on the go.', '', 0, 999.99, 0, 'https://fakeimg.pl/500x500/990099', 0, 0, '2024-07-25 18:00:48'),
(11, 'Portable External SSD', 'Fast and compact external SSD for data storage and transfer.', '', 0, 149.99, 0, 'https://fakeimg.pl/500x500/3399ff', 0, 0, '2024-07-25 18:00:48'),
(12, 'Electric Scooter', 'Eco-friendly electric scooter for urban commuting.', '', 0, 349.99, 0, 'https://fakeimg.pl/500x500/ff6666', 0, 0, '2024-07-25 18:00:48'),
(13, 'Wireless Gaming Mouse', 'Precision gaming mouse with customizable RGB lighting.', '', 0, 59.99, 0, 'https://fakeimg.pl/500x500/993366', 0, 0, '2024-07-25 18:00:48'),
(14, 'Kitchen Blender', 'Powerful blender for smoothies, soups, and more.', '', 0, 89.99, 0, 'https://fakeimg.pl/500x500/33cc99', 0, 0, '2024-07-25 18:00:48'),
(15, 'Fitness Treadmill', 'High-performance treadmill for home workouts.', '', 0, 899.99, 0, 'https://fakeimg.pl/500x500/66cccc', 0, 0, '2024-07-25 18:00:48'),
(16, 'Bluetooth Speaker', 'Portable speaker with powerful sound and long battery life.', '', 0, 79.99, 0, 'https://fakeimg.pl/500x500/ff9933', 0, 0, '2024-07-25 18:00:48'),
(17, 'Professional DSLR Camera', 'Capture stunning photos with this high-end DSLR camera.', '', 0, 1899.99, 0, 'https://fakeimg.pl/500x500/4466cc', 0, 0, '2024-07-25 18:00:48'),
(18, 'Smartphone Camera Gimbal', 'Stabilize your smartphone videos with this advanced gimbal.', '', 0, 159.99, 0, 'https://fakeimg.pl/500x500/33aa33', 0, 0, '2024-07-25 18:00:48'),
(19, 'Smart Thermostat', 'Programmable thermostat for energy-efficient temperature control.', '', 0, 129.99, 0, 'https://fakeimg.pl/500x500/cc9966', 0, 0, '2024-07-25 18:00:48'),
(20, 'Portable Solar Charger', 'Charge your devices using solar power on the go.', '', 0, 49.99, 0, 'https://fakeimg.pl/500x500/ff9900', 0, 0, '2024-07-25 18:00:48'),
(21, 'Portable Bluetooth Projector', 'Project your favorite content anywhere with this compact projector.', '', 0, 179.99, 0, 'https://fakeimg.pl/500x500/ff66cc', 0, 0, '2024-07-25 18:00:48'),
(22, 'Electric Toothbrush', 'Advanced electric toothbrush for effective oral care.', '', 0, 69.99, 0, 'https://fakeimg.pl/500x500/009966', 0, 0, '2024-07-25 18:00:48'),
(23, 'Indoor Plant Set', 'Assortment of low-maintenance indoor plants.', '', 0, 39.99, 0, 'https://fakeimg.pl/500x500/99cc00', 0, 0, '2024-07-25 18:00:48'),
(24, 'Electric Standing Desk', 'Adjustable standing desk for ergonomic workspace setup.', '', 0, 349.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(25, 'Smart Doorbell Camera', 'Monitor your doorstep with this video doorbell.', '', 0, 149.99, 0, 'https://fakeimg.pl/500x500/ff9966', 0, 0, '2024-07-25 18:00:48'),
(26, 'Instant Pot', 'Multi-functional pressure cooker for quick and easy meals.', '', 0, 79.99, 0, 'https://fakeimg.pl/500x500/996633', 0, 0, '2024-07-25 18:00:48'),
(27, 'Yoga Mat', 'High-quality yoga mat for comfortable workouts.', '', 0, 29.99, 0, 'https://fakeimg.pl/500x500/99cc99', 0, 0, '2024-07-25 18:00:48'),
(28, 'Outdoor Backpack', 'Durable backpack for outdoor adventures and travel.', '', 0, 89.99, 0, 'https://fakeimg.pl/500x500/99cc99', 0, 0, '2024-07-25 18:00:48'),
(29, 'Home Security Camera System', 'Comprehensive home security camera system with multiple cameras.', '', 0, 299.99, 0, 'https://fakeimg.pl/500x500/990000', 0, 0, '2024-07-25 18:00:48'),
(30, 'Portable Bluetooth Speaker', 'Compact speaker for music on the go.', '', 0, 49.99, 0, 'https://fakeimg.pl/500x500/ffcc00', 0, 0, '2024-07-25 18:00:48'),
(31, 'Cookware Set', 'Complete set of high-quality cookware for your kitchen.', '', 0, 199.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(32, 'Fitness Resistance Bands Set', 'Set of versatile resistance bands for home workouts.', '', 0, 29.99, 0, 'https://fakeimg.pl/500x500/009966', 0, 0, '2024-07-25 18:00:48'),
(33, 'Ergonomic Office Chair', 'Comfortable and supportive chair for productive work.', '', 0, 249.99, 0, 'https://fakeimg.pl/500x500/996633', 0, 0, '2024-07-25 18:00:48'),
(34, 'Wireless Charging Stand', 'Charging stand for wireless charging of devices at a convenient angle.', '', 0, 39.99, 0, 'https://fakeimg.pl/500x500/ff9933', 0, 0, '2024-07-25 18:00:48'),
(35, 'Drip Coffee Maker', 'Classic drip coffee maker for brewing your favorite coffee.', '', 0, 49.99, 0, 'https://fakeimg.pl/500x500/cc9966', 0, 0, '2024-07-25 18:00:48'),
(36, 'Garden Tool Set', 'Complete set of gardening tools for tending to your garden.', '', 0, 59.99, 0, 'https://fakeimg.pl/500x500/99cc99', 0, 0, '2024-07-25 18:00:48'),
(37, 'Wireless Sport Earbuds', 'Sweat-resistant earbuds for active workouts.', '', 0, 79.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(38, 'Solar-Powered Outdoor Lights', 'Set of energy-efficient outdoor lights powered by solar panels.', '', 0, 29.99, 0, 'https://fakeimg.pl/500x500/ff9966', 0, 0, '2024-07-25 18:00:48'),
(39, 'Fitness Exercise Ball', 'Stability ball for core workouts and stretching.', '', 0, 19.99, 0, 'https://fakeimg.pl/500x500/0099cc', 0, 0, '2024-07-25 18:00:48'),
(40, 'Bluetooth Karaoke Microphone', 'Wireless microphone for karaoke and music enjoyment.', '', 0, 39.99, 0, 'https://fakeimg.pl/500x500/993366', 0, 0, '2024-07-25 18:00:48'),
(41, 'Digital Drawing Tablet', 'High-precision drawing tablet for digital artists.', '', 0, 199.99, 0, 'https://fakeimg.pl/500x500/ffcc00', 0, 0, '2024-07-25 18:00:48'),
(42, 'Reusable Water Bottle', 'Eco-friendly water bottle for staying hydrated on the go.', '', 0, 19.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(43, 'Cordless Vacuum Cleaner', 'Powerful cordless vacuum for efficient cleaning.', '', 0, 179.99, 0, 'https://fakeimg.pl/500x500/009966', 0, 0, '2024-07-25 18:00:48'),
(44, 'Fitness Jump Rope', 'Adjustable jump rope for cardio workouts.', '', 0, 14.99, 0, 'https://fakeimg.pl/500x500/ff6600', 0, 0, '2024-07-25 18:00:48'),
(45, 'Smart Wi-Fi Plug', 'Control your devices remotely with this smart plug.', '', 0, 24.99, 0, 'https://fakeimg.pl/500x500/993366', 0, 0, '2024-07-25 18:00:48'),
(46, 'Bluetooth Keyboard', 'Wireless keyboard for comfortable typing on various devices.', '', 0, 49.99, 0, 'https://fakeimg.pl/500x500/cc9966', 0, 0, '2024-07-25 18:00:48'),
(47, 'Resistance Band Set', 'Set of resistance bands for versatile strength training.', '', 0, 34.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(48, 'Home Theater Projector', 'Create a cinematic experience at home with this HD projector.', '', 0, 299.99, 0, 'https://fakeimg.pl/500x500/99cc99', 0, 0, '2024-07-25 18:00:48'),
(49, 'Smart Wi-Fi Light Bulb', 'Control your lighting with this smart LED light bulb.', '', 0, 19.99, 0, 'https://fakeimg.pl/500x500/99cc99', 0, 0, '2024-07-25 18:00:48'),
(50, 'Camping Tent', 'Spacious tent for outdoor camping adventures.', '', 0, 149.99, 0, 'https://fakeimg.pl/500x500/0099cc', 0, 0, '2024-07-25 18:00:48'),
(51, 'Smart Home Security System', 'Complete smart security system for your home.', '', 0, 399.99, 0, 'https://fakeimg.pl/500x500/993366', 0, 0, '2024-07-25 18:00:48'),
(52, 'Wireless Charging Mouse Pad', 'Mouse pad with built-in wireless charging for your devices.', '', 0, 29.99, 0, 'https://fakeimg.pl/500x500/ff9966', 0, 0, '2024-07-25 18:00:48'),
(53, 'Fitness Tracker Smartwatch', 'Smartwatch with fitness tracking and health monitoring features.', '', 0, 129.99, 0, 'https://fakeimg.pl/500x500/cc9966', 0, 0, '2024-07-25 18:00:48'),
(54, 'Bluetooth Car Speakerphone', 'Hands-free car speakerphone for safer driving.', '', 0, 39.99, 0, 'https://fakeimg.pl/500x500/336699', 0, 0, '2024-07-25 18:00:48'),
(75, 'Logo', 'asdasd', 'men', 5, 2.99, 1.99, 'http://localhost/Aptech_Vision/Product_images/product_img_66c8f30edca4e.png', 42, 1, '2024-08-23 20:37:34'),
(76, 'test', 'asd', 'men', 5, 2.99, 1, 'http://localhost/Aptech_Vision/Product_images/product_img_66c8f9cb8cc1c.png', 43, 3, '2024-08-23 20:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `preview_image` varchar(255) NOT NULL,
  `template` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `created_by` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `category`, `logo`, `preview_image`, `template`, `theme`, `path`, `published`, `domain`, `created_by`) VALUES
(42, 'Daraz', 'E-commerce Clothing Store', 'http://localhost/Aptech_vision/User_Uploads/eef78e79bc931727c95a8e8fddd0c1d0.png', 'http://localhost/Aptech_Vision/Uploads/template-2.png', 'Daraz_giftos', '3', 'http://localhost/Aptech_vision/User_Stores/Daraz_giftos', 0, NULL, 1),
(43, 'Zohain_Shopping_Center', 'E-commerce Clothing Store', 'http://localhost/Aptech_vision/User_Uploads/5ac3677c4d1834c0750f6f4b787c9714.png', 'http://localhost/Aptech_Vision/Uploads/template-2.png', 'Zohain_Shopping_Center_giftos', '8', 'http://localhost/Aptech_vision/User_Stores/Zohain Shopping Center_giftos', 0, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`, `created_at`) VALUES
(1, 'Zohaibkhalid_0', 'Killerzobi@gmail.com', '$2y$10$wWzf9x6BTKiIJWbrHMamauMaQsyMg5wvuzIVmSfFQzVmhVIC5JsU6', '../Uploads/Dribbble.jpeg', '2024-07-01 15:28:01'),
(2, 'zohaib', 'Zohaib@Ismail.com', '$2y$10$T8ccwlW8MVbX62fmu.S8QOZ5PkY0jrvQYqqZKnML6XBsBGxnZCrfa', 'https://img.icons8.com/officel/30/person-male-skin-type-1-2.png', '2024-07-14 11:44:10'),
(3, 'Zohaib Mughal', 'killerzobi893@gmail.com', '$2y$10$sW74AeYLO1X9WmM/528K5.Znb5oS0yfKaskgNYxMXeB1LdDhArTc6', 'https://lh3.googleusercontent.com/a/ACg8ocJAI7S3JqTvVhvegFbLg4OAZMP1h8DHa7m7h-1E9J1UpPHBt1Dj=s96-c', '2024-07-14 19:11:39'),
(4, 'Zohaib Khan', 'lordgrimok@gmail.com', '', 'https://lh3.googleusercontent.com/a/ACg8ocJy4OpCJ7hwkqTIw9PPtUScm7Sm5DRSjva4LRK5ksOntDEnNVA=s96-c', '2024-07-14 19:58:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
