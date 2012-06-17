<?PHP

/**
node.inc.php
*/

defined('SED_CODE') or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', 'any');
sed_block($usr['auth_read']);


require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/node.tpl";
$t = new XTemplate($mskin);

$t->assign(array(

		"RIDELINE_MENU" => $cfg['rideline_recent_menu'],
			
	));


$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
