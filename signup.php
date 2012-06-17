<?PHP



define('SED_CODE', TRUE);
define('SED_USERS', TRUE);
$location = 'Users';
$z = 'users';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

switch($m)
	{

	
	case 'register':
	require('system/core/signup.inc.php');
	break;
	
	default:
	require('system/core/signup.inc.php');
	break;


	}

?>
