CREATE TABLE `amx_amxadmins` (
  `id` int(12) NOT NULL auto_increment,
  `username` varchar(32) default NULL,
  `password` varchar(32) default NULL,
  `access` varchar(32) default NULL,
  `flags` varchar(32) default NULL,
  `steamid` varchar(32) default NULL,
  `nickname` varchar(32) NOT NULL default '',
  `regtime` varchar(15) NOT NULL,
  `timeleft` varchar(15) NOT NULL,
  `nr` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/* Jei turit `amx_amxadmins` lentelę ir ji neturi šių psirinkčių, butinai įvykdykite žemiau esančia komandą savo duomenų bazėje */

ALTER TABLE  `amx_amxadmins` ADD  `regtime` VARCHAR( 15 ) NOT NULL ,
ADD  `timeleft` VARCHAR( 15 ) NOT NULL ,
ADD  `nr` VARCHAR( 15 ) NOT NULL;