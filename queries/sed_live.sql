CREATE TABLE `sed_live` (
  `liveID` int(11) NOT NULL auto_increment,
  `live_video_id` varchar(6) default NULL,
  `live_player_select` varchar(4) default NULL,
  `notice_title` varchar(255) default NULL,
  `notice_date` varchar(255) default NULL,
 
  PRIMARY KEY  (`liveID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
 
 
 
INSERT INTO sed_live (liveID,notice_status, notice_text,notice_title,notice_date) 
 
VALUES ('1','1', 'Egy test','title','2011.01.07');