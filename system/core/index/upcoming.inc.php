<?php

/* ====================
Seditio - Website engine
Copyright 2bros
http://2bros.atw.hu
[BEGIN_SED]
File=maintenance.inc.php
Version=101
Updated=2010-july-27
Type=Core
Author=Neocrome
Description=Miantenance page
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

require("datas/beallit.php");
include("kiemelt.php");
require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/index.upcoming.tpl";
$t = new XTemplate($mskin);


$t->assign(array(


	"INDEX_STANDMAG_ISSUE_LINK" => $standmag_issue_link,
	"INDEX_STANDMAG_ISSUE_TITLE" => $standmag_issue_title,
	"INDEX_STANDMAG_ISSUE_IMG" => $standmag_issue_img,
	
	"INDEX_VIDEO_OF_THE_WEEK_LINK" =>$ki_link_id,
	"INDEX_VIDEO_OF_THE_WEEK" => "<iframe src=\"http://player.vimeo.com/video/$vimeoid?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff\" width=\"".$cfg['vow_width']."\" height=\"".$cfg['vow_height']."\" frameborder=\"0\"></iframe>",
	"INDEX_EVENT" => $index_event_div_show,
	
		));



$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");





?>