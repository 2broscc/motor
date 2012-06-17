<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=rideline.php
Version=121
Updated=2010-feb-06
Type=Core
Author=Neocrome
Description=RidelineMTB
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', 'any');
sed_block($usr['auth_read']);


require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/node.advertisments.tpl";
$t = new XTemplate($mskin);

$t->assign(array(
	"RIDELINE_MENU" => $cfg['rideline_recent_menu'],
	"RIDELINE_ADVERT_KINDS" => "<div align=\"center\"<img src=\"ad/ad_samples.png\"/></div>",

		));


$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
