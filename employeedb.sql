-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2023 at 05:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `employeetbl`
--

CREATE TABLE `employeetbl` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `employee_id` int(50) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `datehired` date NOT NULL,
  `position` varchar(20) NOT NULL,
  `department` varchar(30) NOT NULL,
  `salary` int(50) NOT NULL,
  `account_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeetbl`
--

INSERT INTO `employeetbl` (`username`, `password`, `employee_id`, `firstname`, `lastname`, `datehired`, `position`, `department`, `salary`, `account_type`) VALUES
('johndoe', '$2y$10$1/biW2/R76I/0FAl6iacIe1tKuzD6lpWn1IVRF9B5ug4/zfY.fiam', 1, 'John', 'Doe', '2022-03-15', 'Developer', 'IT', 60000, 'User'),
('janedoe', '$2y$10$j5yzm9ZrUGWchrKbYCN1wOa7t5WxChdPERBK/yHhs.y5wFDFthM6i', 2, 'Jane', 'Doe', '2021-07-10', 'Manager', 'Sales', 80000, 'Admin'),
('bobsmith', '$2y$10$zeowgXBfRj1HfIZPw0zGwecefuXLyZDLciWJsgmwM.JdN/qDFnyTC', 3, 'Bob', 'Smith', '2022-01-01', 'Designer', 'Marketing', 55000, 'User'),
('sarajohnson', '$2y$10$OS45gFEOKxTklaYN0xdaLeLDAAiEBjwazbRTLYqQq2ptfNkRrSxSC', 4, 'Sara', 'Johnson', '2022-02-28', 'Developer', 'IT', 65000, 'User'),
('mikesmith', '$2y$10$Qv072tlR/9QGV3sgo7E06.MxDACIh25KjSBr948NM7nFV2QpVa.gG', 5, 'Mike', 'Smith', '2021-11-15', 'Manager', 'Sales', 75000, 'Admin'),
('annamiller', '$2y$10$w.g7WBf6xLm05xDHffdRFuAnvqwp8s7XmPAA6TcKCqL3ujhD8o.Ja', 6, 'Anna', 'Miller', '2022-04-01', 'Designer', 'Marketing', 60000, 'User'),
('peterlee', '$2y$10$tF.sdbP1ngb5j9EPHUtGiuhck6lLGc/NkB8hyNDgtA7fNdPJVU/iy', 7, 'Peter', 'Lee', '2022-01-15', 'Developer', 'IT', 70000, 'User'),
('jennyluo', '$2y$10$BT4qdErNU3ueVWwMe/eq9eFmdupJP7hkg6Kv3wkRV.60RVQEgQcYG', 8, 'Jenny', 'Luo', '2021-09-01', 'Manager', 'Sales', 85000, 'Admin'),
('davidjohnson', '$2y$10$56fytyWIqNmnZuLqGWbxx.gyMD8UjXI6qW1nfZl1U0zz.NF4avzG6', 9, 'David', 'Johnson', '2022-03-01', 'Designer', 'Marketing', 55000, 'User'),
('katewilliams', '$2y$10$Op46ixVx66mxurBCv6z1pOXzrV26yemNoMj6a0yhWsdCRF6iVRwne', 10, 'Kate', 'Williams', '2022-05-01', 'Developer', 'IT', 75000, 'User'),
('johnmark', '$2y$10$L6zNWBYUFj3shoQ0IPRCm.XRPfi9wtvyNw2pRmhvCWhStQOs4zD2.', 11, 'John Mark', 'Pachico', '2023-04-01', 'Developer', 'IT', 50000, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `projectstbl`
--

CREATE TABLE `projectstbl` (
  `project_id` int(50) NOT NULL,
  `project_name` varchar(40) NOT NULL,
  `employee_name` varchar(40) NOT NULL,
  `department` varchar(30) NOT NULL,
  `project_description` varchar(255) NOT NULL,
  `project_cost` int(50) NOT NULL,
  `project_start` date NOT NULL,
  `project_deadline` date NOT NULL,
  `project_duration` varchar(50) NOT NULL,
  `employee_id` int(50) NOT NULL,
  `project_timeremaining` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectstbl`
--

INSERT INTO `projectstbl` (`project_id`, `project_name`, `employee_name`, `department`, `project_description`, `project_cost`, `project_start`, `project_deadline`, `project_duration`, `employee_id`, `project_timeremaining`) VALUES
(1, 'Project A', 'John Doe', 'IT', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 10000, '2023-04-01', '2024-02-05', '0 Years, 10 Months, and 4 Days', 1, '0 Years, 9 Months, and 30 Days'),
(2, 'Project B', 'Jane Doe', 'Sales', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 20000, '2023-02-02', '2023-04-06', '0 Years, 2 Months, and 4 Days', 2, '0 Years, 0 Months, and 0 Days'),
(3, 'Project C', 'John Doe', 'IT', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 12000, '2022-11-09', '2023-03-11', '0 Years, 4 Months, and 2 Days', 1, '0 Years, 0 Months, and 0 Days'),
(4, 'Project D', 'Kate Williams', 'IT', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 30000, '2022-01-05', '2023-04-05', '1 Years, 3 Months, and 0 Days', 10, '0 Years, 0 Months, and 0 Days'),
(5, 'Project E', 'Mike Smith', 'Sales', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 25000, '2023-03-03', '2025-03-05', '2 Years, 0 Months, and 2 Days', 5, '1 Years, 10 Months, and 27 Days');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employeetbl`
--
ALTER TABLE `employeetbl`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `projectstbl`
--
ALTER TABLE `projectstbl`
  ADD PRIMARY KEY (`project_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employeetbl`
--
ALTER TABLE `employeetbl`
  MODIFY `employee_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `projectstbl`
--
ALTER TABLE `projectstbl`
  MODIFY `project_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
