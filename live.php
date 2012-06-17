<?PHP


/**

test

*/


define('SED_CODE', TRUE);


require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');



 switch ($modul) {
 
 
	case 'liveadd':
	require("system/core/live/live.add.inc.php");
	break;

	default:
	require("system/core/live/live.inc.php");
	break;


 
 }





?>
