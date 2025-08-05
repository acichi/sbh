-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 07:14 PM
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
-- Database: `shelton`
--

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `pin_x` float NOT NULL,
  `pin_y` float NOT NULL,
  `details` text NOT NULL,
  `status` varchar(45) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(45) NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`id`, `name`, `pin_x`, `pin_y`, `details`, `status`, `price`, `image`, `date_added`, `date_updated`) VALUES
(7, 't1', 373.75, 200.52, 'table', 'Available', 500, 'images/6883ad643458d_1.png', '2025-07-26', '0000-00-00'),
(8, 't2', 390.5, 144.1, 'table', 'Available', 500, 'images/6883ad843a665_1.png', '2025-07-26', '0000-00-00'),
(9, 't3', 438.98, 178.48, 'table', 'Available', 500, 'images/6883ad9554680_1.png', '2025-07-26', '0000-00-00'),
(10, 'F1', 226.54, 142.34, 'tables with karaoke', 'Available', 10000, 'images/6883adb46926f_4.png', '2025-07-26', '0000-00-00'),
(11, 'f2', 102.25, 412.08, 'pool, karaoke, good for celebrations rentable', 'Available', 12000, 'images/6883add9d4023_neg.png', '2025-07-26', '0000-00-00'),
(12, 'c1', 371.11, 349.49, 'cottage', 'Available', 1000, 'images/6883adecc0bd6_3.png', '2025-07-26', '0000-00-00'),
(13, 'c2', 122.53, 316.88, 'cottage', 'Available', 1000, 'images/6883ae03082a8_1.png', '2025-07-26', '0000-00-00'),
(14, 'c3', 168.36, 330.1, 'cottage', 'Available', 1000, 'images/6883ae155e983_1.png', '2025-07-26', '0000-00-00'),
(15, 'f3', 258.28, 406.79, 'pool with rooms', 'Available', 10000, 'images/6883ae2d59589_2.png', '2025-07-26', '0000-00-00'),
(16, 'c20', 805.68, 241.95, 'cottage', 'Available', 1000, 'images/6883ae432733a_3.png', '2025-07-26', '0000-00-00'),
(17, 'c21', 497.16, 380.34, 'cottage', 'Available', 1000, 'images/6883ae58beb2d_3.png', '2025-07-26', '0000-00-00'),
(18, 'c12', 651.42, 321.28, 'cottage', 'Available', 1000, 'images/6883ae7048485_3.png', '2025-07-26', '0000-00-00'),
(19, 'c10', 434.57, 433.23, 'cottage', 'Available', 1000, 'images/6883ae8259999_3.png', '2025-07-26', '0000-00-00'),
(20, 'f4', 569.44, 472.02, 'rentable stall', 'Available', 1500, 'images/6883aebd402d0_1.png', '2025-07-26', '0000-00-00'),
(21, 'c8', 800.39, 308.94, 'cottage', 'Available', 1000, 'images/6883aed3ab8ce_4.png', '2025-07-26', '0000-00-00'),
(22, 't6', 692.85, 140.58, 'table', 'Available', 500, 'images/6883aee564dcd_1.png', '2025-07-26', '0000-00-00'),
(23, 't9', 538.59, 139.7, 'table', 'Available', 1000, 'images/6883aefb175a4_4.png', '2025-07-26', '0000-00-00'),
(24, 'c18', 524.49, 325.69, 'cottage', 'Available', 1000, 'images/6883af0e687bd_3.png', '2025-07-26', '0000-00-00'),
(25, 't17', 650.54, 403.26, 'table', 'Available', 1000, 'images/6883af237ffcb_3.png', '2025-07-26', '0000-00-00'),
(26, 't17', 565.92, 408.55, 'cottage', 'Available', 1500, 'images/6883af36e4b25_3.png', '2025-07-26', '0000-00-00'),
(27, 'f10', 439.86, 48.9, 'rooms', 'Available', 10000, 'images/6883af5124eba_1.png', '2025-07-26', '0000-00-00'),
(28, 'f11', 579.14, 40.97, 'rooms', 'Available', 10000, 'images/6883af64001ee_3.png', '2025-07-26', '0000-00-00'),
(29, 'f9', 693.73, 67.41, 'rooms', 'Available', 1000, 'images/6883af77424fd_3.png', '2025-07-26', '0000-00-00'),
(30, 'c19', 786.29, 155.56, 'cottage', 'Available', 1500, 'images/6883af8af3eb6_3.png', '2025-07-26', '0000-00-00'),
(31, 't35', 731.64, 406.79, 'table', 'Available', 1000, 'images/6883afa5760d2_3.png', '2025-07-26', '0000-00-00'),
(32, 'c10', 647.01, 466.73, 'cottage', 'Available', 1000, 'images/6883afc34149f_3.png', '2025-07-26', '0000-00-00'),
(33, 'f9', 330.56, 94.74, 'rooms', 'Available', 1000, 'images/6883afda4a764_4.png', '2025-07-26', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `facility_name` varchar(45) NOT NULL,
  `feedback` text NOT NULL,
  `rate` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_hidden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `fullname`, `facility_name`, `feedback`, `rate`, `timestamp`, `is_hidden`) VALUES
(1, 'John Cruz', 'f1', 'Great experience! The pool was very clean and staff were friendly.', 5, '2025-01-10 02:20:00', 0),
(2, 'Mary Dela Cruz', 'c2', 'The cottages were nice but need more fans.', 4, '2025-01-20 06:45:00', 0),
(3, 'Alex Ramos', 'f3', 'We enjoyed the karaoke night, but the rooms were a bit hot.', 3, '2025-02-05 01:30:00', 0),
(4, 'Grace Lopez', 'c10', 'Perfect for family bonding. Affordable rates.', 5, '2025-02-22 08:15:00', 0),
(5, 'Miguel Santos', 'f4', 'Too crowded during weekends, but the staff managed well.', 4, '2025-03-12 10:00:00', 0),
(6, 'Ana Perez', 'c1', 'The tables were clean and well-arranged.', 5, '2025-03-18 05:05:00', 1),
(7, 'Joey Tan', 't9', 'I think the food is a bit expensive.', 3, '2025-04-02 09:30:00', 0),
(8, 'Liza Chua', 'c18', 'Best resort in Bacolod! Will come back again.', 5, '2025-04-18 03:00:00', 0),
(9, 'Ramon Dizon', 'f11', 'The karaoke system needs an upgrade.', 3, '2025-05-08 11:20:00', 0),
(10, 'Ellen Garcia', 't6', 'Loved the ambiance and the music.', 4, '2025-05-21 04:30:00', 0),
(11, 'Karlo Lim', 'c20', 'Kids loved the pool! Highly recommended.', 5, '2025-06-04 07:00:00', 0),
(12, 'Lea Uy', 'f3', 'Rooms were spacious and clean.', 5, '2025-06-20 02:00:00', 1),
(13, 'Nathan Reyes', 'c8', 'The parking area is small, hard to find space.', 2, '2025-07-10 01:10:00', 0),
(14, 'Shiela Ocampo', 'f1', 'Staff were kind but check-in was slow.', 3, '2025-07-26 00:45:00', 0),
(15, 'Christian Vega', 'c19', 'Everything was perfect! Thank you.', 5, '2025-08-15 06:00:00', 0),
(16, 'Bea Mendoza', 't17', 'The tables near the pool were not shaded.', 3, '2025-08-28 08:30:00', 0),
(17, 'Mark Chan', 'c21', 'Cottages were clean and affordable.', 4, '2025-09-12 02:40:00', 0),
(18, 'Ivy Torres', 'f9', 'Needs improvement in the restroom facilities.', 2, '2025-09-25 11:00:00', 1),
(19, 'Paolo Bautista', 'f10', 'The food was delicious and well-priced.', 5, '2025-10-05 03:30:00', 0),
(20, 'Cathy Villanueva', 't35', 'Great service from the staff.', 5, '2025-10-20 05:50:00', 0),
(21, 'John Doe', 'cottage', 'Great experience! Will come back.', 5, '2025-01-14 16:00:00', 0),
(22, 'Jane Doe', 'pool', 'Kids loved the pool area.', 4, '2025-02-09 16:00:00', 0),
(23, 'Mark Smith', 'rooms', 'Rooms were clean and spacious.', 5, '2025-03-19 16:00:00', 0),
(24, 'Emily Rose', 'table', 'Good service but a bit crowded.', 3, '2025-04-11 16:00:00', 0),
(25, 'Paul Adams', 'cottage', 'Nice place for family gatherings.', 4, '2025-05-07 16:00:00', 0),
(26, 'Anna Lee', 'pool', 'Loved it, highly recommended!', 5, '2025-06-17 16:00:00', 0),
(27, 'Chris White', 'rooms', 'Okay but needs maintenance.', 3, '2025-07-01 16:00:00', 0),
(28, 'Lisa Black', 'table', 'Affordable and convenient.', 4, '2025-08-13 16:00:00', 0),
(29, 'Peter Gray', 'cottage', 'Friendly staff and good ambiance.', 5, '2025-09-05 16:00:00', 0),
(30, 'Maria Blue', 'pool', 'Pool was clean and big enough.', 4, '2025-10-20 16:00:00', 0),
(31, 'John Smith', 'rooms', 'Comfortable stay, will book again.', 5, '2025-11-04 16:00:00', 0),
(32, 'Karen Green', 'table', 'Food could be better.', 3, '2025-12-10 16:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `reservee` varchar(45) NOT NULL,
  `facility_name` varchar(45) NOT NULL,
  `amount_paid` float NOT NULL,
  `balance` float NOT NULL,
  `date_checkin` date NOT NULL,
  `date_checkout` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_booked` date NOT NULL,
  `payment_type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`id`, `transaction_id`, `reservee`, `facility_name`, `amount_paid`, `balance`, `date_checkin`, `date_checkout`, `timestamp`, `date_booked`, `payment_type`) VALUES
(1, 'cs_sCedDjLmvtEu5eKBAxH4iU8b', 'Andrea Antivola', 't2', 4000000, 0, '2025-07-25', '2025-07-28', '2025-07-25 09:39:06', '2025-07-25', 'GCash');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservee` varchar(45) NOT NULL,
  `facility_name` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date_booked` date NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `payment_type` varchar(45) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservee`, `facility_name`, `status`, `date_booked`, `date_start`, `date_end`, `payment_type`, `amount`) VALUES
(1, 'john123', 'f1', 'confirmed', '2025-01-05', '2025-01-10 08:00:00', '2025-01-10 18:00:00', 'gcash', 10000),
(2, 'mary456', 'c2', 'pending', '2025-01-22', '2025-01-27 08:00:00', '2025-01-27 17:00:00', 'cash', 1000),
(3, 'alex789', 't6', 'cancelled', '2025-02-02', '2025-02-05 10:00:00', '2025-02-05 20:00:00', 'gcash', 500),
(4, 'grace777', 'f3', 'confirmed', '2025-02-15', '2025-02-20 08:00:00', '2025-02-20 12:00:00', 'gcash', 12000),
(5, 'mike111', 'c20', 'confirmed', '2025-03-05', '2025-03-08 07:00:00', '2025-03-08 19:00:00', 'card', 1000),
(6, 'anna888', 'f11', 'confirmed', '2025-03-25', '2025-03-30 08:00:00', '2025-03-30 22:00:00', 'gcash', 10000),
(7, 'joey333', 'c10', 'pending', '2025-04-08', '2025-04-12 08:00:00', '2025-04-12 18:00:00', 'cash', 1000),
(8, 'ramon222', 't9', 'confirmed', '2025-04-15', '2025-04-20 09:00:00', '2025-04-20 18:00:00', 'gcash', 1000),
(9, 'ellen444', 'f4', 'confirmed', '2025-05-03', '2025-05-07 08:00:00', '2025-05-07 20:00:00', 'gcash', 1500),
(10, 'karlo666', 'c1', 'cancelled', '2025-05-22', '2025-05-26 08:00:00', '2025-05-26 18:00:00', 'card', 1000),
(11, 'lea999', 'f1', 'confirmed', '2025-06-01', '2025-06-05 08:00:00', '2025-06-05 18:00:00', 'cash', 10000),
(12, 'nathan321', 'c19', 'pending', '2025-06-20', '2025-06-24 07:00:00', '2025-06-24 18:00:00', 'gcash', 1500),
(13, 'shiela555', 'f9', 'confirmed', '2025-07-04', '2025-07-08 08:00:00', '2025-07-08 21:00:00', 'gcash', 1000),
(14, 'christian234', 't17', 'confirmed', '2025-07-18', '2025-07-22 08:00:00', '2025-07-22 18:00:00', 'cash', 1000),
(15, 'mark000', 'c8', 'confirmed', '2025-08-06', '2025-08-10 07:00:00', '2025-08-10 18:00:00', 'gcash', 1000),
(16, 'ivy101', 'f3', 'cancelled', '2025-08-22', '2025-08-27 08:00:00', '2025-08-27 20:00:00', 'gcash', 12000),
(17, 'paolo212', 't35', 'confirmed', '2025-09-02', '2025-09-06 08:00:00', '2025-09-06 18:00:00', 'card', 1000),
(18, 'cathy007', 'f10', 'confirmed', '2025-09-18', '2025-09-22 08:00:00', '2025-09-22 22:00:00', 'gcash', 10000),
(19, 'john123', 'c21', 'pending', '2025-10-05', '2025-10-09 08:00:00', '2025-10-09 18:00:00', 'cash', 1000),
(20, 'mary456', 'f11', 'confirmed', '2025-10-25', '2025-10-30 08:00:00', '2025-10-30 22:00:00', 'gcash', 10000),
(21, 'alex789', 'c2', 'confirmed', '2025-11-08', '2025-11-12 08:00:00', '2025-11-12 18:00:00', 'card', 1000),
(22, 'grace777', 't6', 'confirmed', '2025-11-21', '2025-11-26 08:00:00', '2025-11-26 19:00:00', 'gcash', 500),
(23, 'mike111', 'c8', 'cancelled', '2025-12-04', '2025-12-08 08:00:00', '2025-12-08 18:00:00', 'cash', 1000),
(24, 'anna888', 'f9', 'confirmed', '2025-12-18', '2025-12-22 08:00:00', '2025-12-22 21:00:00', 'gcash', 1000),
(25, 'john_doe', 'cottage', 'confirmed', '2025-01-10', '2025-01-15 10:00:00', '2025-01-15 20:00:00', 'cash', 1500),
(26, 'jane_doe', 'pool', 'confirmed', '2025-01-20', '2025-01-22 08:00:00', '2025-01-22 18:00:00', 'gcash', 3000),
(27, 'mark_smith', 'rooms', 'cancelled', '2025-02-05', '2025-02-07 12:00:00', '2025-02-07 22:00:00', 'cash', 5000),
(28, 'emily_rose', 'table', 'confirmed', '2025-02-12', '2025-02-12 09:00:00', '2025-02-12 21:00:00', 'gcash', 800),
(29, 'paul_adams', 'cottage', 'confirmed', '2025-03-18', '2025-03-20 10:00:00', '2025-03-20 20:00:00', 'cash', 1200),
(30, 'anna_lee', 'pool', 'confirmed', '2025-04-10', '2025-04-15 09:00:00', '2025-04-15 19:00:00', 'cash', 3500),
(31, 'chris_white', 'rooms', 'pending', '2025-05-01', '2025-05-03 12:00:00', '2025-05-03 22:00:00', 'gcash', 6000),
(32, 'lisa_black', 'table', 'confirmed', '2025-06-05', '2025-06-05 08:00:00', '2025-06-05 18:00:00', 'cash', 700),
(33, 'peter_gray', 'cottage', 'confirmed', '2025-07-15', '2025-07-17 09:00:00', '2025-07-17 21:00:00', 'gcash', 2000),
(34, 'maria_blue', 'pool', 'cancelled', '2025-08-02', '2025-08-04 12:00:00', '2025-08-04 22:00:00', 'cash', 4000),
(35, 'john_smith', 'rooms', 'confirmed', '2025-09-09', '2025-09-12 11:00:00', '2025-09-12 21:00:00', 'gcash', 7000),
(36, 'karen_green', 'table', 'confirmed', '2025-10-11', '2025-10-11 08:00:00', '2025-10-11 20:00:00', 'cash', 900),
(37, 'nick_brown', 'cottage', 'confirmed', '2025-11-03', '2025-11-06 10:00:00', '2025-11-06 22:00:00', 'gcash', 1800),
(38, 'olivia_white', 'pool', 'confirmed', '2025-12-15', '2025-12-17 09:00:00', '2025-12-17 19:00:00', 'cash', 3200);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `date_performed` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `number` varchar(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `date_added` timestamp NULL DEFAULT NULL,
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `number`, `username`, `password`, `gender`, `role`, `address`, `date_added`, `date_updated`) VALUES
(1, 'Jeremy G. Lila', 'jeremylila@email.com', '+6396215219', 'jeremylila123', '$2y$10$4b7HjQgpbeIZQuiCWrT61uqciwhoDjDmu7gwMlWa8ZQGSIWWaKOOG', 'Male', 'customer', 'Bago Ciy', '2025-07-18 23:40:12', '2025-07-18 23:40:12'),
(2, 'test', 'test@email.com', '+6396215219', 'test123', '$2y$10$.AGAsFjjszXdfqMFUqmYne0g7.I4Lv86fx5QXkG2F8XJeJACJm8fK', 'Male', 'customer', 'Bago City', '2025-07-19 00:05:08', '2025-07-19 00:05:08'),
(3, 'Andrea Camille Antivola', 'acbt21tata@gmail.com', '+6390728915', 'xoxochi', '$2y$10$gJW5G86UpBE0Ql/Pc3uCCe3gAAMJ2qExHRNKTlk26PylzhRH6Yt76', 'Female', 'admin', 'Sum-ag Bacolod City', '2025-07-21 00:08:24', '2025-07-21 00:08:24'),
(4, 'Juan Dela Cruz', 'juandelacruz@email.com', '+6391234567', 'juancruz01', '$2y$10$rJtXhIVXuRCY6u7XOl0A3u4oG5M1ltaOGBzrZAT6ZBeKslc7xPZ3q', 'Male', 'customer', 'Bacolod City', '2025-07-25 04:46:14', '2025-07-25 04:46:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
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
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
