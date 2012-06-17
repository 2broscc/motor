<?PHP



define('SED_CODE', TRUE);
define('SED_LIST', TRUE);


require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');


switch($m)
	{
	default:
	require('system/core/video/video.list.inc.php');
	break;
	}

?>
