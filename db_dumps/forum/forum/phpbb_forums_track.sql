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

-- Dumping structure for table forum.phpbb_forums_track
DROP TABLE IF EXISTS `phpbb_forums_track`;
CREATE TABLE IF NOT EXISTS `phpbb_forums_track` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `forum_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mark_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table forum.phpbb_forums_track: ~16 rows (approximately)
/*!40000 ALTER TABLE `phpbb_forums_track` DISABLE KEYS */;
INSERT INTO `phpbb_forums_track` (`user_id`, `forum_id`, `mark_time`) VALUES
	(2, 16, 1437055279),
	(22, 15, 1437125835),
	(22, 16, 1437166713),
	(38, 36, 1437732959),
	(39, 29, 1438089493),
	(40, 34, 1437203610),
	(40, 35, 1437204004),
	(45, 15, 1437723594),
	(51, 36, 1438013412),
	(54, 15, 1438017947),
	(54, 16, 1438018025),
	(54, 34, 1438017838),
	(54, 35, 1438017910),
	(54, 36, 1438017942),
	(121, 36, 1437554649),
	(129, 29, 1438242107);
/*!40000 ALTER TABLE `phpbb_forums_track` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;