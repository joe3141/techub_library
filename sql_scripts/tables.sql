-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2015 at 03:02 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Library`
--

-- --------------------------------------------------------

--
-- Table structure for table `Books`
--

CREATE TABLE `Books` (
  `isbn` bigint(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `author` varchar(30) NOT NULL,
  `add_date` date NOT NULL,
  `added_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Books`
--

INSERT INTO `Books` (`isbn`, `name`, `author`, `add_date`, `added_by`) VALUES
(123456, 'War and Peace', 'Leo Tolstoy', '2015-11-27', 'youssefzidan.yz@gmail.com'),
(654321, 'Tale of two cities', 'Charles Dickens', '2015-11-27', 'youssefzidan.yz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Copies`
--

CREATE TABLE `Copies` (
  `id` int(11) NOT NULL,
  `isbn` bigint(20) NOT NULL,
  `borrower` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Copies`
--

INSERT INTO `Copies` (`id`, `isbn`, `borrower`) VALUES
(28, 123456, 'youssefzidan.yz@gmail.com'),
(29, 123456, NULL),
(30, 123456, NULL),
(31, 123456, NULL),
(32, 123456, NULL),
(33, 654321, NULL),
(34, 654321, NULL),
(35, 654321, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`email`, `name`, `password`) VALUES
('youssefzidan.yz@gmail.com', 'Youssef Zidan', 'sarcox');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Books`
--
ALTER TABLE `Books`
  ADD PRIMARY KEY (`isbn`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `Copies`
--
ALTER TABLE `Copies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrower` (`borrower`),
  ADD KEY `isbn` (`isbn`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Copies`
--
ALTER TABLE `Copies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Books`
--
ALTER TABLE `Books`
  ADD CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `Users` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Copies`
--
ALTER TABLE `Copies`
  ADD CONSTRAINT `Copies_ibfk_2` FOREIGN KEY (`borrower`) REFERENCES `Users` (`email`),
  ADD CONSTRAINT `Copies_ibfk_3` FOREIGN KEY (`isbn`) REFERENCES `Books` (`isbn`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;