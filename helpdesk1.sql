/*
SQLyog Community v11.31 (64 bit)
MySQL - 5.6.17-log : Database - help_desk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`help_desk` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `help_desk`;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text,
  PRIMARY KEY (`id`),
  KEY `fkey_iavyetvhpa` (`ticket_id`),
  KEY `fkey_jesvvbcdzr` (`user_id`),
  CONSTRAINT `fkey_iavyetvhpa` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fkey_jesvvbcdzr` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `message` */

insert  into `message`(`id`,`ticket_id`,`user_id`,`timestamp`,`text`) values (1,1,8,'2014-10-29 16:57:23','Where is the fire extinguisher???'),(2,2,9,'2014-10-29 16:58:00','It gets about halfway through the installation before crashing'),(3,3,12,'2014-10-29 16:58:40','No error, just cannot connect to supposedly created tunnel'),(4,4,10,'2014-10-29 16:59:21','I push it and nothing happens'),(5,1,2,'2014-10-29 18:00:45','Do we even have one? :P'),(6,1,4,'2014-10-29 21:50:35','Somewhere, probably.<br><span class=small>Mark is a nerd</span><br><span class=small>Status: \'New\' -> \'In Progress\'</span>');

/*Table structure for table `ticket` */

DROP TABLE IF EXISTS `ticket`;

CREATE TABLE `ticket` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(11) unsigned NOT NULL,
  `tech_id` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'Defaults to special user "Not Assigned" who cannot log in',
  `subject` varchar(50) NOT NULL,
  `closed` timestamp NULL DEFAULT NULL,
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `status` enum('New','In Progress','Closed','Cancelled','Stalled') NOT NULL DEFAULT 'New',
  PRIMARY KEY (`id`),
  KEY `fkey_mpjrtpevba` (`creator_id`),
  CONSTRAINT `fkey_mpjrtpevba` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ticket` */

insert  into `ticket`(`id`,`created`,`creator_id`,`tech_id`,`subject`,`closed`,`priority`,`status`) values (1,'2014-10-29 11:46:02',8,4,'My Computer Is On Fire',NULL,5,'In Progress'),(2,'2014-10-29 11:47:42',9,4,'Symfony Will Not Install',NULL,3,'New'),(3,'2014-10-29 16:06:06',12,3,'Cannot create SSH tunnels',NULL,3,'New'),(4,'2014-10-29 16:25:04',10,1,'Power light does not come on',NULL,3,'New');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pword` varchar(50) NOT NULL,
  `type` enum('User','Technician','Admin') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`uname`),
  UNIQUE KEY `full name` (`fname`,`lname`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`fname`,`lname`,`uname`,`pword`,`type`) values (1,'Not','Assigned','noone','!','Technician'),(2,'Emily','Falder','efalder','353e8061f2befecb6818ba0c034c632fb0bcae1b','Admin'),(3,'Dave','Grant','dgrant','353e8061f2befecb6818ba0c034c632fb0bcae1b','Admin'),(4,'Mark','Dutchuk','mdutchuk','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(5,'Dave','Croft','dcroft','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(6,'Graham','White','gwhite','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(7,'John','Lowen','jlowen','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(8,'Tony','Gallone','tgallone','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(9,'Jan','Kubal','jkubal','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(10,'Caitlin','Samuelsson','csamuelsson','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(11,'Will','Gendemann','wgendemann','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(12,'Chris','Buechler','cbuechler','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(13,'Lindsey','Rauch','lrauch','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(14,'Bill','Dou','bdou','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(15,'Andrew','VanBuskirk','avanbuskirk','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(16,'Nick','Valee','nvalee','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(18,'asdf','jkl;','test2','','User');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
