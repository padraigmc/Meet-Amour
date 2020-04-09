-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2020 at 04:08 PM
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
CREATE DATABASE IF NOT EXISTS `dbgroup13` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbgroup13`;

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

--
-- Dumping data for table `Hobby`
--

INSERT INTO `Hobby` (`hobbyID`, `hobby`) VALUES
(1, 'Programming'),
(2, 'Debugging'),
(3, 'Refactoring'),
(4, 'Concurrency'),
(5, 'Object Oriented Design');

-- --------------------------------------------------------

--
-- Table structure for table `Like`
--

CREATE TABLE `Like` (
  `fromUserID` int(11) NOT NULL,
  `toUserID` int(11) NOT NULL,
  `dateLiked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Like`
--

INSERT INTO `Like` (`fromUserID`, `toUserID`, `dateLiked`) VALUES
(16, 20, '2020-04-01 13:01:23'),
(16, 21, '2020-04-06 18:47:00'),
(16, 34, '2020-04-06 19:19:11'),
(16, 36, '2020-04-06 18:58:36'),
(16, 39, '2020-04-06 15:11:42');

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
(1, 'Cork'),
(2, 'Kerry'),
(3, 'Limerick'),
(4, 'Clare'),
(5, 'Tipperary'),
(6, 'Waterford');

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
  `fileName` varchar(60) NOT NULL,
  `dateUploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Photo`
--

INSERT INTO `Photo` (`photoID`, `userID`, `fileName`, `dateUploaded`) VALUES
(71, 21, 'slice of fuitcake_1585502835442.jpg', '2020-03-29 19:27:15'),
(74, 18, 'Damian_1585610937281.jpg', '2020-03-31 01:28:57'),
(75, 22, 'elon_musk_spacex_boca_chica_vi_1585747465015.jpg', '2020-04-01 15:24:25'),
(77, 10, '5476322_1585749295703.jpg', '2020-04-01 15:54:55'),
(78, 23, 'mike5.PNG10B5D926-6555-4684-80_1585751010016.jpg', '2020-04-01 16:23:30'),
(80, 16, '03658_nightfallatlakeaurora_14_1586176337929.jpg', '2020-04-06 14:32:17');

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
  `description` varchar(255) NOT NULL,
  `locationID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Profile`
--

INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) VALUES
(10, 'Wasim', 'Aswad', '1984-08-08 00:00:00', 1, 2, 'this is me', 3),
(16, 'Mike', 'Wazowski', '1999-06-14 00:00:00', 2, 1, 'I have one eye', 4),
(18, 'Damian', 'Larkin', '2000-05-16 00:00:00', 1, 2, 'Hello!', 2),
(20, 'Padraig', 'McCarthy', '1999-06-14 00:00:00', 1, 1, 'like or i ban', 4),
(21, 'Mary', 'Ryan', '1994-01-16 00:00:00', 1, 1, 'hello I\'m mary', 4),
(22, 'Java', 'Lover', '1996-01-23 00:00:00', 2, 2, 'I just love java', 5),
(23, 'Mike', 'wazowski', '1993-06-17 00:00:00', 1, 2, 'hi ', 3),
(24, 'Aidan', 'Murphy', '1990-01-01 00:00:00', 1, 1, 'Test', 4),
(25, 'Conor', 'Ryan', '1900-04-01 00:00:00', 1, 2, 'I love computer science', 3),
(27, 'Cian', 'Hayes', '2001-01-25 00:00:00', 1, 2, 'UCC,\r\nYoughal,\r\nMuffins\r\n', 1),
(28, 'Love', 'Doctor', '1981-04-30 00:00:00', 1, 2, 'I\'m very rich and have a huge penis ', 3),
(29, 'Global', 'John', '1969-04-20 00:00:00', 3, 3, 'hi im global jon', 4),
(30, 'Nuha', 'Aswad', '2002-03-30 00:00:00', 2, 1, '', 4),
(31, 'Jon', 'Jones', '2002-03-06 00:00:00', 1, 2, 'Hey I like to fuck women', 4),
(33, 'Ashutosh', 'Yadav', '1999-09-08 00:00:00', 1, 2, 'I\'m sexy and I know it, I think. ', 3),
(34, 'Miguel', 'Ganjaman', '1955-09-04 00:00:00', 1, 1, 'uh', 4),
(35, 'jjjjjjjjjj', 'kkkkkkkkkkkk', '1901-01-03 00:00:00', 1, 1, 'kkkkkkkkkkkk', 4),
(36, 'Random', 'User', '2002-01-03 00:00:00', 1, 1, 'NULL', 4),
(37, 'Alan', 'Finnin', '1998-02-15 00:00:00', 1, 1, '', 4),
(38, 's', 's', '1900-12-31 00:00:00', 1, 1, 'name jeff', 4),
(39, 'Mary', 'Ross', '2001-07-13 00:00:00', 2, 1, '18 programming student looking for the one &lt;3', 3),
(40, 'a', 'ty', '2001-11-07 00:00:00', 1, 1, '&quot;;DROP TABLE users;', 4),
(41, 'John', 'Hackerman', '2002-01-09 00:00:00', 2, 2, 'oof', 3),
(42, '1', '2', '2002-02-26 00:00:00', 1, 1, 'yeet', 4),
(43, 'Fish', 'Face', '2000-10-28 00:00:00', 3, 1, 'I am fish', 4);

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
(10, 'wasimghazal@gmail.com', 'wasimghazal', '$2y$10$pLvKF6HfApmiAsrsWyGg0OvaWKjsyKfZaQvZ91e.Jkv3NAR7HDwH6', '2020-03-23 22:53:28', '2020-03-23 22:53:28', 0, 0, 0, 0),
(16, 'mike@wazow.com', 'mikewazowski', '$2y$10$8iAF2vPwqmKleYmekoC3/OYziGAEkUl1SvfngQVdfBy6kig94suGm', '2020-03-24 20:01:33', '2020-03-24 20:01:33', 0, 0, 0, 0),
(18, 'test@gmail.com', 'damianlarkin', '$2y$10$DRngIjVWB77dF80rFW7Ku.Dpw/mJI7zwBO.6iu141JzE9N5MqZF/q', '2020-03-27 18:41:27', '2020-03-27 18:41:27', 0, 0, 0, 0),
(20, 'padraig.mc1999@gmail.com', 'padraigmc', '$2y$10$cUo3MBIYcKgEMScOQZnwIevDucZ9AUFQh7wkENBEF0KAX6aW7fLAu', '2020-03-28 13:40:49', '2020-03-28 13:40:49', 0, 0, 0, 0),
(21, 'mary@gmail.com', 'mary', '$2y$10$tW0XA1LE13/xF8n0JoKajOVStXTRAGuI8M9JDljWFf67MQN2S.pTq', '2020-03-29 17:56:33', '2020-03-29 17:56:33', 0, 0, 0, 0),
(22, 'javalover@yahoo.com', 'i-love-java', '$2y$10$qInC1UJdaKf0wqmeX3uSsuYj07DwhWQNO8dM7A9vWD1PNrROb16bi', '2020-04-01 15:19:23', '2020-04-01 15:19:23', 0, 0, 0, 0),
(23, 'emad@hotmail.com', 'emad_alkasmi', '$2y$10$LPXW5gsMFFTM/fSI4TXbzu5hZ1Wbf.9nlTjyV2H5lfRqJg2NAaK3C', '2020-04-01 15:59:30', '2020-04-01 15:59:30', 0, 0, 0, 0),
(24, 'aidan@murphy.com', 'aidan', '$2y$10$cNIr4CYPE6qNvrFD.i5D2uWz72B2wdnryx4KDYloQ2w.V02H0XM7.', '2020-04-01 15:04:08', '2020-04-01 15:04:08', 0, 0, 0, 0),
(25, 'Conor.ryan@ul.ie', 'Conorryan', '$2y$10$1xNE.BfQOp0VZqZtzjPcreRKdGWDFzdsHuoe9bL2Gq.9LRhBpp4Aa', '2020-04-01 15:19:57', '2020-04-01 15:19:57', 0, 0, 0, 0),
(26, 'rossbyrn@gnail.com', 'doctorlove', '$2y$10$uDUOoVWBCEFW.PVfE5yBeOtj9l8Y7ENg5GICW1bmJpc9Z3vPoIln6', '2020-04-01 15:36:11', '2020-04-01 15:36:11', 0, 0, 0, 0),
(27, 'seejayhaytch@gmail.com', 'CianHayes', '$2y$10$tXrDAPR5ZvqDg9fJ2WuTr.4qLN4Bg86d8nSKmIPorPI7.SWivI9aK', '2020-04-01 15:44:52', '2020-04-01 15:44:52', 0, 0, 0, 0),
(28, 'rossbyrn@gmail.com', 'lovedoctor', '$2y$10$yt8vCqfOeMqXMsXH8eAQve70oB7n6vUfDcEhmQ.FQcp14Ix2tX8Ri', '2020-04-01 15:53:52', '2020-04-01 15:53:52', 0, 0, 0, 0),
(29, 'alternatexzibit3mc@gmail.com', 'JohnDaKid2k9Xx', '$2y$10$DqOvqq3N80ssuxFUG0Ig8u0D8N8XGrkofC6a4KwUY/eR5eUJsbI4W', '2020-04-01 16:24:27', '2020-04-01 16:24:27', 0, 0, 0, 0),
(30, 'nuhaaswad@yahoo.com', 'Nuha', '$2y$10$6TSIvk.tbifbKwEwsOsmg.m4C9fFqiyQF5rcO3JJV03XFYQok/3u.', '2020-04-01 17:34:30', '2020-04-01 17:34:30', 0, 0, 0, 0),
(31, 'jonjones@suckmedick.cum', 'jonjones', '$2y$10$EHNw.cc8AAK98pnHxok6bu.PWD1qHZzhqaiXv9is2tCJTiVv6abpa', '2020-04-03 18:17:49', '2020-04-03 18:17:49', 0, 0, 0, 0),
(32, 'sync1csgo@gmail.com', 'Test', '$2y$10$goxxSX6.zdvzYcKb.Jzd8ewYbC8XtUdB6s3ob4vA.u6hc0G/zE0Ge', '2020-04-04 20:20:01', '2020-04-04 20:20:01', 0, 0, 0, 0),
(33, 'gamertech109@gmail.com', 'test3', '$2y$10$RU6BQNnt2s5LTzsylklopeIO6SctuEHkqL1uK1ao0UHi4.QhpXHU.', '2020-04-04 20:22:48', '2020-04-04 20:22:48', 0, 0, 0, 0),
(34, 'uh@uh.com', 'Miguel', '$2y$10$aM7KlBUKWOQax/TOaJAqpe2xVYqa1N00ZNLeYfPJGEqyIft3qXqQS', '2020-04-05 03:56:38', '2020-04-05 03:56:38', 0, 0, 0, 0),
(35, 'sss@gmail.com', 'jolene12', '$2y$10$wD6hspVx8DybLt7fFRUL4.uPzGoRBXEIkjX86dakMNwrkmk0KPw1W', '2020-04-05 14:36:18', '2020-04-05 14:36:18', 0, 0, 0, 0),
(36, 'Random@User.com', 'RandomUser', '$2y$10$b3S83ni4A1iqZiwA9tyRqOFzU/PYm/0o0IKeTTl6f/XvzkHBZss.O', '2020-04-05 15:53:06', '2020-04-05 15:53:06', 0, 0, 0, 0),
(37, 'user@user.com', 'user', '$2y$10$qRy7CLACmSnthyLNs1ZjnOgUwYXelJTOBnfrecyh7WuXluofBuewq', '2020-04-05 17:26:14', '2020-04-05 17:26:14', 0, 0, 0, 0),
(38, 'awjgucewnfmkrghrxb@ttirv.org', 'Ddog', '$2y$10$lgEzfqYxEfCfFuxudUoime7AQRZseBXa9MPiOzYcxeE0cztF1KhqO', '2020-04-05 18:03:35', '2020-04-05 18:03:35', 0, 0, 0, 0),
(39, 'maryross@mail.com', 'maryross', '$2y$10$QrpCCYK1vjYr0BtSXAWX..t0783FQ9koSAGdhMz3bRa1HWkmmSvRe', '2020-04-05 20:10:27', '2020-04-05 20:10:27', 0, 0, 0, 0),
(40, 'test@test.com', 'John', '$2y$10$iuFHB2lDPDT9DpPaKvppZ.VLOc/tlZDo1.VJ59T/3r54p9.PJBaYW', '2020-04-05 21:01:40', '2020-04-05 21:01:40', 0, 0, 0, 0),
(41, 'hacker@notahacker.com', 'hacker-man', '$2y$10$TR2z9EhJuyXpzUTPKGHEFed5XS53W97YNyv5k6hMBG5pF49ZebyVa', '2020-04-05 21:09:02', '2020-04-05 21:09:02', 0, 0, 0, 0),
(42, 'yeet@gmail.com', 'yeet', '$2y$10$9bA1yRzPhsjLpZjOXCQCOO7.EyCVcoV2UDQspF3VKGyalko0Whxpm', '2020-04-05 22:53:11', '2020-04-05 22:53:11', 0, 0, 0, 0),
(43, 'Fish@face.com', 'Fishface', '$2y$10$/gLS3OjcYGdiul8ZY5BHWuwB8SFlpBB3JT6RHZIINgQqzVc92M2q.', '2020-04-06 00:31:45', '2020-04-06 00:31:45', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserHobby`
--

CREATE TABLE `UserHobby` (
  `hobbyID` int(4) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UserHobby`
--

INSERT INTO `UserHobby` (`hobbyID`, `userID`) VALUES
(1, 10),
(1, 16),
(3, 16),
(4, 16),
(1, 18),
(3, 21),
(4, 21),
(5, 21),
(1, 22),
(5, 22),
(4, 24),
(1, 27),
(1, 29),
(2, 29),
(3, 29),
(4, 29),
(1, 34),
(2, 34),
(3, 34),
(1, 36),
(2, 36),
(3, 36),
(4, 36),
(1, 37),
(2, 37),
(5, 37),
(1, 42),
(2, 42),
(3, 42);

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
  ADD PRIMARY KEY (`fromUserID`,`toUserID`),
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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `UserHobby`
--
ALTER TABLE `UserHobby`
  ADD PRIMARY KEY (`hobbyID`,`userID`),
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
  MODIFY `hobbyID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Location`
--
ALTER TABLE `Location`
  MODIFY `locationID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `photoID` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
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
