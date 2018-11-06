CREATE TABLE `unban_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `show` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '1',
  `lang` varchar(5) COLLATE utf8_lithuanian_ci NOT NULL,
  `sort_place` int(11) NOT NULL,
  `show_num` enum('0','1') COLLATE utf8_lithuanian_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

INSERT INTO `unban_links` (`id`, `url`, `name`, `show`, `lang`, `sort_place`, `show_num`) VALUES
(1, './', 'Unban', '1', '*', 1, '0'),
(2, './index.php?p=list', 'Privileges list', '1', '*', 2, '0'),
(3, './index.php?p=back', 'Privileges recovery', '1', '*', 3, '0'),
(4, './index.php?p=servers', 'Server list', '1', '*', 4, '0');