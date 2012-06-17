-- 
-- Tábla szerkezet: `sed_topeventhandler`
-- 

CREATE TABLE `sed_notice` (
  `noticeID` int(11) NOT NULL auto_increment,
   `notice_status` varchar(6) default NULL,
  `notice_text` varchar(255) default NULL,
  `notice_title` varchar(255) default NULL,
  `notice_date` varchar(255) default NULL,

  PRIMARY KEY  (`noticeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;



INSERT INTO sed_notice (noticeID,notice_status, notice_text,notice_title,notice_date) VALUES ('1','1', 'Egy test','title','2011.01.07');