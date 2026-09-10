-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2026 at 12:36 PM
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
-- Database: `hotelcards`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_type` enum('Gold','Platinum','Silver') NOT NULL DEFAULT 'Gold',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `anniversary` date DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed','Other') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `card_number`, `card_type`, `first_name`, `last_name`, `company_name`, `designation`, `contact_no`, `email`, `address`, `dob`, `anniversary`, `marital_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, '1234-5678-9012', 'Platinum', 'John', 'Smith', 'TechCorp Inc.', 'Senior Engineer', '+1-555-0199', 'john.smith@techcorp.com', '123 Main St, Anytown, CA', '1985-05-15', '2010-10-20', 'Married', 'Special handling for large parties', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(2, '2345-6789-0123', 'Gold', 'Emily', 'Johnson', 'Apex Solutions', 'Marketing Director', '+1-555-0145', 'emily.j@apexsol.com', '456 Elm St, Metro City, NY', '1990-08-22', NULL, 'Single', 'Prefers window seating', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(3, '3456-7890-1234', 'Platinum', 'Michael', 'Chang', 'Global Logistics Ltd', 'VP of Operations', '+1-555-0188', 'm.chang@globallog.com', '789 Pine Ave, Coast City, WA', '1978-12-05', '2005-06-18', 'Married', 'VIP guest, vegan menu preference', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(4, '4567-8901-2345', 'Gold', 'Sarah', 'Miller', 'Creative Studio Co.', 'Art Director', '+1-555-0172', 'sarah.m@creativestudio.com', '321 Maple Dr, Sun City, FL', '1995-03-10', NULL, 'Single', 'Allergic to peanuts', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(5, '666-2026-0032', 'Gold', 'Peter', 'Parker', 'Daily Bulgel', 'Photographer', '9201922929', 'peterparker@gmail.com', 'New York', '2001-04-24', NULL, 'Single', NULL, '2026-09-10 10:33:21', '2026-09-10 10:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `access` enum('Admin','Editor','Viewer') NOT NULL DEFAULT 'Viewer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact_no`, `username`, `password_hash`, `access`, `created_at`, `updated_at`) VALUES
(1, 'Alice Walker', 'alice.admin@system.com', '+1-555-0101', 'alicew', '$2b$12$e8Fv2Jb9J7k7Kq9L6q3jNe8kL3z8vK6u5...', 'Admin', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(2, 'Bob Martin', 'bob.editor@system.com', '+1-555-0102', 'bobm', '$2b$12$k8Lm4Nx9O1p2Qr3S4t5uVe1wX2y3zA4b...', 'Editor', '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(3, 'Clara Davis', 'clara.viewer@system.com', '+1-555-0103', 'clarad', '$2b$12$p9Qv6Ty1U2v3Wx4Y5z6aBe7cD8e9fG0h...', 'Viewer', '2026-08-26 08:16:00', '2026-08-26 08:16:00');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `no_of_pax` int(11) NOT NULL,
  `apc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `member_id`, `visit_date`, `no_of_pax`, `apc`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-02-01', 4, 25.50, 1, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(2, 1, '2024-03-15', 2, 30.10, 2, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(3, 1, '2024-04-10', 6, 22.80, 1, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(4, 1, '2024-05-05', 3, 28.90, 2, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(5, 2, '2024-05-18', 2, 45.00, 2, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(6, 3, '2024-05-20', 8, 38.25, 1, '2026-08-26 08:16:00', '2026-08-26 08:16:00'),
(7, 4, '2026-12-10', 5, 32.22, NULL, '2026-09-10 10:19:54', '2026-09-10 10:19:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_number` (`card_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
