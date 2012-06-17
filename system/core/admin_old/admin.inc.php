<?PHP

defined('SED_CODE') || defined('SED_ADMIN') or die('Wrong URL');


$c = sed_import('c','G','TXT');
$id = sed_import('id','G','TXT');
$po = sed_import('po','G','TXT');
$p = sed_import('p','G','TXT');
$l = sed_import('l','G','TXT');
$o = sed_import('o','P','TXT');
$w = sed_import('w','P','TXT');
$u = sed_import('u','P','TXT');
$s = sed_import('s','G','ALP', 24);

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'any');
sed_block($usr['auth_read']);

$enabled[0] = $L['Disabled'];
$enabled[1] = $L['Enabled'];

/* === Hook for the plugins === */
$extp = sed_getextplugins('admin.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }

	
	
// hooks to see the proper content
$sys['inc'] = (empty($m)) ? 'admin.home' : "admin.$m";
$sys['inc'] = (empty($s)) ? $sys['inc'] : $sys['inc'].".$s";


$sys['inc'] = 'system/core/admin/'.$sys['inc'].'.inc.php';

if (!file_exists($sys['inc'])) { sed_die(); }

$allow_img['0']['0'] = "<img src=\"system/img/admin/deny.gif\" alt=\"\" />";
$allow_img['1']['0'] = "<img src=\"system/img/admin/allow.gif\" alt=\"\" />";
$allow_img['0']['1'] = "<img src=\"system/img/admin/deny_locked.gif\" alt=\"\" />";
$allow_img['1']['1'] = "<img src=\"system/img/admin/allow_locked.gif\" alt=\"\" />";



require($sys['inc']);
$adminhelp = (empty($adminhelp)) ? $L['None'] : $adminhelp;

require("system/header.php");

//admin main menu
include ("system/core/admin/admin.elements.inc.php");
require("system/core/admin/admin.quickmenu.inc.php");

$t = new XTemplate("$user_skin_dir/".$skin."/admin.tpl");


$t->assign(array(
	"ADMIN_TITLE" => sed_build_adminsection($adminpath),
	"ADMIN_SUBTITLE" => $adminsubtitle,
	"ADMIN_MENU" => $adminmenu,
	"ADMIN_MAIN" => $adminmain,
	"ADMIN_HELP" => $adminhelp,
		));

/* === Hook for the plugins === */
$extp = sed_getextplugins('admin.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>