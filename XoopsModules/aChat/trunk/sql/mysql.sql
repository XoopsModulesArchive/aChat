#
# Table structure for table `achat_messages`
#

CREATE TABLE `achat_messages` (
  `mid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `uid` INT( 5 ) UNSIGNED DEFAULT '0' NOT NULL ,
  `uname` varchar ( 60 ) DEFAULT '',
  `msg` VARCHAR( 255 ) NOT NULL ,
  `color` VARCHAR( 6 ) NOT NULL default '000000',
  `date` INT( 10 ) NOT NULL default '0',
  `ip` VARCHAR( 15 ) default '0.0.0.0' NOT NULL ,
  PRIMARY KEY ( `mid` ) ,
  KEY `uid` (uid),
  KEY `ip` (ip),
  KEY `date` (date)
) TYPE=MyISAM;
