-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-05-06 00:46:28
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table int_ita_db.module
DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `module_ID` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL,
  `module_name` varchar(45) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `language` varchar(6) NOT NULL,
  `module_duration_hours` int(11) NOT NULL,
  `module_duration_days` int(11) NOT NULL,
  `lesson_count` int(11) DEFAULT NULL,
  `module_price` decimal(10,0) DEFAULT NULL,
  `for_whom` text,
  `what_you_learn` text,
  `what_you_get` text,
  `module_img` varchar(255) DEFAULT NULL,
  `about_module` text,
  `owners` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`module_ID`),
  UNIQUE KEY `module_ID` (`module_ID`),
  KEY `course` (`course`),
  CONSTRAINT `FK_module_course` FOREIGN KEY (`course`) REFERENCES `course` (`course_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Dumping data for table int_ita_db.module: ~16 rows (approximately)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`module_ID`, `course`, `module_name`, `alias`, `language`, `module_duration_hours`, `module_duration_days`, `lesson_count`, `module_price`, `for_whom`, `what_you_learn`, `what_you_get`, `module_img`, `about_module`, `owners`) VALUES
	(1, 1, 'Вступ до програмування', 'module1', 'ua', 313, 20, 13, 3000, 'для менеджерів проектів і тих, хто відповідає за постановку завдань на розробку;для дизайнерів, які готові почати не просто малювати красиві картинки, а й навчитися тому, як створювати працюючі і зручні інтерфейси;для розробників, які хочуть самостійно створити або змінити свій проект;', 'Ви навчитеся писати чистий код;Користуватися системами контролю версій;Дізнаєтеся, з чого складається сучасний додаток;Для чого потрібен безперервна інтеграція (СІ) сервер;Чому потрібно тестувати свої програми і як це робити;', 'Відеозаписи та текстові матеріали всіх онлайн-занять;Спілкування з розумними одногрупниками;Сертифікат про закінчення навчання;Прилаштованість на робоче місце в силіконовій долині;', '/css/images/courseimg1.png', NULL, '1;2;3;4;'),
	(2, 1, 'Елементарна математика', 'module2', 'ua', 30, 15, 10, 3200, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(3, 1, 'Алгоритмізація і програмування на мові С', 'module3', 'ua', 60, 30, 8, 3500, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(4, 1, 'Елементи вищої математики', 'module4', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(7, 1, 'Комп\'ютерні мережі', 'module5', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(9, 1, 'Розробка та аналіз алгоритмів. Комбінаторні а', 'module6', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(10, 1, 'Дискретна математика', 'module7', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(11, 1, 'Бази даних', 'module8', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(14, 1, 'Англійська мова', 'module9', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(16, 1, 'Програмування на PHP (Частина 1)', 'module10', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(17, 1, 'Програмування на PHP (Частина 2)', 'module11', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(18, 1, 'Верстка на HTML, CSS', 'module12', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(20, 1, 'Програмування на JavaScript', 'module13', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(22, 1, 'Сучасні технології розробки програм', 'module14', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(23, 1, 'Командний дипломний проект', 'module15', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL),
	(24, 1, 'Побудова індивідуального плану кар’єри. Ефект', 'module16', 'ua', 60, 0, 10, 3000, NULL, NULL, NULL, '/css/images/courseimg1.png', NULL, NULL);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
