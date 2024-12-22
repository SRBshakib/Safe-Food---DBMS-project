-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 03:40 PM
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
-- Database: `traceroots`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_t`
--

CREATE TABLE `delivery_t` (
  `shipmentID` int(11) NOT NULL,
  `shipment_date` datetime DEFAULT NULL,
  `pbatchID` int(11) DEFAULT NULL,
  `warehouseID` int(11) DEFAULT NULL,
  `transportID` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_t`
--

INSERT INTO `delivery_t` (`shipmentID`, `shipment_date`, `pbatchID`, `warehouseID`, `transportID`, `status`) VALUES
(2, '2024-12-16 17:10:40', 8, 2, 1, 'In-Stock'),
(3, '2024-12-16 19:17:48', 7, 1, 1, 'In-Stock'),
(4, '2024-12-16 19:17:51', 6, 1, 1, 'In-Stock'),
(5, '2024-12-16 19:18:05', 6, 1, 1, 'In-Stock'),
(6, '2024-12-16 19:43:40', 6, 1, 1, 'In-Stock'),
(7, '2024-12-16 19:49:22', 7, 1, 1, 'In-Stock'),
(8, '2024-12-16 19:49:46', 7, 1, 1, 'In-Stock'),
(9, '2024-12-19 07:58:41', 9, 2, 2, 'In-Stock'),
(10, '2024-12-19 08:01:10', 9, 2, 2, 'In-Stock'),
(11, '2024-12-19 08:01:18', 10, 2, 1, 'In-Stock'),
(12, '2024-12-19 08:39:16', 10, 2, 1, 'In-Stock'),
(13, '2024-12-19 08:39:30', 11, 2, 1, 'In-Stock'),
(14, '2024-12-19 08:43:07', 11, 2, 1, 'In-Stock'),
(15, '2024-12-19 08:43:11', 12, 2, 3, 'In-Stock'),
(16, '2024-12-19 12:05:35', 13, 2, 4, 'In-Stock'),
(17, '2024-12-19 12:51:42', 13, 2, 4, 'In-Stock'),
(18, '2024-12-19 14:24:19', 13, 2, 4, 'Received'),
(19, '2024-12-19 14:24:22', 14, 1, 1, 'In-Stock'),
(20, '2024-12-19 15:53:04', 15, 1, 1, 'Received'),
(21, '2024-12-20 17:11:06', 16, 1, 3, 'Received');

-- --------------------------------------------------------

--
-- Table structure for table `district_t`
--

CREATE TABLE `district_t` (
  `DistrictID` int(11) NOT NULL,
  `DistrictName` varchar(255) NOT NULL,
  `SubDistrictName` varchar(255) NOT NULL,
  `DivisionName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `district_t`
--

INSERT INTO `district_t` (`DistrictID`, `DistrictName`, `SubDistrictName`, `DivisionName`) VALUES
(1, 'Dhaka', 'Uttara', 'Dhaka'),
(2, 'Dhaka', 'Mirpur', 'Dhaka'),
(3, 'Faridpur', 'Faridpur Sadar', 'Dhaka'),
(4, 'Gazipur', 'Gazipur Sadar', 'Dhaka'),
(5, 'Gopalganj', 'Gopalganj Sadar', 'Dhaka'),
(6, 'Kishoreganj', 'Kishoreganj Sadar', 'Dhaka'),
(7, 'Madaripur', 'Madaripur Sadar', 'Dhaka'),
(8, 'Manikganj', 'Manikganj Sadar', 'Dhaka'),
(9, 'Munshiganj', 'Munshiganj Sadar', 'Dhaka'),
(10, 'Narayanganj', 'Narayanganj Sadar', 'Dhaka'),
(11, 'Narsingdi', 'Narsingdi Sadar', 'Dhaka'),
(12, 'Rajbari', 'Rajbari Sadar', 'Dhaka'),
(13, 'Shariatpur', 'Shariatpur Sadar', 'Dhaka'),
(14, 'Tangail', 'Tangail Sadar', 'Dhaka'),
(15, 'Chittagong', 'Chittagong Sadar', 'Chittagong'),
(16, 'Bandarban', 'Bandarban Sadar', 'Chittagong'),
(17, 'Coxs Bazar', 'Coxs Bazar Sadar', 'Chittagong'),
(18, 'Khagrachari', 'Khagrachari Sadar', 'Chittagong'),
(19, 'Lakshmipur', 'Lakshmipur Sadar', 'Chittagong'),
(20, 'Noakhali', 'Noakhali Sadar', 'Chittagong'),
(21, 'Chandpur', 'Chandpur Sadar', 'Chittagong'),
(22, 'Brahmanbaria', 'Brahmanbaria Sadar', 'Chittagong'),
(23, 'Comilla', 'Comilla Sadar', 'Chittagong'),
(24, 'Feni', 'Feni Sadar', 'Chittagong'),
(25, 'Rangamati', 'Rangamati Sadar', 'Chittagong'),
(26, 'Rajshahi', 'Rajshahi Sadar', 'Rajshahi'),
(27, 'Bogura', 'Bogura Sadar', 'Rajshahi'),
(28, 'Naogaon', 'Naogaon Sadar', 'Rajshahi'),
(29, 'Natore', 'Natore Sadar', 'Rajshahi'),
(30, 'Pabna', 'Pabna Sadar', 'Rajshahi'),
(31, 'Chapai Nawabganj', 'Chapai Nawabganj Sadar', 'Rajshahi'),
(32, 'Joypurhat', 'Joypurhat Sadar', 'Rajshahi'),
(33, 'Kurigram', 'Kurigram Sadar', 'Rajshahi'),
(34, 'Khulna', 'Khulna Sadar', 'Khulna'),
(35, 'Bagerhat', 'Bagerhat Sadar', 'Khulna'),
(36, 'Satkhira', 'Satkhira Sadar', 'Khulna'),
(37, 'Meherpur', 'Meherpur Sadar', 'Khulna'),
(38, 'Chuadanga', 'Chuadanga Sadar', 'Khulna'),
(39, 'Kusumgram', 'Kusumgram Sadar', 'Khulna'),
(40, 'Barisal', 'Barisal Sadar', 'Barisal'),
(41, 'Bhola', 'Bhola Sadar', 'Barisal'),
(42, 'Patuakhali', 'Patuakhali Sadar', 'Barisal'),
(43, 'Pirojpur', 'Pirojpur Sadar', 'Barisal'),
(44, 'Sylhet', 'Sylhet Sadar', 'Sylhet'),
(45, 'Moulvibazar', 'Moulvibazar Sadar', 'Sylhet'),
(46, 'Habiganj', 'Habiganj Sadar', 'Sylhet'),
(47, 'Kishoreganj', 'Kishoreganj Sadar', 'Sylhet'),
(48, 'Rangpur', 'Rangpur Sadar', 'Rangpur'),
(49, 'Kurigram', 'Kurigram Sadar', 'Rangpur'),
(50, 'Gaibandha', 'Gaibandha Sadar', 'Rangpur'),
(51, 'Dinajpur', 'Dinajpur Sadar', 'Rangpur'),
(52, 'Thakurgaon', 'Thakurgaon Sadar', 'Rangpur'),
(53, 'Mymensingh', 'Mymensingh Sadar', 'Mymensingh'),
(54, 'Jamalpur', 'Jamalpur Sadar', 'Mymensingh'),
(55, 'Netrokona', 'Netrokona Sadar', 'Mymensingh');

-- --------------------------------------------------------

--
-- Table structure for table `drivers_t`
--

CREATE TABLE `drivers_t` (
  `driverID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'accepted',
  `affiliation_date` date DEFAULT NULL,
  `driving_license_no` varchar(20) DEFAULT NULL,
  `contactNo` int(11) DEFAULT NULL,
  `sub_district` varchar(20) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `division` varchar(20) DEFAULT NULL,
  `dStatus` varchar(15) DEFAULT 'free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers_t`
--

INSERT INTO `drivers_t` (`driverID`, `firstname`, `lastname`, `gender`, `username`, `email`, `password`, `status`, `affiliation_date`, `driving_license_no`, `contactNo`, `sub_district`, `district`, `division`, `dStatus`) VALUES
(5002, 'Abul', 'Kamal', 'male', 'abul', 'abul123@gmail.com', '$2y$10$PUvz39sQ.elafMaH52JBnOrC3XRJkOqa7Ru47QUHJ.xYAXY6WgiBG', NULL, '2024-12-16', NULL, NULL, NULL, NULL, NULL, NULL),
(5003, 'Abul', 'kha', 'male', 'abulKhan', 'abulKhan@gmail.com', '$2y$10$CNUnshXjsVSkNKbkZeiwuejNESa4zS1PJ2plt5UvvqfPxMF4XnGba', NULL, '2024-12-16', NULL, NULL, 'Dinajpur Sadar', 'Dinajpur', 'Rangpur', NULL),
(5004, 'Sakku', 'Khan', 'male', 'sakku', 'sakku@gmail.com', '123', 'accepted', '2024-12-19', NULL, 1234789561, 'Golachipa', 'Patuakhali', 'Barishal', 'free'),
(5005, 'Ashik', 'Khan', 'male', 'asikh', 'asik@gmail.com', '123', 'accepted', '2024-12-19', NULL, 564454654, NULL, NULL, NULL, 'free');

-- --------------------------------------------------------

--
-- Table structure for table `farmers_t`
--

CREATE TABLE `farmers_t` (
  `farmerID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `affiliation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers_t`
--

INSERT INTO `farmers_t` (`farmerID`, `firstname`, `lastname`, `gender`, `username`, `email`, `password`, `status`, `affiliation_date`) VALUES
(1000, 'Abul', 'Khan', 'male', 'abul', 'abul@gmail.com', '12345678', 'accepted', '0000-00-00'),
(1001, 'Kamal', 'Islam', 'male', 'kamal', 'kamal@gmail.com', '12345678', 'accepted', '0000-00-00'),
(1002, 'Dip', 'Kundu', 'male', 'dip', 'dip@gmail.com', '123', 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `farm_t`
--

CREATE TABLE `farm_t` (
  `farmID` int(11) NOT NULL,
  `farmName` varchar(100) DEFAULT NULL,
  `farmerID` int(11) DEFAULT NULL,
  `sub_district` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `farm_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_t`
--

INSERT INTO `farm_t` (`farmID`, `farmName`, `farmerID`, `sub_district`, `district`, `division`, `email`, `contact_no`, `farm_type`) VALUES
(1, 'Fortune Agro', 1000, 'Dinajpur Sadar', 'Dinajpur', 'Rangpur', 'fortuneagro@gmail.com', 1732265448, 'Organic'),
(2, 'Dip Agro', 1002, 'Golacipa', 'Patuakhali', 'Barishal', 'dipagro@gmail.com', 1732265448, 'Organic');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_report_t`
--

CREATE TABLE `inspection_report_t` (
  `report_ID` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `productID` int(11) NOT NULL,
  `qcoID` int(11) NOT NULL,
  `shipmentID` int(11) NOT NULL,
  `wRating` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inspection_report_t`
--

INSERT INTO `inspection_report_t` (`report_ID`, `time`, `date`, `productID`, `qcoID`, `shipmentID`, `wRating`, `warehouseID`) VALUES
(2, '14:30:00', '2024-12-18', 1, 4000, 3, 5, 1),
(5, '10:56:07', '2024-12-18', 1, 4000, 3, 3, 1),
(7, '10:58:56', '2024-12-18', 1, 4000, 7, 3, 1),
(8, '11:08:06', '2024-12-18', 2, 4000, 6, 5, 1),
(9, '11:08:46', '2024-12-18', 2, 4000, 5, 5, 1),
(10, '11:09:27', '2024-12-18', 2, 4000, 2, 5, 2),
(11, '13:10:14', '2024-12-18', 1, 4000, 3, 3, 1),
(12, '13:10:30', '2024-12-19', 1, 4000, 11, 5, 2),
(13, '13:11:32', '2024-12-19', 2, 4000, 10, 5, 2),
(14, '13:12:23', '2024-12-19', 1, 4000, 7, 3, 1),
(15, '13:25:27', '2024-12-19', 2, 4000, 9, 5, 2),
(16, '13:36:58', '2024-12-19', 2, 4000, 9, 5, 2),
(17, '13:37:22', '2024-12-19', 2, 4000, 4, 5, 1),
(18, '13:38:16', '2024-12-19', 1, 4000, 8, 3, 1),
(19, '13:40:12', '2024-12-19', 1, 4000, 13, 5, 2),
(20, '13:43:51', '2024-12-19', 1, 4000, 15, 5, 2),
(21, '19:25:12', '2024-12-19', 1, 4000, 19, 5, 1),
(22, '20:27:24', '2024-12-19', 1, 4000, 16, 5, 2),
(23, '20:27:30', '2024-12-19', 1, 4000, 16, 5, 2),
(24, '20:27:47', '2024-12-19', 1, 4000, 17, 5, 2),
(25, '20:28:36', '2024-12-19', 1, 4000, 18, 5, 2),
(26, '20:30:03', '2024-12-19', 1, 4000, 18, 5, 2),
(27, '20:37:05', '2024-12-19', 1, 4000, 12, 5, 2),
(28, '20:37:25', '2024-12-19', 1, 4000, 12, 5, 2),
(29, '20:37:50', '2024-12-19', 1, 4000, 14, 5, 2),
(30, '20:52:02', '2024-12-19', 1, 4000, 14, 5, 2),
(31, '22:14:16', '2024-12-20', 1, 4000, 21, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lot_t`
--

CREATE TABLE `lot_t` (
  `lotID` int(11) NOT NULL,
  `production_date` date DEFAULT NULL,
  `harvest_area` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `farmID` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lot_t`
--

INSERT INTO `lot_t` (`lotID`, `production_date`, `harvest_area`, `weight`, `quantity`, `productID`, `farmID`, `product_type`, `status`) VALUES
(3, '0000-00-00', NULL, 0.00, 0, NULL, NULL, 'vegetable', 'processed'),
(4, '0000-00-00', NULL, 0.00, 0, NULL, NULL, 'vegetable', 'pending'),
(5, '2024-12-11', NULL, 30.00, 0, 1, 1, 'vegetable', 'processed'),
(6, '2024-12-11', NULL, 20.00, 0, 2, 1, 'vegetable', 'processed'),
(9, '2024-12-11', NULL, 20.00, 0, 2, 1, 'vegetable', 'processed'),
(10, '2024-12-11', NULL, 30.00, 0, 2, 1, 'vegetable', 'processed'),
(11, '2024-12-16', 'golachipa', 50.00, NULL, 2, 2, 'vegetable', 'processed'),
(16, '2024-12-19', NULL, 50.00, 0, 1, 2, 'vegetable', 'processed'),
(17, '2024-12-19', NULL, 50.00, 0, 2, 2, 'vegetable', 'processed'),
(18, '2024-12-19', NULL, 50.00, 0, 1, 2, 'vegetable', 'processed'),
(19, '2024-12-19', NULL, 50.00, 0, 1, 2, 'vegetable', 'processed'),
(20, '2024-12-19', NULL, 50.00, 0, 1, 2, 'vegetable', 'processed'),
(21, '2024-12-19', NULL, 60.00, 0, 1, 1, 'vegetable', 'processed'),
(22, '2024-12-19', NULL, 20.00, 0, 2, 1, 'vegetable', 'processed'),
(23, '2024-12-20', NULL, 50.00, 0, 1, 1, 'vegetable', 'processed');

-- --------------------------------------------------------

--
-- Table structure for table `pending_users_t`
--

CREATE TABLE `pending_users_t` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `affiliation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_users_t`
--

INSERT INTO `pending_users_t` (`ID`, `firstname`, `lastname`, `gender`, `username`, `category`, `email`, `password`, `status`, `affiliation_date`) VALUES
(1, 'Abul', 'Kamal', 'male', 'abul', 'driver', 'abul123@gmail.com', '$2y$10$PUvz39sQ.elafMaH52JBnOrC3XRJkOqa7Ru47QUHJ.xYAXY6WgiBG', 'accepted', '2024-12-16'),
(2, 'Abul', 'kha', 'male', 'abulKhan', 'driver', 'abulKhan@gmail.com', '$2y$10$CNUnshXjsVSkNKbkZeiwuejNESa4zS1PJ2plt5UvvqfPxMF4XnGba', 'accepted', '2024-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `processed_batch_t`
--

CREATE TABLE `processed_batch_t` (
  `pbatchID` int(11) NOT NULL,
  `processing_Date` datetime DEFAULT NULL,
  `Certification` varchar(100) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `lotID` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'processed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `processed_batch_t`
--

INSERT INTO `processed_batch_t` (`pbatchID`, `processing_Date`, `Certification`, `weight`, `quantity`, `rating`, `product_type`, `lotID`, `status`) VALUES
(1, '2024-12-10 00:00:00', 'Halal', 25.00, 0, 4.50, 'vegetable', 5, NULL),
(2, '2024-12-11 00:00:00', 'Halal', 20.00, 0, 4.00, 'vegetable', 9, NULL),
(3, '2024-12-13 00:00:00', 'Halal', 20.00, 0, 4.00, 'vegetable', 3, NULL),
(4, '2024-12-13 00:00:00', 'Halal', 30.00, 0, 5.00, 'vegetable', 10, NULL),
(5, '2024-12-13 00:00:00', 'Halal', 19.00, 0, 5.00, 'vegetable', 6, NULL),
(6, '2024-12-13 00:00:00', 'Halal', 20.00, 0, 5.00, 'vegetable', 9, 'In-Transit'),
(7, '2024-12-13 00:00:00', 'Halal', 10.00, 0, 3.00, 'vegetable', 5, 'In-Transit'),
(8, '2024-12-16 00:00:00', 'Halal', 45.00, 0, 5.00, 'vegetable', 11, 'In-Transit'),
(9, '2024-12-19 00:00:00', 'Halal', 45.00, 0, 5.00, 'vegetable', 17, 'In-Transit'),
(10, '2024-12-19 00:00:00', 'Halal', 50.00, 0, 5.00, 'vegetable', 18, 'In-Transit'),
(11, '2024-12-19 00:00:00', 'Halal', 50.00, 0, 5.00, 'vegetable', 19, 'In-Transit'),
(12, '2024-12-19 00:00:00', 'Halal', 50.00, 0, 5.00, 'vegetable', 20, 'In-Transit'),
(13, '2024-12-19 00:00:00', 'Halal', 50.00, 0, 5.00, 'vegetable', 16, 'In-Transit'),
(14, '2024-12-19 00:00:00', 'Halal', 60.00, 0, 5.00, 'vegetable', 21, 'In-Transit'),
(15, '2024-12-19 00:00:00', 'Halal', 20.00, 0, 5.00, 'vegetable', 22, 'In-Transit'),
(16, '2024-12-20 00:00:00', 'Halal', 50.00, 0, 5.00, 'vegetable', 23, 'In-Transit');

-- --------------------------------------------------------

--
-- Table structure for table `processing_unit_t`
--
-- Error reading structure for table traceroots.processing_unit_t: #1932 - Table &#039;traceroots.processing_unit_t&#039; doesn&#039;t exist in engine
-- Error reading data for table traceroots.processing_unit_t: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `traceroots`.`processing_unit_t`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `product_t`
--

CREATE TABLE `product_t` (
  `productID` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `shelf_life` int(11) DEFAULT NULL,
  `temp` varchar(20) DEFAULT NULL,
  `humidity` varchar(20) DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_t`
--

INSERT INTO `product_t` (`productID`, `product_name`, `shelf_life`, `temp`, `humidity`, `mrp`, `product_type`) VALUES
(1, 'potato', 60, '30', '20', 75.00, 'vegetable'),
(2, 'tomato', 7, '30', '20', 150.00, 'vegetable');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_t`
--

CREATE TABLE `purchase_order_t` (
  `orderID` int(11) NOT NULL,
  `retailerID` int(11) DEFAULT NULL,
  `warehouseID` int(11) DEFAULT NULL,
  `weight` int(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `productID` int(11) DEFAULT NULL,
  `pbatchID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order_t`
--

INSERT INTO `purchase_order_t` (`orderID`, `retailerID`, `warehouseID`, `weight`, `quantity`, `order_date`, `order_time`, `status`, `productID`, `pbatchID`) VALUES
(8, 6000, 1, 20, 0, '2024-12-18', '18:59:34', 'Received', 1, NULL),
(9, 6000, 2, 20, 0, '2024-12-18', '18:59:34', 'Received', 1, NULL),
(10, 6000, 1, 20, 0, '2024-12-18', '19:13:16', 'Received', 1, NULL),
(11, 6000, 2, 20, 0, '2024-12-18', '19:13:17', 'Pending', 1, NULL),
(12, 6000, 1, 20, 0, '2024-12-18', '19:13:52', 'Received', 1, NULL),
(13, 6000, 2, 20, 0, '2024-12-18', '19:13:52', 'Pending', 1, NULL),
(14, 6000, 1, 30, 0, '2024-12-18', '19:14:17', 'Received', 1, NULL),
(15, 6000, 2, 2, 0, '2024-12-18', '19:14:17', 'Pending', 1, NULL),
(16, 6000, 1, 30, 0, '2024-12-18', '19:33:23', 'Received', 1, NULL),
(17, 6000, 2, 2, 0, '2024-12-18', '19:33:23', 'Pending', 1, NULL),
(18, 6000, 1, 30, 0, '2024-12-18', '19:37:57', 'Pending', 1, NULL),
(19, 6000, 2, 2, 0, '2024-12-18', '19:37:57', 'Pending', 1, NULL),
(21, 6000, 1, 20, 0, '2024-12-18', '19:54:47', 'Pending', 2, NULL),
(23, 6000, 1, 20, 0, '2024-12-18', '20:00:35', 'Pending', 2, NULL),
(33, 6000, 1, 5, 0, '2024-12-18', '20:35:55', 'Pending', 2, NULL),
(34, 6000, 1, 5, 0, '2024-12-18', '20:37:16', 'Pending', 1, NULL),
(35, 6000, 1, 5, 0, '2024-12-18', '20:37:16', 'Pending', 2, NULL),
(36, 6000, 2, 40, 0, '2024-12-18', '23:57:29', 'Picked up', 2, NULL),
(37, 6000, 2, 40, 0, '2024-12-18', '23:59:25', 'Picked up', 2, NULL),
(38, 6000, 2, 40, 0, '2024-12-19', '00:01:10', 'Received', 2, NULL),
(39, 6000, 2, 100, 0, '2024-12-19', '08:44:30', 'Received', 1, NULL),
(40, 6000, 2, 50, 0, '2024-12-19', '16:44:03', 'Pending', NULL, 10),
(41, 6000, 2, 50, 0, '2024-12-19', '17:01:34', 'Pending', NULL, 10),
(42, 6000, 2, 10, 0, '2024-12-19', '17:02:42', 'Pending', NULL, 10),
(43, 6000, 2, 10, 0, '2024-12-19', '17:03:32', 'Pending', NULL, 10),
(44, 6000, 1, 60, 0, '2024-12-19', '17:03:52', 'Received', NULL, 14),
(46, 6000, 1, 60, 0, '2024-12-19', '17:36:52', 'Ready', NULL, 14),
(47, 6000, 1, 50, 0, '2024-12-19', '17:37:46', 'Received', NULL, 14),
(48, 6000, 1, 50, 0, '2024-12-20', '12:09:32', 'Received', NULL, 14),
(49, 6000, 1, 50, 0, '2024-12-20', '12:11:01', 'Pending', NULL, 14),
(50, 6000, 1, 50, 0, '2024-12-20', '12:12:12', 'Pending', NULL, 14),
(51, 6000, 2, 50, 0, '2024-12-20', '12:22:56', 'Received', NULL, 10),
(52, 6000, 1, 20, 0, '2024-12-20', '12:24:20', 'Received', NULL, 15),
(53, 6000, 1, 40, 0, '2024-12-20', '17:13:32', 'Pending', NULL, 16);

-- --------------------------------------------------------

--
-- Table structure for table `quality_control_officers_t`
--

CREATE TABLE `quality_control_officers_t` (
  `qcoID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quality_control_officers_t`
--

INSERT INTO `quality_control_officers_t` (`qcoID`, `firstname`, `lastname`, `gender`, `username`, `email`, `password`) VALUES
(4000, 'Rifat', 'Khan', 'male', 'rifat', 'rifat@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `quality_report_t`
--

CREATE TABLE `quality_report_t` (
  `QreportID` int(11) NOT NULL,
  `retailer_ID` int(11) DEFAULT NULL,
  `shop_ID` int(11) NOT NULL,
  `time` datetime DEFAULT NULL,
  `qcoID` int(11) DEFAULT NULL,
  `Inspection_result` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retailers_t`
--

CREATE TABLE `retailers_t` (
  `retailerID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `affiliation_date` date DEFAULT NULL,
  `trade_license_no` varchar(20) DEFAULT NULL,
  `contactNO` int(11) DEFAULT NULL,
  `sub_district` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `division` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `retailers_t`
--

INSERT INTO `retailers_t` (`retailerID`, `firstname`, `lastname`, `gender`, `username`, `email`, `password`, `status`, `affiliation_date`, `trade_license_no`, `contactNO`, `sub_district`, `district`, `division`) VALUES
(6000, 'Manowar', 'Zaman', 'male', 'mano', 'malto@gmail.com', '123', 'pending', NULL, '214311456465313', 1234579867, 'Dinajpur Sadar', 'Dinajpur', 'Rangpur');

-- --------------------------------------------------------

--
-- Table structure for table `retailer_inventory_t`
--

CREATE TABLE `retailer_inventory_t` (
  `retailerID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `retailer_inventory_t`
--

INSERT INTO `retailer_inventory_t` (`retailerID`, `productID`, `weight`, `quantity`, `last_updated`) VALUES
(6000, 1, 450, 0, '2024-12-20 16:16:36'),
(6000, 2, 60, 0, '2024-12-20 11:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `sales_t`
--

CREATE TABLE `sales_t` (
  `saleID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `shopID` int(11) NOT NULL,
  `category` varchar(25) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_t`
--

CREATE TABLE `shop_t` (
  `shopID` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `Humidity_level` int(11) DEFAULT NULL,
  `retailer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_t`
--

CREATE TABLE `transport_t` (
  `transportID` int(11) NOT NULL,
  `transport_storage_temp` int(11) DEFAULT NULL,
  `Vehicle_reg_no` varchar(20) DEFAULT NULL,
  `driverID` int(11) DEFAULT NULL,
  `Transport_capacity` int(11) DEFAULT NULL,
  `Humidity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_t`
--

INSERT INTO `transport_t` (`transportID`, `transport_storage_temp`, `Vehicle_reg_no`, `driverID`, `Transport_capacity`, `Humidity`) VALUES
(1, 5, 'NA1205664', 5003, 1500, 90),
(2, 5, 'NA1111314521', 5002, 30, 90),
(3, 5, 'NA4321314231', 5004, 10, 95),
(4, 5, 'NA7795464', 5005, 50, 90);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_inventory_t`
--

CREATE TABLE `warehouse_inventory_t` (
  `warehouseID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse_inventory_t`
--

INSERT INTO `warehouse_inventory_t` (`warehouseID`, `productID`, `weight`, `quantity`) VALUES
(1, 1, 310, 0),
(2, 1, 200, 0),
(1, 2, 720, 0),
(2, 2, 445, 0);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_managers_t`
--

CREATE TABLE `warehouse_managers_t` (
  `managerID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `affiliation_date` date DEFAULT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse_managers_t`
--

INSERT INTO `warehouse_managers_t` (`managerID`, `firstname`, `lastname`, `gender`, `username`, `email`, `password`, `status`, `affiliation_date`, `phone`) VALUES
(1, 'Aram', 'Islam', 'male', 'arman', 'arman1@gmail.com', '123', 'active', NULL, 2147483647),
(2, 'Rakibul ', 'Hasan', NULL, 'rakibul', 'rakibul@gmail.com', '123', 'active', NULL, 1732235416);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_t`
--

CREATE TABLE `warehouse_t` (
  `warehouseID` int(11) NOT NULL,
  `Sub_district` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `storage_capacity` decimal(10,2) DEFAULT NULL,
  `Humidity_level` int(11) DEFAULT NULL,
  `Temperature` int(11) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `managerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse_t`
--

INSERT INTO `warehouse_t` (`warehouseID`, `Sub_district`, `district`, `division`, `storage_capacity`, `Humidity_level`, `Temperature`, `phone`, `email`, `managerID`) VALUES
(1, 'Dinajpur Sadar', 'Dinajpur', 'Rangpur', 1500.00, 95, 5, 1345789631, NULL, 1),
(2, 'Golacipa', 'Patuakhali', 'Barishal', 10000.00, 95, 5, 1749822422, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `w_inventory_t`
--

CREATE TABLE `w_inventory_t` (
  `warehouseID` int(11) NOT NULL,
  `pbatchID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_inventory_t`
--

INSERT INTO `w_inventory_t` (`warehouseID`, `pbatchID`, `productID`, `weight`, `quantity`) VALUES
(1, 14, 1, 0, 0),
(1, 15, 2, 0, 0),
(1, 16, 1, 10, 0),
(2, 10, 1, 0, 0),
(2, 11, 1, 50, 0),
(2, 13, 1, 50, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_t`
--
ALTER TABLE `delivery_t`
  ADD PRIMARY KEY (`shipmentID`),
  ADD KEY `pbatchID` (`pbatchID`),
  ADD KEY `transportID` (`transportID`),
  ADD KEY `warehouseID` (`warehouseID`);

--
-- Indexes for table `district_t`
--
ALTER TABLE `district_t`
  ADD PRIMARY KEY (`DistrictID`);

--
-- Indexes for table `drivers_t`
--
ALTER TABLE `drivers_t`
  ADD PRIMARY KEY (`driverID`);

--
-- Indexes for table `farmers_t`
--
ALTER TABLE `farmers_t`
  ADD PRIMARY KEY (`farmerID`);

--
-- Indexes for table `farm_t`
--
ALTER TABLE `farm_t`
  ADD PRIMARY KEY (`farmID`),
  ADD KEY `farmerID` (`farmerID`);

--
-- Indexes for table `inspection_report_t`
--
ALTER TABLE `inspection_report_t`
  ADD PRIMARY KEY (`report_ID`),
  ADD KEY `fk_product` (`productID`),
  ADD KEY `fk_qco` (`qcoID`),
  ADD KEY `fk_shipment` (`shipmentID`),
  ADD KEY `fk_warehouse` (`warehouseID`);

--
-- Indexes for table `lot_t`
--
ALTER TABLE `lot_t`
  ADD PRIMARY KEY (`lotID`),
  ADD KEY `farmID` (`farmID`),
  ADD KEY `productID` (`productID`) USING BTREE;

--
-- Indexes for table `pending_users_t`
--
ALTER TABLE `pending_users_t`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `processed_batch_t`
--
ALTER TABLE `processed_batch_t`
  ADD PRIMARY KEY (`pbatchID`),
  ADD KEY `lotID` (`lotID`);

--
-- Indexes for table `product_t`
--
ALTER TABLE `product_t`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `purchase_order_t`
--
ALTER TABLE `purchase_order_t`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `retailerID` (`retailerID`),
  ADD KEY `warehouseID` (`warehouseID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `pbatchID` (`pbatchID`);

--
-- Indexes for table `quality_control_officers_t`
--
ALTER TABLE `quality_control_officers_t`
  ADD PRIMARY KEY (`qcoID`);

--
-- Indexes for table `quality_report_t`
--
ALTER TABLE `quality_report_t`
  ADD PRIMARY KEY (`QreportID`),
  ADD UNIQUE KEY `shop_ID_5` (`shop_ID`),
  ADD KEY `retailer_ID` (`retailer_ID`),
  ADD KEY `qcoID` (`qcoID`);

--
-- Indexes for table `retailers_t`
--
ALTER TABLE `retailers_t`
  ADD PRIMARY KEY (`retailerID`);

--
-- Indexes for table `retailer_inventory_t`
--
ALTER TABLE `retailer_inventory_t`
  ADD PRIMARY KEY (`retailerID`,`productID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `sales_t`
--
ALTER TABLE `sales_t`
  ADD PRIMARY KEY (`saleID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `shopID` (`shopID`);

--
-- Indexes for table `shop_t`
--
ALTER TABLE `shop_t`
  ADD PRIMARY KEY (`shopID`) USING BTREE,
  ADD KEY `retailer_ID` (`retailer_ID`);

--
-- Indexes for table `transport_t`
--
ALTER TABLE `transport_t`
  ADD PRIMARY KEY (`transportID`),
  ADD KEY `driverID` (`driverID`);

--
-- Indexes for table `warehouse_inventory_t`
--
ALTER TABLE `warehouse_inventory_t`
  ADD KEY `warehouseID` (`warehouseID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `warehouse_managers_t`
--
ALTER TABLE `warehouse_managers_t`
  ADD PRIMARY KEY (`managerID`);

--
-- Indexes for table `warehouse_t`
--
ALTER TABLE `warehouse_t`
  ADD PRIMARY KEY (`warehouseID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `w_inventory_t`
--
ALTER TABLE `w_inventory_t`
  ADD PRIMARY KEY (`warehouseID`,`pbatchID`),
  ADD KEY `pbatchID` (`pbatchID`),
  ADD KEY `productID` (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_t`
--
ALTER TABLE `delivery_t`
  MODIFY `shipmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `district_t`
--
ALTER TABLE `district_t`
  MODIFY `DistrictID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `drivers_t`
--
ALTER TABLE `drivers_t`
  MODIFY `driverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5006;

--
-- AUTO_INCREMENT for table `farmers_t`
--
ALTER TABLE `farmers_t`
  MODIFY `farmerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `farm_t`
--
ALTER TABLE `farm_t`
  MODIFY `farmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inspection_report_t`
--
ALTER TABLE `inspection_report_t`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lot_t`
--
ALTER TABLE `lot_t`
  MODIFY `lotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pending_users_t`
--
ALTER TABLE `pending_users_t`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `processed_batch_t`
--
ALTER TABLE `processed_batch_t`
  MODIFY `pbatchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_t`
--
ALTER TABLE `product_t`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_order_t`
--
ALTER TABLE `purchase_order_t`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `quality_control_officers_t`
--
ALTER TABLE `quality_control_officers_t`
  MODIFY `qcoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4001;

--
-- AUTO_INCREMENT for table `quality_report_t`
--
ALTER TABLE `quality_report_t`
  MODIFY `QreportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retailers_t`
--
ALTER TABLE `retailers_t`
  MODIFY `retailerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6001;

--
-- AUTO_INCREMENT for table `sales_t`
--
ALTER TABLE `sales_t`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_t`
--
ALTER TABLE `shop_t`
  MODIFY `shopID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_t`
--
ALTER TABLE `transport_t`
  MODIFY `transportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `warehouse_managers_t`
--
ALTER TABLE `warehouse_managers_t`
  MODIFY `managerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5000;

--
-- AUTO_INCREMENT for table `warehouse_t`
--
ALTER TABLE `warehouse_t`
  MODIFY `warehouseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_t`
--
ALTER TABLE `delivery_t`
  ADD CONSTRAINT `delivery_t_ibfk_1` FOREIGN KEY (`pbatchID`) REFERENCES `processed_batch_t` (`pbatchID`),
  ADD CONSTRAINT `delivery_t_ibfk_2` FOREIGN KEY (`transportID`) REFERENCES `transport_t` (`transportID`),
  ADD CONSTRAINT `delivery_t_ibfk_3` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`),
  ADD CONSTRAINT `delivery_t_ibfk_4` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`);

--
-- Constraints for table `farm_t`
--
ALTER TABLE `farm_t`
  ADD CONSTRAINT `farm_t_ibfk_1` FOREIGN KEY (`farmerID`) REFERENCES `farmers_t` (`farmerID`);

--
-- Constraints for table `inspection_report_t`
--
ALTER TABLE `inspection_report_t`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_qco` FOREIGN KEY (`qcoID`) REFERENCES `quality_control_officers_t` (`qcoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_shipment` FOREIGN KEY (`shipmentID`) REFERENCES `delivery_t` (`shipmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_warehouse` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lot_t`
--
ALTER TABLE `lot_t`
  ADD CONSTRAINT `lot_t_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`),
  ADD CONSTRAINT `lot_t_ibfk_2` FOREIGN KEY (`farmID`) REFERENCES `farm_t` (`farmID`);

--
-- Constraints for table `processed_batch_t`
--
ALTER TABLE `processed_batch_t`
  ADD CONSTRAINT `lotID` FOREIGN KEY (`lotID`) REFERENCES `lot_t` (`lotID`);

--
-- Constraints for table `purchase_order_t`
--
ALTER TABLE `purchase_order_t`
  ADD CONSTRAINT `purchase_order_t_ibfk_1` FOREIGN KEY (`retailerID`) REFERENCES `retailers_t` (`retailerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_t_ibfk_2` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_t_ibfk_3` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`),
  ADD CONSTRAINT `purchase_order_t_ibfk_4` FOREIGN KEY (`pbatchID`) REFERENCES `processed_batch_t` (`pbatchID`);

--
-- Constraints for table `quality_report_t`
--
ALTER TABLE `quality_report_t`
  ADD CONSTRAINT `quality_report_t_ibfk_1` FOREIGN KEY (`retailer_ID`) REFERENCES `retailers_t` (`retailerID`),
  ADD CONSTRAINT `quality_report_t_ibfk_2` FOREIGN KEY (`shop_ID`) REFERENCES `shop_t` (`shopID`),
  ADD CONSTRAINT `quality_report_t_ibfk_3` FOREIGN KEY (`qcoID`) REFERENCES `quality_control_officers_t` (`qcoID`),
  ADD CONSTRAINT `quality_report_t_ibfk_4` FOREIGN KEY (`qcoID`) REFERENCES `quality_control_officers_t` (`qcoID`);

--
-- Constraints for table `retailer_inventory_t`
--
ALTER TABLE `retailer_inventory_t`
  ADD CONSTRAINT `retailer_inventory_t_ibfk_1` FOREIGN KEY (`retailerID`) REFERENCES `retailers_t` (`retailerID`),
  ADD CONSTRAINT `retailer_inventory_t_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`);

--
-- Constraints for table `sales_t`
--
ALTER TABLE `sales_t`
  ADD CONSTRAINT `sales_t_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`),
  ADD CONSTRAINT `sales_t_ibfk_2` FOREIGN KEY (`shopID`) REFERENCES `shop_t` (`shopID`);

--
-- Constraints for table `shop_t`
--
ALTER TABLE `shop_t`
  ADD CONSTRAINT `shop_t_ibfk_1` FOREIGN KEY (`retailer_ID`) REFERENCES `retailers_t` (`retailerID`);

--
-- Constraints for table `transport_t`
--
ALTER TABLE `transport_t`
  ADD CONSTRAINT `transport_t_ibfk_1` FOREIGN KEY (`driverID`) REFERENCES `drivers_t` (`driverID`);

--
-- Constraints for table `warehouse_inventory_t`
--
ALTER TABLE `warehouse_inventory_t`
  ADD CONSTRAINT `warehouse_inventory_t_ibfk_1` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`),
  ADD CONSTRAINT `warehouse_inventory_t_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`);

--
-- Constraints for table `warehouse_t`
--
ALTER TABLE `warehouse_t`
  ADD CONSTRAINT `warehouse_t_ibfk_1` FOREIGN KEY (`managerID`) REFERENCES `warehouse_managers_t` (`managerID`);

--
-- Constraints for table `w_inventory_t`
--
ALTER TABLE `w_inventory_t`
  ADD CONSTRAINT `w_inventory_t_ibfk_1` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse_t` (`warehouseID`),
  ADD CONSTRAINT `w_inventory_t_ibfk_2` FOREIGN KEY (`pbatchID`) REFERENCES `processed_batch_t` (`pbatchID`),
  ADD CONSTRAINT `w_inventory_t_ibfk_3` FOREIGN KEY (`productID`) REFERENCES `product_t` (`productID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
