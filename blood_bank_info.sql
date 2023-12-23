-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2023 at 05:59 PM
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
-- Database: `blood_donation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_own_info`
--

CREATE TABLE `admin_own_info` (
  `Admin_ID` int(7) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Contact_info` varchar(11) NOT NULL,
  `E_Mail` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_own_info`
--

INSERT INTO `admin_own_info` (`Admin_ID`, `Name`, `Contact_info`, `E_Mail`, `password`) VALUES
(1100100, 'Noushin', '01830649226', 'noushin@iub.edu', '$2y$10$E5nqiuRttYwv3z1p0pFTU./Ym46Jjh6lv228R8EzqEa97M1TJjA/e');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank_info`
--

CREATE TABLE `blood_bank_info` (
  `user_id` int(7) NOT NULL,
  `Bpassword` varchar(255) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Security_code` varchar(10) NOT NULL,
  `Contact` varchar(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Storage_capacity` int(5) NOT NULL,
  `facilities` varchar(50) DEFAULT NULL,
  `Verification` enum('Not Verified','Verified') NOT NULL DEFAULT 'Not Verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank_info`
--

INSERT INTO `blood_bank_info` (`user_id`, `Bpassword`, `Name`, `Security_code`, `Contact`, `Email`, `Location`, `Storage_capacity`, `facilities`, `Verification`) VALUES
(1100100, '$2y$10$1zOfN488sIw.gsVZcCKA8OwsJaCSKAskZNxVQjudWYaV/izbeMwQC', 'BLOODBANK4', '1234567890', '01930679928', 'rashed298@yahoo.com', 'Khulna', 45, 'We have facilities', 'Verified'),
(1100134, '$2y$10$VTDaxD3YQ8lNiwZEwkw4xuvh3IOpMl4m6APq4woNNkSXfTzLQ9LOm', 'BLOODBANK1', '1234567890', '01912225776', 'BLOODBANK1@gmail.com', 'Bangladesh', 56, 'So much', 'Verified');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank_pass_reset_request`
--

CREATE TABLE `blood_bank_pass_reset_request` (
  `user_id` int(7) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Security_code` varchar(10) NOT NULL,
  `Contact` varchar(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Storage_capacity` int(5) NOT NULL,
  `Verification` enum('Not Verified','Verified') NOT NULL DEFAULT 'Not Verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank_pass_reset_request`
--

INSERT INTO `blood_bank_pass_reset_request` (`user_id`, `Name`, `Security_code`, `Contact`, `Email`, `Location`, `Storage_capacity`, `Verification`) VALUES
(1100100, 'BLOODBANK4', '1234567890', '01930679928', 'rashed298@yahoo.com', 'Khulna', 45, 'Not Verified');

-- --------------------------------------------------------

--
-- Table structure for table `blood_request_user`
--

CREATE TABLE `blood_request_user` (
  `Blood_Type` enum('AB+','AB-','A+','A-','B+','B-','O+','O-') NOT NULL,
  `User_ID` int(7) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `Preferred_Date` date NOT NULL,
  `Time` time NOT NULL,
  `Age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_request_user`
--

INSERT INTO `blood_request_user` (`Blood_Type`, `User_ID`, `Name`, `Location`, `Phone`, `Preferred_Date`, `Time`, `Age`) VALUES
('AB+', 2200100, 'noushin', 'Dhaka Bangladesh', '01536124142', '2023-11-29', '01:01:00', 23);

-- --------------------------------------------------------

--
-- Table structure for table `donor_information_table`
--

CREATE TABLE `donor_information_table` (
  `Blood_Type` varchar(5) NOT NULL,
  `User_ID` int(7) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Age` int(3) NOT NULL,
  `Last_Donation` int(4) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `UserType` varchar(10) NOT NULL,
  `E_mail` varchar(30) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `Health_Problem` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_information_table`
--

INSERT INTO `donor_information_table` (`Blood_Type`, `User_ID`, `Name`, `Age`, `Last_Donation`, `Location`, `UserType`, `E_mail`, `Phone`, `Health_Problem`) VALUES
('O+', 2200100, 'noushin', 23, 365, 'Dhaka Bangladesh', 'DONOR', 'noushin007@gmail.com', '01536124142', 'no health problem');

-- --------------------------------------------------------

--
-- Table structure for table `pass_req_wit_bbuid`
--

CREATE TABLE `pass_req_wit_bbuid` (
  `User_ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pass_req_wit_bbuid`
--

INSERT INTO `pass_req_wit_bbuid` (`User_ID`) VALUES
(1100100);

-- --------------------------------------------------------

--
-- Table structure for table `pass_req_wit_uid`
--

CREATE TABLE `pass_req_wit_uid` (
  `User_ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pass_req_wit_uid`
--

INSERT INTO `pass_req_wit_uid` (`User_ID`) VALUES
(2200100);

-- --------------------------------------------------------

--
-- Table structure for table `registered_user_info`
--

CREATE TABLE `registered_user_info` (
  `User_ID` int(7) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Age` int(3) NOT NULL,
  `Phone` varchar(11) DEFAULT NULL,
  `E_mail` varchar(30) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Last_Donation` int(4) NOT NULL,
  `UserType` enum('ACCEPTOR','DONOR') NOT NULL,
  `Preferred_Date` date NOT NULL,
  `Blood_Type` enum('AB+','AB-','A+','A-','B+','B-','O+','O-') DEFAULT NULL,
  `Health_Problem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user_info`
--

INSERT INTO `registered_user_info` (`User_ID`, `Name`, `Username`, `Password`, `Age`, `Phone`, `E_mail`, `Location`, `Last_Donation`, `UserType`, `Preferred_Date`, `Blood_Type`, `Health_Problem`) VALUES
(2200100, 'noushin', 'noushin007', '$2y$10$mtx1LegW3leZVj1w4jTTFuc91vUqE3d3bjmoHgEF5o397dxMDM/3G', 23, '01536124142', 'noushin007@gmail.com', 'Dhaka Bangladesh', 365, 'DONOR', '2023-01-07', 'O+', 'no health problem'),
(2200103, 'noushin', 'noushin0071', '$2y$10$Waj59HHmxq30P/NQ4nvGguljlQmyQu36YJkWN80ch533tpBxQHfuO', 23, '01536124142', 'noushin007@gmail.com', 'Dhaka Bangladesh', 365, 'DONOR', '2023-01-07', 'O+', 'no health problem'),
(2200104, 'noushin', 'noushin02', '$2y$10$Waj59HHmxq30P/NQ4nvGguljlQmyQu36YJkWN80ch533tpBxQHfuO', 23, '01536124142', 'noushin007@gmail.com', 'Dhaka Bangladesh', 365, 'DONOR', '2023-01-07', 'O+', 'no health problem'),
(2200105, 'noushin', 'noushin4', '$2y$10$Waj59HHmxq30P/NQ4nvGguljlQmyQu36YJkWN80ch533tpBxQHfuO', 23, '01536124142', 'noushin007@gmail.com', 'Dhaka Bangladesh', 365, 'DONOR', '2023-01-07', 'O+', 'no health problem');

-- --------------------------------------------------------

--
-- Table structure for table `user_pass_reset_request`
--

CREATE TABLE `user_pass_reset_request` (
  `User_ID` int(7) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `E_mail` varchar(30) NOT NULL,
  `Contact` varchar(11) NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `new_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_pass_reset_request`
--

INSERT INTO `user_pass_reset_request` (`User_ID`, `Username`, `Name`, `E_mail`, `Contact`, `UserType`, `new_password`) VALUES
(2200100, 'noushin007', 'noushin', 'noushin007@gmail.com', '01536124142', 'DONOR', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_own_info`
--
ALTER TABLE `admin_own_info`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `blood_bank_info`
--
ALTER TABLE `blood_bank_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `blood_bank_pass_reset_request`
--
ALTER TABLE `blood_bank_pass_reset_request`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `blood_request_user`
--
ALTER TABLE `blood_request_user`
  ADD KEY `blood_request_user_ibfk_1` (`User_ID`);

--
-- Indexes for table `donor_information_table`
--
ALTER TABLE `donor_information_table`
  ADD UNIQUE KEY `User_ID` (`User_ID`);

--
-- Indexes for table `pass_req_wit_bbuid`
--
ALTER TABLE `pass_req_wit_bbuid`
  ADD UNIQUE KEY `User_ID` (`User_ID`);

--
-- Indexes for table `pass_req_wit_uid`
--
ALTER TABLE `pass_req_wit_uid`
  ADD KEY `pass_req_wit_uid_ibfk_1` (`User_ID`);

--
-- Indexes for table `registered_user_info`
--
ALTER TABLE `registered_user_info`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_own_info`
--
ALTER TABLE `admin_own_info`
  MODIFY `Admin_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2013138;

--
-- AUTO_INCREMENT for table `blood_bank_info`
--
ALTER TABLE `blood_bank_info`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1100135;

--
-- AUTO_INCREMENT for table `registered_user_info`
--
ALTER TABLE `registered_user_info`
  MODIFY `User_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2200108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_bank_pass_reset_request`
--
ALTER TABLE `blood_bank_pass_reset_request`
  ADD CONSTRAINT `blood_bank_pass_reset_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `blood_bank_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blood_request_user`
--
ALTER TABLE `blood_request_user`
  ADD CONSTRAINT `blood_request_user_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `registered_user_info` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pass_req_wit_bbuid`
--
ALTER TABLE `pass_req_wit_bbuid`
  ADD CONSTRAINT `pass_req_wit_bbuid_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `blood_bank_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pass_req_wit_uid`
--
ALTER TABLE `pass_req_wit_uid`
  ADD CONSTRAINT `pass_req_wit_uid_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `registered_user_info` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
