/*Authors: Mateusz Simkiewicz, Michał Wieczorek, Szymon Kulej.*/
DROP DATABASE IF EXISTS `DiscerdDB`;
CREATE DATABASE `DiscerdDB`;
USE `DiscerdDB`;


/*account information and management*/
CREATE TABLE `account`
(
    `accountID` INT(11) PRIMARY KEY AUTO_INCREMENT,    /*using also as user tag*/
    `login` VARCHAR(30),
    `password` VARCHAR(100),
    `phone` INT(9),                                     /*phone number*/
    `email` VARCHAR(30),                                /*email adress*/
    `nickname` VARCHAR(30),                             /*difrent between nickname and login is that nickname displays on ur profil and can be repetitive whereas, login is using to log in*/
    `aboutme` VARCHAR(150),                             /*biography*/
    `status` VARCHAR(30),                               /*status message*/
    `activity` INT(1),                                  /*1-Online, 2-Do not distrub, 3-IDle, 4-Offline*/
    `pfp` BLOB,                                         /*profile picture*/
    `banner` BLOB                                       /*profile banner*/
);

/*table for making group chats*/
CREATE TABLE `group`
(
    `groupID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `group_name` VARCHAR(50),                           
    `group_icon` BLOB                                   /*custom group icon/picture*/
);

/*friendships and friends invites*/
CREATE TABLE `friendship`/*account_account*/
(
    `friendshipID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `senderID` INT(11), FOREIGN KEY (`senderID`) REFERENCES `account`(`accountID`),                             /*who invited*/
    `reciverID` INT(11), FOREIGN KEY (`reciverID`) REFERENCES `account`(`accountID`),                             /*who's invited*/
    `status` INT(1)                                                                                                    /*0-reqested 1-accepted 2-rejected 3-unfriended 4-blocked*/
);

/*permission names and values*/
CREATE TABLE `permission`
(
    `permissionID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `permission_name` VARCHAR(255),                      /*name of permission*/
    `permission_value` INT(3),                           /*state of permission*/
    `permission_desc` VARCHAR(255)                       /*description*/
);

/*table describing servers*/
CREATE TABLE `server`
(
    `serverID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `server_name` VARCHAR(50),
    `server_icon` BLOB,
    `is_public` BOOLEAN DEFAULT FALSE                                  /*is server public*/
);

/*emoji table for custom server emojis*/
CREATE TABLE `emoji_sticker`
(
    `emoji_stickerID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(25),
    `picture` BLOB NOT NULL,
    `type` INT(1), /*1-emoji, 2-sticker*/
    `serverID` INT(11), FOREIGN KEY(`serverID`) REFERENCES `server`(`serverID`)
);

/*server roles*/
CREATE TABLE `role`
(
    `roleID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `role_name` VARCHAR(32),
    `colour` VARCHAR(7),
    `weight` INT(3),
    `serverID` INT(11), FOREIGN KEY(`serverID`) REFERENCES `server`(`serverID`)
);

/*roles permissions*/
CREATE TABLE `role_permission`
(
    `role_permissionID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `roleID` INT(11), FOREIGN KEY (`roleID`) REFERENCES `role`(`roleID`),
    `permissionID` int(11), FOREIGN KEY(`permissionID`) REFERENCES `permission`(`permissionID`)
);

/*servers invites*/
CREATE TABLE `invite`
(
    `inviteID` INT(11) PRIMARY KEY AUTO_INCREMENT,     /*also as invite tag*/
    `serverID` INT(11), FOREIGN KEY(`serverID`) REFERENCES `server`(`serverID`),
    `expire_date` DATETIME,
    `create_date` DATETIME,
    `accountID` INT(11), FOREIGN KEY(`accountID`) REFERENCES `account`(`accountID`)
);

/*server categories*/
CREATE TABLE `category`
(
    `categoryID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `serverID` INT(11), FOREIGN KEY(`serverID`) REFERENCES `server`(`serverID`),
    `name` VARCHAR(50),
    `weight` INT(11)
);

/*categories permissions*/
CREATE TABLE `category_permission`
(
    `category_permissionID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `categoryID` INT(11), FOREIGN KEY (`categoryID`) REFERENCES `category`(`categoryID`),
    `permissionID` int(11), FOREIGN KEY(`permissionID`) REFERENCES `permission`(`permissionID`)
);

/*text channels*/
CREATE TABLE `channel`
(
    `channelID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `categoryID` INT(11), FOREIGN KEY(`categoryID`) REFERENCES `category`(`categoryID`),
    `name` VARCHAR(50),
    `weight` INT(11),
    `type` int(1)            /*1-text chanel; 2-voice channel*/
);

/*channel permissions*/
CREATE TABLE `channel_permission`
(
    `channel_permissionID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `channelID` INT(11), FOREIGN KEY (`channelID`) REFERENCES `channel`(`channelID`),
    `permissionID` int(11), FOREIGN KEY(`permissionID`) REFERENCES `permission`(`permissionID`)
);

/*messages (private, group, server)*/
CREATE TABLE `message`
(
    `messageID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `senderID` INT(11),                    FOREIGN KEY (`senderID`) REFERENCES `account`(`accountID`),                              /*from who*/
    `recipientID` INT(11) DEFAULT NULL,    FOREIGN KEY (`recipientID`) REFERENCES `account`(`accountID`),                           /*to who*/
    `groupID` INT(11) DEFAULT NULL,        FOREIGN KEY (`groupID`) REFERENCES `group`(`groupID`),                                   /*where (if group)*/
    `channelID` INT(11) DEFAULT NULL,      FOREIGN KEY (`channelID`) REFERENCES `channel`(`channelID`),                       /*where (if server channel)*/
    `message_date` DATETIME,
    `content` VARCHAR(512)
);

/*table for linking servers/groups and accounts*/
CREATE TABLE `server_group_account`
(
    `server_group_accountID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `serverID` INT(11) DEFAULT NULL,           FOREIGN KEY(`serverID`) REFERENCES `server`(`serverID`),
    `groupID` INT(11) DEFAULT NULL,            FOREIGN KEY(`groupID`) REFERENCES `group`(`groupID`),
    `accountID` INT(11),                       FOREIGN KEY(`accountID`) REFERENCES `account`(`accountID`),
    `muted` int(1) DEFAULT 0
);

/*table for linking roles and accounts*/
CREATE TABLE `role_account`
(
    `role_accountID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `roleID` INT(11), FOREIGN KEY(`roleID`) REFERENCES `role`(`roleID`),
    `accountID` INT(11), FOREIGN KEY(`accountID`) REFERENCES `account`(`accountID`)
);

/*table for eventual personal permissions*/
CREATE TABLE `personal_permission`
(
    `personal_permissionID` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `server_accountID` INT(11), FOREIGN KEY(`server_accountID`) REFERENCES `server_group_account`(`server_group_accountID`),
    `permissionID` int(11), FOREIGN KEY(`permissionID`) REFERENCES `permission`(`permissionID`)
);