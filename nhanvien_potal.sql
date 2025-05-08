-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 04:37 AM
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
-- Database: `nhanvien_potal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `status` enum('draft','approved','rejected') DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `result` enum('pending','passed','failed') DEFAULT NULL,
  `applied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `contract_code` varchar(50) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `contract_type_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_types`
--

CREATE TABLE `contract_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract_types`
--

INSERT INTO `contract_types` (`id`, `name`) VALUES
(1, 'Thử việc'),
(2, '6 tháng'),
(3, '1 năm'),
(4, '2 năm'),
(5, '3 năm'),
(6, 'Không thời hạn');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `tax_code` varchar(50) DEFAULT NULL,
  `family_city` varchar(100) DEFAULT NULL,
  `personal_city` varchar(100) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `id_type` varchar(50) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `passport_number` varchar(50) DEFAULT NULL,
  `passport_issue_date` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `relative_phone` varchar(20) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `other_email` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `zalo` varchar(100) DEFAULT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `other_contact` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `household_number` varchar(50) DEFAULT NULL,
  `family_id` varchar(50) DEFAULT NULL,
  `is_householder` tinyint(1) DEFAULT 0,
  `father_name` varchar(100) DEFAULT NULL,
  `father_birth` int(11) DEFAULT NULL,
  `father_job` varchar(100) DEFAULT NULL,
  `father_phone` varchar(20) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_birth` int(11) DEFAULT NULL,
  `mother_job` varchar(100) DEFAULT NULL,
  `mother_phone` varchar(20) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `spouse_birth` int(11) DEFAULT NULL,
  `spouse_job` varchar(100) DEFAULT NULL,
  `spouse_phone` varchar(20) DEFAULT NULL,
  `child_name` varchar(100) DEFAULT NULL,
  `child_birth` int(11) DEFAULT NULL,
  `child_school` varchar(100) DEFAULT NULL,
  `sibling_name` varchar(100) DEFAULT NULL,
  `sibling_birth` int(11) DEFAULT NULL,
  `sibling_job` varchar(100) DEFAULT NULL,
  `sibling_phone` varchar(20) DEFAULT NULL,
  `political_party` text DEFAULT NULL,
  `political_position` text DEFAULT NULL,
  `military_service` text DEFAULT NULL,
  `military_education` text DEFAULT NULL,
  `health_insurance` varchar(100) DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `vaccine_type` varchar(100) DEFAULT NULL,
  `vaccine_date` date DEFAULT NULL,
  `vaccine_doses` int(11) DEFAULT NULL,
  `vaccine_location` varchar(100) DEFAULT NULL,
  `vaccine_note` text DEFAULT NULL,
  `uniform_date` date DEFAULT NULL,
  `uniform_type` varchar(100) DEFAULT NULL,
  `uniform_quantity` int(11) DEFAULT NULL,
  `work_process` text DEFAULT NULL,
  `concurrent_duty` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `employee_type` enum('internal','external') DEFAULT 'internal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `full_name`, `gender`, `dob`, `place_of_birth`, `hometown`, `marital_status`, `tax_code`, `family_city`, `personal_city`, `religion`, `nationality`, `id_type`, `id_number`, `passport_number`, `passport_issue_date`, `phone`, `company_phone`, `relative_phone`, `personal_email`, `company_email`, `other_email`, `facebook`, `zalo`, `tiktok`, `other_contact`, `country`, `province`, `district`, `ward`, `address`, `household_number`, `family_id`, `is_householder`, `father_name`, `father_birth`, `father_job`, `father_phone`, `mother_name`, `mother_birth`, `mother_job`, `mother_phone`, `spouse_name`, `spouse_birth`, `spouse_job`, `spouse_phone`, `child_name`, `child_birth`, `child_school`, `sibling_name`, `sibling_birth`, `sibling_job`, `sibling_phone`, `political_party`, `political_position`, `military_service`, `military_education`, `health_insurance`, `medical_history`, `vaccine_type`, `vaccine_date`, `vaccine_doses`, `vaccine_location`, `vaccine_note`, `uniform_date`, `uniform_type`, `uniform_quantity`, `work_process`, `concurrent_duty`, `email`, `position`, `department_id`, `join_date`, `employee_type`) VALUES
(31, 'NV001', 'Nguyễn Văn An', 'male', '1995-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0901000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vana@gmail.com', 'Kỹ sư', NULL, '2022-01-01', 'internal'),
(32, 'MT002', 'Trần Thị Hoa', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0918842217', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thihoa@gmail.com', 'Nhân viên hành chính', NULL, '2019-03-15', 'internal'),
(33, 'MT003', 'Lê Văn Nam', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0816647726', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vannam@gmail.com', 'Quản lý dự án', NULL, '2020-08-01', 'internal'),
(34, 'MT004', 'Phạm Thị Anh', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0945576145', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thianh@gmail.com', 'Kế toán viên', NULL, '2020-05-10', 'internal'),
(35, 'MT005', 'Hoàng Văn Hiền', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '08821133645', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vanhien@gmail.com', 'Lập trình viên', NULL, '2021-11-01', 'internal'),
(36, 'MT006', 'Đặng Thị Lài', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0911875467', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thilai@gmail.com', 'Nhân viên Marketing', NULL, '2021-02-20', 'internal'),
(37, 'MT007', 'Ngô Văn Bình', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0812217723', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vanbinh@gmail.com', 'Nhân viên Marketing', NULL, '2022-01-05', 'internal'),
(38, 'MT008', 'Bùi Thị Hà', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0921145569', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thiha@gmail.com', 'Nhân viên nhân sự', NULL, '2022-06-15', 'internal'),
(39, 'MT009', 'Võ Văn Hoàng', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0938875517', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vanhoang@gmail.com', 'Chuyên viên tư vấn', NULL, '2022-01-01', 'internal'),
(40, 'MT010', 'Phan Thị Huyền', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0815547125', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thihuyen@gmail.com', 'Chuyên viên tư vấn', NULL, '2023-09-01', 'internal');

-- --------------------------------------------------------

--
-- Table structure for table `family_members`
--

CREATE TABLE `family_members` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `birth_year` int(11) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('scheduled','confirmed','cancelled') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_requests`
--

CREATE TABLE `recruitment_requests` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'employee',
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `employee_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `role`, `status`, `created_at`, `employee_id`, `full_name`) VALUES
(1, 'MT001', 'vanlinh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'avatar_1746669827_1.png', 'employee', 1, '2025-05-08 08:57:27', 1, NULL),
(2, 'MT002', 'thihoa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 2, NULL),
(3, 'MT003', 'vannam@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 3, NULL),
(4, 'MT004', 'thianh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 4, NULL),
(5, 'MT005', 'vanhien@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 5, NULL),
(6, 'MT006', 'thilai@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 6, NULL),
(7, 'MT007', 'vanbinh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 7, NULL),
(8, 'MT008', 'thiha@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 8, NULL),
(9, 'MT009', 'vanhoang@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 9, NULL),
(10, 'MT010', 'thihuyen@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'employee', 1, '2025-05-08 08:57:27', 10, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `contract_type_id` (`contract_type_id`);

--
-- Indexes for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_members`
--
ALTER TABLE `family_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recruitment_requests`
--
ALTER TABLE `recruitment_requests`
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
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_types`
--
ALTER TABLE `contract_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `family_members`
--
ALTER TABLE `family_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recruitment_requests`
--
ALTER TABLE `recruitment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`contract_type_id`) REFERENCES `contract_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
