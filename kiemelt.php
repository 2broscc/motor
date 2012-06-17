<?
/*

Filename: kiemelt.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:04-10-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu

This file has been added by 2bros cc

*/

require("datas/beallit.php");

//standmag issues @ index.php

$standmag_magazine = "test.png";
$standmag_issue_title = "Issue #11 - FREE";
$standmag_issue_img = "http://standmag.hu/szamok/free2.jpg";
$standmag_issue_link = "http://standmag.hu/";


//advertisments left side @ index.php
//$index_ad_1 = ""; 
$index_ad_3 = "<a href=\"rideline.php?m=hirdetesek\"><img src=\"ad/125×250.png\"/></a>";

//flash advertisments
$index_ad_4 = "<embed src=\"ad/crazyevils_banner_horiz.swf\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" name=\"obj1\" width=\"160\" height=\"80\"></object>";

$index_ad_5 = "<embed src=\"partners/bringaspar/bringaspar100218.swf\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" name=\"bringaspar\" width=\"160\" height=\"216\"></object>";
$index_ad_6 = "<embed src=\"partners/bringaspar/bringaspar120x40.swf\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" name=\"bringaspar_2\" width=\"200\" height=\"66\"></object>";						
	
$index_ad_7 = "<a href=\"http://www.ihbikes.hu\" target=\"blank\"><img width=\"160px\" src=\"partners/dartmoor_logo_ihbikes.jpg\"/></a>";
	
$index_ad_8_crc = "<script src=\"http://www.chainreactioncycles.com/Images/Partner/150/Scripts/swfobject_modified.js\" type=\"text/javascript\"></script>
<object id=\"FlashID\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"150\" height=\"150\">
  <param name=\"movie\" value=\"http://www.chainreactioncycles.com/Images/Partner/150/150.swf\" />
  <param name=\"quality\" value=\"high\" />
  <param name=\"wmode\" value=\"opaque\" />
  <param name=\"swfversion\" value=\"6.0.65.0\" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
  <param name=\"expressinstall\" value=\"http://www.chainreactioncycles.com/Images/Partner/150/Scripts/expressInstall.swf\" />
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type=\"application/x-shockwave-flash\" data=\"http://www.chainreactioncycles.com/Images/Partner/150/150.swf\" width=\"150\" height=\"150\">
    <!--<![endif]-->
    <param name=\"quality\" value=\"high\" />
    <param name=\"wmode\" value=\"opaque\" />
    <param name=\"swfversion\" value=\"6.0.65.0\" />
    <param name=\"expressinstall\" value=\"http://www.chainreactioncycles.com/Images/Partner/150/Scripts/expressInstall.swf\" />

</object>";
	
//advertisments & index.php ridersgear
$index_ad_2 = "<img src=\"ad/ridersgearpromo.png\"/>"; //out of date

//advertisments @ page.php left side 125×250px

$page_ad1 = "<a href=\"rideline.php?m=hirdetesek\"><img src=\"ad/125×250.png\"/></a>";

//partners and advertizers @ footer.php

//standmag.hu
$fot_standmag = "<a href=\"http://www.standmag.hu\" target=\"_newtab\" title=\"Standmag ingyenes nemzetközi magazin!\"><img src=\"partners/standmag.png\" alt=\"Da Standmag logo\" /></a>";


/*

RidersGear
@ bestdeal.indx.tpl
@ index.tpl
*/

$rg_index_advert = "<img src=\"ridersgeartest.jpg\" width=\"570px\" height=\"300px\" alt=\"\" />";


//@index.tpl

$livecast_title = "<h2>Riders Gear #1 - 2010 Elsõ szám</h2";
$livecastlink = "forums.php?m=posts&q=24";
$livecast_recent_link = "http://ridelinemtb.hu/datas/users/1-ridersgear_issue1_cover.jpg";
$livecast_recent = "<a href=\"$livecastlink\"><img src=\"$livecast_recent_link\" width=\"152px\"   alt=\"rgissue\" /></a>";


?>