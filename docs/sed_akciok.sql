-- 
-- Tábla szerkezet: `sed_akciok`
-- 

CREATE TABLE `sed_akciok` (
  `akciokID` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`akciokID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- 
-- Tábla adatok: `sed_akciok`
-- 

INSERT INTO `sed_akciok` VALUES (16, 'URL', 'CÍM', 'SZÖVEG');