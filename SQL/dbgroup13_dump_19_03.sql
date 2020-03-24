-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2020 at 04:37 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbgroup13`
--

-- --------------------------------------------------------

--
-- Table structure for table `Gender`
--

CREATE TABLE `Gender` (
  `genderID` int(1) NOT NULL,
  `gender` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Gender`
--

INSERT INTO `Gender` (`genderID`, `gender`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `Hobby`
--

CREATE TABLE `Hobby` (
  `hobbyID` int(4) NOT NULL,
  `hobby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Like`
--

CREATE TABLE `Like` (
  `likeID` int(11) NOT NULL,
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  `dateLiked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Location`
--

CREATE TABLE `Location` (
  `locationID` int(2) NOT NULL,
  `location` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Location`
--

INSERT INTO `Location` (`locationID`, `location`) VALUES
(1, 'test'),
(2, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE `Message` (
  `messageID` int(11) NOT NULL,
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `dateSent` datetime NOT NULL,
  `nextBlock` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Notification`
--

CREATE TABLE `Notification` (
  `notificationID` int(55) NOT NULL,
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `dateSent` datetime NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Photo`
--

CREATE TABLE `Photo` (
  `photoID` int(55) NOT NULL,
  `userID` int(11) NOT NULL,
  `filePath` varchar(60) NOT NULL,
  `dateUploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Profile`
--

CREATE TABLE `Profile` (
  `userID` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `dob` datetime NOT NULL,
  `genderID` int(1) NOT NULL,
  `seekingID` int(1) NOT NULL,
  `description` varchar(280) NOT NULL,
  `locationID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Profile`
--

INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) VALUES
(2, 'Test', 'User', '1999-03-17 00:00:00', 1, 2, 'Hello, this is a test', 1),
(3, 'Joe', 'Jonas', '1900-03-17 00:00:00', 2, 3, 'THISI S A AOHFQJEWF', 1),
(4, 'PÃ¡draig', 'McCarthy', '2000-01-01 00:00:00', 1, 1, 'Hello world', 1),
(5, 'Adam', 'Driver', '1983-11-19 00:00:00', 1, 2, 'i swole', 1),
(6, 'test', 'user', '2005-12-14 00:00:00', 1, 1, 'tester', 1);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastLogin` datetime NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isBanned` tinyint(1) NOT NULL DEFAULT '0',
  `isDeactivated` tinyint(1) NOT NULL DEFAULT '0',
  `isVerified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `email`, `username`, `passwordHash`, `dateCreated`, `lastLogin`, `isAdmin`, `isBanned`, `isDeactivated`, `isVerified`) VALUES
(1, 'padraig@meetamour.com', 'padraigmc', '$2y$10$4.afL6sXo1VncTsAC4zEEudOGY3tc/6KgJYI.4z74ws2mEDonK80W', '2020-03-17 19:24:49', '2020-03-17 19:24:49', 0, 0, 0, 0),
(2, 'test1@meetamour.com', 'TestUser1', '$2y$10$9BXEftyT8VnQ6cOgwngZL.ATWzA65XwaVZLoV/QshmuXP5su3NLui', '2020-03-17 21:24:55', '2020-03-17 21:24:55', 0, 0, 0, 0),
(3, 'test2@meetamour.com', 'TestUser2', '$2y$10$Av8sKilCDWhLIqiXHozaE.YCea6W90bhw8bqoUMIEdHVw4tivYeZm', '2020-03-17 21:56:51', '2020-03-17 21:56:51', 0, 0, 0, 0),
(4, 'test3@meetamour.com', 'TestUser3', '$2y$10$TIaAyHAWx/myxuIvC91VGuwt9DhXEJcth84A7WbOjU18pbxIr61ES', '2020-03-17 21:59:04', '2020-03-17 21:59:04', 0, 0, 0, 0),
(5, 'adam@driver.com', 'adamDriver123', '$2y$10$qy/QyCAZyu6R5wFQq4nnPOXQdeu4/uxIOJaInDrBddtszY2mmGHAq', '2020-03-17 23:50:54', '2020-03-17 23:52:17', 0, 0, 0, 0),
(6, 'test99@gmail.com', 'testUser99', '$2y$10$5Yb7InczAO131P/5LxnHkeb/ozy1PS8x22JN9ev6tl1dCSXydIa9y', '2020-03-19 17:21:31', '2020-03-19 17:21:31', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserHobby`
--

CREATE TABLE `UserHobby` (
  `hobbyID` int(4) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Gender`
--
ALTER TABLE `Gender`
  ADD PRIMARY KEY (`genderID`);

--
-- Indexes for table `Hobby`
--
ALTER TABLE `Hobby`
  ADD PRIMARY KEY (`hobbyID`);

--
-- Indexes for table `Like`
--
ALTER TABLE `Like`
  ADD PRIMARY KEY (`likeID`),
  ADD KEY `fromUserID` (`fromUserID`),
  ADD KEY `toUserID` (`toUserID`);

--
-- Indexes for table `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`locationID`);

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`messageID`,`fromUserID`,`toUserID`),
  ADD KEY `fromUserID` (`fromUserID`),
  ADD KEY `toUserID` (`toUserID`);

--
-- Indexes for table `Notification`
--
ALTER TABLE `Notification`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `fromUserID` (`fromUserID`),
  ADD KEY `toUserID` (`toUserID`);

--
-- Indexes for table `Photo`
--
ALTER TABLE `Photo`
  ADD PRIMARY KEY (`photoID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `Profile`
--
ALTER TABLE `Profile`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `genderID` (`genderID`),
  ADD KEY `seekingID` (`seekingID`),
  ADD KEY `locationID` (`locationID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `UserHobby`
--
ALTER TABLE `UserHobby`
  ADD PRIMARY KEY (`hobbyID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Gender`
--
ALTER TABLE `Gender`
  MODIFY `genderID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Hobby`
--
ALTER TABLE `Hobby`
  MODIFY `hobbyID` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Like`
--
ALTER TABLE `Like`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Location`
--
ALTER TABLE `Location`
  MODIFY `locationID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Notification`
--
ALTER TABLE `Notification`
  MODIFY `notificationID` int(55) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Photo`
--
ALTER TABLE `Photo`
  MODIFY `photoID` int(55) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Like`
--
ALTER TABLE `Like`
  ADD CONSTRAINT `Like_ibfk_1` FOREIGN KEY (`fromUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Like_ibfk_2` FOREIGN KEY (`toUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`fromUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`toUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Notification`
--
ALTER TABLE `Notification`
  ADD CONSTRAINT `Notification_ibfk_1` FOREIGN KEY (`fromUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Notification_ibfk_2` FOREIGN KEY (`toUserID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Photo`
--
ALTER TABLE `Photo`
  ADD CONSTRAINT `Photo_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Profile`
--
ALTER TABLE `Profile`
  ADD CONSTRAINT `Profile_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Profile_ibfk_2` FOREIGN KEY (`genderID`) REFERENCES `Gender` (`genderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Profile_ibfk_3` FOREIGN KEY (`seekingID`) REFERENCES `Gender` (`genderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Profile_ibfk_4` FOREIGN KEY (`locationID`) REFERENCES `Location` (`locationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UserHobby`
--
ALTER TABLE `UserHobby`
  ADD CONSTRAINT `UserHobby_ibfk_1` FOREIGN KEY (`hobbyID`) REFERENCES `Hobby` (`hobbyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserHobby_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
