CREATE TABLE IF NOT EXISTS `#__cwgallery_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` varchar(100) NOT NULL,
  `field` varchar(40) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `description` TEXT NOT NULL,
  `publish` TINYINT( 1 ) NOT NULL DEFAULT  '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;