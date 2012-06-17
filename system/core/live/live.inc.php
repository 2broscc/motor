<?php

/*
Filename: live.inc.php
CMS Framework based on Seditio v121 
Re-programmed by 2bros cc
Date:04-18-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com
This file has been added by 2bros cc
*/
 
defined('SED_CODE') or die('Wrong URL');
 
require("datas/beallit.php");
require("system/header.php");
 
/*
Here comes the sql query stuff
*/
 
$row['live_player_select'];
 
if ($row['live_player_select'] == "0") {
 
   $live_event_player_body .= "";
 
}
 
elseif ($row['live_player_select'] == "1") {
 
  $live_event_player_body .= "";
 
}
 
if ($row['live_player_select']== "3") {
 
  $live_event_player_body .= "";
 
}
 

$mskin = "$user_skin_dir/".$skin."/index.live.tpl";
$t = new XTemplate($mskin);
 
 
$t->assign(array(
 
 
    "LIVE_EVENT_PLAYER" => $live_event_player_body,
 
    
        ));
 
 
 
$t->parse("MAIN");
$t->out("MAIN");
 
require("system/footer.php");

?>