<?php

/*
Filename: live.add.inc.php
CMS Framework based on Seditio v121 
Programmed by 2bros cc
Date:04-18-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com
This file has been added by 2bros cc
*/
 
 
defined('SED_CODE') or die('Wrong URL');
 
 
//(defined('SED_CODE')  die('Wrong URL.');


/*list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('users', 'a');
sed_block($usr['isadmin']); */


/*
if ($usr['isadmin'] == TRUE) {print "jooo";} else {


echo "nem";

} */
 
require("datas/beallit.php");
require("system/header.php");
 
$form_query = "queries/live_update.php";
 
/*
add form body
*/
 
 
$live_add_form_start = "<form action=\"$form_query\" method=\"post\">";
$live_add_player_body = "<select size=\"1\" name=\"topevent_onoff\">
<option value=\"1\">Bekapcsolás</option>
<option value=\"0\">Kikapcsolás</option>
</select>";
$live_add_video_id = "VimeoID: <input type=\"text\" value=\"ide jön a kép\" name=\"vowvimeo\" />";
$live_add_details = "Részletek:<textarea></textarea>";
$live_add_date = ""; //todo: to implement the sed_ date func here
$live_add_thmb = "Thumbnail:<br><input value=\"\" />"; //todo:
$live_add_upcomingevents = "Szöveg:<br><textarea name=\"bestdealakcio_szoveg\" rows=\"5\" cols=\"100%\">Szöveg...</textarea>";
 
 
 
 
$live_add_form_end = "<input type=\"submit\" /></form>";
 
$mskin = "$user_skin_dir/".$skin."/ridersgear_add.tpl";  //todo: make the template file
 
$t = new XTemplate($mskin);
$t->assign(array(
 
 
    "LIVE_ADD_FORM_START" => $live_add_form_start,
	
	"LIVE_ADD_FORM_PLAYER_BODY" => $live_add_player_body,
	"LIVE_ADD_FORM_VIDEOID" => $live_add_video_id,
	"LIVE_ADD_FORM_DETAILS" => $live_add_details,
	"LIVE_ADD_FORM_DATE" => $live_add_date,
	"LIVE_ADD_FORM_THMB" => $live_add_thmb,
	"LIVE_ADD_FORM_UPCOMINGEVENT" => $live_add_upcomingevents,
	
	
	
	
	
	 "LIVE_ADD_FORM_END" => $live_add_form_end,
 
          
 
 
    
        ));
 
 
 
$t->parse("MAIN");
$t->out("MAIN");
 
require("system/footer.php");


?>