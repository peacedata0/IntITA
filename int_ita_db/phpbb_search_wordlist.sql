-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2015-07-31 18:15:55
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table int_ita_db.phpbb_search_wordlist
DROP TABLE IF EXISTS `phpbb_search_wordlist`;
CREATE TABLE IF NOT EXISTS `phpbb_search_wordlist` (
  `word_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `word_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `word_common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `word_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`word_id`),
  UNIQUE KEY `wrd_txt` (`word_text`),
  KEY `wrd_cnt` (`word_count`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table int_ita_db.phpbb_search_wordlist: ~135 rows (approximately)
/*!40000 ALTER TABLE `phpbb_search_wordlist` DISABLE KEYS */;
INSERT INTO `phpbb_search_wordlist` (`word_id`, `word_text`, `word_common`, `word_count`) VALUES
	(1, 'приклад', 0, 1),
	(2, 'повідомлення', 0, 1),
	(3, 'вашого', 0, 1),
	(4, 'phpbb3', 0, 2),
	(5, 'форуму', 0, 1),
	(6, 'здається', 0, 1),
	(7, 'ніби', 0, 1),
	(8, 'все', 0, 1),
	(9, 'нормально', 0, 1),
	(10, 'працює', 0, 1),
	(11, 'можете', 0, 1),
	(12, 'при', 0, 1),
	(13, 'бажанні', 0, 1),
	(14, 'видалити', 0, 1),
	(15, 'продовжити', 0, 1),
	(16, 'налаштування', 0, 1),
	(17, 'процесі', 0, 1),
	(18, 'встановлення', 0, 1),
	(19, 'вашій', 0, 1),
	(20, 'першій', 0, 1),
	(21, 'категорії', 0, 1),
	(22, 'вашому', 0, 1),
	(23, 'першому', 0, 1),
	(24, 'було', 0, 1),
	(25, 'встановлено', 0, 1),
	(26, 'відповідні', 0, 1),
	(27, 'права', 0, 1),
	(28, 'доступу', 0, 1),
	(29, 'для', 0, 1),
	(30, 'передвстановлених', 0, 1),
	(31, 'груп', 0, 1),
	(32, 'адміністраторів', 0, 1),
	(33, 'ботів', 0, 1),
	(34, 'супермодераторів', 0, 1),
	(35, 'гостей', 0, 1),
	(36, 'зареєстрованих', 0, 1),
	(37, 'користувачів', 0, 1),
	(38, 'coppa', 0, 1),
	(39, 'якщо', 0, 1),
	(40, 'видалите', 0, 1),
	(41, 'вашу', 0, 1),
	(42, 'першу', 0, 1),
	(43, 'категорію', 0, 1),
	(44, 'ваш', 0, 1),
	(45, 'перший', 0, 1),
	(46, 'форум', 0, 1),
	(47, 'забудьте', 0, 1),
	(48, 'надати', 0, 1),
	(49, 'усім', 0, 1),
	(50, 'цих', 0, 1),
	(51, 'групам', 0, 1),
	(52, 'нових', 0, 1),
	(53, 'категорій', 0, 1),
	(54, 'форумів', 0, 1),
	(55, 'які', 0, 1),
	(56, 'створите', 0, 1),
	(57, 'рекомендується', 0, 1),
	(58, 'перейменувати', 0, 1),
	(59, 'скопіювати', 0, 1),
	(60, 'них', 0, 1),
	(61, 'створенні', 0, 1),
	(62, 'успіхів', 0, 1),
	(63, 'ласкаво', 0, 1),
	(64, 'просимо', 0, 1),
	(65, 'день', 0, 1),
	(66, 'пам', 0, 1),
	(67, 'яті', 0, 1),
	(68, 'примирення', 0, 1),
	(69, 'травня', 0, 1),
	(70, 'привіт1', 0, 1),
	(71, 'сьогодні', 0, 1),
	(72, 'червня', 0, 3),
	(73, '2015', 0, 1),
	(74, 'року', 0, 1),
	(75, 'обговорення', 0, 3),
	(76, 'заняття', 0, 3),
	(77, 'змінні', 0, 9),
	(78, 'типи', 0, 9),
	(79, 'даних', 0, 10),
	(80, 'php', 0, 15),
	(81, 'основи', 0, 6),
	(82, 'синтаксису', 0, 6),
	(83, 'обробка', 0, 5),
	(84, 'запитів', 0, 6),
	(85, 'допомогою', 0, 5),
	(86, 'змінюються', 0, 2),
	(87, 'типові', 0, 2),
	(88, 'дуже', 0, 1),
	(89, 'дотепно', 0, 1),
	(90, 'jhbhb', 0, 1),
	(91, '784', 0, 1),
	(92, 'мається', 0, 3),
	(93, 'увазі', 0, 3),
	(94, 'синтаксис', 0, 3),
	(95, 'нова', 0, 2),
	(96, 'тема', 0, 10),
	(97, 'ребететптпааопрыврпьап', 0, 1),
	(98, 'амтавлопра', 0, 1),
	(99, 'итьтьбь', 0, 1),
	(100, 'бтьбьтьбтстит', 0, 1),
	(101, 'бази', 0, 1),
	(102, 'частина', 0, 1),
	(103, 'оллорло', 0, 1),
	(104, 'апаорпаврпалврпл', 0, 1),
	(105, 'воарвлрааларплап', 0, 1),
	(106, 'ваороарллварварпа', 0, 1),
	(107, 'ывораларлалпрапр', 0, 1),
	(108, 'ыравларавларвлав', 0, 1),
	(109, 'ырлрлырпапарпаа', 0, 1),
	(110, 'ылвраварварвааов', 0, 1),
	(111, 'ывраварвававваор', 0, 1),
	(112, 'ворварварварвалр', 0, 1),
	(113, 'ваварвоарвоарвав', 0, 1),
	(114, 'вапвапавпа', 0, 1),
	(115, 'вавравраврал', 0, 1),
	(116, 'апапавп', 0, 1),
	(117, 'авав', 0, 1),
	(118, 'ролплол', 0, 1),
	(119, 'апапва', 0, 1),
	(120, 'тема7', 0, 1),
	(121, 'dghyrturyjfyhjfnhjh', 0, 1),
	(122, 'дякую', 0, 1),
	(123, 'кеп', 0, 1),
	(124, 'ndsdafhgdsf', 0, 1),
	(125, 'fjdsfgdshfgds', 0, 1),
	(126, 'добре', 0, 2),
	(127, 'сьтмьтбьбт', 0, 1),
	(128, 'иьмтьитьиь', 0, 2),
	(129, 'asdfgdsfnhgqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', 0, 1),
	(130, 'нами', 0, 1),
	(131, 'яких', 0, 1),
	(132, 'get', 0, 1),
	(133, 'роst', 0, 1),
	(134, 'ьитьитьсиьит', 0, 1),
	(135, 'аочропр', 0, 1);
/*!40000 ALTER TABLE `phpbb_search_wordlist` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
