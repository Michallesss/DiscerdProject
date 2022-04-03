/*Authors: Mateusz Simkiewicz, Michał Wieczorek, Szymon Kulej.*/
DROP DATABASE IF EXISTS `DiscerdDB`;
CREATE DATABASE `DiscerdDB`;
USE `DiscerdDB`;


/*account information and management*/
CREATE TABLE `account`
(
    `ID_account` INT(11) PRIMARY KEY AUTO_INCREMENT,    /*using also as user tag*/
    `login` VARCHAR(30),
    `password` VARCHAR(30),
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
    `ID_group` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `group_name` VARCHAR(50),                           
    `group_icon` BLOB                                   /*custom group icon/picture*/
);

/*friendships and friends invites*/
CREATE TABLE `friendship`/*account_account*/
(
    `ID_friendship` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_account1` INT(11), FOREIGN KEY (`ID_account1`) REFERENCES `account`(`ID_account`),                             /*who invited*/
    `ID_account2` INT(11), FOREIGN KEY (`ID_account2`) REFERENCES `account`(`ID_account`),                             /*who's invited*/
    `status` INT(1)                                                                                                    /*0-reqested 1-accepted 2-rejected 3-unfriended 4-blocked*/
);

/*permission names and values*/
CREATE TABLE `permission`
(
    `ID_permission` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `permission_name` VARCHAR(255),                      /*name of permission*/
    `permission_value` INT(3),                           /*state of permission*/
    `permission_desc` VARCHAR(255)                       /*description*/
);

/*table describing servers*/
CREATE TABLE `server`
(
    `ID_server` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `server_name` VARCHAR(50),
    `server_icon` BLOB,
    `is_public` BOOLEAN DEFAULT FALSE                                  /*is server public*/
);

/*emoji table for custom server emojis*/
CREATE TABLE `emoji_sticker`
(
    `ID_emoji_sticker` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(25),
    `picture` BLOB NOT NULL,
    `type` INT(1), /*1-emoji, 2-sticker*/
    `ID_server` INT(11), FOREIGN KEY(`ID_server`) REFERENCES `server`(`ID_server`)
);

/*server roles*/
CREATE TABLE `role`
(
    `ID_role` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `rolename` VARCHAR(32),
    `COLOR` VARCHAR(7),
    `weight` INT(3),
    `ID_server` INT(11), FOREIGN KEY(`ID_server`) REFERENCES `server`(`ID_server`),
    `ID_permission` int(11), FOREIGN KEY(`ID_permission`) REFERENCES `permission`(`ID_permission`)
);

/*roles permissions*/
CREATE TABLE `role_permission`
(
    `ID_role_permission` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_role` INT(11), FOREIGN KEY (`ID_role`) REFERENCES `role`(`ID_role`),
    `ID_permission` int(11), FOREIGN KEY(`ID_permission`) REFERENCES `permission`(`ID_permission`)
);

/*servers invites*/
CREATE TABLE `invite`
(
    `ID_invite` INT(11) PRIMARY KEY AUTO_INCREMENT,     /*also as invite tag*/  /*prosze mi się od tego odpierolić jeśli naprawdę chcecie żeby to były jakieś jebane literki to się zrobi w js żeby się zamieniało na szesnastkowy czy coś a nie kombinujemy*/
    `ID_server` INT(11), FOREIGN KEY(`ID_server`) REFERENCES `server`(`ID_server`),
    `expire_date` DATETIME,
    `create_date` DATETIME,
    `ID_account` INT(11), FOREIGN KEY(`ID_account`) REFERENCES `account`(`ID_account`)
);

/*server categories*/
CREATE TABLE `category`
(
    `ID_category` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_server` INT(11), FOREIGN KEY(`ID_server`) REFERENCES `server`(`ID_server`),
    `name` VARCHAR(50),
    `weight` INT(11)
);

/*categories permissions*/
CREATE TABLE `category_permission`
(
    `ID_category_permission` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_category` INT(11), FOREIGN KEY (`ID_category`) REFERENCES `category`(`ID_category`),
    `ID_permission` int(11), FOREIGN KEY(`ID_permission`) REFERENCES `permission`(`ID_permission`)
);

/*text channels*/
CREATE TABLE `channel`
(
    `ID_channel` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_category` INT(11), FOREIGN KEY(`ID_category`) REFERENCES `category`(`ID_category`),
    `name` VARCHAR(50),
    `weight` INT(11),
    `type` int(1)            /*1-text chanel; 2-voice channel*/
);

/*channel permissions*/
CREATE TABLE `channel_permission`
(
    `ID_channel_permission` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_channel` INT(11), FOREIGN KEY (`ID_channel`) REFERENCES `channel`(`ID_channel`),
    `ID_permission` int(11), FOREIGN KEY(`ID_permission`) REFERENCES `permission`(`ID_permission`)
);

/*messages (private, group, server)*/
CREATE TABLE `message`
(
    `ID_message` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_SENDER` INT(11),                    FOREIGN KEY (`ID_SENDER`) REFERENCES `account`(`ID_account`),                              /*from who*/
    `ID_RECIPIENT` INT(11) DEFAULT NULL,    FOREIGN KEY (`ID_RECIPIENT`) REFERENCES `account`(`ID_account`),                           /*to who*/
    `ID_group` INT(11) DEFAULT NULL,        FOREIGN KEY (`ID_group`) REFERENCES `group`(`ID_group`),                                   /*where (if group)*/
    `ID_channel` INT(11) DEFAULT NULL,      FOREIGN KEY (`ID_channel`) REFERENCES `channel`(`ID_channel`),                       /*where (if server channel)*/
    `messagedate` DATETIME,
    `content` VARCHAR(512)
);

/*table for linking servers/groups and accounts*/
CREATE TABLE `server_group_account`
(
    `ID_server_group_account` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_server` INT(11) DEFAULT NULL,           FOREIGN KEY(`ID_server`) REFERENCES `server`(`ID_server`),
    `ID_group` INT(11) DEFAULT NULL,            FOREIGN KEY(`ID_group`) REFERENCES `group`(`ID_group`),
    `ID_account` INT(11),                       FOREIGN KEY(`ID_account`) REFERENCES `account`(`ID_account`),
    `muted` int(1) DEFAULT 0
);

/*table for linking roles and accounts*/
CREATE TABLE `role_account`
(
    `ID_role_account` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_role` INT(11), FOREIGN KEY(`ID_role`) REFERENCES `role`(`ID_role`),
    `ID_account` INT(11), FOREIGN KEY(`ID_account`) REFERENCES `account`(`ID_account`)
);

/*table for eventual personal permissions*/
CREATE TABLE `personal_permission`
(
    `ID_personal_permission` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_server_account` INT(11), FOREIGN KEY(`ID_server_account`) REFERENCES `server_group_account`(`ID_server_group_account`),
    `ID_permission` int(11), FOREIGN KEY(`ID_permission`) REFERENCES `permission`(`ID_permission`)
);