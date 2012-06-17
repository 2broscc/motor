<?PHP

/**
mobile.php
*/

define('SED_CODE', TRUE);


require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');



 switch ($m) {
 
	case "logout":
	require("system/core/mobile/mobile.logout.inc.php");
	break;
 
	case "login":
	require("system/core/mobile/mobile.login.inc.php");
	break;
	
	case "edit":
	require("system/core/mobile/mobile.page.edit.inc.php");
	break;
 
	case "add":
	require("system/core/mobile/mobile.page.add.inc.php");
	break;
 
	case "page":
	require('system/core/mobile/mobile.page.inc.php');
	break;
 
	default:
	require('system/core/mobile/mobile.index.inc.php');
	break;
 
 }





?>
