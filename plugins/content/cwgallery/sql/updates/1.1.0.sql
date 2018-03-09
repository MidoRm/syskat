ALTER TABLE  `#__cwgallery_files` ADD  `caption` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE  `#__cwgallery_files` ADD  `description` TEXT NOT NULL ;
ALTER TABLE  `#__cwgallery_files` ADD  `publish` TINYINT( 1 ) NOT NULL DEFAULT  '1' ;