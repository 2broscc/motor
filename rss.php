<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=rss.php
Version=101
Updated=2010-07-08
Type=Core
Author=Neocrome
Description=RSS
[END_SED]
==================== */
/*
Example of feeds:
rss.php?c=news (or other category)
rss.php?c=comments&id=XX
rss.php?c=forums
rss.php?c=topic&id=XX
rss.php?c=section&id=XX (this and all subsections)
*/
define('SED_CODE', TRUE);

require('system/functions.php');
require('datas/beallit.php');
require('system/common.php');
require("system/core/rss/rss.inc.php");


?>
