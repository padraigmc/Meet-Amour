CREATE DATABASE dbgroup13;
USE dbgroup13;

CREATE TABLE `dbgroup13`.`User` ( 
    `userID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `email` VARCHAR(60) NOT NULL UNIQUE,
    `username` VARCHAR(30) NOT NULL UNIQUE,
    `passwordHash` VARCHAR(255) NOT NULL,
    `dateCreated` DATETIME NOT NULL,
    `lastLogin` DATETIME NOT NULL,
    `isAdmin` TINYINT(1) NOT NULL DEFAULT 0,
    `isBanned` TINYINT(1) NOT NULL DEFAULT 0,
    `isDeactivated` TINYINT(1) NOT NULL DEFAULT 0,
    `isVerified` TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE `dbgroup13`.`Photo` (
    `photoID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `userID` INT(11) NOT NULL,
    `filePath` VARCHAR(60) NOT NULL,
    `dateUploaded` DATETIME NOT NULL,
    FOREIGN KEY (`userID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `dbgroup13`.`Gender` (
    `genderID` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `gender` VARCHAR(8) NOT NULL
);

CREATE TABLE `dbgroup13`.`Location` (
    `locationID` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `location` VARCHAR(10) NOT NULL
);

CREATE TABLE `dbgroup13`.`Hobby` (
    `hobbyID` INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hobby` VARCHAR(30) NOT NULL
);

CREATE TABLE `dbgroup13`.`UserHobby` (
    `hobbyID` INT(4) NOT NULL PRIMARY KEY,
    `userID` INT(11) NOT NULL,
    FOREIGN KEY (`hobbyID`)
    REFERENCES `Hobby`(`hobbyID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`userID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `dbgroup13`.`Notification` (
    `notificationID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fromUserID` INT(11) NOT NULL,
    `toUserID` INT(11) NOT NULL,
    `message` VARCHAR(200) NOT NULL,
    `dateSent` DATETIME NOT NULL,
    `seen` TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (`fromUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`toUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `dbgroup13`.`Like` (
    `likeID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fromUserID` INT(11) NOT NULL,
    `toUserID` INT(11) NOT NULL,
    `dateLiked` DATETIME NOT NULL,
    FOREIGN KEY (`fromUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`toUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `dbgroup13`.`Message` (
    `messageID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fromUserID` INT(11) NOT NULL,
    `toUserID` INT(11) NOT NULL,
    `message` VARCHAR(200) NOT NULL,
    `dateSent` DATETIME NOT NULL,
    `nextBlock` INT(11) NOT NULL,
    `seen` TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (`fromUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`toUserID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `dbgroup13`.`Profile` ( 
    `userID` INT(11) NOT NULL PRIMARY KEY,
    `fname` VARCHAR(30) NOT NULL,
    `lname` VARCHAR(30) NOT NULL,
    `dob` DATETIME NOT NULL,
    `genderID` INT(1) NOT NULL,
    `seekingID` INT(1) NOT NULL,
    `description` VARCHAR(280) NOT NULL,
    `locationID` INT(2) NULL DEFAULT NULL,
    FOREIGN KEY (`userID`)
    REFERENCES `User`(`userID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`genderID`)
    REFERENCES `Gender`(`genderID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`seekingID`)
    REFERENCES `Gender`(`genderID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (`locationID`)
    REFERENCES `Location`(`locationID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);