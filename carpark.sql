# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.20.56 (MySQL 5.6.33)
# Database: parkingSystem
# Generation Time: 2016-11-17 14:29:10 +0000
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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carpark_id` INT(11) UNSIGNED NOT NULL,
  `from` DATETIME DEFAULT NULL,
  `to` DATETIME DEFAULT NULL,
  `user_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `carpark_id` (`carpark_id`),
  KEY `booker_id` (`user_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`carpark_id`) REFERENCES `carpark` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `capacity` INT(5) NOT NULL,
  `isVisitor` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

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
  `userId` INT(11) UNSIGNED NOT NULL COMMENT 'linked to user id in users table',
  `canCreateUser` INT(1) NOT NULL COMMENT '1 = yes',
  KEY `userId` (`userId`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

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
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL DEFAULT '',
  `password` VARCHAR(255) NOT NULL DEFAULT '',
  `validationString` CHAR(40) DEFAULT '',
  `hash` INT(4) DEFAULT NULL,
  `firstName` VARCHAR(255) NOT NULL DEFAULT '',
  `lastName` VARCHAR(255) NOT NULL DEFAULT '',
  `carMake` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'In future link to carmake table',
  `carModel` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'In future link to carmodel table',
  `carNumPlate` CHAR(8) NOT NULL DEFAULT '',
  `phoneNumber` INT(11) UNSIGNED DEFAULT NULL,
  `department` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department` (`department`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `validationString`, `hash`, `firstName`, `lastName`, `carMake`, `carModel`, `carNumPlate`, `phoneNumber`, `department`)
VALUES
  (1,'example@email.com','07be8796e6c6e701448e7b66ae85eaa5073d148e','fb6e1644654ce2f00a0a332e1163dd8d978889b1',1234,'John','Smith','Ford','Fiesta','AB12 ABC','01234 567890','1');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
