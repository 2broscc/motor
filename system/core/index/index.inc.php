<?PHP

/**

Filename: index.inc.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:06-21-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

This file has been added by 2bros cc

*/

defined('SED_CODE') or die('Wrong URL');

/* === Hook === */
$extp = sed_getextplugins('index.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('index', 'a');

/* === Hook === */
$extp = sed_getextplugins('index.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */


require("index.functions.inc.php");

include("kiemelt.php");
require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/index.tpl";
$t = new XTemplate($mskin);

$t->assign(array(

	
	

	"INDEX_LATEST_ENTRY" => latest_entry_in_db(),
	"TOP_APPLE" => short_list(8,"apple"),
	"TOP_ELEKTRONIKA" => short_list(12,"elektronika"),
	
	"TOP_TELEKOMMUNIKACIO" => short_list(6,"telekom"),

	"RG_MASK" => $rg_mask,

	"STANDMAG_MAGAZINE" => $standmag_magazine,
	"TOP_TESZT" => $teszt_mask,
	"TOP_TECH" => $tech_mask,
	
	
	
	
	
	"TOP_NEWS" => kiemelt(),
	
	"LATEST_NEW" => latest_news(),
	
	//to do
	
	"RG" => $mask_rg_odd,
	"RG_EVEN" => $mask_rg_even,
	
	"LATEST_UPDATE_MASK" => $latest_updates_mask,
    "EVENT" => $eventmask,
	"EVENT_HANDLER_TITLE" => $top_counter_title,
	"EVENT_HANDLER_COUNTER" => $countdownmask,
	"EVENT_EXPANDED_OFF" => $expanded_content_off,
	"EVENT_COUNTER_OFF" =>  $counter_div_off,
	"EVENT_HANDLER_ONOFF" => $eventhandler_show,
	"EVENT_HANDLER_DIV" => $div_top,
	
	"SLIDER_MASK" => nivo_slider(),
	

	"LIVECAST_TITLE" => $livecast_title,
	"LIVECAST_RECENT" => $livecast_recent,
	
	
	"MBKSE_BANNER" => $mbkse_banner,
	"INDEX_AD1" => $index_ad_1,
	"INDEX_AD2" => $index_ad_2,
	"INDEX_AD3" => $index_ad_3,
	"INDEX_AD4" => $index_ad_4,
	"INDEX_AD5" => $index_ad_5,
	
	"INDEX_AD7" => $index_ad_7,
	"INDEX_AD8_CRC" => 	$index_ad_8_crc,
	
	"INDEX_STANDMAG_ISSUE_LINK" => $standmag_issue_link,
	"INDEX_STANDMAG_ISSUE_TITLE" => $standmag_issue_title,
	"INDEX_STANDMAG_ISSUE_IMG" => $standmag_issue_img,
	
	"INDEX_VIDEO_OF_THE_WEEK_LINK" =>$ki_link_id,
	
	
	
	"INDEX_VIDEO_OF_THE_WEEK" =>vow(),
	
	
	
	
	"INDEX_EVENT" => $index_event_div_show,
	
	"INDEX_KOPONYEG" => "<script type=\"text/javascript\" src=\"http://koponyeg.hu/addon.js.php?r=4&c=light&s=200x125\"> </script>",
	
	/*======================User defined tags, arrays ================*/
	
	"UDEF_MORE_NEWS" => sed_more_link("list.php?c=news","Összes Hír"),
	"UDEF_MORE_VIDEOS" => sed_more_link("videolist.php","Összes Videó"),
	"UDEF_VIDEO_THMB" => video_thmb(),
	
	
	
		));


/* === Hook === */
$extp = sed_getextplugins('index.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
