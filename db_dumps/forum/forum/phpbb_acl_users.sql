-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-08-06 16:17:55
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table forum.phpbb_acl_users
DROP TABLE IF EXISTS `phpbb_acl_users`;
CREATE TABLE IF NOT EXISTS `phpbb_acl_users` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_option_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_role_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `auth_setting` tinyint(2) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `auth_option_id` (`auth_option_id`),
  KEY `auth_role_id` (`auth_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table forum.phpbb_acl_users: ~1 rows (approximately)
/*!40000 ALTER TABLE `phpbb_acl_users` DISABLE KEYS */;
INSERT INTO `phpbb_acl_users` (`user_id`, `forum_id`, `auth_option_id`, `auth_role_id`, `auth_setting`) VALUES
	(2, 0, 0, 5, 0);
/*!40000 ALTER TABLE `phpbb_acl_users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;