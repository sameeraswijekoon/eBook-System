-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 11:37 AM
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
-- Database: `ebook_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `category_id`, `language_id`, `pdf_file`, `cover_image`, `upload_date`) VALUES
(1, 'BD Chaurasia’s Human _Anatomy Volume 1', 9, 1, 'BD Chaurasia_s Handbook of General Anatomy, 4th Edition.pdf', 'Screenshot 2024-11-28 134904.png', '2024-11-28 08:32:32'),
(3, 'Chris_Eagle_The_IDA_Pro_book_The_unofficial_guide_to_the_world\'s', 4, 5, 'Chris_Eagle_The_IDA_Pro_book_The_unofficial_guide_to_the_world\'s.pdf', 'Screenshot 2024-11-28 143304.png', '2024-11-28 09:03:42'),
(4, 'Concurrency_Control_in_Distributed_System_Using_Mutual_Exclusion.pdf', 15, 1, 'Concurrency_Control_in_Distributed_System_Using_Mutual_Exclusion.pdf', 'Screenshot 2024-11-28 143919.png', '2024-11-28 09:09:53'),
(5, 'Quantum_Computing_for_Computer_Scientists_Cambridge_University_Press', 13, 1, 'Quantum_Computing_for_Computer_Scientists_Cambridge_University_Press.pdf', 'Screenshot 2024-11-28 145250.png', '2024-11-28 09:23:50'),
(6, 'Software_Engineering,_Artificial_Intelligence,_Networking_and_Parallel', 4, 1, 'Software_Engineering,_Artificial_Intelligence,_Networking_and_Parallel.pdf', 'Screenshot 2024-11-28 150153.png', '2024-11-28 09:32:33'),
(7, 'Distributed_Real_Time_Systems_Theory_and_Practice_Springer_International', 4, 1, 'Distributed_Real_Time_Systems_Theory_and_Practice_Springer_International.pdf', 'Screenshot 2024-11-28 150334.png', '2024-11-28 09:33:57'),
(8, 'Chaurasia’s_Human_Anatomy,_Volume_1_Upper_Limb_Thorax,_6th_Edition', 9, 1, 'Quantum_Computing_for_Computer_Scientists_Cambridge_University_Press.pdf', 'Screenshot 2024-11-29 153310.png', '2024-11-29 10:04:37'),
(9, 'Ceennnngms M of PracAnatVol1', 9, 1, 'Software_Engineering,_Artificial_Intelligence,_Networking_and_Parallel.pdf', 'Screenshot 2024-11-29 153550.png', '2024-11-29 10:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Science'),
(2, 'Fiction'),
(3, 'History'),
(4, 'Technology'),
(5, 'Art'),
(6, 'Biography'),
(7, 'Literature'),
(8, 'Education'),
(9, 'Health'),
(10, 'Psychology'),
(11, 'Philosophy'),
(12, 'Religion'),
(13, 'Mathematics'),
(14, 'Engineering'),
(15, 'Economics'),
(16, 'Politics'),
(17, 'Law'),
(18, 'Travel'),
(19, 'Sports'),
(20, 'Cooking');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `language_id` int(11) NOT NULL,
  `language_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`language_id`, `language_name`) VALUES
(1, 'English'),
(2, 'Sinhala'),
(3, 'Tamil'),
(4, 'French'),
(5, 'Spanish');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Sameera ', 'sameerasw99@gmail.com', '$2y$10$h4LcyNVGOxlyh7Svk8gSneuqS/o1IQCgWVzs6yVfUlSs5Lw1d2jLK', '2024-11-28 06:50:15', 'user'),
(2, 'Kalpa', 'kalpa@gmail.com', '$2y$10$eYrKTCgUnI9qHYle7BnGqOTl4pxQUn.ZHM8ow7tsSqmyBnbapNEYG', '2024-11-28 06:57:19', 'user'),
(3, 'Navin', 'navin@gmail.com', '$2y$10$Ws36v1zOWNDn6nOttLPgfuchTJsWNDvbEI8ff5vuB1mEBnkrBx0Gi', '2024-11-28 09:22:22', 'user'),
(4, 'admin', 'admin@gmail.com', '$2y$10$n.Jq20218u96hj0MYIDHq.m5sIxrrtj9EB6iMvAXcBQy.Fy9LEc.2', '2024-11-29 04:10:46', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`language_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
