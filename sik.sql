/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.21-MariaDB : Database - sik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `auth_activation_attempts` */

DROP TABLE IF EXISTS `auth_activation_attempts`;

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_activation_attempts` */

/*Table structure for table `auth_groups` */

DROP TABLE IF EXISTS `auth_groups`;

CREATE TABLE `auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_groups` */

/*Table structure for table `auth_groups_permissions` */

DROP TABLE IF EXISTS `auth_groups_permissions`;

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`),
  CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_groups_permissions` */

/*Table structure for table `auth_groups_users` */

DROP TABLE IF EXISTS `auth_groups_users`;

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`),
  CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_groups_users` */

/*Table structure for table `auth_logins` */

DROP TABLE IF EXISTS `auth_logins`;

CREATE TABLE `auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `auth_logins` */

insert  into `auth_logins`(`id`,`ip_address`,`email`,`user_id`,`date`,`success`) values 
(1,'::1','admin',NULL,'2022-06-07 10:34:35',0),
(2,'::1','admin',NULL,'2022-06-07 10:37:23',0),
(3,'::1','dedi.slamets@gmail.com',NULL,'2022-06-07 10:41:11',0),
(4,'::1','dedi.slamets@gmail.com',1,'2022-06-07 10:41:17',1),
(5,'::1','dedi.slamets@gmail.com',1,'2022-06-07 11:10:24',1),
(6,'::1','dedi.slamets@gmail.com',1,'2022-06-07 13:03:45',1),
(7,'::1','dedi.slamets@gmail.com',1,'2022-06-07 13:21:04',1),
(8,'::1','dedi.slamets@gmail.com',1,'2022-06-08 07:21:21',1),
(9,'::1','dedi.slamets@gmail.com',1,'2022-06-08 10:54:58',1),
(10,'::1','dedi.slamets@gmail.com',1,'2022-06-10 04:21:13',1),
(11,'::1','dedi.slamets@gmail.com',1,'2022-06-10 04:50:15',1),
(12,'::1','dedi.slamets@gmail.com',1,'2022-06-10 14:01:39',1),
(13,'::1','dedi.slamets@gmail.com',1,'2022-06-10 14:25:06',1),
(14,'::1','dedi.slamets@gmail.com',1,'2022-06-11 01:40:08',1),
(15,'::1','dedi.slamets@gmail.com',1,'2022-06-11 05:47:44',1),
(16,'::1','dedi.slamets@gmail.com',1,'2022-06-11 06:10:51',1),
(17,'::1','dedi.slamets@gmail.com',1,'2022-06-11 06:26:58',1),
(18,'::1','sachrul95@gmail.com',2,'2022-06-11 06:29:22',1);

/*Table structure for table `auth_permissions` */

DROP TABLE IF EXISTS `auth_permissions`;

CREATE TABLE `auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_permissions` */

/*Table structure for table `auth_reset_attempts` */

DROP TABLE IF EXISTS `auth_reset_attempts`;

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_reset_attempts` */

/*Table structure for table `auth_tokens` */

DROP TABLE IF EXISTS `auth_tokens`;

CREATE TABLE `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`),
  CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_tokens` */

/*Table structure for table `auth_users_permissions` */

DROP TABLE IF EXISTS `auth_users_permissions`;

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`),
  CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_users_permissions` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `contacts` */

insert  into `contacts`(`id`,`name`,`email`,`phone`,`address`) values 
(1,'Dedi Slamet','dedi.slamets@gmail.com','085795476164','Perum graha prima blok ia no88a jl. Mendut 2, Kel. satriajaya, kec. Tambun utara kab. Bekasi'),
(3,'AFIFAH Shulha','afifah.sulha@gmail.com','085624078612','Perum graha prima blok ia no88a jl. Mendut 2, Kel. satriajaya, kec. Tambun utara kab. Bekasi');

/*Table structure for table `deputi` */

DROP TABLE IF EXISTS `deputi`;

CREATE TABLE `deputi` (
  `id_deputi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_deputi` varchar(100) NOT NULL,
  `extention` varchar(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  PRIMARY KEY (`id_deputi`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `deputi` */

insert  into `deputi`(`id_deputi`,`nama_deputi`,`extention`,`parent_id`) values 
(1,'Deputi Bidang Kebijakan','5000',0),
(2,'Bidang SOP','5001',1),
(3,'',NULL,NULL),
(4,'Deputi I (Ekonomi Makro dan Keuangan)','1000',0),
(5,'Deputi Fiskal / Sekretaris Deput','1001',4),
(6,'Deputi Moneter dan Sektor Eksternal','1002',4),
(7,'Deputi II (Pangan dan Agribisnis)','2000',0),
(8,'Deputi Pangan / Sekretaris Deputi','2001',7),
(9,'Litbang Pangan','2010',8),
(10,'',NULL,NULL),
(12,'Deputi III (Pengembangan Usaha Badan Usaha Milik Negara, Riset, dan Inovasi)','4000',0),
(13,'Deputi Minyak dan Gas, Pertambangan, dan Petrokimia / Sekretaris Deputi','4001',12),
(14,'Litbang Migas','4010',13);

/*Table structure for table `karyawan` */

DROP TABLE IF EXISTS `karyawan`;

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `agama` varchar(15) DEFAULT NULL,
  `deputi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `karyawan` */

insert  into `karyawan`(`id`,`name`,`email`,`phone`,`address`,`status`,`agama`,`deputi`) values 
(2,'AFIFAH Shulha','afifah.sulha@gmail.com','+6285795476164','Perum graha prima blok ia no88a jl. Mendut 2\r\nKel. satriajaya, kec. Tambun utara kab. Bekasi','single','Islam',1),
(3,'Dedi Slamet','dedi.slamets@gmail.com','+6285795476164','Perum graha prima blok ia no88a jl. Mendut 2\r\nKel. satriajaya, kec. Tambun utara kab. Bekasi','menikah','Islam',1),
(4,'Ahdi Mahfudi','ahdi@gmail.com','0908879898',' Kayu ringin','single','Katolik',14),
(5,'Ahdi Bahrudin','ahdi.bh@gmail.com','09978977698978',' Cibitung','menikah','Kristen',7),
(6,'dedi sukaja','dedi.suka@gmail.com','0384325098908',' jakarta barat','menikah','Islam',6);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`version`,`class`,`group`,`namespace`,`time`,`batch`) values 
(1,'2022-06-06-163105','App\\Database\\Migrations\\Contact','default','App',1654533624,1),
(2,'2017-11-20-223112','Myth\\Auth\\Database\\Migrations\\CreateAuthTables','default','Myth\\Auth',1654613310,2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`username`,`password_hash`,`reset_hash`,`reset_at`,`reset_expires`,`activate_hash`,`status`,`status_message`,`active`,`force_pass_reset`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'dedi.slamets@gmail.com','Dedi Slamet','$2y$10$zaqYnxftcgKDoaqDNczkm.eqg0vLoYvyYAtetMBsOkuazL4FLiOZG',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2022-06-07 10:41:01','2022-06-07 10:41:01',NULL),
(2,'sachrul95@gmail.com','sachrul95','$2y$10$F6s1LxbTVoNc2sihPrjAKO97d6b9lH9PYcROmSbSCpDqKCuzqP0Ta',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2022-06-11 06:29:10','2022-06-11 06:29:10',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
