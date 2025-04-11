-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 07:34 PM
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
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(1, 'admin', 'Test@12345', '04-03-2024 11:42:05 AM');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `doctorSpecialization` varchar(255) DEFAULT NULL,
  `doctorId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `consultancyFees` int(11) DEFAULT NULL,
  `appointmentDate` varchar(255) DEFAULT NULL,
  `appointmentTime` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `userStatus` int(11) DEFAULT NULL,
  `doctorStatus` int(11) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `doctorSpecialization`, `doctorId`, `userId`, `consultancyFees`, `appointmentDate`, `appointmentTime`, `postingDate`, `userStatus`, `doctorStatus`, `updationDate`) VALUES
(3, 'HIV Test', 10, 1, 0, '2024-11-13', '10:00 AM', '2024-11-16 13:42:56', 1, 1, NULL),
(4, 'Fasting Blood Sugar ', 12, 1, 0, '2024-11-28', '2:00 PM', '2024-11-16 15:52:35', 1, 1, NULL),
(5, 'Direct Sputum Smear Microscopy', 11, 1, 0, '2024-11-25', '1:00 PM', '2024-11-16 15:53:04', 1, 1, NULL),
(6, 'Dental', 0, 1, 0, '2024-11-29', '11:00 PM', '2024-11-29 16:53:29', 1, 1, NULL),
(7, 'Dengue Test', 0, 1, 0, '2024-11-27', '12:00 AM', '2024-11-29 16:54:51', 1, 1, NULL),
(8, 'Dental', 14, 11, 0, '2024-11-27', '2:00 PM', '2024-11-30 06:38:34', 1, 1, NULL),
(9, 'Dental', 14, 14, 0, '2024-11-28', '2:45 PM', '2024-11-30 06:40:08', 1, 1, NULL),
(10, 'Dental', 14, 1, 0, '2024-11-29', '3:00 PM', '2024-11-30 06:45:45', 0, 1, '2024-11-30 06:47:43'),
(11, 'Dental', 14, 4, 0, '2025-04-30', '12:30 PM', '2025-04-02 04:21:06', 1, 1, NULL),
(12, 'Direct Sputum Smear Microscopy', 11, 4, 0, '2025-04-02', '12:15 PM', '2025-04-02 05:12:29', 1, 0, '2025-04-02 05:35:39'),
(13, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-02', '12:45 PM', '2025-04-02 05:36:39', 0, 1, '2025-04-11 15:05:57'),
(14, 'Direct Sputum Smear Microscopy', 11, 6, 0, '2025-04-05', '1:45 PM', '2025-04-03 05:40:37', 1, 1, NULL),
(15, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-16', '3:00 PM', '2025-04-03 06:49:01', 0, 1, '2025-04-11 15:05:59'),
(16, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-20', '11:15 PM', '2025-04-11 15:06:51', 1, 1, NULL),
(17, 'Direct Sputum Smear Microscopy', 11, 7, 0, '2025-04-21', '11:15 PM', '2025-04-11 15:09:28', 1, 1, NULL),
(18, 'Direct Sputum Smear Microscopy', 11, 7, 0, '2025-04-22', '11:15 PM', '2025-04-11 15:10:13', 1, 1, NULL),
(19, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-30', '11:15 PM', '2025-04-11 15:12:19', 1, 1, NULL),
(20, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-28', '1:30 AM', '2025-04-11 17:18:34', 1, 1, NULL),
(21, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-27', '1:35 AM', '2025-04-11 17:19:26', 1, 1, NULL),
(22, 'Direct Sputum Smear Microscopy', 11, 5, 0, '2025-04-15', '1:30 AM', '2025-04-11 17:23:21', 1, 1, NULL),
(23, 'Direct Sputum Smear Microscopy', 11, 5, NULL, '2025-04-14', '1:30 AM', '2025-04-11 17:24:17', 1, 1, NULL),
(24, 'Direct Sputum Smear Microscopy', 11, 5, NULL, '2025-04-13', '1:30 AM', '2025-04-11 17:25:17', 1, 1, NULL),
(25, 'Direct Sputum Smear Microscopy', 11, 5, NULL, '2025-04-16', '1:30 AM', '2025-04-11 17:28:02', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dental_lab_form`
--

CREATE TABLE `dental_lab_form` (
  `id` int(11) NOT NULL,
  `labName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `patientId` varchar(50) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Female','Male','Other') NOT NULL,
  `contactNumber` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `patientAddress` varchar(255) NOT NULL,
  `dentistName` varchar(255) NOT NULL,
  `dentistContact` varchar(50) NOT NULL,
  `previousProcedures` text DEFAULT NULL,
  `existingProsthetics` varchar(255) DEFAULT NULL,
  `knownAllergies` varchar(255) DEFAULT NULL,
  `medicalConditions` text DEFAULT NULL,
  `prostheticWork` varchar(255) DEFAULT NULL,
  `materials` varchar(255) DEFAULT NULL,
  `teethImpression` varchar(255) DEFAULT NULL,
  `shadeGuide` varchar(255) DEFAULT NULL,
  `customShade` enum('Yes','No') DEFAULT NULL,
  `shadeInstructions` text DEFAULT NULL,
  `otherServices` varchar(255) DEFAULT NULL,
  `urgency` enum('Standard','Rush') NOT NULL,
  `dentistNotes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_lab_form`
--

INSERT INTO `dental_lab_form` (`id`, `labName`, `address`, `phone`, `date`, `patientId`, `fullName`, `dob`, `age`, `gender`, `contactNumber`, `email`, `patientAddress`, `dentistName`, `dentistContact`, `previousProcedures`, `existingProsthetics`, `knownAllergies`, `medicalConditions`, `prostheticWork`, `materials`, `teethImpression`, `shadeGuide`, `customShade`, `shadeInstructions`, `otherServices`, `urgency`, `dentistNotes`, `created_at`) VALUES
(1, 'Dental Litex 1', '123 Commonwealth Q.C', '09123456789', '2025-04-04', '32512', 'Sarah Dela Cruz 1', '2005-01-04', 19, 'Female', '09124123', 'sarah@gmail.com', '124 Payatas Q.C', 'Yuno Mariz', '091241252', 'Nothing', 'Bridges', 'None', 'Heart issue', 'Complete Denture', '123', 'Upper Impression', 'shade1', 'Yes', 'spec1', 'Teeth Whitening Trays', 'Standard', 'Nothing', '2025-04-04 05:57:07'),
(4, 'hehe', '123 Commonwealth Q.C', '0123456789', '2025-04-04', '32512', 'Princess Ann', '2025-04-04', 2, 'Female', '09312472367', 'sarah@gmail.com', '234 calocaan', 'Manny Pakyu', '09234124', 'egsdg', 'Bridges', 'None', 'wetw', 'Crown', 'mat123', 'Lower Impression', 'ewt', 'No', 'erter', 'Orthodontic Appliances', 'Standard', 'wetewt', '2025-04-04 06:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `doctorName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `docFees` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `docEmail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `specilization`, `doctorName`, `address`, `docFees`, `contactno`, `docEmail`, `password`, `creationDate`, `updationDate`) VALUES
(11, 'Direct Sputum Smear Microscopy', 'Cristel Ann Lapinoso', 'Bagong Silang, Caloocan City', '', 95547812456, 'cristelann@email.com', '25d55ad283aa400af464c76d713c07ad', '2024-11-16 14:01:46', '2024-11-29 17:26:48'),
(12, 'Fasting Blood Sugar ', 'John Erick Bustillo', 'Fairview, QC', '', 9887547541, 'erickbustillo@email.com', '25d55ad283aa400af464c76d713c07ad', '2024-11-16 15:43:40', NULL),
(13, 'Dengue Test', 'Chester', 'Bagong Silang, Caloocan City', '', 9918328693, 'chester@gmail.com', '228bbc2f87caeb21bb7f6949fddcb91d', '2024-11-30 00:43:53', NULL),
(14, 'Dental', 'Dr. Gangat', 'SJDM, Bulacan', '', 9123123764, 'docgangat@email.com', '25d55ad283aa400af464c76d713c07ad', '2024-11-30 06:37:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctorslog`
--

CREATE TABLE `doctorslog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorslog`
--

INSERT INTO `doctorslog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(5, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-16 15:49:35', '16-11-2024 09:21:37 PM', 1),
(6, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-16 15:53:28', NULL, 1),
(7, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-27 02:35:06', NULL, 0),
(8, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-27 02:35:13', '27-11-2024 08:06:58 AM', 1),
(9, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-27 02:56:13', NULL, 1),
(10, NULL, 'cristelann@12345678', 0x3a3a3100000000000000000000000000, '2024-11-29 16:57:29', NULL, 0),
(11, NULL, 'cristelann@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-29 16:58:00', NULL, 0),
(12, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-29 17:24:51', NULL, 0),
(13, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-29 17:26:10', NULL, 0),
(14, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-29 17:27:12', NULL, 1),
(15, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 00:40:15', '30-11-2024 06:11:59 AM', 1),
(16, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:32:30', NULL, 1),
(17, NULL, 'docgangat@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:38:55', NULL, 0),
(18, 14, 'docgangat@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:39:13', NULL, 1),
(19, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:43:38', NULL, 1),
(20, 14, 'docgangat@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:44:57', NULL, 1),
(21, 14, 'docgangat@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:46:05', NULL, 1),
(22, 14, 'docgangat@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:47:51', NULL, 1),
(23, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:49:33', NULL, 1),
(24, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2025-04-02 04:21:43', NULL, 0),
(25, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 04:24:45', NULL, 1),
(26, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:31:07', '02-04-2025 11:01:54 AM', 1),
(27, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:32:04', NULL, 1),
(28, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:33:29', NULL, 1),
(29, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:34:25', '02-04-2025 11:04:31 AM', 1),
(30, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:35:35', '02-04-2025 11:05:47 AM', 1),
(31, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:36:57', '02-04-2025 11:07:13 AM', 1),
(32, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2025-04-02 05:42:34', NULL, 0),
(33, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2025-04-02 05:43:12', NULL, 0),
(34, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2025-04-02 05:43:35', NULL, 0),
(35, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:46:11', '02-04-2025 11:28:47 AM', 1),
(36, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:00:22', '02-04-2025 11:33:29 AM', 1),
(37, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:05:19', '02-04-2025 11:40:17 AM', 1),
(38, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:12:36', '02-04-2025 11:43:23 AM', 1),
(39, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:15:15', NULL, 1),
(40, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:25:21', '02-04-2025 11:59:21 AM', 1),
(41, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:29:29', '02-04-2025 12:58:19 PM', 1),
(42, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-03 05:39:39', '03-04-2025 11:11:10 AM', 1),
(43, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-03 05:43:38', '03-04-2025 12:18:22 PM', 1),
(44, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-04 03:03:54', '04-04-2025 08:34:14 AM', 1),
(45, 11, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2025-04-11 14:41:52', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctorspecilization`
--

CREATE TABLE `doctorspecilization` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `room` varchar(255) NOT NULL DEFAULT 'Room 0',
  `max_patients` int(255) NOT NULL DEFAULT 10,
  `avail_slots` int(255) NOT NULL DEFAULT 10,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorspecilization`
--

INSERT INTO `doctorspecilization` (`id`, `specilization`, `room`, `max_patients`, `avail_slots`, `open_time`, `close_time`, `creationDate`, `updationDate`) VALUES
(18, 'Direct Sputum Smear Microscopy', '1', 15, 8, '08:00:00', '17:00:00', '2024-11-16 08:54:42', '2025-04-11 17:28:02'),
(19, 'Dengue Test', '2', 10, 0, '08:00:00', '17:00:00', '2024-11-16 08:55:01', '2025-04-11 16:15:12'),
(20, 'HIV Test', '3', 10, 5, '08:00:00', '17:00:00', '2024-11-16 08:55:27', '2025-04-11 16:11:22'),
(21, 'Dental', '4', 10, 10, '08:00:00', '17:00:00', '2024-11-16 08:55:36', '2025-04-11 16:11:29'),
(22, 'Fasting Blood Sugar ', '5', 10, 10, '08:00:00', '15:00:00', '2024-11-16 15:42:22', '2025-04-11 15:27:31'),
(23, 'Medical Checkup', '6', 10, 10, '08:00:00', '15:00:00', '2025-04-02 06:44:14', '2025-04-11 16:11:34'),
(24, 'Prenatal', '7', 10, 10, '08:00:00', '15:00:00', '2025-04-02 06:44:14', '2025-04-11 16:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `patient_ques`
--

CREATE TABLE `patient_ques` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL DEFAULT 'Medical Checkup',
  `room` varchar(255) NOT NULL,
  `queue_number` int(11) NOT NULL,
  `queue_date` date NOT NULL,
  `status` enum('Waiting','Consulting','Completed','Cancelled') DEFAULT 'Waiting',
  `priority` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_ques`
--

INSERT INTO `patient_ques` (`id`, `lastname`, `firstname`, `middlename`, `service`, `room`, `queue_number`, `queue_date`, `status`, `priority`, `created_at`) VALUES
(20, 'Rimbang', 'Khadafi', 'Minalang', 'Medical Checkup', '6', 13, '2025-04-08', 'Completed', 0, '2025-04-08 14:13:51'),
(21, 'Cena', 'John', 'Mendez', 'HIV Test', '3', 14, '2025-04-08', 'Consulting', 0, '2025-04-08 14:34:56'),
(22, 'Dela Cruz', 'Princess Ann', 'Quirino', 'Prenatal', '7', 15, '2025-04-08', 'Consulting', 0, '2025-04-08 14:57:08'),
(25, 'Cruz', 'Princess', 'Henz', 'Dengue Test', '2', 18, '2025-04-11', 'Waiting', 0, '2025-04-11 14:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_lab_form`
--

CREATE TABLE `prenatal_lab_form` (
  `id` int(11) NOT NULL,
  `labName` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `patientId` varchar(50) DEFAULT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Female','Male','Other') DEFAULT NULL,
  `contactNumber` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `patientAddress` varchar(255) DEFAULT NULL,
  `obgynName` varchar(255) DEFAULT NULL,
  `obgynContact` varchar(255) DEFAULT NULL,
  `lmp` date DEFAULT NULL,
  `edd` date DEFAULT NULL,
  `gravida` int(11) DEFAULT NULL,
  `para` int(11) DEFAULT NULL,
  `previousPregnancies` varchar(255) DEFAULT NULL,
  `previousComplications` varchar(255) DEFAULT NULL,
  `bloodTests` text DEFAULT NULL,
  `urineTests` text DEFAULT NULL,
  `diseaseScreening` text DEFAULT NULL,
  `geneticScreening` text DEFAULT NULL,
  `ultrasound` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `physicianNotes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_lab_form`
--

INSERT INTO `prenatal_lab_form` (`id`, `labName`, `address`, `phone`, `date`, `patientId`, `fullName`, `dob`, `age`, `gender`, `contactNumber`, `email`, `patientAddress`, `obgynName`, `obgynContact`, `lmp`, `edd`, `gravida`, `para`, `previousPregnancies`, `previousComplications`, `bloodTests`, `urineTests`, `diseaseScreening`, `geneticScreening`, `ultrasound`, `notes`, `physicianNotes`) VALUES
(3, 'Prenatal Test', '4234 Prenetal address', '091241274', '2025-04-04', '43514', 'Sarah Dela Cruz', '2005-01-03', 20, 'Female', '09124123', 'sarah@gmail.com', '13423 hqowhqw', 'HDoaus', '09324322', '2025-02-06', '2025-04-25', 2, 3, 'None123', 'None321', 'CBC', 'Others', 'GBS', 'Carrier', 'NTScan', 'Wala po', 'Wala'),
(5, 'Prenatal Name', '234 rdqsq', '09324376', '2025-04-04', '23432', 'Alexa Dumo', '2005-01-05', 20, 'Female', '091236124', 'alexa@gmail.com', '123 Ihiqwqwr', 'HSIduq', '09324723', '2025-03-20', '2025-05-27', 5, 6, 'None', 'None', 'Others', 'Urinalysis', 'Others', 'Others', 'FetalUltrasound', 'None', 'Testlang po1'),
(7, 'Prenatal Litex', '123 Litex Q.C', '12345', '2025-04-04', '231312', 'Princess Ann', '2001-01-11', 24, 'Female', '09312472367', 'qpal@gmail.com', '124 Payatas Q.C', 'Anna Mendoza', '09235233', '2025-03-26', '2025-06-18', 2, 5, 'None', 'None', 'Others, Test1', 'Urinalysis', 'Chlamydia', 'Trisomy', 'NTScan', 'None', 'All goods');

-- --------------------------------------------------------

--
-- Table structure for table `queue_tb`
--

CREATE TABLE `queue_tb` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `service` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactus`
--

CREATE TABLE `tblcontactus` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(12) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `LastupdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `IsRead` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicalhistory`
--

CREATE TABLE `tblmedicalhistory` (
  `ID` int(10) NOT NULL,
  `PatientID` int(10) DEFAULT NULL,
  `BloodPressure` varchar(200) DEFAULT NULL,
  `BloodSugar` varchar(200) NOT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `Temperature` varchar(200) DEFAULT NULL,
  `MedicalPres` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmedicalhistory`
--

INSERT INTO `tblmedicalhistory` (`ID`, `PatientID`, `BloodPressure`, `BloodSugar`, `Weight`, `Temperature`, `MedicalPres`, `CreationDate`) VALUES
(1, 2, '80/120', '110', '85', '97', 'Dolo,\r\nLevocit 5mg', '2024-05-16 09:07:16'),
(2, 3, '124', '324', '44', '43', 'Test', '2025-04-02 06:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT current_timestamp(),
  `OpenningTime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `OpenningTime`) VALUES
(1, 'aboutus', 'About Us', '<ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 1.313em; margin-left: 1.655em;\" times=\"\" new=\"\" roman\";=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" center;=\"\" background-color:=\"\" rgb(255,=\"\" 246,=\"\" 246);\"=\"\"><li style=\"text-align: left;\"><br></li></ul>', NULL, NULL, '2020-05-20 07:21:52', NULL),
(2, 'contactus', 'Contact Details', '<i>Barangay. Holy Spirit, Quezon City. Metro Manila</i>', 'holyspirithealthcare@gmail.com', 968547548, '2020-05-20 07:24:07', '9 am To 8 Pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient`
--

CREATE TABLE `tblpatient` (
  `ID` int(10) NOT NULL,
  `Docid` int(10) DEFAULT NULL,
  `PatientLastname` varchar(200) DEFAULT NULL,
  `PatientFirstname` varchar(255) NOT NULL,
  `PatientMiddlename` varchar(255) NOT NULL,
  `PatientContno` bigint(10) DEFAULT NULL,
  `PatientEmail` varchar(200) DEFAULT NULL,
  `PatientGender` varchar(50) DEFAULT NULL,
  `PatientAdd` mediumtext DEFAULT NULL,
  `PatientAge` int(10) DEFAULT NULL,
  `PatientMedhis` mediumtext DEFAULT NULL,
  `service` varchar(255) NOT NULL DEFAULT 'Medical Checkup',
  `room` int(255) NOT NULL DEFAULT 0,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpatient`
--

INSERT INTO `tblpatient` (`ID`, `Docid`, `PatientLastname`, `PatientFirstname`, `PatientMiddlename`, `PatientContno`, `PatientEmail`, `PatientGender`, `PatientAdd`, `PatientAge`, `PatientMedhis`, `service`, `room`, `CreationDate`, `UpdationDate`) VALUES
(18, 11, 'Rimbang', 'Khadafi', 'Minalang', 912345678, 'rimbang@gmail.com', 'male', '123 Payatas Q.C', 25, 'None', 'Medical Checkup', 0, '2025-04-08 14:13:51', NULL),
(19, 11, 'Cena', 'John', 'Mendez', 998765432, 'cena@gmail.com', 'male', '123 Payatas Q.C', 25, 'None', 'HIV Test', 0, '2025-04-08 14:34:56', NULL),
(20, 11, 'Dela Cruz', 'Princess Ann', 'Quirino', 912345678, 'cruz@gmail.com', 'female', '123 Commonwealth Q.C', 21, 'None', 'Prenatal', 0, '2025-04-08 14:57:08', NULL),
(23, 1, 'Cruz', 'Princess', 'Henz', 912345678, 'cruz1@gmail.com', 'female', '123 Payatas Q.C', 25, 'None', 'Dengue Test', 2, '2025-04-11 14:55:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(8, 3, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-16 08:13:11', NULL, 1),
(9, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-16 13:40:39', '16-11-2024 07:11:10 PM', 1),
(10, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-16 13:42:36', '16-11-2024 07:13:00 PM', 1),
(11, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-16 14:02:22', NULL, 1),
(12, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-16 15:51:49', NULL, 1),
(13, NULL, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-27 02:37:12', NULL, 0),
(14, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-27 02:37:19', '27-11-2024 08:26:00 AM', 1),
(15, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-29 16:52:46', '29-11-2024 10:25:04 PM', 1),
(16, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 00:34:51', NULL, 0),
(17, NULL, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 00:36:34', NULL, 0),
(18, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 00:37:17', NULL, 1),
(19, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 00:37:58', '30-11-2024 06:10:09 AM', 1),
(20, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:31:58', NULL, 1),
(21, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:43:22', NULL, 0),
(22, NULL, 'cristelann@email.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:43:26', NULL, 0),
(23, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:45:16', NULL, 1),
(24, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:47:23', NULL, 1),
(25, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:49:22', NULL, 1),
(26, 1, 'vincentmelowork@gmail.com', 0x3a3a3100000000000000000000000000, '2024-11-30 06:54:24', NULL, 1),
(27, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 04:20:42', '02-04-2025 09:51:10 AM', 1),
(28, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 04:27:37', NULL, 1),
(29, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:33:07', NULL, 1),
(30, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:33:46', NULL, 1),
(31, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:34:41', '02-04-2025 11:05:25 AM', 1),
(32, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:35:54', '02-04-2025 11:06:07 AM', 1),
(33, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:36:12', '02-04-2025 11:06:21 AM', 1),
(34, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:36:25', '02-04-2025 11:06:43 AM', 1),
(35, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 05:59:03', '02-04-2025 11:30:14 AM', 1),
(36, NULL, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:03:34', NULL, 0),
(37, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:03:39', '02-04-2025 11:34:43 AM', 1),
(38, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:10:22', '02-04-2025 11:42:29 AM', 1),
(39, 4, 'khadafirimbang7@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-02 06:13:33', '02-04-2025 11:45:03 AM', 1),
(40, 6, 'qpal@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-03 05:40:17', '03-04-2025 11:10:57 AM', 1),
(41, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-03 06:48:40', NULL, 1),
(42, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-04 03:03:19', '04-04-2025 08:33:44 AM', 1),
(43, NULL, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:05:39', NULL, 0),
(44, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:05:46', '11-04-2025 08:37:02 PM', 1),
(45, NULL, 'khadafi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:07:14', NULL, 0),
(46, NULL, 'rimbang@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:07:33', NULL, 0),
(47, 7, 'rimbang@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:08:07', '11-04-2025 08:41:01 PM', 1),
(48, 5, 'santiago@gmail.com', 0x3a3a3100000000000000000000000000, '2025-04-11 15:11:08', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `address`, `city`, `gender`, `email`, `password`, `regDate`, `updationDate`) VALUES
(1, 'Vincent Melo', 'Kelsey Hills Bulacan', 'SJDM', 'male', 'vincentmelowork@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2024-11-16 08:12:40', '2024-11-16 08:18:00'),
(4, 'Khadafi M. Rimbang', '040 Aloe Vera St. Payatas', 'Quezon City', 'male', 'khadafirimbang7@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-04-02 04:20:24', NULL),
(5, 'Felipe Santiago', '124 asdwq', 'Quezon City', 'male', 'santiago@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-04-02 05:32:56', NULL),
(6, 'Sarah Qpal', '24 weruwe', 'Quezon City', 'female', 'qpal@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-04-03 05:40:04', NULL),
(7, 'Khadafi Minalang Rimbang', '123 Payatas', 'Quezon City', 'male', 'rimbang@gmail.com', '4297f44b13955235245b2497399d7a93', '2025-04-11 15:07:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dental_lab_form`
--
ALTER TABLE `dental_lab_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorslog`
--
ALTER TABLE `doctorslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_ques`
--
ALTER TABLE `patient_ques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prenatal_lab_form`
--
ALTER TABLE `prenatal_lab_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_tb`
--
ALTER TABLE `queue_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `dental_lab_form`
--
ALTER TABLE `dental_lab_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `doctorslog`
--
ALTER TABLE `doctorslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `patient_ques`
--
ALTER TABLE `patient_ques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `prenatal_lab_form`
--
ALTER TABLE `prenatal_lab_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `queue_tb`
--
ALTER TABLE `queue_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
