<?PHP

/*

Filename: rg.inc.php
Programmed by 2bros cc
Date:04-15-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu


*/

defined('SED_CODE') or die('Wrong URL');

require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/ridersgear_index.tpl";
$t = new XTemplate($mskin);

$t->assign(array(

	"RIDERSGEAR_MAGAZINE_LINK" => sed_more_link("list.php?c=ridersgear","RidersGear Issues"),

		));
		
		
		
$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
