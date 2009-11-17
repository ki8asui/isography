-- MySQL dump 10.11
--
-- ------------------------------------------------------
-- Server version	5.0.58

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `post_pictures`
--

-- DROP TABLE IF EXISTS `post_pictures`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `post_pictures` (
  `post_id` int(10) unsigned NOT NULL,
  `pic_url` char(250) default NULL,
  `created` datetime default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `post_videos`
--

-- DROP TABLE IF EXISTS `post_videos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `post_videos` (
  `post_id` int(10) unsigned NOT NULL,
  `vid_url` char(250) default NULL,
  `created` datetime default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `posts`
--

-- DROP TABLE IF EXISTS `posts`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `site_id` int(11) default NULL,
  `post_date` datetime default NULL,
  `post_type` char(40) default NULL,
  `pic_url` char(250) default NULL,
  `vid_url` char(250) default NULL,
  `message` text,
  PRIMARY KEY  (`id`),
  KEY `FK_posts` (`user_id`),
  KEY `FK_posts_sites` (`site_id`),
  CONSTRAINT `FK_posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_posts_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sites`
--

-- DROP TABLE IF EXISTS `sites`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sites` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) default NULL,
  `created` date default NULL,
  `name` char(250) default NULL,
  `subdomain` char(40) default NULL,
  `active_y_n` char(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_sites` (`owner_id`),
  CONSTRAINT `FK_sites` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_is_member_of_site`
--

-- DROP TABLE IF EXISTS `user_is_member_of_site`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_is_member_of_site` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `subscribe_y_n` char(1) default NULL,
  `facebook_pics_y_n` char(1) default NULL,
  `facebook_vids_y_n` char(1) default NULL,
  `member_y_n` char(1) default NULL,
  `facebook_infinite_key` char(200) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`user_id`,`site_id`),
  KEY `FK_user_is_member_of_site_sites` (`site_id`),
  CONSTRAINT `FK_user_is_member_of_site` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_user_is_member_of_site_sites` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `users`
--

-- DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` char(250) default NULL,
  `email` char(250) default NULL,
  `provider` char(250) default NULL,
  `last_login_date` datetime default NULL,
  `fb_user_id` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-09-24  9:01:04
