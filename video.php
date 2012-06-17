<?PHP
/*

Filename: video.php


*/


define('SED_CODE', TRUE);
define('SED_PAGE', TRUE);


require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

sed_dieifdisabled($cfg['disable_page']);

switch($m)
	{
	
	case 'videolist':
	require('system/core/video/video.list.inc.php');
	break;
	
	case 'add':
	require('system/core/page/page.add.inc.php');
	break;

	case 'edit':
	require('system/core/page/page.edit.inc.php');
	break;
	
	default:
	require('system/core/video/video.inc.php');
	break;
	}

?>
