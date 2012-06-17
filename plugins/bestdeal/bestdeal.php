<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/bestdeal/bestdeal.php
Version=1.0
Updated=30-05-07
Type=Plugin
Author=J3ll3nl
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=bestdeal
Part=main
File=bestdeal
Hooks=standalone
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE') || !defined('SED_PLUG')) { die('Wrong URL.'); }
list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('plug', 'bestdeal');
sed_block($usr['auth_read']);
include ('plugins/bestdeal/inc/functions.bestdeal.inc.php');

$page = sed_import('page','G','ALP');
$cat = sed_import('cat','G','ALP');
$action = sed_import('a','G','ALP');
$id =  sed_import('id','G','ALP');
$p = sed_import('pn','G','INT');

/* Settings */
$autovalidation = $cfg['plugin']['bestdeal']['autovalidation']; // Autovalidation (0)
$admin_mail = $cfg['plugin']['bestdeal']['admin_mail'];
$state_active = $cfg['plugin']['bestdeal']['state_active']; // Months a item will stay active (1)
$maxitemsperpage = $cfg['plugin']['bestdeal']['maxitemsperpage']; // Max pages per categorie (5)
$valuta = $cfg['plugin']['bestdeal']['valuta']; // Valuta-sign (€)
$delphotoatclose = $cfg['plugin']['bestdeal']['delphotoatclose']; // Delete photo's when closing the item (1)

$photodir = "datas/photos/"; // Directory for the photo's (Make sure to chmod the directory)

$max_size_item_photo= $cfg['plugin']['bestdeal']['max_size_item_photo']; // Max size for one item photo (500000)
$max_x_item_photo = $cfg['plugin']['bestdeal']['max_x_item_photo']; // Max width for one item photo (500)
$max_y_item_photo = $cfg['plugin']['bestdeal']['max_y_item_photo']; // Max heigth for one item photo (500)

$ParseBBcodes  = $cfg['plugin']['bestdeal']['ParseBBcodes']; // Parse bbcodes (1)
$ParseSmilies  = $cfg['plugin']['bestdeal']['ParseSmilies']; // Parse smilies (1)
$ParseBR = "1"; // Parse ... (1)

/* Switch for Pages*/

switch($page) {
	default:
		if($id > 0) {
			require('plugins/bestdeal/inc/viewitem.bestdeal.inc.php');
}
	else {
		require('plugins/bestdeal/inc/index.bestdeal.inc.php');
}
	break;

	case 'viewcat':
	
		sed_shield_protect();
	
	require('plugins/bestdeal/inc/viewcat.bestdeal.inc.php');
	
	break;
	
	case 'additem':
	
		sed_shield_protect();
		sed_block($usr['auth_write']);
		include ('plugins/bestdeal/inc/tb2.bestdeal.php');
		require('plugins/bestdeal/inc/additem.bestdeal.inc.php');
	
	break;
	
	case 'edititem':
	
		sed_shield_protect();
		sed_block($usr['auth_write']);
		include ('plugins/bestdeal/inc/tb2.bestdeal.php');
		require('plugins/bestdeal/inc/edititem.bestdeal.inc.php');
	break;
	
	case 'userpanel':
		require('plugins/bestdeal/inc/userpanel.bestdeal.inc.php');
	break;
	
	case 'addcat':
	
		sed_shield_protect();
		sed_block($usr['isadmin']);
		include ('plugins/bestdeal/inc/tb2.bestdeal.php');
		require('plugins/bestdeal/inc/addcat.bestdeal.inc.php');
	break;
	
	case 'editcat':
	
		sed_shield_protect();
		sed_block($usr['isadmin']);
		include ('plugins/bestdeal/inc/tb2.bestdeal.php');	
		require('plugins/bestdeal/inc/editcat.bestdeal.inc.php');	
	break;
	
	case 'sendmail':
	
		sed_shield_protect();
		sed_block($usr['auth_write']);
		include ('plugins/bestdeal/inc/tb2.bestdeal.php');
		require('plugins/bestdeal/inc/sendmail.bestdeal.inc.php');
	break;
	
	case 'akcio':
	
		require("plugins/bestdeal/inc/akcio.bestdeal.inc.php");
	break;
	
} //switch end

?>