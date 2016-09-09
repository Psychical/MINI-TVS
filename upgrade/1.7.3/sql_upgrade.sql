ALTER TABLE  `unban_sms_config` ADD  `message_type` VARCHAR( 255 ) NOT NULL;
ALTER TABLE  `unban_sms_config` ADD  `priv_time` INT( 11 ) NOT NULL;
ALTER TABLE  `unban_sms_config` ADD  `privs` VARCHAR( 255 ) NOT NULL;

CREATE TABLE `unban_messages_types` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) character set utf8 collate utf8_lithuanian_ci NOT NULL,
  `page_content` text character set utf8 collate utf8_lithuanian_ci NOT NULL,
  `lang` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `unban_order_prvilegies` (
  `id` int(11) NOT NULL auto_increment,
  `priv` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `unban_messages_types` VALUES ('1', 'unban', '', 'lt');
INSERT INTO `unban_messages_types` VALUES ('2', 'vip', 'Siuskite zinute su tekstu %key% %ip% numeriu %nr%. Kaina %time%d/%price% %price_type% Kai nusiusite SMS zinute iskart po atsakymo VIP bus automatiskai aktivuotas!', 'lt');

INSERT INTO `unban_order_prvilegies` VALUES ('1', 'unban', 'unban');
INSERT INTO `unban_order_prvilegies` VALUES ('2', 'bt', 'vip');

INSERT INTO `unban_links` VALUES ('7', './index.php?p=ovip', 'VIP pirkimas', '1', 'lt', '9');