<?php
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=similar
Name=Similar Pages
Description=Displays pages which are relevant to current
Version=1.0.1
Date=2010-aug-29
Author=Raveex
Copyright=Created by Raveex - www.NovaMobile.net
Notes=Add {SIMILAR_PAGES} to page.tpl
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
max_sim=01:select:1,2,3,4,5,6,7,8,9,10:5:Max. similar pages for output
relev=02:select:0,1,2,3,4,5:2:Relevance strictness
cutstr=03:string::100:Max. title length
[END_SED_EXTPLUGIN_CONFIG]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

if ($action == 'install')
{
	$res = sed_sql_query("SHOW INDEXES FROM $db_pages WHERE Key_name = 'page_title_fulltext' AND Column_name = 'page_title';");
	if (sed_sql_numrows($res) == 0)
	{
		sed_sql_query("ALTER TABLE $db_pages ADD FULLTEXT page_title_fulltext(page_title)");
	}
}
elseif ($action == 'uninstall')
{
	$res = sed_sql_query("SHOW INDEXES FROM $db_pages WHERE Key_name = 'page_title_fulltext' AND Column_name = 'page_title';");
	if (sed_sql_numrows($res) > 0)
	{
		sed_sql_query("ALTER TABLE $db_pages DROP INDEX page_title_fulltext");
	}
}

?>