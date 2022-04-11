USE `DiscerdDB`;

INSERT INTO `account` (`accountID`, `login`, `password`, `phone`, `email`, `nickname`, `aboutme`, `status`, `activity`, `pfp`, `banner`)
VALUES (NULL, 'Mikael', 'admin', '123456789', 'michalw@discerd.pl', 'Mikael', 'a jak pan jezus powiedział?', NULL, '1', null, null);
INSERT INTO `account` (`accountID`, `login`, `password`, `phone`, `email`, `nickname`, `aboutme`, `status`, `activity`, `pfp`, `banner`)
VALUES (NULL, 'Szymon', 'admin', '987654321', 'szymonk@discerd.pl', 'dhorbon', 'tak jak pan jezus powiedział', 'programming...', '2', NULL, NULL);
INSERT INTO `account` (`accountID`, `login`, `password`, `phone`, `email`, `nickname`, `aboutme`, `status`, `activity`, `pfp`, `banner`)
VALUES (NULL, 'maciekcieslak', 'maciuskox', '519643782', 'promaciek@wp.pl', 'dzikimacius', 'kocham pana szczepanika', 'hej bejb', NULL, NULL, NULL);

INSERT INTO `group` (`groupID`, `group_name`, `group_icon`)
VALUES (NULL, 'friends', NULL);

INSERT INTO `server_group_account` (`server_group_accountID`, `serverID`, `groupID`, `accountID`, `muted`)
VALUES (NULL, NULL, '1', '1', '1');
INSERT INTO `server_group_account` (`server_group_accountID`, `serverID`, `groupID`, `accountID`, `muted`)
VALUES (NULL, NULL, '1', '2', '0');

INSERT INTO `friendship` (`friendshipID`, `senderID`, `reciverID`, `status`)
VALUES (NULL, '1', '2', '1');
INSERT INTO `friendship` (`friendshipID`, `senderID`, `reciverID`, `status`)
VALUES (NULL, '3', '1', '0');

INSERT INTO `server` (`serverID`, `server_name`, `server_icon`, `is_public`)
VALUES (NULL, 'DiscerdAnnouncements', NULL, '0');

INSERT INTO `server_group_account` (`server_group_accountID`, `serverID`, `groupID`, `accountID`, `muted`)
VALUES (NULL, '1', NULL, '1', '0');
INSERT INTO `server_group_account` (`server_group_accountID`, `serverID`, `groupID`, `accountID`, `muted`)
VALUES (NULL, '1', NULL, '2', '0');
INSERT INTO `server_group_account` (`server_group_accountID`, `serverID`, `groupID`, `accountID`, `muted`)
VALUES (NULL, '1', NULL, '3', '0');

INSERT INTO `category` (`categoryID`, `serverID`, `name`, `weight`)
VALUES (NULL, '1', 'text-channels', '1');
INSERT INTO `category` (`categoryID`, `serverID`, `name`, `weight`)
VALUES (NULL, '1', 'voice-channels', '2');
INSERT INTO `channel` (`channelID`, `categoryID`, `name`, `weight`, `type`)
VALUES (NULL, '1', 'main', '1', '1');
INSERT INTO `channel` (`channelID`, `categoryID`, `name`, `weight`, `type`)
VALUES (NULL, '1', 'spam', '2', '1');
INSERT INTO `channel` (`channelID`, `categoryID`, `name`, `weight`, `type`)
VALUES (NULL, '2', 'vc1', '1', '2');
INSERT INTO `channel` (`channelID`, `categoryID`, `name`, `weight`, `type`)
VALUES (NULL, '2', 'vc2', '2', '2');

INSERT INTO `invite` (`inviteID`, `serverID`, `expire_date`, `create_date`, `accountID`)
VALUES (NULL, '1', '2032-06-23 01:27:49', '2022-04-03 02:27:49.000000', '1');
INSERT INTO `invite` (`inviteID`, `serverID`, `expire_date`, `create_date`, `accountID`)
VALUES (NULL, '1', '2022-04-03 02:29:56.000000', '2022-04-10 01:29:56', '3');

INSERT INTO `emoji_sticker` (`emoji_stickerID`, `name`, `picture`, `type`, `serverID`)
VALUES (NULL, 'smirk', 2137, '1', '1');
INSERT INTO `emoji_sticker` (`emoji_stickerID`, `name`, `picture`, `type`, `serverID`)
VALUES (NULL, 'pogchamp', 2137, '2', '1');

INSERT INTO `message` (`messageID`, `senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`)
VALUES (NULL, '1', '2', NULL, NULL, '2022-04-03 01:47:04.000000', 'Siema');
INSERT INTO `message` (`messageID`, `senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`)
VALUES (NULL, '2', '1', NULL, NULL, '2022-04-03 01:48:17.000000', 'cześć');
INSERT INTO `message` (`messageID`, `senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`)
VALUES (NULL, '1', '2', NULL, NULL, '2022-04-03 01:49:35.000000', 'co tam?');
INSERT INTO `message` (`messageID`, `senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`)
VALUES (NULL, '2', '1', NULL, NULL, '2022-04-03 01:51:10.000000', 'dobrze');
INSERT INTO `message` (`messageID`, `senderID`, `recipientID`, `groupID`, `channelID`, `message_date`, `content`)
VALUES (NULL, '2', '1', NULL, NULL, '2022-04-03 01:51:44.000000', 'a u ciebie?');


INSERT INTO `permission` (`permissionID`,`permission_name`,`permission_value`,`permission_desc`)
VALUES
(NULL,'Wyświetlanie kanałów',0,'Pozwala członkom na domyślne wyświetlanie kanałów (z wyjątkiem kanałów prywatnych).'),
(NULL,'Wyświetlanie kanałów',1,'Pozwala członkom na domyślne wyświetlanie kanałów (z wyjątkiem kanałów prywatnych).'),
(NULL,'Wyświetlanie kanałów',2,'Pozwala członkom na domyślne wyświetlanie kanałów (z wyjątkiem kanałów prywatnych).'),
(NULL,'Zarządzanie kanałami',0,'Pozwala członkom na tworzenie, edytowanie i usuwanie kanałów.'),
(NULL,'Zarządzanie kanałami',1,'Pozwala członkom na tworzenie, edytowanie i usuwanie kanałów.'),
(NULL,'Zarządzanie kanałami',2,'Pozwala członkom na tworzenie, edytowanie i usuwanie kanałów.'),
(NULL,'Zarządzanie rolami',0,'Pozwala członkom na tworzenie nowych ról, edytowanie i usuwanie ról niższych rangą od ich najwyższej roli, a także na zmianę uprawnień poszczególnych kanałów, do których mają dostęp.'),
(NULL,'Zarządzanie rolami',1,'Pozwala członkom na tworzenie nowych ról, edytowanie i usuwanie ról niższych rangą od ich najwyższej roli, a także na zmianę uprawnień poszczególnych kanałów, do których mają dostęp.'),
(NULL,'Zarządzanie rolami',2,'Pozwala członkom na tworzenie nowych ról, edytowanie i usuwanie ról niższych rangą od ich najwyższej roli, a także na zmianę uprawnień poszczególnych kanałów, do których mają dostęp.');