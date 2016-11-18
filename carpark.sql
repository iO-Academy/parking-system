# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.20.56 (MySQL 5.6.33)
# Database: parkingSystem
# Generation Time: 2016-11-18 09:15:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bookings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carpark_id` int(11) unsigned NOT NULL,
  `from` datetime DEFAULT NULL,
  `to` datetime DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `carpark_id` (`carpark_id`),
  KEY `booker_id` (`user_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`carpark_id`) REFERENCES `carpark` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;

INSERT INTO `bookings` (`id`, `carpark_id`, `from`, `to`, `user_id`)
VALUES
	(1,1,'2016-11-20 00:00:00','2016-11-22 00:00:00',1);

/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table carpark
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carpark`;

CREATE TABLE `carpark` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `capacity` int(5) NOT NULL,
  `isVisitor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `carpark` WRITE;
/*!40000 ALTER TABLE `carpark` DISABLE KEYS */;

INSERT INTO `carpark` (`id`, `name`, `capacity`, `isVisitor`)
VALUES
	(1,'hobnob',100,0),
	(3,'digestive',50,0),
	(4,'rich tea',50,1);

/*!40000 ALTER TABLE `carpark` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table department
# ------------------------------------------------------------

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;

INSERT INTO `department` (`id`, `name`)
VALUES
	(1,'HR'),
	(2,'unknown'),
	(6,'admin'),
	(7,'orbit'),
	(8,'academy');

/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `userId` int(11) unsigned NOT NULL COMMENT 'linked to user id in users table',
  `canCreateUser` int(1) NOT NULL COMMENT '1 = yes',
  KEY `userId` (`userId`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;

INSERT INTO `permissions` (`userId`, `canCreateUser`)
VALUES
	(1,1);

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `validationString` char(40) NOT NULL DEFAULT '',
  `hash` int(4) NOT NULL,
  `firstName` varchar(255) NOT NULL DEFAULT '',
  `lastName` varchar(255) NOT NULL DEFAULT '',
  `carMake` varchar(255) DEFAULT '' COMMENT 'In future link to carmake table',
  `carModel` varchar(255) DEFAULT '' COMMENT 'In future link to carmodel table',
  `carNumPlate` char(8) DEFAULT '',
  `phoneNumber` int(11) unsigned DEFAULT NULL,
  `department` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department` (`department`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `validationString`, `hash`, `firstName`, `lastName`, `carMake`, `carModel`, `carNumPlate`, `phoneNumber`, `department`)
VALUES
	(1,'example@email.com','07be8796e6c6e701448e7b66ae85eaa5073d148e','5ed2001fd97f9e659f85ff6ff7a26461ab11f82f',1234,'John','Smith','Ford','Fiesta','AB12 ABC',1234,1),
	(2,'ben morris','34353092078deebdbbaa93b05736292a2fc2dbca','',6750,'','','','','',NULL,2),
	(3,'ben morris','b8e7e2ec339dbdf2eac28b05d916c7cfbd6b32fd','',1100,'','','','','',NULL,2),
	(4,'ben morris','a1a97c50fbf07feccf806a7fea6edb781437ea8a','',2664,'','','','','',NULL,2),
	(5,'ben@morris.com','eb24d277d17acd51d50946c8744df21e1c8b78fe','e085c6dedf0e464bd7162625560ee5cfd26a4ace',9254,'','','','','',NULL,2),
	(6,'a@a.com','62519bbd3824dc5bf0e125ff65f72c31300e19f4','9dbb8e9689d8a6307bbb791670577f6d7ad94d03',9681,'ben','mo','','','',0,2),
	(7,'c@c.com','9801c65d117d72cf8ef9bdbeb17daa9fe2b27712','',7120,'a','a','','','',0,2),
	(8,'e@e.com','b397775450d5394c1209525fda581292b15a42a2','e5434e15ee0be339af79612f153b0cf01d2ad219',4063,'a','a','','','',0,2);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
