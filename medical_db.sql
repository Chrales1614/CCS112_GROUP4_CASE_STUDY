-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 03:40 PM
-- Server version: 8.0.40
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` text NOT NULL,
  `phone_primary` varchar(20) NOT NULL,
  `phone_alternate` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `dob`, `gender`, `address`, `phone_primary`, `phone_alternate`, `email`) VALUES
(2, 'Renelyn Concina', '2025-03-08', 'female', 'Dummy Street', '09932123123', '09932123234', 'renelynconcina@gmail.com'),
(3, 'Hans Consuelo', '2025-02-27', 'male', 'Dummy Street', '09932123123', '09932123234', 'hansconsuelo@gmail.com'),
(4, 'Jude DelRosario', '2025-02-19', 'male', 'Dummy Street', '09932123123', '09932123234', 'judedelrosario@gmail.com'),
(5, 'Charles Delgado', '2003-12-27', 'male', 'Dummy Street', '09932123123', '09932123234', 'charlesallendelgado@gmail.com'),
(6, 'Princess Duran', '2025-01-28', 'female', 'Dummy Street', '09932123123', '09932123234', 'princessduran@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `soap_notes`
--

CREATE TABLE `soap_notes` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `date_of_visit` date NOT NULL,
  `chief_complaint` text NOT NULL,
  `history_present_illness` text NOT NULL,
  `past_medical_history` text,
  `family_history` text,
  `social_history` text,
  `review_of_systems` text,
  `temperature` decimal(5,2) DEFAULT NULL,
  `blood_pressure` varchar(10) DEFAULT NULL,
  `heart_rate` int DEFAULT NULL,
  `respiratory_rate` int DEFAULT NULL,
  `physical_exam_findings` text,
  `lab_results` text,
  `imaging_results` text,
  `primary_diagnosis` text,
  `differential_diagnosis` text,
  `medications_prescribed` text,
  `additional_tests` text,
  `referrals` text,
  `patient_instructions` text,
  `follow_up_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `soap_notes`
--

INSERT INTO `soap_notes` (`id`, `patient_id`, `patient_name`, `date_of_visit`, `chief_complaint`, `history_present_illness`, `past_medical_history`, `family_history`, `social_history`, `review_of_systems`, `temperature`, `blood_pressure`, `heart_rate`, `respiratory_rate`, `physical_exam_findings`, `lab_results`, `imaging_results`, `primary_diagnosis`, `differential_diagnosis`, `medications_prescribed`, `additional_tests`, `referrals`, `patient_instructions`, `follow_up_date`, `created_at`) VALUES
(2, 3, 'Hans', '2025-02-25', 'Dry Cough', 'Experiencing a persistent dry cough for the past 10 days. The cough is worse at night and is not associated with fever or chest pain. No history of recent travel or sick contacts.', 'Asthma', 'Father has hypertension; Mother has no known medical conditions.', 'Non-smoker, occasional alcohol consumption, works in an office setting with frequent exposure to air conditioning.', 'General: No weight loss, fever, or fatigue', 98.40, '118/78', 76, 18, 'Lungs clear to auscultation bilaterally, no wheezing or crackles.', 'CBC: Normal\r\nCRP: Normal', 'Chest X-ray: No abnormalities detected', 'Upper Respiratory Tract Infection (Viral)', 'Post-viral cough', 'Cetirizine 10mg once daily for 5 days', 'Allergy testing if symptoms persist', 'Pulmonologist if symptoms persist beyond 4 weeks', 'Stay hydrated and avoid cold drinks.\r\nUse a humidifier at home if air is too dry.\r\nAvoid exposure to dust and allergens.\r\nFollow up if cough persists or worsens.', '2025-03-04', '2025-02-25 14:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'delgadocharles1614@gmail.com', '$2y$10$BenkVFKaTLHS61GWLWbIR.29TDuBsZ7iyS2ZdwWZC2b07sB/XvcIW'),
(2, 'charlesallendelgado@gmail.com', '$2y$10$DvutUEfgwyAg6.4cFo.0Q.s3WjUZYqK7VEbunwwRTJiDXBKbhsGXW'),
(3, 'marloninocencio36@gmail.com', '$2y$10$c82pGP.LE05ilRCFICwk9OMrkchrQHuPGrKILYImNOjUjWc52TxUi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `soap_notes`
--
ALTER TABLE `soap_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `soap_notes`
--
ALTER TABLE `soap_notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `soap_notes`
--
ALTER TABLE `soap_notes`
  ADD CONSTRAINT `soap_notes_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
