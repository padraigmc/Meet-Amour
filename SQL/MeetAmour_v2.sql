DROP DATABASE MeetAmour;

CREATE DATABASE MeetAmour;
USE MeetAmour;

CREATE TABLE `MeetAmour`.`User` ( 
    `userID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `email` VARCHAR(60) NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `fname` VARCHAR(30) NOT NULL,
    `lname` VARCHAR(30) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `salt` VARCHAR(128) NOT NULL,
    `dateCreated` DATETIME NOT NULL,
    `lastLogin` DATETIME NOT NULL,
    `isAdmin` TINYINT(1) NOT NULL DEFAULT 0,
    `isBanned` TINYINT(1) NOT NULL DEFAULT 0,
    `isDeactivated` TINYINT(1) NOT NULL DEFAULT 0,
    `isVerified` TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE `MeetAmour`.`Photo` (
    `photoID` INT(11) NOT NULL AUTO_INCREMENT,
    `userID` INT(11) NOT NULL,
    `filePath` VARCHAR(60) NOT NULL,
    `dateUploaded` DATETIME NOT NULL,
    PRIMARY KEY (`photoID`, `userID`)
);

CREATE TABLE `MeetAmour`.`Gender` (
    `genderID` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `gender` VARCHAR(8) NOT NULL
);

CREATE TABLE `MeetAmour`.`Location` (
    `locationID` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `location` VARCHAR(10) NOT NULL
);

CREATE TABLE `MeetAmour`.`Hobby` (
    `hobbyID` INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hobby` VARCHAR(30) NOT NULL
);

CREATE TABLE `MeetAmour`.`UserHobby` (
    `hobbyID` INT(4) NOT NULL PRIMARY KEY,
    `userID` VARCHAR(11) NOT NULL,
    FOREIGN KEY (`hobbyID`)
    REFERENCES `Hobby`(`hobbyID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE `MeetAmour`.`Notification` (
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

CREATE TABLE `MeetAmour`.`Like` (
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

CREATE TABLE `MeetAmour`.`Message` (
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

CREATE TABLE `MeetAmour`.`Profile` ( 
    `userID` INT(11) NOT NULL PRIMARY KEY, 
    `age` INT(3) NOT NULL,
    `genderID` INT(1) NOT NULL,
    `seekingID` INT(1) NOT NULL,
    `description` VARCHAR(280) NOT NULL,
    `locationID` INT(2) NULL DEFAULT NULL,
    `photoID` INT(11) NULL DEFAULT NULL,
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
        ON DELETE CASCADE,
    FOREIGN KEY (`photoID`)
    REFERENCES `Photo`(`photoID`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);