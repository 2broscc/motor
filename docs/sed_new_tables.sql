
CREATE TABLE sed_forum_posts (
  fp_id mediumint(8) unsigned NOT NULL auto_increment,
  fp_topicid mediumint(8) NOT NULL default '0',
  fp_sectionid smallint(5) NOT NULL default '0',
  fp_posterid int(11) NOT NULL default '-1',
  fp_postername varchar(24) NOT NULL default '',
  fp_creation int(11) NOT NULL default '0',
  fp_updated int(11) NOT NULL default '0',
  fp_updater varchar(24) NOT NULL default '0',
  fp_text text NOT NULL,
  fp_posterip varchar(15) NOT NULL default '',
  PRIMARY KEY  (fp_id),
  UNIQUE KEY fp_topicid (fp_topicid,fp_id),
  KEY fp_updated (fp_creation)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE sed_forum_sections (
  fs_id smallint(5) unsigned NOT NULL auto_increment,
  fs_state tinyint(1) unsigned NOT NULL default '0',
  fs_order smallint(5) unsigned NOT NULL default '0',
  fs_title varchar(128) NOT NULL default '',
  fs_category varchar(64) NOT NULL default '',
  fs_desc varchar(255) NOT NULL default '',
  fs_icon varchar(255) NOT NULL default '',
  fs_lt_id int(11) NOT NULL default '0',
  fs_lt_title varchar(64) NOT NULL default '',
  fs_lt_date int(11) NOT NULL default '0',
  fs_lt_posterid int(11) NOT NULL default '-1',
  fs_lt_postername varchar(24) NOT NULL default '',
  fs_autoprune int(11) NOT NULL default '0',
  fs_allowusertext tinyint(1) NOT NULL default '1',
  fs_allowbbcodes tinyint(1) NOT NULL default '1',
  fs_allowsmilies tinyint(1) NOT NULL default '1',
  fs_allowprvtopics tinyint(1) NOT NULL default '0',
  fs_countposts tinyint(1) NOT NULL default '1',
  fs_topiccount mediumint(8) NOT NULL default '0',
  fs_topiccount_pruned int(11) default '0',
  fs_postcount mediumint(8) NOT NULL default '0',
  fs_postcount_pruned int(11) default '0',
  fs_viewcount mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (fs_id),
  KEY fs_order (fs_order)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE sed_forum_structure (
  fn_id mediumint(8) NOT NULL auto_increment,
  fn_path varchar(16) NOT NULL default '',
  fn_code varchar(16) NOT NULL default '',
  fn_tpl varchar(64) NOT NULL default '',
  fn_title varchar(32) NOT NULL default '',
  fn_desc varchar(255) NOT NULL default '',
  fn_icon varchar(128) NOT NULL default '',
  fn_defstate tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (fn_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE sed_forum_topics (
  ft_id mediumint(8) unsigned NOT NULL auto_increment,
  ft_mode tinyint(1) unsigned NOT NULL default '0',
  ft_state tinyint(1) unsigned NOT NULL default '0',
  ft_sticky tinyint(1) unsigned NOT NULL default '0',
  ft_tag varchar(16) NOT NULL default '',
  ft_sectionid mediumint(8) NOT NULL default '0',
  ft_title varchar(64) NOT NULL default '',
  ft_desc varchar(64) NOT NULL default '',
  ft_creationdate int(11) NOT NULL default '0',
  ft_updated int(11) NOT NULL default '0',
  ft_postcount mediumint(8) NOT NULL default '0',
  ft_viewcount mediumint(8) NOT NULL default '0',
  ft_lastposterid int(11) NOT NULL default '-1',
  ft_lastpostername varchar(24) NOT NULL default '',
  ft_firstposterid int(11) NOT NULL default '-1',
  ft_firstpostername varchar(24) NOT NULL default '',
  ft_poll int(11) default '0',
  ft_movedto int(11) default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_updated (ft_updated),
  KEY ft_mode (ft_mode),
  KEY ft_state (ft_state),
  KEY ft_sticky (ft_sticky),
  KEY ft_sectionid (ft_sectionid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*extra stuff is page_text2!*/
CREATE TABLE sed_pages (
  page_id int(11) unsigned NOT NULL auto_increment,
  page_state tinyint(1) unsigned NOT NULL default '0',
  page_type tinyint(1) default '0',
  page_cat varchar(16) default NULL,
  page_key varchar(16) default NULL,
  page_extra1 varchar(255) NOT NULL default '',
  page_extra2 varchar(255) NOT NULL default '',
  page_extra3 varchar(255) NOT NULL default '',
  page_extra4 varchar(255) NOT NULL default '',
  page_extra5 varchar(255) NOT NULL default '',
  page_title varchar(255) default NULL,
  page_desc varchar(255) default NULL,
  page_text text,
  page_text2 text,
  page_author varchar(24) default NULL,
  page_ownerid int(11) NOT NULL default '0',
  page_date int(11) NOT NULL default '0',
  page_begin int(11) NOT NULL default '0',
  page_expire int(11) NOT NULL default '0',
  page_file tinyint(1) default NULL,
  page_url varchar(255) default NULL,
  page_size varchar(16) default NULL,
  page_count mediumint(8) unsigned default '0',
  page_rating decimal(5,2) NOT NULL default '0.00',
  page_comcount mediumint(8) unsigned default '0',
  page_filecount mediumint(8) unsigned default '0',
  page_alias varchar(24) NOT NULL default '',
  PRIMARY KEY  (page_id),
  KEY page_cat (page_cat)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO sed_forum_sections VALUES ('1', '0', '100', 'General discussion', 'pub', 'General chat.', 'system/img/admin/forums.gif', 0, '', 0, 0, '', 365, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);
INSERT INTO sed_forum_sections VALUES ('2', '0', '101', 'Off-topic', 'pub', 'Various and off-topic.', 'system/img/admin/forums.gif', 0, '', 0, 0, '', 365, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0);
INSERT INTO sed_forum_structure VALUES ('1', '1', 'pub', '', 'Public', '', '', 1);