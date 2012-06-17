CREATE TABLE `sed_akciok` (
  `akciokID` int(11) NOT NULL auto_increment,
  `url` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `content` varchar(15) default NULL,
  PRIMARY KEY  (`akciokID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- 
-- Tábla adatok: `sed_akciók`
-- 

/* Sample file how to make an insertation into sql database */

INSERT INTO sed_akciok (url, title, content) VALUES ('URL', 'CÍM', 'SZÖVEG');

/* Alter table for pages*/

ALTER TABLE `sed_pages` ADD `page_extra6` VARCHAR( 255 ) NOT NULL AFTER `page_extra5` ;


