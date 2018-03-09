#
#<?php die('Forbidden.'); ?>
#Date: 2018-03-05 00:19:25 UTC
#Software: Joomla Platform 13.1.0 Stable [ Curiosity ] 24-Apr-2013 00:00 GMT

#Fields: datetime	priority clientip	category	message
2018-03-05T00:19:25+00:00	DEBUG ::1	-	-------------------------------------------------------
2018-03-05T00:19:25+00:00	DEBUG ::1	-	Starting to log install.rsgallery2.php for installation X
2018-03-05T00:19:25+00:00	DEBUG ::1	-	preflight: install
2018-03-05T00:19:25+00:00	DEBUG ::1	-	Installing component manifest file version = 4.3.1
2018-03-05T00:19:25+00:00	DEBUG ::1	-	Installing component manifest file minimum Joomla version = 3.0
2018-03-05T00:19:25+00:00	DEBUG ::1	-	Current Joomla version = 3.4.3
2018-03-05T00:19:25+00:00	DEBUG ::1	-	After version compare
2018-03-05T00:19:25+00:00	DEBUG ::1	-	-> pre freshInstall
2018-03-05T00:19:25+00:00	DEBUG ::1	-	Preflight install checks complete for com_rsgallery2 component. 4.3.1
2018-03-05T00:19:25+00:00	DEBUG ::1	-	exit preflight
2018-03-05T00:19:28+00:00	WARNING ::1	jerror	JInstaller: :Install: File does not exist C:\wamp\www\syskat\tmp\install_5a9c8d0d3c525\en-GB\en-GB.com_rsgallery2.ini
2018-03-05T00:19:28+00:00	WARNING ::1	deprecated	JFile::getName is deprecated. Use native basename() syntax.
2018-03-05T00:19:28+00:00	ERROR ::1	database-error	Database query failed (error # 1064): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '---
--- galleries
---

CREATE TABLE IF NOT EXISTS `uur3m_rsgallery2_gallerie' at line 1 SQL=---
--- galleries
---

CREATE TABLE IF NOT EXISTS `uur3m_rsgallery2_galleries` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default 0,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user` tinyint(4) NOT NULL default '0',
  `uid` int(11) unsigned NOT NULL default '0',
  `allowed` varchar(100) NOT NULL default '0',
  `thumb_id` int(11) unsigned NOT NULL default '0',
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `access` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
2018-03-05T00:19:28+00:00	WARNING ::1	jerror	You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '---
--- galleries
---

CREATE TABLE IF NOT EXISTS `uur3m_rsgallery2_gallerie' at line 1 SQL=---
--- galleries
---

CREATE TABLE IF NOT EXISTS `uur3m_rsgallery2_galleries` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default 0,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user` tinyint(4) NOT NULL default '0',
  `uid` int(11) unsigned NOT NULL default '0',
  `allowed` varchar(100) NOT NULL default '0',
  `thumb_id` int(11) unsigned NOT NULL default '0',
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `access` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
