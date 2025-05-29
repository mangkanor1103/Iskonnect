-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 08:16 AM
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
(1, 'ria10@gmail.com', 'ria@gmail.com', 'good', '2025-05-10 14:57:17'),
(2, 'Rhea M. Melchor', 'R@gmail.com', 'nice', '2025-05-16 20:13:03'),
(3, 'Maria Cuasay', 'mariacusay@gmail.com', 'The form needs improvement', '2025-05-29 13:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_posts`
--

CREATE TABLE `scholarship_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `how_to_apply` text DEFAULT NULL,
  `scholarship_type` varchar(50) DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_posts`
--

INSERT INTO `scholarship_posts` (`id`, `title`, `content`, `how_to_apply`, `scholarship_type`, `posted_by`, `attachment`, `created_at`, `updated_at`, `deadline`) VALUES
(11, 'SAP', 'You are qualified to apply.', 'You may scan the qr code attached to access the application form, then if you have question you can contact SAS staff in this email SASoffice @gmail.com.', 'Student Assistance Program (SAP)', 169, '6837db69da4c8_application_form_qr_code.pdf', '2025-05-29 03:58:33', '2025-05-29 03:58:33', '2025-06-06');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `batch_number` varchar(50) DEFAULT NULL,
  `batch_date` date DEFAULT NULL,
  `processed_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `scholarship_type`, `last_name`, `first_name`, `middle_name`, `course_yr`, `civil_status`, `photo`, `gender`, `date_of_birth`, `place_of_birth`, `student_id`, `address`, `residence_type`, `guardian_name`, `telephone`, `religion`, `existing_scholarship`, `mobile`, `email`, `is_pwd`, `disability_type`, `parent_status`, `father_name`, `father_age`, `father_address`, `father_tel`, `father_mobile`, `father_email`, `father_occupation`, `father_company`, `father_income`, `father_years_service`, `father_education`, `father_school`, `father_unemployment_reason`, `mother_name`, `mother_age`, `mother_address`, `mother_tel`, `mother_mobile`, `mother_email`, `mother_occupation`, `mother_company`, `mother_income`, `mother_years_service`, `mother_education`, `mother_school`, `mother_unemployment_reason`, `working_siblings`, `studying_siblings`, `total_siblings`, `house_rental`, `food_grocery`, `car_loan`, `other_loan`, `school_bus`, `transportation`, `education_plan`, `insurance_policy`, `health_insurance`, `govt_loans`, `clothing`, `utilities`, `communication`, `helper_count`, `helper_expense`, `driver_count`, `driver_expense`, `medicines`, `doctors_fee`, `hospitalization`, `recreation`, `other_monthly_expenses`, `total_monthly_expenses`, `annual_monthly_expenses`, `tuition`, `withholding_tax`, `govt_contributions`, `other_annual_expenses`, `annual_expenses_subtotal`, `total_annual_expenses`, `parents_annual_pay`, `siblings_annual_pay`, `business_income`, `land_rental_income`, `property_rental_income`, `pension_income`, `commission_income`, `relative_support`, `bank_deposits`, `other_income`, `total_annual_income`, `secondary_school`, `school_location`, `year_graduated`, `general_average`, `honors_awards`, `reference1_name`, `reference1_relationship`, `reference1_contact`, `reference2_name`, `reference2_relationship`, `reference2_contact`, `req_photo`, `req_itr`, `req_ofw`, `req_grades`, `req_moral`, `req_letter`, `req_schedule`, `office_received`, `office_screened`, `office_remarks`, `status`, `created_at`, `updated_at`, `batch_number`, `batch_date`, `processed_by`) VALUES
(12, 'Financial Assistantship', 'Santos', 'Maria', 'Cruz', 'BSIT 3', 'Single', NULL, 'Female', '2001-05-15', 'Manila', '2019-0001', '123 Rizal St., Makati City', 'Renting', 'Juan Santos', '02-8123-4567', 'Roman Catholic', NULL, '0917-1234-567', 'maria.santos@example.com', 'No', NULL, 'Married', 'Juan Santos', 45, NULL, NULL, NULL, NULL, 'Driver', NULL, 15000.00, NULL, NULL, NULL, NULL, 'Elena Santos', 42, NULL, NULL, NULL, NULL, 'Housewife', NULL, 0.00, NULL, NULL, NULL, NULL, 1, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Makati Science High School', 'Makati City', '2019', '92', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'testing', 'Status updated by testing on 2025-05-10 14:26:25', 'Approved', '2025-05-10 09:27:00', '2025-05-11 01:27:15', '2025051102', '2025-05-11', 'testing'),
(13, 'Student Assistantship Program', 'Reyes', 'Miguel', 'Garcia', 'BSCS 2', 'Single', NULL, 'Male', '2002-03-21', 'Quezon City', '2020-0045', '456 Mabini Ave., Quezon City', 'Family Owned', 'Roberto Reyes', '02-8765-4321', 'Born Again Christian', NULL, '0918-7654-321', 'miguel.reyes@example.com', 'No', NULL, 'Separated', 'Roberto Reyes', 50, NULL, NULL, NULL, NULL, 'Businessman', NULL, 25000.00, NULL, NULL, NULL, NULL, 'Carla Reyes', 48, NULL, NULL, NULL, NULL, 'Teacher', NULL, 18000.00, NULL, NULL, NULL, NULL, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Quezon City Science High School', 'Quezon City', '2020', '89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'testing', 'Status updated by testing on 2025-05-10 14:34:04', 'Rejected', '2025-05-10 09:27:00', '2025-05-10 12:34:04', NULL, NULL, NULL),
(14, 'Financial Assistantship', 'Lim', 'Angela', 'Tan', 'BSA 4', 'Single', NULL, 'Female', '2000-11-08', 'Manila', '2018-0098', '789 Legaspi St., Pasig City', 'Renting', 'Henry Lim', '02-8901-2345', 'Protestant', NULL, '0919-8765-432', 'angela.lim@example.com', 'No', NULL, 'Married', 'Henry Lim', 55, NULL, NULL, NULL, NULL, 'Store Owner', NULL, 30000.00, NULL, NULL, NULL, NULL, 'Mary Lim', 53, NULL, NULL, NULL, NULL, 'Store Cashier', NULL, 15000.00, NULL, NULL, NULL, NULL, 3, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'St. Paul College Pasig', 'Pasig City', '2018', '91', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'Nicole', 'Status updated by Nicole on 2025-05-13 05:00:34', 'Approved', '2025-05-10 09:27:00', '2025-05-13 03:00:34', NULL, NULL, NULL),
(15, 'Student Assistantship Program', 'Dela Cruz', 'Carlos', 'Mendoza', 'BSME 3', 'Single', NULL, 'Male', '2001-07-12', 'Cavite', '2019-0123', '101 Aguinaldo Highway, Cavite', 'Family Owned', 'Manuel Dela Cruz', '046-123-4567', 'Roman Catholic', NULL, '0920-1234-567', 'carlos.delacruz@example.com', 'No', NULL, 'Married', 'Manuel Dela Cruz', 52, NULL, NULL, NULL, NULL, 'Engineer', NULL, 35000.00, NULL, NULL, NULL, NULL, 'Teresa Dela Cruz', 49, NULL, NULL, NULL, NULL, 'Accountant', NULL, 28000.00, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cavite National Science High School', 'Cavite', '2019', '94', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'Nicole', 'Status updated by Nicole on 2025-05-13 05:11:42', 'Approved', '2025-05-10 09:27:00', '2025-05-16 11:43:55', '2025051601', '2025-05-16', 'Eyacuasay'),
(16, 'Financial Assistantship', 'Gonzales', 'Sofia', 'Rivera', 'BSN 2', 'Single', NULL, 'Female', '2002-09-03', 'Laguna', '2020-0234', '202 National Highway, San Pablo, Laguna', 'Living with Relatives', 'Eduardo Gonzales', '049-567-8901', 'Iglesia ni Cristo', NULL, '0921-2345-678', 'sofia.gonzales@example.com', 'Yes', NULL, 'Widowed', 'Eduardo Gonzales', 60, NULL, NULL, NULL, NULL, 'Retired Teacher', NULL, 12000.00, NULL, NULL, NULL, NULL, 'Deceased', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'San Pablo City Science High School', 'San Pablo, Laguna', '2020', '88', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'Nicole', 'Status updated by Nicole on 2025-05-19 08:59:47', 'Approved', '2025-05-10 09:27:00', '2025-05-24 04:08:08', '2025052401', '2025-05-24', 'Nicole'),
(17, 'Student Assistantship Program', 'Aquino', 'John', 'Pascual', 'BSECE 1', 'Single', NULL, 'Male', '2003-01-25', 'Bulacan', '2021-0345', '303 Malolos Road, Malolos, Bulacan', 'Family Owned', 'Ricardo Aquino', '044-789-0123', 'Roman Catholic', NULL, '0922-3456-789', 'john.aquino@example.com', 'No', NULL, 'Married', 'Ricardo Aquino', 47, NULL, NULL, NULL, NULL, 'Farmer', NULL, 10000.00, NULL, NULL, NULL, NULL, 'Luisa Aquino', 45, NULL, NULL, NULL, NULL, 'Seamstress', NULL, 8000.00, NULL, NULL, NULL, NULL, 0, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Marcelo H. del Pilar National High School', 'Bulacan', '2021', '90', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, 'Nicole', 'Status updated by Nicole on 2025-05-27 04:54:22', 'Rejected', '2025-05-10 09:27:00', '2025-05-27 02:54:22', NULL, NULL, NULL),
(27, 'Student Assistantship Program', 'Melchor', 'Rhea', 'M.', 'BSIT 3', 'Single', 'uploads/682414828459e_6102393966742850143.jpg', 'female', '2003-10-02', 'San Vicente, Sagana, Bongabong, Oriental Mindoro', 'MBC2022-0102', 'Sagana, Bongabong, Oriental Mindoro', 'parents', '', '09234567654', 'Roman Cathlolic', 'None', '09923306144', 'rheamelchor@gmail.com', 'no', 'No', 'living_together', 'Juanito Melchor', 60, 'Sagana, Bongabong, Oriental Mindoro', '09378446789', '09234567654', 'j@gmail.com', 'Farmer', 'None', 5.00, 0, 'Elementary ', '', '', 'Maria Melchor', 55, 'Sagana, Bongabong, Oriental Mindoro', '09874563425', '09874567895', 'm@gmail.com', 'house wife', 'None', 5.00, 0, 'Elementary', '', '', 0, 0, 0, 0.00, 2000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', 'Pending', '2025-05-14 03:56:50', '2025-05-14 03:56:50', NULL, NULL, NULL),
(29, 'Student Assistantship Program', 'Lanot', 'louvee', 'Semilla', 'BSIT 3', 'Single', '', 'female', '2004-12-04', 'Santa Theresa, Gloria, Oriental Mindoro', 'mbc2022-0225', 'San Antonio, Gloria, Oriental Mindoro', 'parents', '', '09065929694', 'Catholic', 'None', '09065929694', 'jruby131@gmail.com', 'no', '', 'separated', 'James Ronald Lanot', 36, 'Guimbonan, Gloria, Oriental Mindoro', '09378446789', '09065929694', 'jruby131@gmail.com', 'Driver', 'none', 2000.00, 1, 'High School Grad', 'Sacred Heart Academy', 'none', 'Glaiza Semilla', 37, 'San Antonio, Gloria, Oriental Mindoro', '09163463352', '09065929694', 'jruby131@gmail.com', 'Housewife', 'none', 0.00, 0, 'High School Grad', 'Sacred Heart Academy', 'none', 0, 1, 1, 0.00, 2000.00, 2000.00, 2000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '', 'Pending', '2025-05-19 06:55:54', '2025-05-19 06:55:54', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','staff','ched','student') NOT NULL DEFAULT 'staff',
  `fullname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`, `fullname`) VALUES
(13, 'testuser', '$2y$10$0hzg9Ic2UdJSTPr.UksbHOKcgqBTCK23Q1dZvpfca7iqW3evV1Uxe', '2025-05-09 04:08:05', 'admin', NULL),
(35, 'admin', '$2y$10$2mV4/lOlrPrSo2epeKqSueORyk.Jq.UvWtyKwmuBMkh.64YP2/g6O', '2025-05-09 04:46:03', 'staff', NULL),
(49, 'Rhea Melchor', '$2y$10$poEsXpUQCp5DuXOfBWjECOP2sYqjmr7k2Vj3inbibi9ULruFBZsGq', '2025-05-09 04:55:15', 'staff', NULL),
(54, 'Rica Melchor', '$2y$10$uRCWnSSTW2vciEOkasoWJuhTh04BRRE5OINRqsPMl/XWaTsZOiBpK', '2025-05-09 04:58:16', 'staff', NULL),
(95, 'rheamelchor@gmail.com', '$2y$10$.ZINmaoGxNox8fUDhL6ByODjIwxrDuPjgl7Yo9caFkaLJrVpil8pG', '2025-05-09 05:15:37', 'staff', NULL),
(96, 'admin', '$2y$10$cwvYTdw/BMCWxcke1/F6YO7qxg9S.vjj.xYPp5KR/QjvFDfQoIfmq', '2025-05-07 11:56:28', 'admin', NULL),
(97, 'admin', '$2y$10$L/jOQSQFNdy2NOwa8fRLEOfXtynqov65dkgaSzvXhxUZzXAcZ0ME6', '2025-05-07 11:56:31', 'admin', NULL),
(98, 'admin', '$2y$10$.CgYTcjKtDvwT8m6IaxJ.uBWVSFQoabZJNUgDj7RHMgh8zzVjGmx2', '2025-05-07 11:57:24', 'admin', NULL),
(99, 'admin', '$2y$10$RmdO1u/nBTgY9fy4oAOd/.HLRMXIb7H0OzJoxwJu71BOX9cg28526', '2025-05-07 11:57:27', 'admin', NULL),
(100, 'admin', '$2y$10$ohFVrlmo8nJkZIvk7YHl9.WL.b4GZv/ji2rJSQDexqEIP6YdWBwFu', '2025-05-07 11:57:32', 'admin', NULL),
(101, 'admin', '$2y$10$HOrtziBaW.3.Jb9DGcxDgejBWSd/cFDlJc9.9dixQWf2sllpHVni.', '2025-05-07 11:57:40', 'admin', NULL),
(102, 'test', '$2y$10$jgRIYp8CiTN0x6igza5vf.2hhTSfV9FG0slROjh4co9Ncd73mpZum', '2025-05-07 11:57:41', 'ched', NULL),
(103, 'admin', '$2y$10$9mE2Bl9cKHlFJGnVRlhJw.wf2H/hz7PNteYxEGYVkyTCCGVqrgRQ6', '2025-05-07 11:57:45', 'admin', NULL),
(104, 'admin', '$2y$10$.Hk0ifr2iy0XPcRyvzct4OIiUI9Qr.IfFPTgbbVK1xZLIWqp6PD12', '2025-05-10 05:04:49', 'admin', NULL),
(105, 'admin', '$2y$10$Z.i97hjab7vHcjp5dUOaIe/Owou1KqYDG5wxAmpFIuF.nOJLaHVv6', '2025-05-10 05:05:22', 'admin', NULL),
(106, 'admin', '$2y$10$mUXHB69FsH.AWzfIInYhbuKPHvvs5w/O1X6L1Pc3cZHQah7joH56.', '2025-05-10 05:05:30', 'admin', NULL),
(107, 'admin', '$2y$10$Ukt09nsSiC3tA8Vglb8VqO1omsRzf2Qu2gLlyx3dF/JADQmEyVcQK', '2025-05-10 05:06:19', 'admin', NULL),
(108, 'admin', '$2y$10$Lm3VrxgbZQn1ZmvKyQoQq.oEwqTdlZGID/zRTDbgJd.r5p8MN1K/C', '2025-05-10 05:08:57', 'admin', NULL),
(109, 'admin', '$2y$10$vLgW8dYEE0ukAExtkzcmg.YkkT7uV3.9Fn.hJA5arxINCsJtsRsla', '2025-05-10 05:09:03', 'admin', NULL),
(110, 'admin', '$2y$10$zX9/dLAAIk6VAc.MPIs8ruHIz6KGgXflGXPDJbkXkvGOHdKjve8fy', '2025-05-10 05:10:30', 'admin', NULL),
(111, 'admin', '$2y$10$1g3vwkWsAQFhp9PEyXmifeaQatTS89cdNSPeNKdMW1CHgBvDDfL5K', '2025-05-10 05:17:11', 'admin', NULL),
(112, 'admin', '$2y$10$6oqoW/Mb3mhC6T3WxGk40u1n8rJOxGRzSQTokz3Zjzp/.RkSU8tfm', '2025-05-10 05:19:25', 'admin', NULL),
(113, 'admin', '$2y$10$qT2Q0Ysrvrhd3wBm1KGfiuXNXIU0KUMdEKjQOwK3IH2hy/qwYjqH6', '2025-05-10 05:24:37', 'admin', NULL),
(114, 'admin', '$2y$10$fcco9hxY4nt/9NGzyLM2degzzzIn70R569zIyiAF9EAGaiAsU8bEG', '2025-05-10 05:24:59', 'admin', NULL),
(115, 'admin', '$2y$10$kFzGkBmVBPs5D5dyxSFCn.XBWtQUh5l0RO/O2Vb27gpII6ar5Qypa', '2025-05-10 05:29:40', 'admin', NULL),
(116, 'admin', '$2y$10$jeljJIXc9qdnHloJnvI61.Os9cgjoTDc3jzLWvHbOgrGuRzTBttGC', '2025-05-10 05:29:42', 'admin', NULL),
(117, 'admin', '$2y$10$JJNtSUVvscYfzdhKtRcIIOl9vdCsiEXR96I1x6l5zhbDbX.EBaCEy', '2025-05-10 05:29:44', 'admin', NULL),
(118, 'admin', '$2y$10$md1r41lz74ccQioUiID8z.csEI5JqsjgAgiaoQzq1mTcqopfTT7i.', '2025-05-10 05:37:18', 'admin', NULL),
(119, 'admin', '$2y$10$Fe3GsZvDlXGEPFzGHoowv./nG8BVxQ0OSkzSd.pHrb/DpkfHjuioG', '2025-05-10 05:37:19', 'admin', NULL),
(120, 'admin', '$2y$10$MgW.vXCG.fr7QL/skCXFc.1xNZlVmZQdCDm72OC1982kGOA6kJwhq', '2025-05-10 05:37:33', 'admin', NULL),
(121, 'admin', '$2y$10$4jwClgrYHfHA5neOIMyqEuVwrZ5IfUyOdyudyy7keIzoP.3C5AQsm', '2025-05-10 05:37:36', 'admin', NULL),
(122, 'admin', '$2y$10$iFcB2MS0RvE/Mdcrzx63dez.TOaCbSCqpHayQc2yBSCmtdLnC.RX6', '2025-05-10 05:37:36', 'admin', NULL),
(123, 'admin', '$2y$10$k8W/xxHwWF8zJZAj.YvWiOOuKRS/QsfirIudbSBwpLAixUW.iF8L.', '2025-05-10 05:45:12', 'admin', NULL),
(124, 'admin', '$2y$10$FL.xtTqZXxdA3DPe8Ei.5.eI5TOMOIKTWg1X5QaqHRD1iLiDEnFPi', '2025-05-10 05:55:14', 'admin', NULL),
(125, 'admin', '$2y$10$S9Pdz7fgD7.B2asvTLlk8.YCPnUqyZB3Gko0sDWsLu8wSt5NA6ryu', '2025-05-10 05:58:36', 'admin', NULL),
(126, 'admin', '$2y$10$M4RA0iukgp4sPYSsNrf8xOOiu3/7DWN2W6QQC.hvg/WNyzORPGlim', '2025-05-10 06:00:30', 'admin', NULL),
(127, 'admin', '$2y$10$nIXEEViTdhxyjXiIrTpm6.0qwwS20541CKNzyytAeysg9d5Vg9dwm', '2025-05-10 06:00:30', 'admin', NULL),
(128, 'admin', '$2y$10$XsQw9IBMHJ25sggQ2aE8tu2pRfU9urDeOOIwB1gpNALOw23kosspG', '2025-05-10 06:03:04', 'admin', NULL),
(129, 'admin', '$2y$10$ZKxelJC5BWp0XpQHUtdMRO853RPDSfbBB.WyHXb8eg6L/Phv0eWq2', '2025-05-10 06:11:31', 'admin', NULL),
(130, 'admin', '$2y$10$zJEL79G7BjTSa//r36gbD.rnPikcHtOsZvpWWrqWyx3cX12uTPUOK', '2025-05-10 06:11:32', 'admin', NULL),
(131, 'admin', '$2y$10$uEJxJ20n3cQhmR5R9nTGBeN.uMk3SyOrqgtJvQYWOq1s8WXzjsAaS', '2025-05-10 06:11:42', 'admin', NULL),
(132, 'admin', '$2y$10$morwUhgC.uS7ULl/vuwedO8v9Ir8tnZC1F/l2W4dTGBB.1M5gm7xu', '2025-05-10 06:11:54', 'admin', NULL),
(133, 'admin', '$2y$10$WyDP4/Xk2tZILthuF/5waOz.NRLCR8Z8NNS4pBUSqKdY98vNvBPTW', '2025-05-10 06:12:02', 'admin', NULL),
(134, 'admin', '$2y$10$qGZeYXM//KV1I15SyZo/J.5zlTGIT8yA//0Bsw1sC74ByC/ZB876u', '2025-05-10 06:12:04', 'admin', NULL),
(135, 'admin', '$2y$10$SIqwzbJAf42PkYBE.PlbNeB6B0sqb/FJq1pPWJy3WOWS/eshQDWeG', '2025-05-10 06:12:09', 'admin', NULL),
(136, 'admin', '$2y$10$fVCwjW3B92cSosKHz4x4HOYrQsX0OVSkIGLRcTEX8emvn1SyLlXRW', '2025-05-10 06:14:29', 'admin', NULL),
(137, 'admin', '$2y$10$JXRXRH/2KWL5mxmG2zX9TewyVOd17nbqcN.nGZaLhQs1uRBOvjEqG', '2025-05-10 06:14:34', 'admin', NULL),
(138, 'admin', '$2y$10$1ib0Dv9QenjkmdVKMJCvXeF7Px3GTRLlN297jJ6XCwJSrtKxajcfe', '2025-05-10 06:14:34', 'admin', NULL),
(139, 'admin', '$2y$10$7QFr9jye.dhm83RaJ.98/uMexrN0EPI7VDkQFbMkGmKiDzZ51qZBS', '2025-05-10 06:14:39', 'admin', NULL),
(140, 'admin', '$2y$10$ITbftwPvhwgLYsVrKOdTqOh6Z4vRnywn8szXJpqF7i4BnwPkF2nIS', '2025-05-10 06:14:52', 'admin', NULL),
(141, 'admin', '$2y$10$euiB3S3U7ePKG/emqnhD/.T6Z.Q./svVqG.045M/5GhBQAW798YpS', '2025-05-10 06:14:57', 'admin', NULL),
(142, 'admin', '$2y$10$OWiyp4Bcopx.oCM85m.G4uNIKtcpg1B2sYN7eRh3po9l2YoebEiny', '2025-05-10 06:15:05', 'admin', NULL),
(143, 'testing', '$2y$10$cv1msneAcV1Bcq4DpAwPEO7eVala3nVCnbl6yt/1fH86KunHTnIve', '2025-05-10 06:15:06', 'ched', NULL),
(144, 'admin', '$2y$10$BEpqOpt7QcuaBlKmRIUEuuKppyveAKY7d9CqXUIUwPwbErMhYLGMa', '2025-05-10 06:15:09', 'admin', NULL),
(145, 'admin', '$2y$10$lYfMZxWW367lEDtJSPw67.O8uW0nOuczTWxV3cs3aHzaYZLkhiFyO', '2025-05-10 06:15:13', 'admin', NULL),
(146, 'admin', '$2y$10$Mmf3gLtlJhMDJhg0LaMioOjxOsZK2yfiKPGLSP2eUMxg9SkOAItKe', '2025-05-10 06:15:23', 'admin', NULL),
(147, 'admin', '$2y$10$59CGfCjmNLT1MdOpgSenaO2VabUe51OB8fTpggqC2I8sQho67OWY6', '2025-05-10 06:15:27', 'admin', NULL),
(148, 'admin', '$2y$10$lSjKLV58j.wHBd1az7kBsenPVVVQbqcxmc7wUZECrwV4W06EbvLSe', '2025-05-10 06:16:25', 'admin', NULL),
(149, 'admin', '$2y$10$FHr./zu9ULu36S7P52UL2ebfGxR1HIYoKeE0XWQkfhDmHtISf980u', '2025-05-10 06:19:01', 'admin', NULL),
(150, 'admin', '$2y$10$O0572yiSRgs/4LdHgviVhu1caSZDjpa1RPIPhLZKcOe1NoUsyoYGO', '2025-05-10 06:19:11', 'admin', NULL),
(151, 'admin', '$2y$10$jm9xrk5hyu3Fd9lE3ElepetBZUyyOvpD5FUVbsHwI8JLiVRpZF3ve', '2025-05-10 06:19:11', 'admin', NULL),
(152, 'admin', '$2y$10$aHcLQVHALhzZXymyFZgiI.uYaR.aV0bNDyyl4sRzOn5cLPiMKOFZe', '2025-05-10 06:19:22', 'admin', NULL),
(153, 'admin', '$2y$10$YSW1srbFk/Dq6Q7gi7BLK.SCQJnFK1PUcJ4YwYRt5fLndVIi07oBK', '2025-05-10 06:19:30', 'admin', NULL),
(154, 'admin', '$2y$10$krL2Kd4NU0/jkVA6sRxvu.cdojEN7jOVoJyD0C9mb2UbDcLJhQCXy', '2025-05-10 06:20:27', 'admin', NULL),
(155, 'admin', '$2y$10$RTkImu1kREuiKcyNDK5R8uFr7PCllnm9JTqQvJRamtJYeOrh9RhX2', '2025-05-10 06:20:32', 'admin', NULL),
(156, 'admin', '$2y$10$rNkaxnR4GdznPVdAEqe2f.NlSUutt324Rdeh2Rm0FpxPqC4Gh5aFy', '2025-05-10 06:20:33', 'admin', NULL),
(157, 'admin', '$2y$10$CBE8qoWDTvSGXyf5J5UbeO/BEPQ.39BdEIeO7QkN.FT8uLG1XeFpO', '2025-05-10 06:20:36', 'admin', NULL),
(158, 'admin', '$2y$10$7ojhhHPvtpmyQec2kHZ3m./uBa5Akh8lFecUprUxpT9arkPZyxToO', '2025-05-10 06:22:40', 'admin', NULL),
(159, 'admin', '$2y$10$2GNvODvZHdgM7PZnnzA/tO/p.u/NJn3acY.sklFzYNlGcOZCoMw22', '2025-05-10 06:22:40', 'admin', NULL),
(160, 'admin', '$2y$10$StyHwnvq543wlIOev0LzZuarIIH6y.WIUBYmKnmzj1a5ehtVdCwjq', '2025-05-10 06:22:42', 'admin', NULL),
(161, 'admin', '$2y$10$ffMiT.ZG63o0zy4y9.gnFOi4nDzB6AP4IYRydcg7kI/ySJT1RqFJG', '2025-05-10 06:22:47', 'admin', NULL),
(162, 'admin', '$2y$10$UR9UWDvcB0UNqBMGjerBs.89SzjCq5GTXm6rLgImkX1b/p62jlniS', '2025-05-10 06:22:48', 'admin', NULL),
(163, 'admin', '$2y$10$mxUnV8bey7vD5kxVO2TYHu9uo8ntVDGQMgxEx.b.rKWPPcQ071NC.', '2025-05-10 06:22:51', 'admin', NULL),
(164, 'admin', '$2y$10$d7SCZKS749e4NgfXgl6iTuzKj3onTDA1srTs77zzCaqjRRN5VYkea', '2025-05-10 06:22:54', 'admin', NULL),
(165, 'admin', '$2y$10$8zpFAbYFnapueME8bARxQO3bqKMEKMaZHEIEgWiVBP/17jcAQJciO', '2025-05-10 06:23:05', 'admin', NULL),
(166, 'staff', '$2y$10$.gOV9IPSZFqMtEmFsh9czeiPNDxocDQC75CiIwWTUzpf2dQeizqWu', '2025-05-10 06:23:05', 'staff', NULL),
(167, 'admin', '$2y$10$JEOZwuFOo2oZQmeHkwtN/e.T3T3o6DDZP/.DydK/pqFLlRkCEc2k.', '2025-05-10 06:23:09', 'admin', NULL),
(168, 'admin', '$2y$10$gzu0EK/VRLwNz3VpuiETh.Okop9eXi3QCnViYQSuIzp9Bj9KBPfsC', '2025-05-10 06:24:26', 'admin', NULL),
(169, 'Eyacuasay', '$2y$10$IkFeq./PpyXd7C.ZDHN.LePORQ7LcGecXYOigXM.gL/E71miaxHJK', '2025-05-12 23:13:40', 'staff', NULL),
(170, 'Nicole', '$2y$10$EeS8E10oNxcTOffS4//0reg5mgkM4tn8ndnE5kA.LdKtrULFir/ZK', '2025-05-13 02:59:01', 'ched', NULL),
(171, 'SolaboJ001', '$2y$10$Z1TcrIpHSgWEr/MDrcv3..M1A72XtuRaq9evhtj9aO6FjiahwQI7a', '2025-05-19 06:46:10', 'staff', NULL),
(172, 'eya', '$2y$10$nctfLL9TLNO2iGU/racWaeY3CoyTIoN5VpWMc3L1qQ9dFUP.tltci', '2025-05-24 03:42:25', 'student', NULL),
(175, 'Maria', '$2y$10$yAmzm7L/Mk7L8DiHTqojQ.14LnTl9NCU7Lg/oqdr9Pb4HEi5tJNAS', '2025-05-24 11:17:04', 'student', NULL),
(176, 'ressamelchor', '$2y$10$rqa1bnQNQKklPcL4AlmfweYG634n/TfaUeDlND9c0kVjlccDJt.Y.', '2025-05-29 03:11:40', 'student', 'Ressa M. Melchor'),
(177, 'Juanitomelchor', '$2y$10$Wv0lTtdoSqmpimB5WIiYuu7Vto6onnxyPRKDe./IcXYsroqzp.b.q', '2025-05-29 04:36:47', 'staff', NULL),
(178, 'Ressaburgos', '$2y$10$kNEBpcvhEvHpGe.AJMiGaeuV1KGaHBqRvo2id8ADtld9EewpLOwd2', '2025-05-29 04:37:13', 'ched', NULL),
(179, 'inalabiano', '$2y$10$sblYJ./LQ.j/B32cudQBJel2FzmYU4fyXuJblXQIA2lcLz9xtqFWi', '2025-05-29 04:43:40', 'ched', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship_posts`
--
ALTER TABLE `scholarship_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scholarship_posts`
--
ALTER TABLE `scholarship_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
