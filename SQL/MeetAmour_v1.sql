CREATE DATABASE DatingWebsite;
USE DatingWebsite;

CREATE TABLE `DatingWebsite`.`User` ( 
    `userID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    `email` VARCHAR(60) NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `fname` VARCHAR(30) NOT NULL,
    `lname` VARCHAR(30) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `salt` VARCHAR(128) NOT NULL
);

CREATE TABLE `DatingWebsite`.`Gender` (
    `genderID` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `gender` VARCHAR(8) NOT NULL
);

CREATE TABLE `DatingWebsite`.`Location` (
    `locationID` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `location` VARCHAR(10) NOT NULL
);

CREATE TABLE `DatingWebsite`.`Profile` ( 
    `userID` INT(11) NOT NULL PRIMARY KEY, 
    `age` INT(2) NOT NULL,
    `genderID` INT(1) NOT NULL,
    `seekingID` INT(1) NOT NULL,
    `description` VARCHAR(280) NOT NULL,
    `locationID` INT(1) NULL DEFAULT NULL,
    `photo` VARCHAR(60) NULL DEFAULT NULL,
    `banned` TINYINT(1) NULL DEFAULT 0,
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

CREATE TABLE `DatingWebsite`.`Match` (
    `userID1` INT(11) NOT NULL,
    `userID2` INT(11) NOT NULL,
    `matchDate` DATE NOT NULL,
    PRIMARY KEY(`userID1`, `useRID2`)
);

CREATE TABLE `DatingWebsite`.`Hobby` (
    `hobbyID` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `hobby` VARCHAR(10) NOT NULL
);

CREATE TABLE `DatingWebsite`.`UserHobby` (
    `hobbyID` INT(3) NOT NULL PRIMARY KEY,
    `userID` VARCHAR(10) NOT NULL,
    FOREIGN KEY (`hobbyID`)
    REFERENCES `Hobby`(`hobbyID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE `DatingWebsite`.`Notification` (
    `userID` INT(11) NOT NULL PRIMARY KEY,
    `content` VARCHAR(200) NOT NULL,
    `timeSent` DATETIME NOT NULL,
    FOREIGN KEY (`userID`)
    REFERENCES `User`(`userID`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

