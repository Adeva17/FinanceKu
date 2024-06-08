-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 04:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbfinanceku`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL CHECK (`month` between 1 and 12),
  `amount` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `userId`, `year`, `month`, `amount`) VALUES
(1, 5, 2024, 6, 250000.00),
(2, 5, 2024, 6, 250000.00),
(3, 5, 2024, 6, 200000.00),
(4, 5, 2024, 6, 200000.00),
(5, 4, 2024, 6, 100000.00);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `expenseCategory` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `userId`, `date`, `amount`, `expenseCategory`, `description`) VALUES
(1, 5, '2024-06-05', 120000.00, 'Makanan', 'Membeli Jajan cilok'),
(2, 4, '2024-06-06', 75000.00, 'Kesehatan', 'Beli Toner, Serum, Sunscreen');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `incomeSource` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `userId`, `date`, `amount`, `incomeSource`) VALUES
(3, 4, '2024-06-04', 250000.00, 'Gaji'),
(4, 4, '2024-06-04', 50000.00, 'Bisnis'),
(5, 4, '2024-06-04', 100000.00, 'Bisnis'),
(6, 5, '2024-06-05', 350000.00, 'Gaji'),
(7, 5, '2024-06-05', 20000.00, 'Bisnis');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullName`, `nickname`) VALUES
(2, 'adeva17', '$2y$10$dD9BVFi7Uy7sGMNWFYeKD.9hvYdKFUILS4lPiuQVH8nTr0Ns3nNc2', 'mhmmdadeva@gmail.com', 'Muhammad Adeva', 'Adeva'),
(4, 'wismrt', '$2y$10$qlUOxuRJPPIsfzBWyimzlelUkSufpVwUg7DRI0/DiYaVZi9W4GNXe', 'wisnumurti982@gmail.com', 'Hapsoro Wisnu', 'Wisnu'),
(5, 'wahyu', '$2y$10$TC7n950FxMFLiIO4Gxa1RuLs4FQO0Li/PIAaEXb5r9J46Lfz8FFFe', 'wahyu@gmail.com', 'Wahyu Sampurno', 'Wahyu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
