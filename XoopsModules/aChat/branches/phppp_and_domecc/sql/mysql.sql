#
# Table structure for table `achat_messages`
#

CREATE TABLE `achat_messages` (
  `mid` 		int(11) 		UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` 		mediumint(8) 	UNSIGNED NOT NULL DEFAULT '0' ,
  `uname` 		varchar(64) 	NOT NULL DEFAULT '',
  `msg` 		VARCHAR(255) 	NOT NULL default '',
  `color` 		VARCHAR(6) 		NOT NULL default '000000',
  `date` 		int(10) 		NOT NULL default '0',
  `ip` 			VARCHAR(15) 	NOT NULL default '0.0.0.0',
  
  PRIMARY KEY 	(`mid`) ,
  KEY `uid` 	(`uid`),
  KEY `ip` 		(`ip`),
  KEY `date` 	(`date`)
) TYPE=MyISAM;