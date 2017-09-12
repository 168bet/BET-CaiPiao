/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.1.28-rc-community : Database - si3m
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`si3m` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `si3m`;

/*Table structure for table `web_nconfig` */

DROP TABLE IF EXISTS `web_nconfig`;

CREATE TABLE `web_nconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `web_notices` */

DROP TABLE IF EXISTS `web_notices`;

CREATE TABLE `web_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `addpople` varchar(255) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `view_ids` text,
  `reply_to_uid` varchar(255) DEFAULT NULL,
  `curr_reply` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1294 DEFAULT CHARSET=latin1;

/*Table structure for table `web_notices_reply` */

DROP TABLE IF EXISTS `web_notices_reply`;

CREATE TABLE `web_notices_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL,
  `reply_uid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Table structure for table `web_notices_to` */

DROP TABLE IF EXISTS `web_notices_to`;

CREATE TABLE `web_notices_to` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) NOT NULL,
  `notice_to` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1246 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
