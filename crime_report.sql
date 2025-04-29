-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 12:17 PM
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
-- Database: `crime_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_complaints`
--

CREATE TABLE `add_complaints` (
  `ID` int(11) NOT NULL,
  `Complainant_Description` varchar(200) DEFAULT NULL,
  `Date_time` varchar(200) DEFAULT NULL,
  `Type_of_Crime` varchar(200) DEFAULT NULL,
  `Location_of_Incident` varchar(200) DEFAULT NULL,
  `Suspected_Perpetrator` varchar(200) DEFAULT NULL,
  `Police_Station` varchar(200) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Gender` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Station_id` varchar(200) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `UserId` varchar(200) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `Complete_Status` varchar(200) DEFAULT NULL,
  `Date` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_complaints`
--

INSERT INTO `add_complaints` (`ID`, `Complainant_Description`, `Date_time`, `Type_of_Crime`, `Location_of_Incident`, `Suspected_Perpetrator`, `Police_Station`, `Name`, `Gender`, `Email`, `Address`, `Station_id`, `Status`, `UserId`, `district`, `Complete_Status`, `Date`) VALUES
(15, 'i have lost my mobile', '2025-06-10T14:06', 'Theft', 'mt', 'NERA SHOP', 'abc', 'bike', 'Male', 'abi@gmail.com', 'KLs', '3', '1', '4', NULL, '0', '2025-04-28'),
(16, 'helpmate lost', '2025-04-25 14:04:00', 'Theft', 'KL', 'no Perpetrator', 'idukii police', 'not know', 'Male', 'no@gmail.com', 'MTM', '4', '1', '5', NULL, '0', '2025-04-28'),
(19, 'dfssssssssss', '2025-04-10 17:27:00', 'Assault', 'ygty7ug', 'yg', 'kannu police', 'ytg', NULL, 'ft@hghy', 'fty', '2', '1', '6', 'Kannur', '1', '2025-04-28'),
(20, 'hgyugy', '2025-04-18 17:57:00', 'Assault', 'jhgy', 'yugyu', 'kannu police', 'gyu', NULL, 'gyug@gkjnhjbj', 'uyg', '2', '0', '6', 'Kannur', '0', '2025-04-28'),
(21, 'ygyuf', '2025-04-26 22:00:00', 'Assault', 'yutyuf', 'uy', 'kannu police', 'fuy', 'Male', 'gfty@yugu', 'iuhuy', '2', '0', '6', 'Kannur', '0', '2025-04-28'),
(22, 'aaa', '2025-04-10 22:23:00', 'Theft', 'bb', 'cc', 'kannu police', 'aa', 'Female', 'aa@gmail.com', 'aa', '2', '0', '6', 'Kannur', '0', '2025-04-28'),
(23, 'AA', '2025-04-25 09:49:00', NULL, 'AA', 'AA', 'kannu police', 'aa', 'Male', 'aa@gmail.com', 'MYL', '2', '0', '6', 'Kannur', '0', '2025-04-29'),
(24, 'bads', '2025-04-22T10:45', 'Assault', 'Kl', 'NONE', 'tvm', 'i cant see', 'Male', 'cat@gmail.com', 'MTM', '5', '1', '8', 'Thiruvananthapuram', '0', '2025-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `case_evidence`
--

CREATE TABLE `case_evidence` (
  `Id` int(11) NOT NULL,
  `case_Id` varchar(200) DEFAULT NULL,
  `Title` varchar(400) DEFAULT NULL,
  `Files` varchar(400) DEFAULT NULL,
  `Time_stamp` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_evidence`
--

INSERT INTO `case_evidence` (`Id`, `case_Id`, `Title`, `Files`, `Time_stamp`) VALUES
(1, '15', 'yes', 'uploads/1745517090_images (11).jpg', NULL),
(2, '15', 'done', 'uploads/1745554834_download (11).jpg', '2025-04-25 06:20:34'),
(3, '15', 'aa', 'uploads/1745820245_unnamed (7).png', '2025-04-28 08:04:05'),
(4, '15', 'done', 'uploads/1745839684_download (11).jpg', '2025-04-28 13:28:04'),
(5, '19', 'YES', 'uploads/1745855192_download (11).jpg', '2025-04-28 17:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `citizen`
--

CREATE TABLE `citizen` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `DOB` varchar(100) DEFAULT NULL,
  `District` varchar(200) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `Aadhar` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen`
--

INSERT INTO `citizen` (`Id`, `Name`, `Contact`, `Gender`, `DOB`, `District`, `Address`, `Aadhar`) VALUES
(1, 'abi', '1236547896', '1', '2025-04-22', 'Kasargod', 'Kl', '45789651452'),
(4, 'mob', '09876543212', 'Female', '', 'Kannur', 'KL', '87654398765431'),
(5, 'roopika', '45789654121', 'Female', '', 'Idukki', 'KLS', '54789654124578'),
(6, 'test', '1234567890', 'Male', '2024-05-16', 'Alappuzha', 'KL', '12345678909876'),
(7, 'aaaa', '1111111111', 'Female', '2025-04-25', '', 'kl', '11111111111111'),
(8, 'testt', '1234567890', 'Male', '', 'Thiruvananthapuram', 'Kl', '12345678909876');

-- --------------------------------------------------------

--
-- Table structure for table `completed_crime`
--

CREATE TABLE `completed_crime` (
  `Id` int(11) NOT NULL,
  `cmId` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `proof` varchar(200) DEFAULT NULL,
  `Date` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_crime`
--

INSERT INTO `completed_crime` (`Id`, `cmId`, `title`, `description`, `proof`, `Date`) VALUES
(1, '19', 'completed', 'yes', '../uploads/unnamed (7).png', '2025-04-28'),
(2, '19', 'yes2', 'Complete 2', '../uploads/download (11).jpg', '2025-04-28'),
(3, '19', 'test', 'testdesc', '../uploads/CV.png', '2025-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `evidance_report`
--

CREATE TABLE `evidance_report` (
  `ID` int(11) NOT NULL,
  `Pid` varchar(200) DEFAULT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `Document` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evidance_report`
--

INSERT INTO `evidance_report` (`ID`, `Pid`, `Title`, `Document`) VALUES
(12, '15', 'mobile was lost', '../uploads/1745488189_images11.jpg'),
(13, '16', 'heee', '../uploads/1745570182_cyber-freight-trucks.jpg'),
(14, '17', 'YYYY', '../uploads/1745841259_download (11).jpg'),
(15, '18', 'tfy', '../uploads/1745841383_download (11).jpg'),
(16, '19', 'fy', '../uploads/1745841487_download (11).jpg'),
(17, '20', 'yu', '../uploads/1745843290_download (11).jpg'),
(18, '21', 'yug', '../uploads/1745857842_download (11).jpg'),
(19, '22', 'jjjjj', '../uploads/1745859244_download (10).jpg'),
(20, '23', 'll', '../uploads/1745900425_video-file.png'),
(21, '24', 'kkk', '../uploads/1745903781_1.png');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Id` int(11) NOT NULL,
  `PId` varchar(100) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `Usertype` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Id`, `PId`, `Email`, `Password`, `Status`, `Usertype`) VALUES
(1, '1', 'abi@gmail.com', '$2y$10$0OifbbasSaWhHGvopGRBQOtiwgeUN3YEGyrh2a9YY2ZJu7QAltwgy', 'active', 'Citizen'),
(4, '4', 'mob@gmail.com', '$2y$10$MCaSewBy6FlQOPRAEox55uefXx21sZ3iiqkZkSLoe.g0mTYoHaNZa', 'active', 'Citizen'),
(6, '2', 'kan@gmail.com', '$2y$10$kEsSaIc1DiCL.Yyw54aHceSZPwBEVlh6atElcjTNuWISp3bZp9HIa', 'active', 'Police_officer'),
(7, '3', 'abc@gmail.com', '$2y$10$kEsSaIc1DiCL.Yyw54aHceSZPwBEVlh6atElcjTNuWISp3bZp9HIa', 'active', 'Police_officer'),
(8, '4', 'iduki@gmail.com', '$2y$10$kEsSaIc1DiCL.Yyw54aHceSZPwBEVlh6atElcjTNuWISp3bZp9HIa', 'active', 'Police_officer'),
(9, '5', 'roop@gmail.com', '$2y$10$RaOzxSGP3u8Tjzt8PTi4reh6iDWgPSYwHVnEnFm3b4lEtmMuqMInO', 'active', 'Citizen'),
(10, '6', 'test@gmail.com', '$2y$10$nLOnWLcj/3oXurk1b1r7K.zjs9lDjf32saKUouxxcRG5kZWTeTFDq', 'active', 'Citizen'),
(11, '7', 'aa@gmail.com', '$2y$10$RXEUFWyecZA9xbYKiavar.MbB8z6PC/dN0fz7h7EStBGiiQjFivLG', 'active', 'Citizen'),
(12, '5', 'tvm@gmail.com', '$2y$10$kEsSaIc1DiCL.Yyw54aHceSZPwBEVlh6atElcjTNuWISp3bZp9HIa', 'active', 'Police_officer'),
(13, NULL, 'admin@crime.com', 'admin123', 'active', 'ADMIN'),
(14, '8', 'tets1@gmail.com', '$2y$10$MCaSewBy6FlQOPRAEox55uefXx21sZ3iiqkZkSLoe.g0mTYoHaNZa', 'active', 'Citizen'),
(15, '6', 'za@gmail.com', '$2y$10$kEsSaIc1DiCL.Yyw54aHceSZPwBEVlh6atElcjTNuWISp3bZp9HIa', 'active', 'Police_officer');

-- --------------------------------------------------------

--
-- Table structure for table `stationregistration`
--

CREATE TABLE `stationregistration` (
  `ID` int(11) NOT NULL,
  `District` varchar(100) DEFAULT NULL,
  `Registration_number` varchar(100) DEFAULT NULL,
  `Station_code` varchar(50) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Contact` varchar(200) DEFAULT NULL,
  `Station_incharge_name` varchar(200) DEFAULT NULL,
  `Station_incharge_contact` varchar(200) DEFAULT NULL,
  `Station_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stationregistration`
--

INSERT INTO `stationregistration` (`ID`, `District`, `Registration_number`, `Station_code`, `Address`, `Contact`, `Station_incharge_name`, `Station_incharge_contact`, `Station_name`) VALUES
(2, 'Kannur', 'ABC132', '098ZX', 'KL', '09876543211', 'kannur', '123456789011', 'kannu police'),
(3, 'Thiruvananthapuram', 'KJGBG87', 'LMK', 'kerla', '21456987451', 'ABi', '25478965412', 'abc'),
(4, 'Idukki', 'BFF8676', 'KHGFB987', 'Kl', '09876543132', 'idukii', '54789654145', 'idukii police'),
(5, 'Thiruvananthapuram', 'HKl', 'HHH', 'tvm', '12345678901', 'tvm', '1234567890', 'tvm'),
(6, 'Kollam', 'aaaaaaa', 'aaaaa', 'aaaaaaaaa', '1234567890', 'aaaaa', 'aaaaaa', 'aaaaaaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_complaints`
--
ALTER TABLE `add_complaints`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `case_evidence`
--
ALTER TABLE `case_evidence`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `citizen`
--
ALTER TABLE `citizen`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `completed_crime`
--
ALTER TABLE `completed_crime`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `evidance_report`
--
ALTER TABLE `evidance_report`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `stationregistration`
--
ALTER TABLE `stationregistration`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_complaints`
--
ALTER TABLE `add_complaints`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `case_evidence`
--
ALTER TABLE `case_evidence`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `citizen`
--
ALTER TABLE `citizen`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `completed_crime`
--
ALTER TABLE `completed_crime`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evidance_report`
--
ALTER TABLE `evidance_report`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stationregistration`
--
ALTER TABLE `stationregistration`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
