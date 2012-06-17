<?
/**
beallit.php
*/


$cfg['mysqlhost'] = 'localhost';
$cfg['mysqluser'] = 'root';	
$cfg['mysqlpassword'] = 'peter';
$cfg['mysqldb'] = 'mbedsolutions';	

//for data conversion!
$con = mysql_connect("".$cfg['mysqlhost']."","".$cfg['mysqluser']."","".$cfg['mysqlpassword']."");
	if (!$con) {   die('Could not connect: ' . mysql_error()); }



// todo rename the config fucntion
$cfg['rideline_recent_menu'] = "	
					
					<li><a href=\"node.php?m=disclaimer\">Felhasználási feltételek</a></li>
					<li><a href=\"node.php?m=jogi\">Jogi nyilatkozat</a></li>
					<li><a href=\"node.php?m=hirdetesek\">Hírdetések</a></li>
					<li><a href=\"node.php?m=banner\">Bannerek</a></li>
					<li>Partnerek</li>
					<li>GYIK</li>
					<li><a href=\"node.php?m=changelog\">Changelog</a></li>";
					
			

/**
bestdeal
*/					

$cfg['bestdeal_path'] = "plugins/bestdeal/tpl_files";
//the site main URL
$cfg['baseurl'] = "http://localhost/ridelinemtb";  
/*Bestdeal configuration variables*/
$cfg['bestdeal_akciok_limit'] = 4; //how many queries will be shown
// Default skin code. Be SURE it's pointing to a valid folder in /skins/... !!

$cfg['default_skin_dir'] = "themes";  //todo?

$cfg['defaultskin'] = 'ice';	
// Default language code
$cfg['defaultlang'] = 'hu';		
	

$cfg['authmode'] = 3; 	// (1:cookies, 2:sessions, 3:cookies+sessions)		
$cfg['xmlclient'] = FALSE; // For testing-purposes only, else keep it off		
$cfg['enablecustomhf'] = FALSE;	// To enable header.$location.tpl and footer.$location.tpl			
$cfg['videoplayerurl'] = 'datas/player';	//the site own mediaplayer  location Dont trailing slash at the end!!						

/*
PFS dirs
*/
$cfg['th_dir'] = 'datas/thumbs/';
$cfg['pfs_dir'] = 'datas/users/';

$cfg['javascript_dir'] = "javascript"; //dont trailing slash
		
$cfg['pfsmaxuploads'] = 10;

/*==========*/
$cfg['sqldb'] = 'mysql';  							// Type of the database engine.
$cfg['authmode'] = 3; 								// (1:cookies, 2:sessions, 3:cookies+sessions) default=3
$cfg['redirmode'] = false;							// 0 or 1, Set to '1' if you cannot sucessfully log in (IIS servers)
$cfg['xmlclient'] = FALSE;  						// For testing-purposes only, else keep it off.
$cfg['ipcheck'] = TRUE;  							// Will kill the logged-in session if the IP has changed
$cfg['allowphp_override'] = FALSE; 					// General lock for execution of the PHP code by the core
/*==========*/
$cfg['header_url'] = "index.php";					//here you can add the header url where do you want to redirect
$cfg['twitter_username'] = "ridelinemtb";



$cfg['video_height_big'] = 420;					//for the videos bbcode normal setup
$cfg['video_width_big'] = 700;					//for the videos bbcode normal setup

$cfg['video_height'] = 300;					//for the videos bbcode normal setup
$cfg['video_width'] = 500;					//for the videos bbcode normal setup

$cfg['bbcode_img_border_height'] = 465;
$cfg['bbcode_img_border_width'] = 620;

$cfg['vow_height'] = "150px";
$cfg['vow_width'] = "230px";

$cfg['bestdealitemphoto'] = "650px";

/*==========*/

//default preview img on page_add
$cfg['newpagepreviewimg'] = "datas/default/nopic.png";  
//rss channels

//news
$cfg['rss_channels_news'] = "rss.php?m=news";
$cfg['rss_titles_news'] = "News Feed";
//articles
$cfg['rss_channels_articles'] = "rss.php?m=articles";
$cfg['rss_titles_articles'] = "Articles Feed";
//videosarok
$cfg['rss_channels_videosarok'] = "rss.php?m=video";
$cfg['rss_titles_videosarok'] = "Videos  Feed";
//forums
$cfg['rss_channels_forums'] = "rss.php?m=forums";
$cfg['rss_titles_forums'] = "Forums Feed";

//RSS settings

$cfg['rss_titlenews']  = "News";

//RSS Titles 
$cfg_titlenews	= "News";
$cfg_titleforums	= "Forums";
$cfg_titlearticles	= "Articles";
//Page categories by sections
$cfg_newscat	= "news";
$cfg_articlecat	= "articles";
//Main site url
$cfg_url	= "http://www.site.ru";
//RSS Charset
$cfg_charset	= "windows-1250";
//News displayed in RSS
$cfg_maxlines	= 25;
$cfg_ttl	= 1;

 
// ========================
// Name of MySQL tables
// (OPTIONAL, if missing, Seditio will set default values)
// Only change the "sed" part if you'd like to
// make 2 separated install in the same database.
// or you'd like to share some tables between 2 sites.
// Else do not change.
// ========================

$prefix = 'sed_';

$db_auth			= ''.$prefix.'auth';
$db_banlist 		= ''.$prefix.'banlist';
$db_cache 			= ''.$prefix.'cache';
$db_com 			= ''.$prefix.'com';
$db_core			= ''.$prefix.'core';
$db_config 			= ''.$prefix.'config';
$db_forum_posts 	= ''.$prefix.'forum_posts';
$db_forum_sections 	= ''.$prefix.'forum_sections';
$db_forum_structure	= ''.$prefix.'forum_structure';
$db_forum_topics 	= ''.$prefix.'forum_topics';
$db_groups 			= ''.$prefix.'groups';
$db_groups_users 	= ''.$prefix.'groups_users';
$db_logger 			= ''.$prefix.'logger';
$db_online 			= ''.$prefix.'online';
$db_pages 			= ''.$prefix.'pages';
$db_pfs 			= ''.$prefix.'pfs';
$db_pfs_folders 	= ''.$prefix.'pfs_folders';
$db_plugins 		= ''.$prefix.'plugins';
$db_pm 				= ''.$prefix.'pm';
$db_polls 			= ''.$prefix.'polls';
$db_polls_options 	= ''.$prefix.'polls_options';
$db_polls_voters 	= ''.$prefix.'polls_voters';
$db_rated 			= ''.$prefix.'rated';
$db_ratings 		= ''.$prefix.'ratings';
$db_referers 		= ''.$prefix.'referers';
$db_smilies 		= ''.$prefix.'smilies';
$db_stats 			= ''.$prefix.'stats';
$db_structure 		= ''.$prefix.'structure';
$db_trash	 		= ''.$prefix.'trash';
$db_users 			= ''.$prefix.'users';
/*tags*/
$db_tag_references	= 'sed_tag_references';
$db_tags			= 'sed_tags';

$db_slider 			= ''.$prefix.'slider'; //sed_slider
$db_eventhand		= ''.$prefix.'topeventhandler';//sed_topeventhandler
$db_akciok			= ''.$prefix.'akciok';//sed_akciok
$db_vow				= ''.$prefix.'vow';//sed_vow aka video of the week
$db_notice 			= ''.$prefix.'notice'; //sed_notice

//$db_videos 			= ''.$prefix.'videos'; //sed_videos 








//if you want to add more tables to the databes just use this sample
//$dc_modified only this = ''.$prefix.'modified only this'  
//default table prefix is sed_ so if you want to change it first you have to change the sql structure and the 
//sql prefixes

?>