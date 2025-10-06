-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2025 at 10:01 PM
-- Server version: 8.0.43
-- PHP Version: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keralaTourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$sQGkPoY5FNRNynC9VoKAS.p2e0WJ7dFt4W.hRoqnDSN3S5nzERvGC', '2025-09-28 05:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `spot_id` int NOT NULL,
  `district_id` int NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `spot_id`, `district_id`, `visit_date`, `visit_time`, `status`, `created_at`) VALUES
(2, 1, 57, 14, '2025-09-13', '22:17:00', 'pending', '2025-09-10 16:52:11'),
(3, 1, 57, 14, '2025-09-11', '22:44:00', 'pending', '2025-09-10 17:13:57'),
(4, 1, 46, 11, '2025-09-11', '22:46:00', 'pending', '2025-09-10 17:14:30'),
(5, 1, 15, 3, '2025-09-12', '22:42:00', 'pending', '2025-09-11 17:11:09'),
(6, 2, 26, 6, '2025-09-28', '13:49:00', 'pending', '2025-09-13 08:18:12'),
(7, 3, 13, 3, '2025-09-21', '12:42:00', 'pending', '2025-09-14 07:09:53'),
(8, 5, 13, 3, '2025-09-25', '10:49:00', 'pending', '2025-09-24 05:16:25'),
(9, 5, 10, 2, '2025-09-28', '10:59:00', 'pending', '2025-09-24 05:25:19'),
(10, 6, 21, 5, '2025-09-30', '14:12:00', 'pending', '2025-09-24 05:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `first_name`, `last_name`, `email`, `mobile`, `message`, `created_at`) VALUES
(2, 1, 'ROHIT', 'mathew', 'akdmuralimk@gmail.com', '9999999999', 'test', '2025-09-10 17:26:23'),
(4, 5, 'Rahul', 'Krishna', 'unnimon3812@gmail.com', '9999999999', 'test', '2025-09-24 05:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `image`, `description`) VALUES
(1, 'Thiruvananthapuram', 'thiruvananthapuram.jpg', 'Capital city of Kerala, Thiruvananthapuram is famous for Kovalam Beach, Sree Padmanabhaswamy Temple, Napier Museum, and rich cultural heritage. It is also a hub of Ayurveda, historic monuments, and natural beauty.'),
(2, 'Kollam', 'kollam.jpg', 'Kollam, known as the gateway to Kerala’s backwaters, is famous for Ashtamudi Lake, cashew processing, Neendakara Port, and Thangassery Lighthouse. It is also a historic center for trade with a vibrant coastal culture.'),
(3, 'Pathanamthitta', 'pathanamthitta.jpg', 'Pathanamthitta is known as the pilgrimage capital of Kerala, home to the famous Sabarimala Temple, Perunthenaruvi Waterfalls, and Gavi eco-tourism. It is surrounded by forests, rivers, and hill ranges.'),
(4, 'Alappuzha', 'alappuzha.jpg', 'Alappuzha, often called the “Venice of the East,” is world famous for its houseboat cruises along the backwaters, Alappuzha Beach, Nehru Trophy Boat Race, and coir industry.'),
(5, 'Kottayam', 'kottayam.jpg', 'Kottayam, known as the land of letters, latex, and lakes, is a hub of education and publishing. It is surrounded by Vembanad Lake, Kumarakom Bird Sanctuary, rubber plantations, and churches with historic significance.'),
(6, 'Idukki', 'idukki.jpg', 'Idukki is a hilly and forest-rich district, home to Periyar Tiger Reserve, Idukki Arch Dam, Munnar hill station, and numerous waterfalls. It is famous for tea, coffee, spices, and eco-tourism.'),
(7, 'Ernakulam', 'ernakulam.jpg', 'Ernakulam is the commercial capital of Kerala, housing Kochi city. Known for Fort Kochi, Chinese fishing nets, Mattancherry Palace, Marine Drive, and modern IT hubs. It is a blend of history, trade, and cosmopolitan life.'),
(8, 'Thrissur', 'thrissur.jpg', 'Thrissur, the cultural capital of Kerala, is famous for Thrissur Pooram festival, Vadakkumnathan Temple, Kerala Kalamandalam, and Athirappilly Waterfalls. It is also a hub of classical arts and traditions.'),
(9, 'Palakkad', 'palakkad.jpg', 'Palakkad, known as the granary of Kerala, is famous for its lush paddy fields, Palakkad Fort, Silent Valley National Park, Malampuzha Dam, and scenic Western Ghats passes like Palakkad Gap.'),
(10, 'Malappuram', 'malappuram.jpg', 'Malappuram is rich in cultural heritage, mosques, and festivals. Famous for Kottakkunnu Park, Teak Museum, Nilambur forests, and its strong football culture, it is a blend of history and natural beauty.'),
(11, 'Kozhikode', 'kozhikode.jpg', 'Kozhikode, formerly known as Calicut, is famous for Kappad Beach where Vasco da Gama landed, Kozhikode sweets like halwa, Beypore Port, and spice markets. It has a glorious history in trade and culture.'),
(12, 'Wayanad', 'wayanad.jpg', 'Wayanad is a scenic hill district famous for Edakkal Caves, Soochipara Waterfalls, Banasura Sagar Dam, Wayanad Wildlife Sanctuary, and tea-coffee plantations. It is rich in tribal heritage and eco-tourism.'),
(13, 'Kannur', 'kannur.jpg', 'Kannur, also called the land of looms and lore, is famous for Theyyam performances, Payyambalam Beach, St. Angelo Fort, Muzhappilangad Drive-in Beach, and handloom industry.'),
(14, 'Kasaragod', 'kasargod.jpg', 'Kasargod, at the northern tip of Kerala, is known for Bekal Fort, Ananthapura Lake Temple, Chandragiri Fort, and multilingual culture blending Malayalam, Tulu, and Kannada. It is rich in history and coastal beauty.');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_services`
--

CREATE TABLE `emergency_services` (
  `id` int NOT NULL,
  `district_id` int NOT NULL,
  `type` enum('Hospital','Fire & Rescue','Ham Radio','Elephant Squad','Police','Ambulance','Coast Guard') NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` text,
  `image` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `emergency_services`
--

INSERT INTO `emergency_services` (`id`, `district_id`, `type`, `name`, `contact`, `address`, `image`, `description`) VALUES
(1, 1, 'Hospital', 'Medical College Hospital', '0471-2528300', 'Medical College P.O, Thiruvananthapuram', 'thiruvananthapuram_hospital.jpg', 'One of the largest government hospitals in Kerala with multi-specialty care.'),
(2, 7, 'Hospital', 'Ernakulam General Hospital', '0484-2351954', 'Hospital Road, Kochi, Ernakulam', 'ernakulam_hospital.jpg', 'Major referral hospital serving Ernakulam district.'),
(3, 1, 'Fire & Rescue', 'Thiruvananthapuram Fire Station', '0471-2322100', 'Overbridge Junction, Thiruvananthapuram', 'thiruvananthapuram_fire_&_rescue.jpg', 'Quick response team for fire and rescue operations.'),
(4, 8, 'Fire & Rescue', 'Thrissur Fire Station', '0487-2331444', 'M.G. Road, Thrissur', 'thrissur_fire_&_rescue.jpg', 'Emergency fire fighting and disaster response team.'),
(5, 2, 'Ham Radio', 'Kollam Amateur Radio Society', '9447001122', 'Beach Road, Kollam', 'kollam_ham_radio.jpg', 'Volunteer HAM radio operators assisting during natural calamities.'),
(6, 12, 'Ham Radio', 'Wayanad Disaster HAM Club', '9745001122', 'Kalpetta, Wayanad', 'wayanad_ham_radio.jpg', 'Provides emergency communication in remote hilly areas.'),
(7, 6, 'Elephant Squad', 'Idukki Elephant Rapid Response', '9446002211', 'Forest Division Office, Thekkady, Idukki', 'elephant_idukki.jpg', 'Trained squad for handling wild elephant conflict situations.'),
(8, 13, 'Elephant Squad', 'Kannur Elephant Squad', '9446004422', 'Kannur Forest Circle Office', 'elephant_kannur.jpg', 'Special team to manage human-elephant conflict zones.'),
(9, 1, 'Police', 'Thiruvananthapuram City Police Control Room', '100', 'Vazhuthacaud, Thiruvananthapuram', 'thiruvananthapuram_police.jpg', '24/7 police control room for law and order.'),
(10, 11, 'Police', 'Kozhikode City Police Headquarters', '100', 'YMCA Cross Road, Kozhikode', 'kozhikode_police.jpg', 'Handles emergency law enforcement and crowd management.'),
(11, 3, 'Ambulance', 'Pathanamthitta Emergency Ambulance Service', '108', 'Central Junction, Pathanamthitta', 'pathanamthitta_ambulance.jpg', '24/7 government ambulance service with trained paramedics.'),
(12, 14, 'Ambulance', 'Kasargod Trauma Ambulance Unit', '108', 'Near Govt. District Hospital, Kasargod', 'kasaragod_ambulance.jpg', 'Rapid response ambulance for accident and trauma care.'),
(13, 7, 'Coast Guard', 'Cochin Coast Guard Station', '0484-2662123', 'Fort Kochi, Ernakulam', 'coastguard_kochi.jpg', 'Indian Coast Guard base providing maritime security and rescue.'),
(14, 2, 'Coast Guard', 'Kollam Coast Guard Unit', '0474-2761123', 'Port Area, Kollam', 'coastguard_kollam.jpg', 'Coastal rescue operations and patrolling for Kollam district.'),
(16, 1, 'Fire & Rescue', 'Fire Station Thiruvananthapuram', '101', 'PMG, Thiruvananthapuram', 'thiruvananthapuram_fire_&_rescue.jpg', 'Emergency fire and rescue services.'),
(17, 1, 'Police', 'Museum Police Station', '0471-2320564', 'Vellayambalam, Thiruvananthapuram', 'thiruvananthapuram_police.jpg', 'City police station ensuring law and order.'),
(18, 1, 'Ambulance', '108 Ambulance Service', '108', 'Available across Thiruvananthapuram', 'thiruvananthapuram_ambulance.jpg', '24/7 ambulance emergency response.'),
(19, 1, 'Ham Radio', 'Kerala Amateur Radio Club', '0471-2334567', 'Vazhuthacaud, Thiruvananthapuram', 'thiruvananthapuram_ham_radio.jpg', 'Emergency ham radio communication support.'),
(20, 2, 'Hospital', 'District Hospital Kollam', '0474-2741321', 'Anchalumoodu, Kollam', 'kollam_hospital.jpg', 'District-level multispecialty hospital.'),
(21, 2, 'Fire & Rescue', 'Kollam Fire Station', '101', 'Chinnakada, Kollam', 'kollam_fire_&_rescue.jpg', 'Fire and rescue service station.'),
(22, 2, 'Police', 'Kollam East Police Station', '0474-2762456', 'Chinnakada, Kollam', 'kollam_police.jpg', 'Police station for Kollam city region.'),
(23, 2, 'Ambulance', '108 Ambulance Service Kollam', '108', 'Across Kollam', 'kollam_ambulance.jpg', '24/7 ambulance support for emergencies.'),
(24, 2, 'Ham Radio', 'Kollam Ham Radio Club', '0474-2728391', 'Kadappakada, Kollam', 'kollam_ham_radio.jpg', 'Ham radio services for emergencies.'),
(25, 3, 'Hospital', 'General Hospital Pathanamthitta', '0468-2222221', 'Near Civil Station, Pathanamthitta', 'pathanamthitta_hospital.jpg', 'Government general hospital for the district.'),
(26, 3, 'Fire & Rescue', 'Fire Station Pathanamthitta', '101', 'Omalloor Road, Pathanamthitta', 'pathanamthitta_fire_&_rescue.jpg', 'Emergency fire services in the district.'),
(27, 3, 'Police', 'Pathanamthitta Police Station', '0468-2223232', 'Near KSRTC Bus Stand, Pathanamthitta', 'pathanamthitta_police.jpg', 'Police station for district HQ.'),
(28, 3, 'Ambulance', '108 Ambulance Service Pathanamthitta', '108', 'Across Pathanamthitta', 'pathanamthitta_ambulance.jpg', '24/7 ambulance support.'),
(29, 3, 'Ham Radio', 'Pathanamthitta Ham Club', '0468-2256789', 'Adoor Road, Pathanamthitta', 'pathanamthitta_ham_radio.jpg', 'Ham radio for disaster support.'),
(30, 4, 'Hospital', 'Alappuzha District Hospital', '0477-2254321', 'Hospital Road, Alappuzha', 'alappuzha_hospital.jpg', 'Major district hospital with emergency services.'),
(31, 4, 'Fire & Rescue', 'Alappuzha Fire Station', '101', 'Near Boat Jetty, Alappuzha', 'alappuzha_fire_&_rescue.jpg', 'Fire and rescue support in the district.'),
(32, 4, 'Police', 'Alappuzha Town Police Station', '0477-2233445', 'Town Center, Alappuzha', 'alappuzha_police.jpg', 'Police station ensuring law and order.'),
(33, 4, 'Ambulance', '108 Ambulance Service Alappuzha', '108', 'Across Alappuzha', 'alappuzha_ambulance.jpg', 'Emergency ambulance services 24/7.'),
(34, 4, 'Ham Radio', 'Alappuzha Ham Club', '0477-2265432', 'Near Alappuzha Beach', 'alappuzha_ham_radio.jpg', 'Ham radio communication for emergencies.'),
(35, 5, 'Hospital', 'Kottayam General Hospital', '0481-2567890', 'Medical College Road, Kottayam', 'kottayam_hospital.jpg', 'Government hospital for general and emergency cases.'),
(36, 5, 'Fire & Rescue', 'Kottayam Fire Station', '101', 'Town Center, Kottayam', 'kottayam_fire_&_rescue.jpg', 'Emergency fire and rescue services.'),
(37, 5, 'Police', 'Kottayam South Police Station', '0481-2345678', 'Near KSRTC, Kottayam', 'kottayam_police.jpg', 'City police station for Kottayam.'),
(38, 5, 'Ambulance', '108 Ambulance Service Kottayam', '108', 'Across Kottayam', 'kottayam_ambulance.jpg', '24/7 emergency ambulance.'),
(39, 5, 'Ham Radio', 'Kottayam Amateur Radio Club', '0481-2233445', 'Town Center, Kottayam', 'kottayam_ham_radio.jpg', 'Ham radio for emergency communication.'),
(40, 6, 'Hospital', 'Idukki District Hospital', '0486-2256789', 'Near Idukki Dam, Idukki', 'idukki_hospital.jpg', 'District hospital providing emergency services.'),
(41, 6, 'Fire & Rescue', 'Idukki Fire Station', '101', 'Town Center, Idukki', 'idukki_fire_&_rescue.jpg', 'Fire and rescue support for Idukki.'),
(42, 6, 'Police', 'Idukki Police Station', '0486-2345678', 'Idukki Town', 'idukki_police.jpg', 'Police station for law enforcement.'),
(43, 6, 'Ambulance', '108 Ambulance Service Idukki', '108', 'Across Idukki', 'idukki_ambulance.jpg', '24/7 emergency ambulance.'),
(44, 6, 'Ham Radio', 'Idukki Ham Club', '0486-2233445', 'Near Idukki Town', 'idukki_ham_radio.jpg', 'Ham radio for emergencies.'),
(45, 7, 'Hospital', 'Government Medical College Ernakulam', '0484-2345678', 'Kaloor, Ernakulam', 'ernakulam_hospital.jpg', 'Major government hospital.'),
(46, 7, 'Fire & Rescue', 'Ernakulam Fire Station', '101', 'MG Road, Ernakulam', 'ernakulam_fire_&_rescue.jpg', 'Fire and rescue emergency services.'),
(47, 7, 'Police', 'Ernakulam South Police Station', '0484-2233445', 'Ernakulam Town', 'ernakulam_police.jpg', 'City police station.'),
(48, 7, 'Ambulance', '108 Ambulance Service Ernakulam', '108', 'Across Ernakulam', 'ernakulam_ambulance.jpg', '24/7 ambulance services.'),
(49, 7, 'Ham Radio', 'Ernakulam Ham Club', '0484-2256789', 'Near Town Center', 'ernakulam_ham_radio.jpg', 'Ham radio support.'),
(50, 8, 'Hospital', 'Thrissur General Hospital', '0487-2345678', 'Town Center, Thrissur', 'thrissur_hospital.jpg', 'District hospital with emergency care.'),
(51, 8, 'Fire & Rescue', 'Thrissur Fire Station', '101', 'Near Swaraj Round, Thrissur', 'thrissur_fire_&_rescue.jpg', 'Emergency fire services.'),
(52, 8, 'Police', 'Thrissur Police Station', '0487-2233445', 'Thrissur Town', 'thrissur_police.jpg', 'City police station.'),
(53, 8, 'Ambulance', '108 Ambulance Service Thrissur', '108', 'Across Thrissur', 'thrissur_ambulance.jpg', '24/7 ambulance support.'),
(54, 8, 'Ham Radio', 'Thrissur Ham Club', '0487-2256789', 'Near Thrissur Town', 'thrissur_ham_radio.jpg', 'Ham radio for emergency situations.'),
(55, 9, 'Hospital', 'Palakkad District Hospital', '0491-2345678', 'Town Center, Palakkad', 'palakkad_hospital.jpg', 'District hospital with emergency services.'),
(56, 9, 'Fire & Rescue', 'Palakkad Fire Station', '101', 'Town Center, Palakkad', 'palakkad_fire_&_rescue.jpg', 'Emergency fire and rescue.'),
(57, 9, 'Police', 'Palakkad Police Station', '0491-2233445', 'Palakkad Town', 'palakkad_police.jpg', 'Police station.'),
(58, 9, 'Ambulance', '108 Ambulance Service Palakkad', '108', 'Across Palakkad', 'palakkad_ambulance.jpg', '24/7 ambulance services.'),
(59, 9, 'Ham Radio', 'Palakkad Ham Club', '0491-2256789', 'Near Town Center', 'palakkad_ham_radio.jpg', 'Ham radio support.'),
(61, 1, 'Fire & Rescue', 'Fire Station Thiruvananthapuram', '101', 'PMG, Thiruvananthapuram', 'thiruvananthapuram_fire_&_rescue.jpg', 'Emergency fire and rescue services.'),
(63, 1, 'Ambulance', '108 Ambulance Service', '108', 'Available across Thiruvananthapuram', 'thiruvananthapuram_ambulance.jpg', '24/7 ambulance emergency response.'),
(66, 2, 'Fire & Rescue', 'Kollam Fire Station', '101', 'Chinnakada, Kollam', 'kollam_fire_&_rescue.jpg', 'Fire and rescue service station.'),
(68, 2, 'Ambulance', '108 Ambulance Service Kollam', '108', 'Across Kollam', 'kollam_ambulance.jpg', '24/7 ambulance support for emergencies.'),
(71, 3, 'Fire & Rescue', 'Fire Station Pathanamthitta', '101', 'Omalloor Road, Pathanamthitta', 'pathanamthitta_fire_&_rescue.jpg', 'Emergency fire services in the district.'),
(73, 3, 'Ambulance', '108 Ambulance Service Pathanamthitta', '108', 'Across Pathanamthitta', 'pathanamthitta_ambulance.jpg', '24/7 ambulance support.'),
(76, 4, 'Fire & Rescue', 'Alappuzha Fire Station', '101', 'Near Boat Jetty, Alappuzha', 'alappuzha_fire_&_rescue.jpg', 'Fire and rescue support in the district.'),
(78, 4, 'Ambulance', '108 Ambulance Service Alappuzha', '108', 'Across Alappuzha', 'alappuzha_ambulance.jpg', 'Emergency ambulance services 24/7.'),
(81, 5, 'Fire & Rescue', 'Kottayam Fire Station', '101', 'Town Center, Kottayam', 'kottayam_fire_&_rescue.jpg', 'Emergency fire and rescue services.'),
(83, 5, 'Ambulance', '108 Ambulance Service Kottayam', '108', 'Across Kottayam', 'kottayam_ambulance.jpg', '24/7 emergency ambulance.'),
(86, 6, 'Fire & Rescue', 'Idukki Fire Station', '101', 'Town Center, Idukki', 'idukki_fire_&_rescue.jpg', 'Fire and rescue support for Idukki.'),
(88, 6, 'Ambulance', '108 Ambulance Service Idukki', '108', 'Across Idukki', 'idukki_ambulance.jpg', '24/7 emergency ambulance.'),
(91, 7, 'Fire & Rescue', 'Ernakulam Fire Station', '101', 'MG Road, Ernakulam', 'ernakulam_fire_&_rescue.jpg', 'Fire and rescue emergency services.'),
(93, 7, 'Ambulance', '108 Ambulance Service Ernakulam', '108', 'Across Ernakulam', 'ernakulam_ambulance.jpg', '24/7 ambulance services.'),
(96, 8, 'Fire & Rescue', 'Thrissur Fire Station', '101', 'Near Swaraj Round, Thrissur', 'thrissur_fire_&_rescue.jpg', 'Emergency fire services.'),
(98, 8, 'Ambulance', '108 Ambulance Service Thrissur', '108', 'Across Thrissur', 'thrissur_ambulance.jpg', '24/7 ambulance support.'),
(101, 9, 'Fire & Rescue', 'Palakkad Fire Station', '101', 'Town Center, Palakkad', 'palakkad_fire_&_rescue.jpg', 'Emergency fire and rescue.'),
(103, 9, 'Ambulance', '108 Ambulance Service Palakkad', '108', 'Across Palakkad', 'palakkad_ambulance.jpg', '24/7 ambulance services.'),
(105, 10, 'Hospital', 'Malappuram District Hospital', '0483-2345678', 'Town Center, Malappuram', 'malappuram_hospital.jpg', 'Emergency hospital services.'),
(106, 10, 'Fire & Rescue', 'Malappuram Fire Station', '101', 'Town Center, Malappuram', 'malappuram_fire_&_rescue.jpg', 'Fire and rescue service.'),
(107, 10, 'Police', 'Malappuram Police Station', '0483-2233445', 'Malappuram Town', 'malappuram_police.jpg', 'Police station.'),
(108, 10, 'Ambulance', '108 Ambulance Service Malappuram', '108', 'Across Malappuram', 'malappuram_ambulance.jpg', '24/7 ambulance services.'),
(109, 10, 'Ham Radio', 'Malappuram Ham Club', '0483-2256789', 'Near Town Center', 'malappuram_ham_radio.jpg', 'Ham radio for emergencies.'),
(110, 11, 'Hospital', 'Kozhikode Medical College', '0495-2345678', 'Kozhikode Town', 'kozhikode_hospital.jpg', 'Major hospital in Kozhikode.'),
(111, 11, 'Fire & Rescue', 'Kozhikode Fire Station', '101', 'Near Town Center, Kozhikode', 'kozhikode_fire_&_rescue.jpg', 'Fire and rescue services.'),
(112, 11, 'Police', 'Kozhikode Police Station', '0495-2233445', 'Kozhikode Town', 'kozhikode_police.jpg', 'City police station.'),
(113, 11, 'Ambulance', '108 Ambulance Service Kozhikode', '108', 'Across Kozhikode', 'kozhikode_ambulance.jpg', '24/7 ambulance support.'),
(114, 11, 'Ham Radio', 'Kozhikode Ham Club', '0495-2256789', 'Near Town Center', 'kozhikode_ham_radio.jpg', 'Ham radio services.'),
(115, 12, 'Hospital', 'Wayanad District Hospital', '04936-234567', 'Kalpetta, Wayanad', 'wayanad_hospital.jpg', 'Emergency hospital services.'),
(116, 12, 'Fire & Rescue', 'Wayanad Fire Station', '101', 'Kalpetta, Wayanad', 'wayanad_fire_&_rescue.jpg', 'Fire and rescue service.'),
(117, 12, 'Police', 'Wayanad Police Station', '04936-223344', 'Kalpetta Town', 'wayanad_police.jpg', 'District police station.'),
(118, 12, 'Ambulance', '108 Ambulance Service Wayanad', '108', 'Across Wayanad', 'wayanad_ambulance.jpg', '24/7 ambulance services.'),
(119, 12, 'Ham Radio', 'Wayanad Ham Club', '04936-225678', 'Near Kalpetta Town', 'wayanad_ham_radio.jpg', 'Ham radio for emergencies.'),
(120, 13, 'Hospital', 'Kannur District Hospital', '0497-2345678', 'Kannur Town', 'kannur_hospital.jpg', 'Emergency hospital services.'),
(121, 13, 'Fire & Rescue', 'Kannur Fire Station', '101', 'Kannur Town', 'kannur_fire_&_rescue.jpg', 'Fire and rescue services.'),
(122, 13, 'Police', 'Kannur Police Station', '0497-2233445', 'Kannur Town', 'kannur_police.jpg', 'City police station.'),
(123, 13, 'Ambulance', '108 Ambulance Service Kannur', '108', 'Across Kannur', 'kannur_ambulance.jpg', '24/7 ambulance support.'),
(124, 13, 'Ham Radio', 'Kannur Ham Club', '0497-2256789', 'Near Town Center', 'kannur_ham_radio.jpg', 'Ham radio support.'),
(125, 14, 'Hospital', 'Kasaragod District Hospital', '04994-234567', 'Kasaragod Town', 'kasaragod_hospital.jpg', 'District hospital with emergency services.'),
(126, 14, 'Fire & Rescue', 'Kasaragod Fire Station', '101', 'Kasaragod Town', 'kasaragod_fire_&_rescue.jpg', 'Fire and rescue services.'),
(127, 14, 'Police', 'Kasaragod Police Station', '04994-223344', 'Kasaragod Town', 'kasaragod_police.jpg', 'City police station.'),
(128, 14, 'Ambulance', '108 Ambulance Service Kasaragod', '108', 'Across Kasaragod', 'kasaragod_ambulance.jpg', '24/7 ambulance support.'),
(129, 14, 'Ham Radio', 'Kasaragod Ham Club', '04994-225678', 'Near Town Center', 'kasaragod_ham_radio.jpg', 'Ham radio for emergencies.');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `district_id` int DEFAULT NULL,
  `spot_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_card` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `first_name`, `last_name`, `email`, `mobile`, `username`, `password`, `district_id`, `spot_id`, `image`, `id_card`, `status`, `created_at`) VALUES
(4, 'Arun', 'Nair', 'arun.nair@example.com', '9876543001', 'arun_tvpm', '32250170a0dca92d53ec9624f336ca24', 1, 4, 'guide1.jpg', 'id1.jpg', 'Approved', '2025-09-14 02:47:06'),
(5, 'Meera', 'Pillai', 'meera.pillai@example.com', '9876543002', 'meera_tvpm', '32250170a0dca92d53ec9624f336ca24', 1, 5, 'guide2.jpg', 'id2.jpg', 'Approved', '2025-09-14 02:47:06'),
(6, 'Suresh', 'Menon', 'suresh.menon@example.com', '9876543003', 'suresh_tvpm', '32250170a0dca92d53ec9624f336ca24', 1, 6, 'guide3.jpg', 'id3.jpg', 'Approved', '2025-09-14 02:47:06'),
(7, 'Lakshmi', 'Varma', 'lakshmi.varma@example.com', '9876543004', 'lakshmi_tvpm', '32250170a0dca92d53ec9624f336ca24', 1, 7, 'guide4.jpg', 'id4.jpg', 'Approved', '2025-09-14 02:47:06'),
(8, 'Ravi', 'Kumar', 'ravi.kumar@example.com', '9876543005', 'ravi_kollam', '32250170a0dca92d53ec9624f336ca24', 2, 9, 'guide5.jpg', 'id5.jpg', 'Approved', '2025-09-14 02:47:06'),
(9, 'Divya', 'Suresh', 'divya.suresh@example.com', '9876543006', 'divya_kollam', '32250170a0dca92d53ec9624f336ca24', 2, 10, 'guide6.jpg', 'id6.jpg', 'Approved', '2025-09-14 02:47:06'),
(10, 'Ajay', 'Krishnan', 'ajay.krishnan@example.com', '9876543007', 'ajay_kollam', '32250170a0dca92d53ec9624f336ca24', 2, 11, 'guide7.jpg', 'id7.jpg', 'Approved', '2025-09-14 02:47:06'),
(11, 'Reshma', 'Nair', 'reshma.nair@example.com', '9876543008', 'reshma_kollam', '32250170a0dca92d53ec9624f336ca24', 2, 12, 'guide8.jpg', 'id8.jpg', 'Approved', '2025-09-14 02:47:06'),
(12, 'Manu', 'Varghese', 'manu.varghese@example.com', '9876543009', 'manu_pathanam', '32250170a0dca92d53ec9624f336ca24', 3, 13, 'guide9.jpg', 'id9.jpg', 'Approved', '2025-09-14 02:47:06'),
(13, 'Anju', 'Menon', 'anju.menon@example.com', '9876543010', 'anju_pathanam', '32250170a0dca92d53ec9624f336ca24', 3, 14, 'guide10.jpg', 'id10.jpg', 'Approved', '2025-09-14 02:47:06'),
(14, 'Hari', 'Das', 'hari.das@example.com', '9876543011', 'hari_pathanam', '32250170a0dca92d53ec9624f336ca24', 3, 15, 'guide11.jpg', 'id11.jpg', 'Approved', '2025-09-14 02:47:06'),
(15, 'Sneha', 'Krishnan', 'sneha.krishnan@example.com', '9876543012', 'sneha_pathanam', '32250170a0dca92d53ec9624f336ca24', 3, 16, 'guide12.jpg', 'id12.jpg', 'Approved', '2025-09-14 02:47:06'),
(16, 'Rahul', 'Suresh', 'rahul.suresh@example.com', '9876543013', 'rahul_alpy', '32250170a0dca92d53ec9624f336ca24', 4, 17, 'guide13.jpg', 'id13.jpg', 'Approved', '2025-09-14 02:47:06'),
(17, 'Nisha', 'Nair', 'nisha.nair@example.com', '9876543014', 'nisha_alpy', '32250170a0dca92d53ec9624f336ca24', 4, 18, 'guide14.jpg', 'id14.jpg', 'Approved', '2025-09-14 02:47:06'),
(18, 'Arjun', 'Varma', 'arjun.varma@example.com', '9876543015', 'arjun_alpy', '32250170a0dca92d53ec9624f336ca24', 4, 19, 'guide15.jpg', 'id15.jpg', 'Approved', '2025-09-14 02:47:06'),
(19, 'Priya', 'Menon', 'priya.menon@example.com', '9876543016', 'priya_alpy', '32250170a0dca92d53ec9624f336ca24', 4, 20, 'guide16.jpg', 'id16.jpg', 'Approved', '2025-09-14 02:47:06'),
(20, 'Joseph', 'Mathew', 'joseph.mathew@example.com', '9876543017', 'joseph_ktym', '32250170a0dca92d53ec9624f336ca24', 5, 21, 'guide17.jpg', 'id17.jpg', 'Approved', '2025-09-14 02:47:06'),
(21, 'Bindu', 'Varghese', 'bindu.varghese@example.com', '9876543018', 'bindu_ktym', '32250170a0dca92d53ec9624f336ca24', 5, 22, 'guide18.jpg', 'id18.jpg', 'Approved', '2025-09-14 02:47:06'),
(22, 'Nikhil', 'Thomas', 'nikhil.thomas@example.com', '9876543019', 'nikhil_ktym', '32250170a0dca92d53ec9624f336ca24', 5, 23, 'guide19.jpg', 'id19.jpg', 'Approved', '2025-09-14 02:47:06'),
(23, 'Anitha', 'George', 'anitha.george@example.com', '9876543020', 'anitha_ktym', '32250170a0dca92d53ec9624f336ca24', 5, 24, 'guide20.jpg', 'id20.jpg', 'Approved', '2025-09-14 02:47:06'),
(24, 'Biju', 'Jose', 'biju.jose@example.com', '9876543021', 'biju_idk', '32250170a0dca92d53ec9624f336ca24', 6, 25, 'guide21.jpg', 'id21.jpg', 'Approved', '2025-09-14 02:47:06'),
(25, 'Deepa', 'Mani', 'deepa.mani@example.com', '9876543022', 'deepa_idk', '32250170a0dca92d53ec9624f336ca24', 6, 26, 'guide22.jpg', 'id22.jpg', 'Approved', '2025-09-14 02:47:06'),
(26, 'Vishnu', 'Das', 'vishnu.das@example.com', '9876543023', 'vishnu_idk', '32250170a0dca92d53ec9624f336ca24', 6, 27, 'guide23.jpg', 'id23.jpg', 'Approved', '2025-09-14 02:47:06'),
(27, 'Leena', 'Raj', 'leena.raj@example.com', '9876543024', 'leena_idk', '32250170a0dca92d53ec9624f336ca24', 6, 28, 'guide24.jpg', 'id24.jpg', 'Approved', '2025-09-14 02:47:06'),
(28, 'Sanjay', 'Menon', 'sanjay.menon@example.com', '9876543025', 'sanjay_ekm', '32250170a0dca92d53ec9624f336ca24', 7, 29, 'guide25.jpg', 'id25.jpg', 'Approved', '2025-09-14 02:47:06'),
(29, 'Asha', 'Varma', 'asha.varma@example.com', '9876543026', 'asha_ekm', '32250170a0dca92d53ec9624f336ca24', 7, 30, 'guide26.jpg', 'id26.jpg', 'Approved', '2025-09-14 02:47:06'),
(30, 'Naveen', 'Pillai', 'naveen.pillai@example.com', '9876543027', 'naveen_ekm', '32250170a0dca92d53ec9624f336ca24', 7, 31, 'guide27.jpg', 'id27.jpg', 'Approved', '2025-09-14 02:47:06'),
(31, 'Geetha', 'Krishnan', 'geetha.krishnan@example.com', '9876543028', 'geetha_ekm', '32250170a0dca92d53ec9624f336ca24', 7, 32, 'guide28.jpg', 'id28.jpg', 'Approved', '2025-09-14 02:47:06'),
(32, 'Ramesh', 'Kumar', 'ramesh.kumar@example.com', '9876543029', 'ramesh_tsr', '32250170a0dca92d53ec9624f336ca24', 8, 33, 'guide29.jpg', 'id29.jpg', 'Approved', '2025-09-14 02:47:06'),
(33, 'Sita', 'Mohan', 'sita.mohan@example.com', '9876543030', 'sita_tsr', '32250170a0dca92d53ec9624f336ca24', 8, 34, 'guide30.jpg', 'id30.jpg', 'Approved', '2025-09-14 02:47:06'),
(34, 'Anil', 'George', 'anil.george@example.com', '9876543031', 'anil_tsr', '32250170a0dca92d53ec9624f336ca24', 8, 35, 'guide31.jpg', 'id31.jpg', 'Approved', '2025-09-14 02:47:06'),
(35, 'Kavya', 'Raj', 'kavya.raj@example.com', '9876543032', 'kavya_tsr', '32250170a0dca92d53ec9624f336ca24', 8, 36, 'guide32.jpg', 'id32.jpg', 'Approved', '2025-09-14 02:47:06'),
(36, 'Mohan', 'Das', 'mohan.das@example.com', '9876543033', 'mohan_pkd', '32250170a0dca92d53ec9624f336ca24', 9, 37, 'guide33.jpg', 'id33.jpg', 'Approved', '2025-09-14 02:47:06'),
(37, 'Rekha', 'Nair', 'rekha.nair@example.com', '9876543034', 'rekha_pkd', '32250170a0dca92d53ec9624f336ca24', 9, 38, 'guide34.jpg', 'id34.jpg', 'Approved', '2025-09-14 02:47:06'),
(38, 'Sunil', 'Varghese', 'sunil.varghese@example.com', '9876543035', 'sunil_pkd', '32250170a0dca92d53ec9624f336ca24', 9, 39, 'guide35.jpg', 'id35.jpg', 'Approved', '2025-09-14 02:47:06'),
(39, 'Anu', 'Mathew', 'anu.mathew@example.com', '9876543036', 'anu_pkd', '32250170a0dca92d53ec9624f336ca24', 9, 40, 'guide36.jpg', 'id36.jpg', 'Approved', '2025-09-14 02:47:06'),
(40, 'Ashok', 'Kumar', 'ashok.kumar@example.com', '9876543037', 'ashok_mlp', '32250170a0dca92d53ec9624f336ca24', 10, 41, 'guide37.jpg', 'id37.jpg', 'Approved', '2025-09-14 02:47:06'),
(41, 'Parvathy', 'Menon', 'parvathy.menon@example.com', '9876543038', 'parvathy_mlp', '32250170a0dca92d53ec9624f336ca24', 10, 42, 'guide38.jpg', 'id38.jpg', 'Approved', '2025-09-14 02:47:06'),
(42, 'Gopi', 'Krishnan', 'gopi.krishnan@example.com', '9876543039', 'gopi_mlp', '32250170a0dca92d53ec9624f336ca24', 10, 43, 'guide39.jpg', 'id39.jpg', 'Approved', '2025-09-14 02:47:06'),
(43, 'Soumya', 'Raj', 'soumya.raj@example.com', '9876543040', 'soumya_mlp', '32250170a0dca92d53ec9624f336ca24', 10, 44, 'guide40.jpg', 'id40.jpg', 'Approved', '2025-09-14 02:47:06'),
(44, 'Vivek', 'Nair', 'vivek.nair@example.com', '9876543041', 'vivek_kkd', '32250170a0dca92d53ec9624f336ca24', 11, 45, 'guide41.jpg', 'id41.jpg', 'Approved', '2025-09-14 02:47:06'),
(45, 'Athira', 'Varma', 'athira.varma@example.com', '9876543042', 'athira_kkd', '32250170a0dca92d53ec9624f336ca24', 11, 46, 'guide42.jpg', 'id42.jpg', 'Approved', '2025-09-14 02:47:06'),
(46, 'Pranav', 'Suresh', 'pranav.suresh@example.com', '9876543043', 'pranav_kkd', '32250170a0dca92d53ec9624f336ca24', 11, 47, 'guide43.jpg', 'id43.jpg', 'Approved', '2025-09-14 02:47:06'),
(47, 'Radhika', 'Menon', 'radhika.menon@example.com', '9876543044', 'radhika_kkd', '32250170a0dca92d53ec9624f336ca24', 11, 48, 'guide44.jpg', 'id44.jpg', 'Approved', '2025-09-14 02:47:06'),
(48, 'Soman', 'Pillai', 'soman.pillai@example.com', '9876543045', 'soman_wyd', '32250170a0dca92d53ec9624f336ca24', 12, 49, 'guide45.jpg', 'id45.jpg', 'Approved', '2025-09-14 02:47:06'),
(49, 'Neethu', 'Varghese', 'neethu.varghese@example.com', '9876543046', 'neethu_wyd', '32250170a0dca92d53ec9624f336ca24', 12, 50, 'guide46.jpg', 'id46.jpg', 'Approved', '2025-09-14 02:47:06'),
(50, 'Kiran', 'Das', 'kiran.das@example.com', '9876543047', 'kiran_wyd', '32250170a0dca92d53ec9624f336ca24', 12, 51, 'guide47.jpg', 'id47.jpg', 'Approved', '2025-09-14 02:47:06'),
(51, 'Aparna', 'Krishnan', 'aparna.krishnan@example.com', '9876543048', 'aparna_wyd', '32250170a0dca92d53ec9624f336ca24', 12, 52, 'guide48.jpg', 'id48.jpg', 'Approved', '2025-09-14 02:47:06'),
(52, 'Vimal', 'George', 'vimal.george@example.com', '9876543049', 'vimal_knr', '32250170a0dca92d53ec9624f336ca24', 13, 53, 'guide49.jpg', 'id49.jpg', 'Approved', '2025-09-14 02:47:06'),
(53, 'Swathi', 'Nair', 'swathi.nair@example.com', '9876543050', 'swathi_knr', '32250170a0dca92d53ec9624f336ca24', 13, 54, 'guide50.jpg', 'id50.jpg', 'Approved', '2025-09-14 02:47:06'),
(54, 'Aravind', 'Menon', 'aravind.menon@example.com', '9876543051', 'aravind_knr', '32250170a0dca92d53ec9624f336ca24', 13, 55, 'guide51.jpg', 'id51.jpg', 'Approved', '2025-09-14 02:47:06'),
(55, 'Jyothi', 'Pillai', 'jyothi.pillai@example.com', '9876543052', 'jyothi_knr', '32250170a0dca92d53ec9624f336ca24', 13, 56, 'guide52.jpg', 'id52.jpg', 'Approved', '2025-09-14 02:47:06'),
(56, 'Nandakumar', 'Das', 'nandakumar.das@example.com', '9876543053', 'nanda_ksd', '32250170a0dca92d53ec9624f336ca24', 14, 57, 'guide53.jpg', 'id53.jpg', 'Approved', '2025-09-14 02:47:06'),
(57, 'Devika', 'Menon', 'devika.menon@example.com', '9876543054', 'devika_ksd', '32250170a0dca92d53ec9624f336ca24', 14, 58, 'guide54.jpg', 'id54.jpg', 'Approved', '2025-09-14 02:47:06'),
(58, 'Sajin', 'Varma', 'sajin.varma@example.com', '9876543055', 'sajin_ksd', '32250170a0dca92d53ec9624f336ca24', 14, 59, 'guide55.jpg', 'id55.jpg', 'Approved', '2025-09-14 02:47:06'),
(59, 'Keerthi', 'Nair', 'keerthi.nair@example.com', '9876543056', 'keerthi_ksd', '32250170a0dca92d53ec9624f336ca24', 14, 60, 'guide56.jpg', 'id56.jpg', 'Approved', '2025-09-14 02:47:06'),
(60, 'SAM', 'C', 'sam2003@gmail.com', '9999999999', 'SAM2003', '$2y$10$u.3z0k56DEqBrlEhA/ZQc.bmv5c0EUuNcTxYh6JwhRzYETLm7B7F6', 3, 15, '1757820323_kalari.jpg', '4567777', 'Approved', '2025-09-14 03:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `guide_bookings`
--

CREATE TABLE `guide_bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `guide_id` int NOT NULL,
  `description` text,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guide_bookings`
--

INSERT INTO `guide_bookings` (`id`, `user_id`, `guide_id`, `description`, `booking_date`, `booking_time`, `status`, `created_at`) VALUES
(1, 1, 12, '', '2025-09-21', '08:48:00', 'Pending', '2025-09-14 03:14:58'),
(3, 3, 12, 'test', '2025-09-20', '12:42:00', 'Pending', '2025-09-14 07:10:07'),
(4, 3, 60, 'test', '2025-09-27', '12:46:00', 'Accepted', '2025-09-14 07:11:05'),
(5, 5, 60, 'test', '2025-09-28', '10:48:00', 'Accepted', '2025-09-24 05:14:56'),
(6, 6, 20, 'lulumal', '2025-09-30', '14:13:00', 'Pending', '2025-09-24 05:40:37'),
(7, 6, 60, 'test', '2025-09-30', '16:32:00', 'Accepted', '2025-09-24 05:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `district_id` int NOT NULL,
  `spot_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `email`, `mobile`, `username`, `password`, `district_id`, `spot_id`, `image`, `status`, `created_at`) VALUES
(1, 'Hari Sree', 'akdmuralimk@gmail.com', '8877512897', 'HariSree', '$2y$10$uLSckAchp1xma1NF.rqMS.ra8z1sPDL0J9Nk5MX0PJEr27uAHKiFW', 3, 16, '1759033322_mask.jpeg', 'Approved', '2025-09-14 11:45:51'),
(2, 'sreevalsam', 'hotel@gmail.com', '9999999999', 'sree', '$2y$10$AzSwdeI3Am/Z08IG8JE5euRloAKSxv.bXNMv0OsMHbyizlHM2nyoW', 4, 19, '1758691165_screenshot3.png', 'Approved', '2025-09-24 10:49:25'),
(3, 'janatha', 'janatha@gamail.com', '1234567890', 'janatha', '$2y$10$f9qWGHoUseLbMNMrd5TwSeh3zzPDufNOmuV2/jvw./YuLP56r8/pW', 5, 65, '1758693680_Eco-friendly-Travel-In-Kerala.avif', 'Approved', '2025-09-24 11:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_bookings`
--

CREATE TABLE `hotel_bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `hotel_id` int NOT NULL,
  `room_id` int NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `notes` text,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hotel_bookings`
--

INSERT INTO `hotel_bookings` (`id`, `user_id`, `hotel_id`, `room_id`, `booking_date`, `booking_time`, `notes`, `status`, `created_at`) VALUES
(3, 5, 1, 2, '2025-09-20', '12:45:00', 'dfgdfg', 'Confirmed', '2025-09-24 05:15:28'),
(4, 5, 2, 3, '2025-10-04', '10:55:00', 'book', 'Confirmed', '2025-09-24 05:22:28'),
(5, 6, 2, 3, '2025-09-30', '15:27:00', 'rdudr', 'Confirmed', '2025-09-24 05:53:45'),
(6, 6, 3, 4, '2025-09-30', '12:40:00', 'take care', 'Pending', '2025-09-24 06:09:26'),
(7, 1, 1, 1, '2025-09-30', '10:03:00', '', 'Confirmed', '2025-09-28 04:31:11'),
(8, 1, 1, 2, '2025-09-30', '10:04:00', '', 'Confirmed', '2025-09-28 04:31:21'),
(9, 1, 1, 1, '2025-09-29', '13:08:00', '', 'Pending', '2025-09-28 04:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `id` int NOT NULL,
  `hotel_id` int NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `total_rooms` int NOT NULL DEFAULT '1',
  `available_rooms` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hotel_rooms`
--

INSERT INTO `hotel_rooms` (`id`, `hotel_id`, `room_type`, `description`, `price`, `total_rooms`, `available_rooms`, `created_at`) VALUES
(1, 1, 'deluxe', 'AC Room', '2000.00', 5, 2, '2025-09-14 12:15:17'),
(2, 1, 'Single Bed Room', '1 bed', '600.00', 5, 1, '2025-09-14 12:42:46'),
(3, 2, 'deluxe', '2 bed room', '1000.00', 2, 1, '2025-09-24 10:51:47'),
(4, 3, 'deluxe', 'AC/ NON AC', '750.00', 5, 3, '2025-09-24 11:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `category`, `title`, `image`, `description`, `created_at`) VALUES
(1, 'Culture', 'Kalaripayattu', 'kalari.jpg', 'Kalaripayattu is one of the oldest martial arts in the world, combining combat techniques, weapon training, and graceful movements inspired by animals. It’s still practiced across Kerala today.', '2025-08-10 11:52:31'),
(2, 'Culture', 'Ayurveda', 'ayurvedha.jpeg', 'Kerala is globally renowned for Ayurveda — the ancient Indian system of medicine. With herbal treatments, therapeutic massages, and detox programs, it offers natural healing and wellness experiences.', '2025-08-10 11:54:03'),
(4, 'Culture', 'Kathakali', 'kathakali.jpeg', 'This classical dance-drama combines elaborate costumes, painted faces, and expressive gestures to narrate stories from epics like the Mahabharata and Ramayana.', '2025-08-10 12:14:07'),
(5, 'Culture', 'Theyyam', 'theyyam.jpeg', 'Theyyam is a unique ritual art form from North Kerala, where performers transform into deities through intricate makeup, costumes, and dance during temple festivals.', '2025-08-10 12:14:43'),
(6, 'Culture', 'Boat Races', 'boat-race.jpeg', 'Held during the monsoon season, these traditional races feature massive snake boats rowed by dozens of oarsmen, accompanied by music and cheering crowds.', '2025-08-10 12:15:25'),
(7, 'Wedding Destinations', 'Kumarakom Lake Resort', 'lakeresort.jpg', 'Luxury lakeside resort perfect for serene backwater weddings with traditional charm.', '2025-08-10 12:21:58'),
(9, 'Wedding Destinations', 'Bekal Fort Beach', 'bekal.jpeg', 'Historic fort with breathtaking beach views — a unique wedding backdrop.', '2025-08-10 12:23:34'),
(10, 'Wedding Destinations', 'Varkala Cliff Resorts', 'vliff.avif', 'Clifftop views of the Arabian Sea make this a romantic and scenic wedding spot.', '2025-08-10 12:24:10'),
(11, 'Activity', 'Trekking in Munnar', 'treking.jpeg', 'Explore tea plantations, rolling hills, and misty landscapes on guided treks in Munnar.', '2025-08-10 12:29:54'),
(12, 'Activity', 'Houseboat Ride in Alleppey', 'house boat.webp', 'Glide through Kerala’s famous backwaters and witness village life from a traditional houseboat.', '2025-08-10 12:30:18'),
(13, 'Activity', 'Spice Plantation Tour', 'plantation.jpeg', 'Walk through fragrant spice gardens and learn about Kerala’s spice trade heritage.', '2025-08-10 12:30:53'),
(14, 'Activity', 'Bamboo Rafting in Thekkady', 'rafting.jpg', 'Bamboo Rafting in Thekkady', '2025-08-10 12:31:17'),
(15, 'Souvenir', 'Aranmula Kannadi', 'aranmulakanndi.jpg', 'A unique handmade metal-alloy mirror from Aranmula village, believed to bring good luck and prosperity.', '2025-08-10 12:35:00'),
(16, 'Souvenir', 'Kasavu Saree', 'saree.jpeg', 'Elegant cream-colored sarees with golden borders, traditionally worn during Onam and weddings.', '2025-08-10 12:35:33'),
(17, 'Souvenir', 'Nettipattam', 'nettipattom.jpeg', 'Golden ornament used to decorate elephants during festivals — a perfect wall décor souvenir.', '2025-08-10 12:36:00'),
(18, 'Souvenir', 'Kathakali Masks', 'mask.jpeg', 'Colorful masks representing characters from Kerala’s classical dance-drama Kathakali.', '2025-08-10 12:36:26'),
(19, 'Food', 'Sadya', 'sadhya.jpeg', 'A traditional vegetarian feast served on a banana leaf, featuring rice, sambar, avial, thoran, olan, pickles, and payasam.', '2025-08-10 13:57:16'),
(20, 'Food', 'Karimeen Pollichathu', 'karimmen.jpeg', 'Pearl spot fish marinated in spices, wrapped in banana leaf, and grilled to perfection.', '2025-08-10 13:57:52'),
(21, 'Food', 'Erissery', 'erissery.webp', 'Pumpkin and cowpea curry cooked with coconut and mild spices, a favorite Onam dish.', '2025-08-10 13:58:27'),
(22, 'Food', 'Puttu and Kadala Curry', '1754835271_putt.jpeg', 'Steamed rice flour cylinders layered with coconut, served with black chickpea curry.', '2025-08-10 13:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `tourist_spots`
--

CREATE TABLE `tourist_spots` (
  `id` int NOT NULL,
  `district_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Pending','Approved') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tourist_spots`
--

INSERT INTO `tourist_spots` (`id`, `district_id`, `name`, `image`, `description`, `status`) VALUES
(4, 1, 'Sree Padmanabhaswamy Temple', 'padmanabhaswamy.jpg', 'Sree Padmanabhaswamy Temple, located in Thiruvananthapuram, Kerala, is an architectural marvel and one of the wealthiest temples in the world. Dedicated to Lord Vishnu, it boasts intricate carvings, golden sanctum, and centuries-old treasures. The temple is renowned for its cultural significance, elaborate rituals, and annual festivals that attract devotees from all over the world.', 'Approved'),
(5, 1, 'Kovalam Beach', 'kovalam.jpg', 'Kovalam Beach, a crescent-shaped paradise in Kerala, is famous for its golden sands, iconic lighthouse, and serene surroundings. Visitors can enjoy sunbathing, swimming, and water sports, along with Ayurveda therapies in nearby resorts. The beach offers breathtaking sunsets and is ideal for leisure, photography, and relaxation.', 'Approved'),
(6, 1, 'Ponmudi Hills', 'ponmudi.jpg', 'Ponmudi Hills is a tranquil hill station in Kerala, surrounded by mist-covered peaks, lush green tea plantations, and winding trekking trails. Nature enthusiasts can enjoy scenic walks, bird watching, and panoramic views of the Western Ghats. Its cool climate and serene environment make it a perfect weekend getaway.', 'Approved'),
(7, 1, 'Neyyar Dam & Wildlife Sanctuary', 'neyyar.jpg', 'Neyyar Dam & Wildlife Sanctuary, located near Thiruvananthapuram, is famous for its Lion and Deer Safari and boating on the Neyyar Dam. The sanctuary is home to diverse flora and fauna, offering wildlife spotting, trekking, and nature walks. It is an ideal destination for families and nature lovers seeking tranquility amidst lush greenery.', 'Approved'),
(8, 1, 'Poovar Island', 'poovar.jpg', 'Poovar Island, where the Neyyar River meets the Arabian Sea, is a picturesque backwater destination in Kerala. It offers serene boat rides, golden beaches, and unique estuary landscapes. Visitors can experience local fishing villages, tranquil surroundings, and the perfect retreat into nature.', 'Approved'),
(9, 2, 'Ashtamudi Lake', 'ashtamudi.jpg', 'Ashtamudi Lake, in Kollam, Kerala, is a stunning freshwater lake known for its houseboat cruises, backwater canals, and rich biodiversity. Surrounded by coconut palms and quaint villages, it provides a serene setting for boating, bird watching, and photography. The lake is a prime destination for experiencing Kerala’s famous backwaters.', 'Approved'),
(10, 2, 'Jatayu Earth’s Center', 'jatayu.jpg', 'Jatayu Earth’s Center in Chadayamangalam is home to the world’s largest bird sculpture and an adventure park. Visitors can enjoy rock climbing, rappelling, and trekking trails while admiring the massive Jatayu sculpture. The center combines mythology, adventure, and scenic views, making it a unique tourist attraction in Kerala.', 'Approved'),
(11, 2, 'Palaruvi Waterfalls', 'palaruvi.jpg', 'Palaruvi Waterfalls, located in Kollam district, is a breathtaking cascade set amidst lush forests. Known as the \"Stream of Milk,\" the waterfall offers a tranquil environment ideal for nature walks, picnics, and photography. The surrounding area is rich in flora and fauna, providing a peaceful retreat for visitors.', 'Approved'),
(12, 2, 'Thangassery Lighthouse', 'thangassery.jpg', 'Thangassery Lighthouse, built in 1902 in Kollam, Kerala, is a historic structure offering panoramic views of the Arabian Sea. Visitors can climb the lighthouse to enjoy scenic vistas, explore nearby forts, and learn about maritime history. Its coastal charm and heritage significance make it a popular spot for tourists.', 'Approved'),
(13, 3, 'Sabarimala Temple', 'sabarimala.jpg', 'Sabarimala Temple, in Pathanamthitta district, is one of the most famous pilgrimage centers in India, dedicated to Lord Ayyappa. It attracts millions of devotees annually, especially during the Mandalam-Makaravilakku season. The temple is set amidst scenic hills and forests, offering a spiritually enriching experience combined with natural beauty.', 'Approved'),
(14, 3, 'Perunthenaruvi Waterfalls', 'perunthenaruvi.jpg', 'Perunthenaruvi Waterfalls, situated on the Pamba River in Pathanamthitta, Kerala, is a scenic waterfall surrounded by lush greenery and rocky terrain. Known for its wide cascade and picturesque surroundings, it is ideal for picnics, nature photography, and tranquil retreats amidst the forested hills.', 'Approved'),
(15, 3, 'Konni Elephant Training Center', 'konni.jpg', 'Konni Elephant Training Center, located in Pathanamthitta, Kerala, is famous for its elephant safaris, mahout training programs, and lush forest surroundings. Visitors can interact with elephants, learn about their care, and enjoy guided treks through the nearby forests, making it an educational and adventurous destination.', 'Approved'),
(16, 3, 'Gavi', 'gavi.jpg', 'Gavi, an eco-tourism destination in Pathanamthitta, Kerala, offers trekking trails, bird watching, and wildlife spotting. Surrounded by dense forests and serene streams, Gavi provides a pristine natural environment perfect for eco-tourists, nature enthusiasts, and adventure seekers.', 'Approved'),
(17, 4, 'Alleppey Backwaters', 'alleppey.jpg', 'Alleppey Backwaters, famously known as the \"Venice of the East,\" feature an extensive network of canals, lagoons, and lakes. Visitors can enjoy traditional houseboat cruises, witness rural village life, and explore lush paddy fields and coconut palms, making it a quintessential Kerala experience.', 'Approved'),
(18, 4, 'Marari Beach', 'marari.jpg', 'Marari Beach, in Alappuzha district, Kerala, is a serene and pristine coastal destination with golden sands and swaying coconut palms. Visitors can enjoy sunbathing, beach walks, and local seafood, along with a tranquil atmosphere ideal for relaxation and meditation.', 'Approved'),
(19, 4, 'Ambalappuzha Temple', 'ambalappuzha.jpg', 'Ambalappuzha Sri Krishna Temple, located in Alappuzha, Kerala, is renowned for its traditional Kerala architecture and famous Palpayasam (sweet milk porridge) offering. The temple attracts devotees and tourists alike with its spiritual ambiance, intricate carvings, and annual festivals.', 'Approved'),
(20, 4, 'Pathiramanal Island', 'pathiramanal.jpg', 'Pathiramanal Island, situated in Vembanad Lake, Kerala, is a haven for bird watchers and nature lovers. The small island hosts numerous migratory and native bird species, offering peaceful trails, scenic views of the lake, and a serene retreat into nature.', 'Approved'),
(21, 5, 'Kumarakom Bird Sanctuary', 'kumarakom.jpg', 'Kumarakom Bird Sanctuary, located on the banks of Vembanad Lake in Kerala, is home to migratory birds such as herons, egrets, and kingfishers. Visitors can enjoy guided boat rides, nature trails, and bird photography in this peaceful haven of avian diversity.', 'Approved'),
(22, 5, 'Illikkal Kallu', 'illikkal.jpg', 'Illikkal Kallu, a spectacular rock formation in Kottayam district, Kerala, offers breathtaking panoramic views of the surrounding valleys, hills, and waterfalls. Popular for trekking and adventure enthusiasts, the site is also a serene escape into nature\'s grandeur.', 'Approved'),
(23, 5, 'Vagamon', 'vagamon.jpg', 'Vagamon, a beautiful hill station in Kerala, is known for its rolling meadows, pine forests, and adventure sports like paragliding and trekking. The misty climate, lush greenery, and scenic tea gardens make it an ideal destination for relaxation and nature exploration.', 'Approved'),
(24, 5, 'Ettumanoor Mahadeva Temple', 'ettumanoor.jpg', 'Ettumanoor Mahadeva Temple, in Kottayam, Kerala, is an ancient temple dedicated to Lord Shiva. Famous for its exquisite murals, traditional architecture, and vibrant festivals, the temple attracts devotees and art enthusiasts alike.', 'Approved'),
(25, 6, 'Munnar', 'munnar.jpg', 'Munnar, a hill station in Idukki district, Kerala, is renowned for its sprawling tea plantations, misty hills, and pleasant climate. Visitors can explore tea estates, waterfalls, trekking trails, and enjoy the rich biodiversity of the Western Ghats.', 'Approved'),
(26, 6, 'Thekkady (Periyar Wildlife Sanctuary)', 'thekkady.jpg', 'Thekkady, in Kerala, India, is famous for the Periyar National Park and Wildlife Sanctuary, home to elephants, tigers, and diverse wildlife. Visitors can enjoy bamboo rafting on Periyar Lake, spice plantation tours, and cultural performances like Kathakali and local craft shopping.', 'Approved'),
(27, 6, 'Idukki Arch Dam', 'idukki.jpg', 'Idukki Arch Dam, located in Kerala, is one of the highest arch dams in Asia, surrounded by lush forests and rolling hills. It is a marvel of engineering, attracting tourists for its panoramic views, hydroelectric significance, and serene landscapes.', 'Approved'),
(28, 6, 'Meesapulimala', 'meesapulimala.jpg', 'Meesapulimala, the second highest peak in South India, is located in the Western Ghats of Kerala. Known for its trekking trails, breathtaking sunrise views, and mist-covered hills, it offers an adventurous and scenic experience for nature lovers and hikers.', 'Approved'),
(29, 7, 'Fort Kochi', 'fortkochi.jpg', 'Fort Kochi, a historic town in Kerala, showcases colonial architecture, Chinese fishing nets, and vibrant street art. Visitors can explore cafes, museums, churches, and enjoy cultural performances, making it a hub of history and heritage.', 'Approved'),
(30, 7, 'Cherai Beach', 'cherai.jpg', 'Cherai Beach, located near Kochi, Kerala, is known for its clean golden sands, shallow waters, and frequent dolphin sightings. Ideal for swimming, sunbathing, and beachside relaxation, it is a popular destination for families and tourists.', 'Approved'),
(31, 7, 'Marine Drive Kochi', 'marinedrive.jpg', 'Marine Drive, Kochi, is a scenic promenade along the backwaters, offering views of ferries, boats, and the city skyline. Visitors can enjoy leisurely walks, street shopping, and the serene ambiance of the waterfront.', 'Approved'),
(32, 7, 'Mattancherry Palace', 'mattancherry.jpg', 'Mattancherry Palace, also known as the Dutch Palace, in Kochi, Kerala, is famous for its Kerala murals, historical artifacts, and royal architecture. It provides insights into the history and culture of the region.', 'Approved'),
(33, 8, 'Vadakkumnathan Temple', 'vadakkumnathan.jpg', 'Vadakkumnathan Temple, a UNESCO heritage site in Thrissur, Kerala, is dedicated to Lord Shiva. Known for its traditional Kerala architecture, intricate carvings, and the famous Thrissur Pooram festival, it is a spiritual and cultural landmark.', 'Approved'),
(34, 8, 'Athirappilly Waterfalls', 'athirappilly.jpg', 'Athirappilly Waterfalls, often called the \"Niagara of India,\" is located in Thrissur, Kerala. Surrounded by dense forests, it offers stunning views, trekking opportunities, and a serene natural environment, making it a top attraction for nature lovers and photographers.', 'Approved'),
(35, 8, 'Guruvayur Temple', 'guruvayur.jpg', 'Guruvayur Temple, in Thrissur, Kerala, is a prominent pilgrimage site dedicated to Lord Krishna. Known for its strict rituals, sacred traditions, and the famous Guruvayur Ekadasi festival, it draws devotees from across India.', 'Approved'),
(36, 8, 'Punnathur Kotta', 'punnathur.jpg', 'Punnathur Kotta, near Guruvayur in Kerala, is an elephant sanctuary housing temple elephants. Visitors can observe and interact with elephants, learn about their care, and explore the unique heritage associated with the temple.', 'Approved'),
(37, 9, 'Palakkad Fort', 'palakkadfort.jpg', 'Palakkad Fort, built by Hyder Ali in Palakkad, Kerala, is a historic fort known for its well-preserved walls, strategic architecture, and lush surroundings. It is a popular spot for history enthusiasts and photography.', 'Approved'),
(38, 9, 'Silent Valley National Park', 'silentvalley.jpg', 'Silent Valley National Park, in Kerala\'s Western Ghats, is a biodiversity hotspot rich in endemic flora and fauna. Known for its pristine rainforests, rare species, and trekking trails, it is ideal for eco-tourism and wildlife study.', 'Approved'),
(39, 9, 'Malampuzha Dam & Gardens', 'malampuzha.jpg', 'Malampuzha Dam and Gardens, in Palakkad, Kerala, is famous for its scenic dam, ropeway, rock garden, and recreational areas. It attracts families and tourists seeking leisure and picturesque landscapes.', 'Approved'),
(40, 9, 'Dhoni Waterfalls', 'dhoni.jpg', 'Dhoni Waterfalls, located near Palakkad, Kerala, is a serene trekking and waterfall destination. Surrounded by lush greenery and hills, it offers opportunities for hiking, picnics, and nature photography.', 'Approved'),
(41, 10, 'Kottakkunnu Park', 'kottakkunnu.jpg', 'Kottakkunnu Park, in Malappuram, Kerala, is a historic hill garden with panoramic views. It features beautifully landscaped gardens, playgrounds, and walking paths, making it ideal for leisure and family visits.', 'Approved'),
(42, 10, 'Nedumkayam Rainforest', 'nedumkayam.jpg', 'Nedumkayam Rainforest, in Malappuram, Kerala, is a tropical rainforest rich in wildlife and trekking trails. It is perfect for nature enthusiasts interested in exploring dense forests and observing rare species.', 'Approved'),
(43, 10, 'Adyanpara Waterfalls', 'adyanpara.jpg', 'Adyanpara Waterfalls, located in Malappuram, Kerala, is a beautiful waterfall surrounded by dense forests. Visitors can enjoy swimming in natural pools, trekking, and scenic views in a tranquil environment.', 'Approved'),
(44, 10, 'Kadalundi Bird Sanctuary', 'kadalundi.jpg', 'Kadalundi Bird Sanctuary, in Malappuram, Kerala, is a haven for migratory and native birds. Spanning river estuaries and mangroves, it provides excellent birdwatching, photography, and nature study opportunities.', 'Approved'),
(45, 11, 'Kozhikode Beach', 'kozhikodebeach.jpg', 'Kozhikode Beach, in Kozhikode, Kerala, is a historic and scenic beach famous for its golden sands, vibrant sunsets, and local seafood. Visitors can enjoy leisurely walks, kite flying, and beachside activities.', 'Approved'),
(46, 11, 'Beypore Port', 'beypore.jpg', 'Beypore Port, in Kozhikode, Kerala, is an ancient port known for Uru shipbuilding. It reflects maritime heritage and offers a glimpse into traditional ship construction and Kerala\'s trading history.', 'Approved'),
(47, 11, 'Kappad Beach', 'kappad.jpg', 'Kappad Beach, in Kozhikode, Kerala, is a historic site where Vasco da Gama landed in 1498. It features scenic shoreline, calm waters, and rich historical significance, making it a popular tourist spot.', 'Approved'),
(48, 11, 'Thusharagiri Waterfalls', 'thusharagiri.jpg', 'Thusharagiri Waterfalls, in Kozhikode, Kerala, is a beautiful cascading waterfall nestled in lush forests. It is ideal for trekking, photography, and enjoying the serene natural environment.', 'Approved'),
(49, 12, 'Edakkal Caves', 'edakkal.jpg', 'Edakkal Caves, in Wayanad, Kerala, are prehistoric caves with carvings from the Neolithic period. They offer insights into ancient human civilization and rock art, attracting history enthusiasts and researchers.', 'Approved'),
(50, 12, 'Banasura Sagar Dam', 'banasura.jpg', 'Banasura Sagar Dam, in Wayanad, Kerala, is the largest earth dam in India. Surrounded by hills and lakes, it provides boating, trekking, and scenic photography opportunities, making it a popular tourist attraction.', 'Approved'),
(51, 12, 'Wayanad Wildlife Sanctuary', 'wayanad.jpg', 'Wayanad Wildlife Sanctuary, in Kerala\'s Western Ghats, is rich in biodiversity with elephants, tigers, and rare species. It offers eco-tourism, trekking, and wildlife observation in a pristine forest environment.', 'Approved'),
(52, 12, 'Soochipara Waterfalls', 'soochipara.jpg', 'Soochipara Waterfalls, also known as Sentinel Rock Waterfalls, in Wayanad, Kerala, is a three-tiered waterfall ideal for trekking, swimming, and photography. Surrounded by dense forests, it offers a refreshing escape into nature.', 'Approved'),
(53, 13, 'St. Angelo Fort', 'angelo.jpg', 'St. Angelo Fort, in Kannur, Kerala, is a historic sea-facing fort built by the Portuguese. It offers panoramic views of the Arabian Sea, colonial history, and insight into Kerala\'s strategic maritime past.', 'Approved'),
(54, 13, 'Payyambalam Beach', 'payyambalam.jpg', 'Payyambalam Beach, in Kannur, Kerala, is a clean and scenic beach with golden sands and palm trees. It is ideal for relaxing, walking, and witnessing beautiful sunsets along the coast.', 'Approved'),
(55, 13, 'Muzhappilangad Drive-in Beach', 'muzhappilangad.jpg', 'Muzhappilangad Drive-in Beach, in Kannur, Kerala, is Asia\'s longest drive-in beach. Visitors can drive along the coastline, enjoy water sports, and explore the unique landscape.', 'Approved'),
(56, 13, 'Parassinikadavu Temple', 'parassini.jpg', 'Parassinikadavu Temple, in Kannur, Kerala, is dedicated to Lord Muthappan. Known for unique rituals, elephant festivals, and its riverside location, it attracts devotees and tourists interested in Kerala\'s spiritual heritage.', 'Approved'),
(57, 14, 'Bekal Fort', 'bekal.jpg', 'Bekal Fort, in Kasaragod, Kerala, is the largest fort in Kerala overlooking the Arabian Sea. With its historic architecture, scenic views, and strategic coastal location, it is a top attraction for history lovers and photographers.', 'Approved'),
(58, 14, 'Ranipuram Hills', 'ranipuram.jpg', 'Ranipuram Hills, in Kasaragod, Kerala, is a hill station with trekking trails, lush greenery, and diverse wildlife. It offers cool climates, scenic viewpoints, and adventure activities for nature enthusiasts.', 'Approved'),
(59, 14, 'Ananthapura Lake Temple', 'ananthapura.jpg', 'Ananthapura Lake Temple, in Kasaragod, Kerala, is a unique temple situated in the middle of a lake. It is dedicated to Lord Vishnu and is known for its serene environment and traditional architecture.', 'Approved'),
(60, 14, 'Kappil Beach', 'kappilkasargod.jpg', 'Kappil Beach, in Kasaragod, Kerala, is a serene beach with estuary views, coconut palms, and calm waters. It is perfect for relaxation, photography, and enjoying Kerala\'s coastal beauty.', 'Approved'),
(63, 4, 'demo', 'ayurvedha.jpeg', 'demo', 'Approved'),
(64, 4, 'ceconline', 'litrature.png', 'testyy', 'Approved'),
(65, 5, 'mammood', 'screenshot3.png', 'very nice place', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile`, `username`, `password`, `created_at`) VALUES
(1, 'ROHIT', 'mathew', 'akdmuralimk@gmail.com', '9999999999', 'Rohit', '$2y$10$rxK.vR1y2v41zHriUJut/ubrc9h.cp7rR7VdVPVp.n9z4/0O6/3kS', '2025-09-10 16:03:48'),
(2, 'Rahul', 'G', 'loversland1997@gmail.com', '9999999999', 'RahulG21', '$2y$10$gXd7FjR8Xwam78Nr/pwrsOnDYSLsxYDJPRRpsXOGBi23QWLKQeWNe', '2025-09-13 08:17:31'),
(3, 'Rahul', 'G', 'demo@gmail.com', '9999999999', 'Rahul', '$2y$10$Qt2.kGMjA9N7Ir6QGGN5h.sXcuWfKwWIX.s8ruGyjPeXYMW80YJny', '2025-09-14 07:08:44'),
(4, 'Murali', 'Krishna', 'kannan@gmail.com', '9999999999', 'kannan', '$2y$10$hWBD4WHx6oGS8QbqpOMo7ulo3Rig.nxZW4VDx58eqa5eDaKW6DZlO', '2025-09-22 15:49:30'),
(5, 'Rahul', 'Krishna', 'unnimon3812@gmail.com', '9999999997', 'unni', '$2y$10$OWgb9fowP2hAtLPnmUMkJOpnwN/srfEsrHkApTsVa8zBCDw8ky06K', '2025-09-24 05:13:10'),
(6, 'Rahul', 'r', 'rahulg2259@gmail.com', '1234567890', 'rahul123', '$2y$10$bGhemXaq.locSGYQw5UTSO456fd/l01vcRzgpgaWzxzhEBb9NECWe', '2025-09-24 05:39:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_services`
--
ALTER TABLE `emergency_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `district_id` (`district_id`),
  ADD KEY `spot_id` (`spot_id`);

--
-- Indexes for table `guide_bookings`
--
ALTER TABLE `guide_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_guide` (`guide_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `district_id` (`district_id`),
  ADD KEY `spot_id` (`spot_id`);

--
-- Indexes for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `emergency_services`
--
ALTER TABLE `emergency_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `guide_bookings`
--
ALTER TABLE `guide_bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`spot_id`) REFERENCES `tourist_spots` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `guides_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `guides_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `tourist_spots` (`id`);

--
-- Constraints for table `guide_bookings`
--
ALTER TABLE `guide_bookings`
  ADD CONSTRAINT `fk_booking_guide` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `hotels_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `tourist_spots` (`id`);

--
-- Constraints for table `hotel_bookings`
--
ALTER TABLE `hotel_bookings`
  ADD CONSTRAINT `hotel_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hotel_bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hotel_bookings_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `hotel_rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tourist_spots`
--
ALTER TABLE `tourist_spots`
  ADD CONSTRAINT `tourist_spots_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
