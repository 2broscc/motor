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
	
	/*case 'register':
	require('system/core/users/users.register.inc.php');
	break;
	*/

	case 'auth':
	require('system/core/users/users.auth.inc.php');
	break;

	case 'details':
	require('system/core/users/users.details.inc.php');
	break;

	case 'edit':
	require('system/core/users/users.edit.inc.php');
	break;

	case 'logout':
	require('system/core/users/users.logout.inc.php');
	break;
	
	case 'profile':
	require('system/core/users/users.profile.inc.php');
	break;
	
	default:
	require('system/core/users/users.inc.php');
	break;


	}

?>
