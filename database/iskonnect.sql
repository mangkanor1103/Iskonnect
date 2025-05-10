-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 02:44 PM
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
-- Database: `iskonnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `full_name`, `email`, `message`, `created_at`) VALUES
(1, 'sunnygkp10@gmail.com', 'kianr664@gmail.com', 'dd', '2025-05-10 14:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `scholarship_type` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `course_yr` varchar(50) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `residence_type` varchar(50) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `existing_scholarship` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_pwd` varchar(5) DEFAULT NULL,
  `disability_type` varchar(100) DEFAULT NULL,
  `parent_status` varchar(50) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_age` int(3) DEFAULT NULL,
  `father_address` varchar(255) DEFAULT NULL,
  `father_tel` varchar(50) DEFAULT NULL,
  `father_mobile` varchar(50) DEFAULT NULL,
  `father_email` varchar(100) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `father_company` varchar(100) DEFAULT NULL,
  `father_income` decimal(10,2) DEFAULT NULL,
  `father_years_service` int(3) DEFAULT NULL,
  `father_education` varchar(100) DEFAULT NULL,
  `father_school` varchar(100) DEFAULT NULL,
  `father_unemployment_reason` text DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_age` int(3) DEFAULT NULL,
  `mother_address` varchar(255) DEFAULT NULL,
  `mother_tel` varchar(50) DEFAULT NULL,
  `mother_mobile` varchar(50) DEFAULT NULL,
  `mother_email` varchar(100) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `mother_company` varchar(100) DEFAULT NULL,
  `mother_income` decimal(10,2) DEFAULT NULL,
  `mother_years_service` int(3) DEFAULT NULL,
  `mother_education` varchar(100) DEFAULT NULL,
  `mother_school` varchar(100) DEFAULT NULL,
  `mother_unemployment_reason` text DEFAULT NULL,
  `working_siblings` int(3) DEFAULT NULL,
  `studying_siblings` int(3) DEFAULT NULL,
  `total_siblings` int(3) DEFAULT NULL,
  `house_rental` decimal(10,2) DEFAULT NULL,
  `food_grocery` decimal(10,2) DEFAULT NULL,
  `car_loan` decimal(10,2) DEFAULT NULL,
  `other_loan` decimal(10,2) DEFAULT NULL,
  `school_bus` decimal(10,2) DEFAULT NULL,
  `transportation` decimal(10,2) DEFAULT NULL,
  `education_plan` decimal(10,2) DEFAULT NULL,
  `insurance_policy` decimal(10,2) DEFAULT NULL,
  `health_insurance` decimal(10,2) DEFAULT NULL,
  `govt_loans` decimal(10,2) DEFAULT NULL,
  `clothing` decimal(10,2) DEFAULT NULL,
  `utilities` decimal(10,2) DEFAULT NULL,
  `communication` decimal(10,2) DEFAULT NULL,
  `helper_count` int(3) DEFAULT NULL,
  `helper_expense` decimal(10,2) DEFAULT NULL,
  `driver_count` int(3) DEFAULT NULL,
  `driver_expense` decimal(10,2) DEFAULT NULL,
  `medicines` decimal(10,2) DEFAULT NULL,
  `doctors_fee` decimal(10,2) DEFAULT NULL,
  `hospitalization` decimal(10,2) DEFAULT NULL,
  `recreation` decimal(10,2) DEFAULT NULL,
  `other_monthly_expenses` decimal(10,2) DEFAULT NULL,
  `total_monthly_expenses` decimal(10,2) DEFAULT NULL,
  `annual_monthly_expenses` decimal(10,2) DEFAULT NULL,
  `tuition` decimal(10,2) DEFAULT NULL,
  `withholding_tax` decimal(10,2) DEFAULT NULL,
  `govt_contributions` decimal(10,2) DEFAULT NULL,
  `other_annual_expenses` decimal(10,2) DEFAULT NULL,
  `annual_expenses_subtotal` decimal(10,2) DEFAULT NULL,
  `total_annual_expenses` decimal(10,2) DEFAULT NULL,
  `parents_annual_pay` decimal(10,2) DEFAULT NULL,
  `siblings_annual_pay` decimal(10,2) DEFAULT NULL,
  `business_income` decimal(10,2) DEFAULT NULL,
  `land_rental_income` decimal(10,2) DEFAULT NULL,
  `property_rental_income` decimal(10,2) DEFAULT NULL,
  `pension_income` decimal(10,2) DEFAULT NULL,
  `commission_income` decimal(10,2) DEFAULT NULL,
  `relative_support` decimal(10,2) DEFAULT NULL,
  `bank_deposits` decimal(10,2) DEFAULT NULL,
  `other_income` decimal(10,2) DEFAULT NULL,
  `total_annual_income` decimal(10,2) DEFAULT NULL,
  `secondary_school` varchar(100) DEFAULT NULL,
  `school_location` varchar(100) DEFAULT NULL,
  `year_graduated` varchar(20) DEFAULT NULL,
  `general_average` varchar(20) DEFAULT NULL,
  `honors_awards` text DEFAULT NULL,
  `reference1_name` varchar(100) DEFAULT NULL,
  `reference1_relationship` varchar(50) DEFAULT NULL,
  `reference1_contact` varchar(50) DEFAULT NULL,
  `reference2_name` varchar(100) DEFAULT NULL,
  `reference2_relationship` varchar(50) DEFAULT NULL,
  `reference2_contact` varchar(50) DEFAULT NULL,
  `req_photo` tinyint(1) DEFAULT 0,
  `req_itr` tinyint(1) DEFAULT 0,
  `req_ofw` tinyint(1) DEFAULT 0,
  `req_grades` tinyint(1) DEFAULT 0,
  `req_moral` tinyint(1) DEFAULT 0,
  `req_letter` tinyint(1) DEFAULT 0,
  `req_schedule` tinyint(1) DEFAULT 0,
  `office_received` varchar(100) DEFAULT NULL,
  `office_screened` varchar(100) DEFAULT NULL,
  `office_remarks` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `scholarship_type`, `last_name`, `first_name`, `middle_name`, `course_yr`, `civil_status`, `photo`, `gender`, `date_of_birth`, `place_of_birth`, `student_id`, `address`, `residence_type`, `guardian_name`, `telephone`, `religion`, `existing_scholarship`, `mobile`, `email`, `is_pwd`, `disability_type`, `parent_status`, `father_name`, `father_age`, `father_address`, `father_tel`, `father_mobile`, `father_email`, `father_occupation`, `father_company`, `father_income`, `father_years_service`, `father_education`, `father_school`, `father_unemployment_reason`, `mother_name`, `mother_age`, `mother_address`, `mother_tel`, `mother_mobile`, `mother_email`, `mother_occupation`, `mother_company`, `mother_income`, `mother_years_service`, `mother_education`, `mother_school`, `mother_unemployment_reason`, `working_siblings`, `studying_siblings`, `total_siblings`, `house_rental`, `food_grocery`, `car_loan`, `other_loan`, `school_bus`, `transportation`, `education_plan`, `insurance_policy`, `health_insurance`, `govt_loans`, `clothing`, `utilities`, `communication`, `helper_count`, `helper_expense`, `driver_count`, `driver_expense`, `medicines`, `doctors_fee`, `hospitalization`, `recreation`, `other_monthly_expenses`, `total_monthly_expenses`, `annual_monthly_expenses`, `tuition`, `withholding_tax`, `govt_contributions`, `other_annual_expenses`, `annual_expenses_subtotal`, `total_annual_expenses`, `parents_annual_pay`, `siblings_annual_pay`, `business_income`, `land_rental_income`, `property_rental_income`, `pension_income`, `commission_income`, `relative_support`, `bank_deposits`, `other_income`, `total_annual_income`, `secondary_school`, `school_location`, `year_graduated`, `general_average`, `honors_awards`, `reference1_name`, `reference1_relationship`, `reference1_contact`, `reference2_name`, `reference2_relationship`, `reference2_contact`, `req_photo`, `req_itr`, `req_ofw`, `req_grades`, `req_moral`, `req_letter`, `req_schedule`, `office_received`, `office_screened`, `office_remarks`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Financial Assistantship', 'Santos', 'Maria', 'Cruz', 'BSIT 3', 'Single', NULL, 'Female', '2001-05-15', 'Manila', '2019-0001', '123 Rizal St., Makati City', 'Renting', 'Juan Santos', '02-8123-4567', 'Roman Catholic', NULL, '0917-1234-567', 'maria.santos@example.com', 'No', NULL, 'Married', 'Juan Santos', 45, NULL, NULL, NULL, NULL, 'Driver', NULL, 15000.00, NULL, NULL, NULL, NULL, 'Elena Santos', 42, NULL, NULL, NULL, NULL, 'Housewife', NULL, 0.00, NULL, NULL, NULL, NULL, 1, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Makati Science High School', 'Makati City', '2019', '92', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'testing', 'Status updated by testing on 2025-05-10 14:26:25', 'Approved', '2025-05-10 09:27:00', '2025-05-10 12:26:25'),
(13, 'Student Assistantship Program', 'Reyes', 'Miguel', 'Garcia', 'BSCS 2', 'Single', NULL, 'Male', '2002-03-21', 'Quezon City', '2020-0045', '456 Mabini Ave., Quezon City', 'Family Owned', 'Roberto Reyes', '02-8765-4321', 'Born Again Christian', NULL, '0918-7654-321', 'miguel.reyes@example.com', 'No', NULL, 'Separated', 'Roberto Reyes', 50, NULL, NULL, NULL, NULL, 'Businessman', NULL, 25000.00, NULL, NULL, NULL, NULL, 'Carla Reyes', 48, NULL, NULL, NULL, NULL, 'Teacher', NULL, 18000.00, NULL, NULL, NULL, NULL, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Quezon City Science High School', 'Quezon City', '2020', '89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'testing', 'Status updated by testing on 2025-05-10 14:34:04', 'Rejected', '2025-05-10 09:27:00', '2025-05-10 12:34:04'),
(14, 'Financial Assistantship', 'Lim', 'Angela', 'Tan', 'BSA 4', 'Single', NULL, 'Female', '2000-11-08', 'Manila', '2018-0098', '789 Legaspi St., Pasig City', 'Renting', 'Henry Lim', '02-8901-2345', 'Protestant', NULL, '0919-8765-432', 'angela.lim@example.com', 'No', NULL, 'Married', 'Henry Lim', 55, NULL, NULL, NULL, NULL, 'Store Owner', NULL, 30000.00, NULL, NULL, NULL, NULL, 'Mary Lim', 53, NULL, NULL, NULL, NULL, 'Store Cashier', NULL, 15000.00, NULL, NULL, NULL, NULL, 3, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'St. Paul College Pasig', 'Pasig City', '2018', '91', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 'Pending', '2025-05-10 09:27:00', '2025-05-10 09:27:00'),
(15, 'Student Assistantship Program', 'Dela Cruz', 'Carlos', 'Mendoza', 'BSME 3', 'Single', NULL, 'Male', '2001-07-12', 'Cavite', '2019-0123', '101 Aguinaldo Highway, Cavite', 'Family Owned', 'Manuel Dela Cruz', '046-123-4567', 'Roman Catholic', NULL, '0920-1234-567', 'carlos.delacruz@example.com', 'No', NULL, 'Married', 'Manuel Dela Cruz', 52, NULL, NULL, NULL, NULL, 'Engineer', NULL, 35000.00, NULL, NULL, NULL, NULL, 'Teresa Dela Cruz', 49, NULL, NULL, NULL, NULL, 'Accountant', NULL, 28000.00, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cavite National Science High School', 'Cavite', '2019', '94', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 'Pending', '2025-05-10 09:27:00', '2025-05-10 09:27:00'),
(16, 'Financial Assistantship', 'Gonzales', 'Sofia', 'Rivera', 'BSN 2', 'Single', NULL, 'Female', '2002-09-03', 'Laguna', '2020-0234', '202 National Highway, San Pablo, Laguna', 'Living with Relatives', 'Eduardo Gonzales', '049-567-8901', 'Iglesia ni Cristo', NULL, '0921-2345-678', 'sofia.gonzales@example.com', 'Yes', NULL, 'Widowed', 'Eduardo Gonzales', 60, NULL, NULL, NULL, NULL, 'Retired Teacher', NULL, 12000.00, NULL, NULL, NULL, NULL, 'Deceased', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'San Pablo City Science High School', 'San Pablo, Laguna', '2020', '88', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 'Pending', '2025-05-10 09:27:00', '2025-05-10 09:27:00'),
(17, 'Student Assistantship Program', 'Aquino', 'John', 'Pascual', 'BSECE 1', 'Single', NULL, 'Male', '2003-01-25', 'Bulacan', '2021-0345', '303 Malolos Road, Malolos, Bulacan', 'Family Owned', 'Ricardo Aquino', '044-789-0123', 'Roman Catholic', NULL, '0922-3456-789', 'john.aquino@example.com', 'No', NULL, 'Married', 'Ricardo Aquino', 47, NULL, NULL, NULL, NULL, 'Farmer', NULL, 10000.00, NULL, NULL, NULL, NULL, 'Luisa Aquino', 45, NULL, NULL, NULL, NULL, 'Seamstress', NULL, 8000.00, NULL, NULL, NULL, NULL, 0, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Marcelo H. del Pilar National High School', 'Bulacan', '2021', '90', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 'Pending', '2025-05-10 09:27:00', '2025-05-10 09:27:00'),
(23, 'Student Assistantship', 'rodriguez', 'Kian', 'M.', 'eyye5', 'sss', 'uploads/681f42bbba48c_Capture.JPG', 'male', '2025-05-02', 'rhrh', 'mbc2022-0197', 'Sagana, Bongabong, Oriental Mindoro', 'boarding', '', '09234567654', 'fftmf', 'fmft', '', 'rheamelchor@gmail.com', 'no', 'hm', 'living_together', 'fnn', 9, 'Sagana, Bongabong, Oriental Mindoro', '658', '09234567654', 'rheamelchor@gmail.com', 'jtrfjt', '456', 7868.00, 78, 'jfj', 'fjfj', 'fjtf', 'Rhea M. Melchor', 9, 'ddn', '68568', '', 'rheamelchor@gmail.com', 'ftjfj', 'fjtfjf', 6786.00, 7, 'fjj', 'fjtfjf', 'fjtfjt', 1, 1, 2, 45.00, 5646.00, 46546.00, 465.00, 46.00, 456.00, 456.00, 456.00, 456.00, 456.00, 456.00, 46.00, 46.00, 0, 0.00, 0, 0.00, 46.00, 465.00, 456464.00, 56456.00, 565646.00, 4564.00, 466.00, 46.00, 456.00, 6456.00, 46.00, 456.00, 0.00, 464.00, 464.00, 456.00, 45.00, 456.00, 456.00, 46.00, 56.00, 456.00, 465.00, 46.00, 'tu6', 'tu6', 't6u', 'tut', 'sdd', 'fnn', 'nfn', '8858', 'Rhea M. Melchor', 'nfn', '09234567654', 1, 0, 0, 0, 0, 0, 0, 'vmv', 'vnvmvm', 'ddbf', 'Pending', '2025-05-10 12:12:43', '2025-05-10 12:12:43'),
(24, 'Financial Assistantship Program', 'rodriguez', 'Kian', 'M.', 'eyye5', 'sss', 'uploads/681f43517c389_face.png', '', '2025-05-02', 'rhrh', 'mbc2022-0197', 'Sagana, Bongabong, Oriental Mindoro', 'boarding', '', '09234567654', 'fftmf', 'fmft', '', 'rheamelchor@gmail.com', 'no', 'hm', 'living_together', 'fnn', 9, 'Sagana, Bongabong, Oriental Mindoro', '658', '09234567654', 'rheamelchor@gmail.com', 'jtrfjt', '456', 7868.00, 78, 'jfj', 'fjfj', 'fjtf', 'Rhea M. Melchor', 9, 'ddn', '68568', '', 'rheamelchor@gmail.com', 'ftjfj', 'fjtfjf', 6786.00, 7, 'fjj', 'fjtfjf', 'fjtfjt', 1, 1, 2, 0.00, 5646.00, 46546.00, 465.00, 46.00, 456.00, 456.00, 456.00, 456.00, 456.00, 456.00, 46.00, 46.00, 0, 0.00, 0, 0.00, 46.00, 465.00, 456464.00, 56456.00, 565646.00, 4564.00, 466.00, 46.00, 456.00, 6456.00, 46.00, 456.00, 46.00, 464.00, 464.00, 456.00, 45.00, 456.00, 456.00, 46.00, 56.00, 456.00, 465.00, 46.00, 'tu6f', 'tu6', 't6u', 'tut', 'fawfw', 'fnn', 'nfn', '8858', 'Rhea M. Melchor', 'nfn', '09234567654', 0, 0, 0, 0, 0, 0, 0, 'vmv', 'vnvmvm', '', 'Pending', '2025-05-10 12:15:13', '2025-05-10 12:15:13'),
(25, 'Financial Assistantship Program', 'rodriguez', 'Kian', 'M.', 'eyye5', 'sss', 'uploads/681f43be8fbca_face.png', 'male', '2025-05-02', 'rhrh', 'mbc2022-0197', 'Sagana, Bongabong, Oriental Mindoro', 'boarding', '', '09234567654', 'fftmf', 'fmft', '', 'rheamelchor@gmail.com', 'no', 'hm', 'living_together', 'fnn', 9, 'Sagana, Bongabong, Oriental Mindoro', '658', '09234567654', 'rheamelchor@gmail.com', 'jtrfjt', '456', 7868.00, 78, 'jfj', 'fjfj', 'fjtf', 'Rhea M. Melchor', 9, 'ddn', '68568', '', 'rheamelchor@gmail.com', 'ftjfj', 'fjtfjf', 6786.00, 7, 'fjj', 'fjtfjf', 'fjtfjt', 1, 1, 2, 0.00, 5646.00, 46546.00, 465.00, 46.00, 456.00, 456.00, 456.00, 456.00, 456.00, 456.00, 46.00, 46.00, 0, 0.00, 0, 0.00, 46.00, 465.00, 456464.00, 56456.00, 565646.00, 4564.00, 466.00, 46.00, 456.00, 6456.00, 46.00, 456.00, 46.00, 464.00, 464.00, 456.00, 45.00, 456.00, 456.00, 46.00, 56.00, 456.00, 465.00, 46.00, 'tu6f', 'tu6', 't6u', 'tut', 'rfdr', 'fnn', 'nfn', '8858', 'Rhea M. Melchor', 'nfn', '09234567654', 0, 0, 0, 0, 0, 0, 0, 'vmv', 'vnvmvm', '', 'Pending', '2025-05-10 12:17:02', '2025-05-10 12:17:02'),
(26, 'Student Assistantship Program', 'rodriguez', 'Kian', 'M.', 'eyye5', 'sss', 'uploads/681f4434ec8d0_face.png', 'male', '2025-05-02', 'rhrh', 'mbc2022-0197', 'Sagana, Bongabong, Oriental Mindoro', 'boarding', '', '09234567654', 'fftmf', 'fmft', '', 'rheamelchor@gmail.com', 'no', 'hm', 'single_parent', 'fnn', 9, 'Sagana, Bongabong, Oriental Mindoro', '658', '09234567654', 'rheamelchor@gmail.com', 'jtrfjt', '456', 7868.00, 78, 'jfj', 'fjfj', 'fjtf', 'Rhea M. Melchor', 9, 'ddn', '68568', '', 'rheamelchor@gmail.com', 'ftjfj', 'fjtfjf', 6786.00, 7, 'fjj', 'fjtfjf', 'fjtfjt', 1, 1, 2, 43.00, 5646.00, 46546.00, 465.00, 46.00, 456.00, 456.00, 456.00, 456.00, 456.00, 456.00, 46.00, 46.00, 0, 0.00, 0, 0.00, 46.00, 465.00, 456464.00, 56456.00, 565646.00, 4564.00, 466.00, 46.00, 456.00, 6456.00, 46.00, 456.00, 46.00, 464.00, 464.00, 456.00, 45.00, 456.00, 456.00, 46.00, 56.00, 456.00, 465.00, 46.00, 'tu6f', 'tu6', 't6u', 'tut', 'fwfa', 'fnn', 'nfn', '8858', 'Rhea M. Melchor', 'nfn', '09234567654', 0, 0, 0, 0, 0, 0, 0, 'vmv', 'vnvmvm', '', 'Pending', '2025-05-10 12:19:00', '2025-05-10 12:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','staff','ched') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(13, 'testuser', '$2y$10$0hzg9Ic2UdJSTPr.UksbHOKcgqBTCK23Q1dZvpfca7iqW3evV1Uxe', '2025-05-09 04:08:05', 'admin'),
(35, 'admin', '$2y$10$2mV4/lOlrPrSo2epeKqSueORyk.Jq.UvWtyKwmuBMkh.64YP2/g6O', '2025-05-09 04:46:03', 'staff'),
(49, 'Rhea Melchor', '$2y$10$poEsXpUQCp5DuXOfBWjECOP2sYqjmr7k2Vj3inbibi9ULruFBZsGq', '2025-05-09 04:55:15', 'staff'),
(54, 'Rica Melchor', '$2y$10$uRCWnSSTW2vciEOkasoWJuhTh04BRRE5OINRqsPMl/XWaTsZOiBpK', '2025-05-09 04:58:16', 'staff'),
(95, 'rheamelchor@gmail.com', '$2y$10$.ZINmaoGxNox8fUDhL6ByODjIwxrDuPjgl7Yo9caFkaLJrVpil8pG', '2025-05-09 05:15:37', 'staff'),
(0, 'admin', '$2y$10$cwvYTdw/BMCWxcke1/F6YO7qxg9S.vjj.xYPp5KR/QjvFDfQoIfmq', '2025-05-07 11:56:28', 'admin'),
(0, 'admin', '$2y$10$L/jOQSQFNdy2NOwa8fRLEOfXtynqov65dkgaSzvXhxUZzXAcZ0ME6', '2025-05-07 11:56:31', 'admin'),
(0, 'admin', '$2y$10$.CgYTcjKtDvwT8m6IaxJ.uBWVSFQoabZJNUgDj7RHMgh8zzVjGmx2', '2025-05-07 11:57:24', 'admin'),
(0, 'admin', '$2y$10$RmdO1u/nBTgY9fy4oAOd/.HLRMXIb7H0OzJoxwJu71BOX9cg28526', '2025-05-07 11:57:27', 'admin'),
(0, 'admin', '$2y$10$ohFVrlmo8nJkZIvk7YHl9.WL.b4GZv/ji2rJSQDexqEIP6YdWBwFu', '2025-05-07 11:57:32', 'admin'),
(0, 'admin', '$2y$10$HOrtziBaW.3.Jb9DGcxDgejBWSd/cFDlJc9.9dixQWf2sllpHVni.', '2025-05-07 11:57:40', 'admin'),
(0, 'test', '$2y$10$jgRIYp8CiTN0x6igza5vf.2hhTSfV9FG0slROjh4co9Ncd73mpZum', '2025-05-07 11:57:41', 'ched'),
(0, 'admin', '$2y$10$9mE2Bl9cKHlFJGnVRlhJw.wf2H/hz7PNteYxEGYVkyTCCGVqrgRQ6', '2025-05-07 11:57:45', 'admin'),
(0, 'admin', '$2y$10$.Hk0ifr2iy0XPcRyvzct4OIiUI9Qr.IfFPTgbbVK1xZLIWqp6PD12', '2025-05-10 05:04:49', 'admin'),
(0, 'admin', '$2y$10$Z.i97hjab7vHcjp5dUOaIe/Owou1KqYDG5wxAmpFIuF.nOJLaHVv6', '2025-05-10 05:05:22', 'admin'),
(0, 'admin', '$2y$10$mUXHB69FsH.AWzfIInYhbuKPHvvs5w/O1X6L1Pc3cZHQah7joH56.', '2025-05-10 05:05:30', 'admin'),
(0, 'admin', '$2y$10$Ukt09nsSiC3tA8Vglb8VqO1omsRzf2Qu2gLlyx3dF/JADQmEyVcQK', '2025-05-10 05:06:19', 'admin'),
(0, 'admin', '$2y$10$Lm3VrxgbZQn1ZmvKyQoQq.oEwqTdlZGID/zRTDbgJd.r5p8MN1K/C', '2025-05-10 05:08:57', 'admin'),
(0, 'admin', '$2y$10$vLgW8dYEE0ukAExtkzcmg.YkkT7uV3.9Fn.hJA5arxINCsJtsRsla', '2025-05-10 05:09:03', 'admin'),
(0, 'admin', '$2y$10$zX9/dLAAIk6VAc.MPIs8ruHIz6KGgXflGXPDJbkXkvGOHdKjve8fy', '2025-05-10 05:10:30', 'admin'),
(0, 'admin', '$2y$10$1g3vwkWsAQFhp9PEyXmifeaQatTS89cdNSPeNKdMW1CHgBvDDfL5K', '2025-05-10 05:17:11', 'admin'),
(0, 'admin', '$2y$10$6oqoW/Mb3mhC6T3WxGk40u1n8rJOxGRzSQTokz3Zjzp/.RkSU8tfm', '2025-05-10 05:19:25', 'admin'),
(0, 'admin', '$2y$10$qT2Q0Ysrvrhd3wBm1KGfiuXNXIU0KUMdEKjQOwK3IH2hy/qwYjqH6', '2025-05-10 05:24:37', 'admin'),
(0, 'admin', '$2y$10$fcco9hxY4nt/9NGzyLM2degzzzIn70R569zIyiAF9EAGaiAsU8bEG', '2025-05-10 05:24:59', 'admin'),
(0, 'admin', '$2y$10$kFzGkBmVBPs5D5dyxSFCn.XBWtQUh5l0RO/O2Vb27gpII6ar5Qypa', '2025-05-10 05:29:40', 'admin'),
(0, 'admin', '$2y$10$jeljJIXc9qdnHloJnvI61.Os9cgjoTDc3jzLWvHbOgrGuRzTBttGC', '2025-05-10 05:29:42', 'admin'),
(0, 'admin', '$2y$10$JJNtSUVvscYfzdhKtRcIIOl9vdCsiEXR96I1x6l5zhbDbX.EBaCEy', '2025-05-10 05:29:44', 'admin'),
(0, 'admin', '$2y$10$md1r41lz74ccQioUiID8z.csEI5JqsjgAgiaoQzq1mTcqopfTT7i.', '2025-05-10 05:37:18', 'admin'),
(0, 'admin', '$2y$10$Fe3GsZvDlXGEPFzGHoowv./nG8BVxQ0OSkzSd.pHrb/DpkfHjuioG', '2025-05-10 05:37:19', 'admin'),
(0, 'admin', '$2y$10$MgW.vXCG.fr7QL/skCXFc.1xNZlVmZQdCDm72OC1982kGOA6kJwhq', '2025-05-10 05:37:33', 'admin'),
(0, 'admin', '$2y$10$4jwClgrYHfHA5neOIMyqEuVwrZ5IfUyOdyudyy7keIzoP.3C5AQsm', '2025-05-10 05:37:36', 'admin'),
(0, 'admin', '$2y$10$iFcB2MS0RvE/Mdcrzx63dez.TOaCbSCqpHayQc2yBSCmtdLnC.RX6', '2025-05-10 05:37:36', 'admin'),
(0, 'admin', '$2y$10$k8W/xxHwWF8zJZAj.YvWiOOuKRS/QsfirIudbSBwpLAixUW.iF8L.', '2025-05-10 05:45:12', 'admin'),
(0, 'admin', '$2y$10$FL.xtTqZXxdA3DPe8Ei.5.eI5TOMOIKTWg1X5QaqHRD1iLiDEnFPi', '2025-05-10 05:55:14', 'admin'),
(0, 'admin', '$2y$10$S9Pdz7fgD7.B2asvTLlk8.YCPnUqyZB3Gko0sDWsLu8wSt5NA6ryu', '2025-05-10 05:58:36', 'admin'),
(0, 'admin', '$2y$10$M4RA0iukgp4sPYSsNrf8xOOiu3/7DWN2W6QQC.hvg/WNyzORPGlim', '2025-05-10 06:00:30', 'admin'),
(0, 'admin', '$2y$10$nIXEEViTdhxyjXiIrTpm6.0qwwS20541CKNzyytAeysg9d5Vg9dwm', '2025-05-10 06:00:30', 'admin'),
(0, 'admin', '$2y$10$XsQw9IBMHJ25sggQ2aE8tu2pRfU9urDeOOIwB1gpNALOw23kosspG', '2025-05-10 06:03:04', 'admin'),
(0, 'admin', '$2y$10$ZKxelJC5BWp0XpQHUtdMRO853RPDSfbBB.WyHXb8eg6L/Phv0eWq2', '2025-05-10 06:11:31', 'admin'),
(0, 'admin', '$2y$10$zJEL79G7BjTSa//r36gbD.rnPikcHtOsZvpWWrqWyx3cX12uTPUOK', '2025-05-10 06:11:32', 'admin'),
(0, 'admin', '$2y$10$uEJxJ20n3cQhmR5R9nTGBeN.uMk3SyOrqgtJvQYWOq1s8WXzjsAaS', '2025-05-10 06:11:42', 'admin'),
(0, 'admin', '$2y$10$morwUhgC.uS7ULl/vuwedO8v9Ir8tnZC1F/l2W4dTGBB.1M5gm7xu', '2025-05-10 06:11:54', 'admin'),
(0, 'admin', '$2y$10$WyDP4/Xk2tZILthuF/5waOz.NRLCR8Z8NNS4pBUSqKdY98vNvBPTW', '2025-05-10 06:12:02', 'admin'),
(0, 'admin', '$2y$10$qGZeYXM//KV1I15SyZo/J.5zlTGIT8yA//0Bsw1sC74ByC/ZB876u', '2025-05-10 06:12:04', 'admin'),
(0, 'admin', '$2y$10$SIqwzbJAf42PkYBE.PlbNeB6B0sqb/FJq1pPWJy3WOWS/eshQDWeG', '2025-05-10 06:12:09', 'admin'),
(0, 'admin', '$2y$10$fVCwjW3B92cSosKHz4x4HOYrQsX0OVSkIGLRcTEX8emvn1SyLlXRW', '2025-05-10 06:14:29', 'admin'),
(0, 'admin', '$2y$10$JXRXRH/2KWL5mxmG2zX9TewyVOd17nbqcN.nGZaLhQs1uRBOvjEqG', '2025-05-10 06:14:34', 'admin'),
(0, 'admin', '$2y$10$1ib0Dv9QenjkmdVKMJCvXeF7Px3GTRLlN297jJ6XCwJSrtKxajcfe', '2025-05-10 06:14:34', 'admin'),
(0, 'admin', '$2y$10$7QFr9jye.dhm83RaJ.98/uMexrN0EPI7VDkQFbMkGmKiDzZ51qZBS', '2025-05-10 06:14:39', 'admin'),
(0, 'admin', '$2y$10$ITbftwPvhwgLYsVrKOdTqOh6Z4vRnywn8szXJpqF7i4BnwPkF2nIS', '2025-05-10 06:14:52', 'admin'),
(0, 'admin', '$2y$10$euiB3S3U7ePKG/emqnhD/.T6Z.Q./svVqG.045M/5GhBQAW798YpS', '2025-05-10 06:14:57', 'admin'),
(0, 'admin', '$2y$10$OWiyp4Bcopx.oCM85m.G4uNIKtcpg1B2sYN7eRh3po9l2YoebEiny', '2025-05-10 06:15:05', 'admin'),
(0, 'testing', '$2y$10$cv1msneAcV1Bcq4DpAwPEO7eVala3nVCnbl6yt/1fH86KunHTnIve', '2025-05-10 06:15:06', 'ched'),
(0, 'admin', '$2y$10$BEpqOpt7QcuaBlKmRIUEuuKppyveAKY7d9CqXUIUwPwbErMhYLGMa', '2025-05-10 06:15:09', 'admin'),
(0, 'admin', '$2y$10$lYfMZxWW367lEDtJSPw67.O8uW0nOuczTWxV3cs3aHzaYZLkhiFyO', '2025-05-10 06:15:13', 'admin'),
(0, 'admin', '$2y$10$Mmf3gLtlJhMDJhg0LaMioOjxOsZK2yfiKPGLSP2eUMxg9SkOAItKe', '2025-05-10 06:15:23', 'admin'),
(0, 'admin', '$2y$10$59CGfCjmNLT1MdOpgSenaO2VabUe51OB8fTpggqC2I8sQho67OWY6', '2025-05-10 06:15:27', 'admin'),
(0, 'admin', '$2y$10$lSjKLV58j.wHBd1az7kBsenPVVVQbqcxmc7wUZECrwV4W06EbvLSe', '2025-05-10 06:16:25', 'admin'),
(0, 'admin', '$2y$10$FHr./zu9ULu36S7P52UL2ebfGxR1HIYoKeE0XWQkfhDmHtISf980u', '2025-05-10 06:19:01', 'admin'),
(0, 'admin', '$2y$10$O0572yiSRgs/4LdHgviVhu1caSZDjpa1RPIPhLZKcOe1NoUsyoYGO', '2025-05-10 06:19:11', 'admin'),
(0, 'admin', '$2y$10$jm9xrk5hyu3Fd9lE3ElepetBZUyyOvpD5FUVbsHwI8JLiVRpZF3ve', '2025-05-10 06:19:11', 'admin'),
(0, 'admin', '$2y$10$aHcLQVHALhzZXymyFZgiI.uYaR.aV0bNDyyl4sRzOn5cLPiMKOFZe', '2025-05-10 06:19:22', 'admin'),
(0, 'admin', '$2y$10$YSW1srbFk/Dq6Q7gi7BLK.SCQJnFK1PUcJ4YwYRt5fLndVIi07oBK', '2025-05-10 06:19:30', 'admin'),
(0, 'admin', '$2y$10$krL2Kd4NU0/jkVA6sRxvu.cdojEN7jOVoJyD0C9mb2UbDcLJhQCXy', '2025-05-10 06:20:27', 'admin'),
(0, 'admin', '$2y$10$RTkImu1kREuiKcyNDK5R8uFr7PCllnm9JTqQvJRamtJYeOrh9RhX2', '2025-05-10 06:20:32', 'admin'),
(0, 'admin', '$2y$10$rNkaxnR4GdznPVdAEqe2f.NlSUutt324Rdeh2Rm0FpxPqC4Gh5aFy', '2025-05-10 06:20:33', 'admin'),
(0, 'admin', '$2y$10$CBE8qoWDTvSGXyf5J5UbeO/BEPQ.39BdEIeO7QkN.FT8uLG1XeFpO', '2025-05-10 06:20:36', 'admin'),
(0, 'admin', '$2y$10$7ojhhHPvtpmyQec2kHZ3m./uBa5Akh8lFecUprUxpT9arkPZyxToO', '2025-05-10 06:22:40', 'admin'),
(0, 'admin', '$2y$10$2GNvODvZHdgM7PZnnzA/tO/p.u/NJn3acY.sklFzYNlGcOZCoMw22', '2025-05-10 06:22:40', 'admin'),
(0, 'admin', '$2y$10$StyHwnvq543wlIOev0LzZuarIIH6y.WIUBYmKnmzj1a5ehtVdCwjq', '2025-05-10 06:22:42', 'admin'),
(0, 'admin', '$2y$10$ffMiT.ZG63o0zy4y9.gnFOi4nDzB6AP4IYRydcg7kI/ySJT1RqFJG', '2025-05-10 06:22:47', 'admin'),
(0, 'admin', '$2y$10$UR9UWDvcB0UNqBMGjerBs.89SzjCq5GTXm6rLgImkX1b/p62jlniS', '2025-05-10 06:22:48', 'admin'),
(0, 'admin', '$2y$10$mxUnV8bey7vD5kxVO2TYHu9uo8ntVDGQMgxEx.b.rKWPPcQ071NC.', '2025-05-10 06:22:51', 'admin'),
(0, 'admin', '$2y$10$d7SCZKS749e4NgfXgl6iTuzKj3onTDA1srTs77zzCaqjRRN5VYkea', '2025-05-10 06:22:54', 'admin'),
(0, 'admin', '$2y$10$8zpFAbYFnapueME8bARxQO3bqKMEKMaZHEIEgWiVBP/17jcAQJciO', '2025-05-10 06:23:05', 'admin'),
(0, 'staff', '$2y$10$.gOV9IPSZFqMtEmFsh9czeiPNDxocDQC75CiIwWTUzpf2dQeizqWu', '2025-05-10 06:23:05', 'staff'),
(0, 'admin', '$2y$10$JEOZwuFOo2oZQmeHkwtN/e.T3T3o6DDZP/.DydK/pqFLlRkCEc2k.', '2025-05-10 06:23:09', 'admin'),
(0, 'admin', '$2y$10$gzu0EK/VRLwNz3VpuiETh.Okop9eXi3QCnViYQSuIzp9Bj9KBPfsC', '2025-05-10 06:24:26', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
