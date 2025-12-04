-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 09:04 AM
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
-- Database: `digisafedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslog`
--

CREATE TABLE `accesslog` (
  `AccessLogID` int(8) NOT NULL,
  `UserID` int(5) DEFAULT NULL,
  `LockerID` int(3) NOT NULL,
  `QRCodeID` varchar(20) NOT NULL,
  `ActionType` varchar(10) NOT NULL,
  `ErrorDetails` varchar(100) NOT NULL,
  `TimeAttempt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accesslog`
--

INSERT INTO `accesslog` (`AccessLogID`, `UserID`, `LockerID`, `QRCodeID`, `ActionType`, `ErrorDetails`, `TimeAttempt`) VALUES
(15, 3, 1, 'rori8d', 'Scan QR', 'N/A', '2025-05-10 20:25:33'),
(16, 3, 1, 'qhxfa', 'Scan QR', 'N/A', '2025-05-10 20:30:43'),
(17, 3, 1, 'qhxfa', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-10 20:30:57'),
(18, 3, 1, 'ryo7r', 'Scan QR', 'N/A', '2025-05-17 10:57:44'),
(19, 3, 1, 'ryo7r', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-17 10:59:05'),
(20, 3, 1, 'ryo7r', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-17 11:01:28'),
(21, 3, 1, 'ryo7r', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-17 11:01:44'),
(22, 3, 1, '9fvl1', 'Scan QR', 'N/A', '2025-05-17 11:02:31'),
(23, 3, 1, 'hs81lx', 'Scan QR', 'N/A', '2025-05-17 11:04:30'),
(24, 3, 1, 'hs81lx', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-17 11:07:28'),
(25, 3, 1, 'hs81lx', 'Scan QR', 'INVALID or EXPIRED QR', '2025-05-17 11:07:38'),
(26, 3, 1, 'gjxijr', 'Scan QR', 'N/A', '2025-05-17 11:07:54'),
(27, 3, 1, '0rpoo', 'Scan QR', 'N/A', '2025-05-17 11:12:34'),
(28, 3, 1, 'fhqda', 'Scan QR', 'N/A', '2025-05-17 11:13:58'),
(29, 3, 1, 'm2gsjv', 'Scan QR', 'N/A', '2025-05-17 11:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `locker`
--

CREATE TABLE `locker` (
  `LockerID` int(3) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locker`
--

INSERT INTO `locker` (`LockerID`, `Location`, `Status`) VALUES
(1, 'Unknown', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `qrcode`
--

CREATE TABLE `qrcode` (
  `QRCodeID` varchar(20) NOT NULL,
  `GeneratedByUserID` int(5) NOT NULL,
  `LockerID` int(3) NOT NULL,
  `TimeGenerated` datetime NOT NULL,
  `TimeExpired` datetime NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qrcode`
--

INSERT INTO `qrcode` (`QRCodeID`, `GeneratedByUserID`, `LockerID`, `TimeGenerated`, `TimeExpired`, `Status`) VALUES
('068hw', 3, 0, '2025-05-10 19:18:49', '2025-05-10 13:23:49', 'Used'),
('0rpoo', 3, 0, '2025-05-17 11:12:10', '2025-05-17 05:17:10', 'Used'),
('4uup', 3, 0, '2025-05-10 19:27:00', '2025-05-10 13:32:00', 'Used'),
('9fvl1', 3, 0, '2025-05-17 11:01:58', '2025-05-17 05:06:58', 'Used'),
('fhqda', 3, 0, '2025-05-17 11:13:34', '2025-05-17 05:18:34', 'Used'),
('gjxijr', 3, 0, '2025-05-17 11:07:06', '2025-05-17 05:12:06', 'Used'),
('hs81lx', 3, 0, '2025-05-17 11:03:58', '2025-05-17 05:08:58', 'Used'),
('m2gsjv', 3, 0, '2025-05-17 11:14:36', '2025-05-17 05:19:36', 'Used'),
('qhxfa', 3, 0, '2025-05-10 20:30:39', '2025-05-10 14:35:39', 'Used'),
('rori8d', 3, 0, '2025-05-10 20:25:32', '2025-05-10 14:30:32', 'Used'),
('ryo7r', 3, 0, '2025-05-17 10:56:55', '2025-05-17 05:01:55', 'Used'),
('sz55no', 3, 0, '2025-05-10 19:07:26', '2025-05-10 13:12:26', 'Used'),
('uxdg9c', 3, 0, '2025-05-10 19:13:36', '2025-05-10 13:18:36', 'Used'),
('yfxab6', 3, 0, '2025-05-10 19:36:38', '2025-05-10 13:41:38', 'Used');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `TicketID` int(7) NOT NULL,
  `UserID` int(5) NOT NULL,
  `Concern` varchar(300) NOT NULL,
  `TimeSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support`
--

INSERT INTO `support` (`TicketID`, `UserID`, `Concern`, `TimeSent`) VALUES
(1, 11, 'Lorem ipsum dolor sit amet. Et libero culpa et iusto sequi quo quae asperiores. Hic ipsam fugiat est iste velit eum blanditiis harum et voluptates Quis sit iste dolores.', '2025-05-19 14:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(5) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `RegistrationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `Role`, `RegistrationDate`) VALUES
(2, 'Admin User', 'admin@gmail.com', '$2y$10$q./LlKxnu/mAavZb9xyXK.kkIWpHXhJUmQN4OjNAZw51Y6T2KVUqi', 'Admin', '2025-04-22'),
(3, 'User User', 'user@gmail.com', '$2y$10$KD23D1hIyE3pKirzDN3pCuW9Nxnk04vQOPJTAt1F3qIbI.Xsa9CfK', 'User', '2025-04-22'),
(11, 'Renny Rivera', 'aceraze123@gmail.com', '$2y$10$nN.4paR4QVOJIQKTykiLtuUL7QpSb9H0ZSk3Ic.Hto895PVSyDgWK', 'User', '2025-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslog`
--
ALTER TABLE `accesslog`
  ADD PRIMARY KEY (`AccessLogID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `LockerID` (`LockerID`),
  ADD KEY `QRCodeID` (`QRCodeID`);

--
-- Indexes for table `locker`
--
ALTER TABLE `locker`
  ADD PRIMARY KEY (`LockerID`);

--
-- Indexes for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`QRCodeID`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslog`
--
ALTER TABLE `accesslog`
  MODIFY `AccessLogID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `locker`
--
ALTER TABLE `locker`
  MODIFY `LockerID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `TicketID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesslog`
--
ALTER TABLE `accesslog`
  ADD CONSTRAINT `LockerID` FOREIGN KEY (`LockerID`) REFERENCES `locker` (`LockerID`),
  ADD CONSTRAINT `QRCodeID` FOREIGN KEY (`QRCodeID`) REFERENCES `qrcode` (`QRCodeID`),
  ADD CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `support`
--
ALTER TABLE `support`
  ADD CONSTRAINT `support_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
