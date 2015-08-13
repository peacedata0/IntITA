-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-08-10 17:27:19
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table intita.element_type
DROP TABLE IF EXISTS `element_type`;
CREATE TABLE IF NOT EXISTS `element_type` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Types of lecture elements.';

-- Dumping data for table intita.element_type: ~13 rows (approximately)
/*!40000 ALTER TABLE `element_type` DISABLE KEYS */;
INSERT INTO `element_type` (`id`, `type`) VALUES
	(1, 'text'),
	(2, 'video'),
	(3, 'code'),
	(4, 'example'),
	(5, 'task'),
	(6, 'final task'),
	(7, 'instruction'),
	(8, 'label'),
	(9, 'image'),
	(10, 'formula'),
	(11, 'table'),
	(12, 'test'),
	(13, 'final test');
/*!40000 ALTER TABLE `element_type` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;