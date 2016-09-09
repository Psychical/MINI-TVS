CREATE TABLE `unban_config` (
  `id` varchar(32) NOT NULL,
  `value` varchar(64) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `unban_config` VALUES ('sms_type', '0');
INSERT INTO `unban_config` VALUES ('makro_type', '1');
INSERT INTO `unban_config` VALUES ('sms_status', '0');
INSERT INTO `unban_config` VALUES ('web_title', 'Mini TVS - SMS CS 1.6');
INSERT INTO `unban_config` VALUES ('paysera_projectid', '');
INSERT INTO `unban_config` VALUES ('paysera_sign', '');
INSERT INTO `unban_config` VALUES ('paysera_makro_price', '300');
INSERT INTO `unban_config` VALUES ('vpsnet_systems_pass', '');
INSERT INTO `unban_config` VALUES ('main_lang', 'en');
INSERT INTO `unban_config` VALUES ('home_dir', '');
INSERT INTO `unban_config` VALUES ('amxbans_prefix', 'amx');
INSERT INTO `unban_config` VALUES ('vpsnet_makro_price', '0');