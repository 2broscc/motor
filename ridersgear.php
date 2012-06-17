<?PHP

define('SED_CODE', TRUE);


require('system/functions.php');

require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');



switch($m)
	{
	
	
	case 'add':
	require('system/core/ridersgear/rg.add.inc.php');
	break;
	

	default:
	require('system/core/ridersgear/rg.inc.php');
	break;
	}

?>
