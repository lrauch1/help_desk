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

CREATE USER 'helpdeskuser'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES	
    ON `help_desk`.*	
    TO 'helpdeskuser'@'%';
FLUSH PRIVILEGES;	

USE `help_desk`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `pword` varchar(50) NOT NULL,
  `type` enum('User','Technician','Admin') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`uname`),
  UNIQUE KEY `full name` (`fname`,`lname`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`fname`,`lname`,`uname`,`salt`,`pword`,`type`) values (1,'Not','Assigned','noone','','!','Technician'),(2,'Emily','Falder','efalder','aCqpPXeZ','2b329af455a17c8a33f3bcd2a545217daf60c4c2','Admin'),(3,'Dave','Grant','dgrant','','353e8061f2befecb6818ba0c034c632fb0bcae1b','Admin'),(4,'Mark','Dutchuk','mdutchuk','','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(5,'Dave','Croft','dcroft','','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(6,'Graham','White','gwhite','','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(7,'John','Lowen','jlowen','','353e8061f2befecb6818ba0c034c632fb0bcae1b','Technician'),(8,'Tonyy','Gallone','tgallone','','f8fde4f28c22e1a5a6201b6cce363477940cde50','User'),(9,'Jan','Kubal','jkubal','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(10,'Caitlin','Samuelsson','csamuelsson','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(11,'Will','Gendemann','wgendemann','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(12,'Chris','Buechler','cbuechler','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(13,'Lindsey','Rauch','lrauch','QHwCZpoj','3da7382e854c6dbc293ec775583a4cb7a67c16f6','Admin'),(14,'Bill','Dou','bdou','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(15,'Andrew','VanBuskirk','avanbuskirk','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(16,'Nick','Valee','nvalee','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(18,'asdf','jkl;','test2','','','User'),(19,'peter','joseph','pjoseph','68677fa171','d8ee09a49c0c61a6e1381d899cc9e859a6c00340','User'),(20,'Gabor','Mate','gmate','7849051c02','f3d757eda9a517a956cf469fea811f37d1703c5a','User'),(21,'avon','barksdale','abarksdale','23507d46be','15080449e05b7d17e3f93ce33adb1b38e100b65e','User'),(22,'stringer','bell','sbell','dd6eff88e3','8c95169aa6d48929985653246f935bec4f678849','User'),(23,'greg','chandler','gchandler','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(27,'tim','viney','tviney','','353e8061f2befecb6818ba0c034c632fb0bcae1b','User'),(28,'test','test','test','','c4033bff94b567a190e33faa551f411caef444f2','User'),(29,'john','hall','jhall','2921ea8ca7','e600d63ba1def9d8504c60d7f1922031ab71e2d0','User');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `ticket` */

insert  into `ticket`(`id`,`created`,`creator_id`,`tech_id`,`subject`,`closed`,`priority`,`status`) values (1,'2014-10-29 11:46:02',8,4,'My Computer Is On Fire',NULL,5,'In Progress'),(2,'2014-10-29 11:47:42',9,2,'Symfony Will Not Install',NULL,3,'In Progress'),(3,'2014-10-29 16:06:06',12,3,'Cannot create SSH tunnels',NULL,3,'New'),(4,'2014-10-29 16:25:04',10,6,'Power light does not come on',NULL,3,'Stalled'),(5,'2014-11-12 12:30:37',2,1,'screen has purple tint',NULL,3,'New'),(6,'2014-11-16 14:42:17',6,1,'Fan is very loud',NULL,3,'New'),(7,'2014-11-19 09:17:22',13,1,'Webcam wont turn on','2014-11-19 18:06:33',3,'Closed'),(8,'2014-11-19 09:48:56',13,1,'test','2014-11-19 18:56:13',3,'Cancelled'),(9,'2014-11-19 09:49:39',2,1,'test2',NULL,3,'New'),(10,'2014-11-19 10:05:11',4,4,'test3',NULL,3,'In Progress'),(11,'2014-11-19 12:27:09',19,1,'global redesign institute servers are down',NULL,3,'New'),(12,'2014-11-23 15:16:07',20,3,'test',NULL,3,'New'),(13,'2014-11-24 19:18:01',22,1,'my mouse cursor wont move',NULL,3,'New'),(14,'2014-11-24 21:17:50',9,1,'netbeans keeps freezing',NULL,3,'New'),(15,'2014-11-25 11:22:12',21,1,'cannot enter my bios screen',NULL,3,'New');

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Data for the table `message` */

insert  into `message`(`id`,`ticket_id`,`user_id`,`timestamp`,`text`) values (1,1,8,'2014-10-29 16:57:23','Where is the fire extinguisher???'),(2,2,9,'2014-10-29 16:58:00','It gets about halfway through the installation before crashing'),(3,3,12,'2014-10-29 16:58:40','No error, just cannot connect to supposedly created tunnel11111'),(4,4,10,'2014-10-29 16:59:21','I push it and nothing happens'),(5,1,2,'2014-10-29 18:00:45','Do we even have one? :P'),(6,1,4,'2014-10-29 21:50:35','Somewhere, probably.<br><span class=small>Mark is a nerd</span><br><span class=small>Status: \'New\' -> \'In Progress\'</span>'),(7,1,2,'2014-11-12 12:28:22','it exploded'),(8,5,2,'2014-11-12 12:30:37','I dropped my monitor and now it has a purple tint'),(9,4,5,'2014-11-12 12:33:26','have you tried turning it off and on again'),(10,1,4,'2014-11-16 14:39:06','lol'),(11,6,6,'2014-11-16 14:42:17','Fan seems to have a bunch of dust in it'),(12,7,13,'2014-11-19 09:17:22','Webcam wont turn on.'),(13,8,13,'2014-11-19 09:48:56','test'),(14,9,2,'2014-11-19 09:49:39','test2'),(15,2,2,'2014-11-19 09:52:54','change to in progress<br><span class=small>Emily was assigned to this ticket</span><br><span class=small>Status: \'New\' -> \'In Progress\'</span>'),(16,10,4,'2014-11-19 10:05:11','test3'),(17,10,4,'2014-11-19 10:05:22','<br><span class=small>Mark was assigned to this ticket</span><br><span class=small>Status: \'New\' -> \'In Progress\'</span>'),(18,7,4,'2014-11-19 10:06:33','<br><span class=small>Status: \'New\' -> \'Closed\'</span>'),(19,8,13,'2014-11-19 10:56:13','<br><span class=small>Status: \'New\' -> \'Cancelled\'</span>'),(20,11,19,'2014-11-19 12:27:09','why dis?'),(21,3,2,'2014-11-19 13:53:25','hahah noob!'),(22,12,20,'2014-11-23 15:16:07','testggggg'),(23,13,22,'2014-11-24 19:18:01','my mouse cursor wont move'),(24,14,9,'2014-11-24 21:17:50','intermittently randomly freezing'),(25,4,6,'2014-11-24 21:28:05','<br><span class=small>Graham was assigned to this ticket</span><br><span class=small>Status: \'New\' -> \'In Progress\'</span>'),(26,4,6,'2014-11-24 21:28:14','working on it now'),(27,4,6,'2014-11-24 21:29:12','<br><span class=small>Status: \'In Progress\' -> \'Stalled\'</span>'),(28,15,21,'2014-11-25 11:22:12','no matter what combination of keys I try, I cannot access bios');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
