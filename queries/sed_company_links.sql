-- 
-- Tábla szerkezet: `sed_topeventhandler`
-- 

CREATE TABLE `sed_company_links` (
  `clID` int(11) NOT NULL auto_increment,
  `cl_text` varchar(255) default NULL,
  `cl_title` varchar(255) default NULL,
  `cl_cat` varchar(255) default NULL,

  PRIMARY KEY  (`clID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;



INSERT INTO sed_company_links (clID,cl_text,cl_title,cl_cat) VALUES ('1','Az elsõ bejegyzés', 'Az elsõ cím','test_cat');