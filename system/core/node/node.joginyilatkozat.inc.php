<?PHP

/***/

if (!defined('SED_CODE')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', 'any');
sed_block($usr['auth_read']);


require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/node.joginyil.tpl";
$t = new XTemplate($mskin);

$t->assign(array(
	"RIDELINE_MENU" => $cfg['rideline_recent_menu'],
	"FORUMS_SECTIONS_PAGETITLE" => "<a href=\"forums.php\">".$L['Forums']."</a>",
	"FORUMS_SECTIONS_MARKALL" =>  $out['markall'],
	"FORUMS_SECTIONS_GMTTIME" => $L['Alltimesare']." ".$usr['timetext'],
	"FORUMS_SECTIONS_WHOSONLINE" => $out['whosonline']." : ".$out['whosonline_reg_list']
		));


$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
