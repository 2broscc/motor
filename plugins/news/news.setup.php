<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/news/news.setup.php
Version=1.5
Updated=19-Sep-2006
Type=Plugin
Author=Neocrome advanced by Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=news
Name=News
Description=Pick up pages from a category and display the newest in the home page.
Version=1.5
Updated=19-Sep-2006
Author=Neocrome advanced by Tefra
Copyright=
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
category=01:string::news:Category code of the parent category
maxpages=02:select:0,1,2,3,4,5,6,7,8,9,10,15,20,25,30,50,100:10:Recent pages displayed
maxheadlines=03:select:0,1,2,3,4,5,6,7,8,9,10,15,20,25,30,50,100:50:Recent headlines displayed
pagenav=04:select:Default,Sedplus:Default:Pagination method (sedplus only if installed)
newscomments=05:radio::1:Show comments in news (excessive queries resources if enabled)
newsratings=06:radio::1:Show ratings in news (excessive queries resources if enabled)
[END_SED_EXTPLUGIN_CONFIG]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

?>
