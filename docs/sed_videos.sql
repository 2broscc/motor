-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Hoszt: localhost
-- Létrehozás ideje: 2011. Feb 19. 19:42
-- Szerver verzió: 5.0.45
-- PHP Verzió: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Adatbázis: `ridelinemtb`
-- 

-- --------------------------------------------------------

-- 
-- Tábla szerkezet: `sed_video`
-- 

CREATE TABLE `sed_videos` (

  `page_id` int(11) unsigned NOT NULL auto_increment,
  `page_state` tinyint(1) unsigned NOT NULL default '0',
  `page_type` tinyint(1) default '0',
  `page_cat` varchar(16) default NULL,
  `page_key` varchar(16) default NULL,
  `page_extra1` varchar(255) NOT NULL default '',
  `page_extra2` varchar(255) NOT NULL default '',
  `page_extra3` varchar(255) NOT NULL default '',
  `page_extra4` varchar(255) NOT NULL default '',
  `page_extra5` varchar(255) NOT NULL default '',
  `page_extra6` varchar(255) NOT NULL,
  `page_title` varchar(255) default NULL,
  `page_desc` varchar(255) default NULL,
  `page_text` text,
  `page_text2` text character set utf8 collate utf8_unicode_ci,
  `page_author` varchar(24) default NULL,
  `page_ownerid` int(11) NOT NULL default '0',
  `page_date` int(11) NOT NULL default '0',
  `page_begin` int(11) NOT NULL default '0',
  `page_expire` int(11) NOT NULL default '0',
  `page_file` tinyint(1) default NULL,
  `page_url` varchar(255) default NULL,
  `page_size` varchar(16) default NULL,
  `page_count` mediumint(8) unsigned default '0',
  `page_rating` decimal(5,2) NOT NULL default '0.00',
  `page_filecount` mediumint(8) unsigned default '0',
  `page_alias` varchar(24) NOT NULL default '',
  PRIMARY KEY  (`page_id`),
  KEY `page_cat` (`page_cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1353 ;

