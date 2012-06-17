<?PHP

/**
node.php
*/

define('SED_CODE', TRUE);

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

switch($m) {
	
	//for the magazines
	case 'ridersgear':
	require('system/core/node/node.ridersgear.inc.php');
	break;
	
	case 'naptar':
	require('system/core/node/node.naptar.inc.php');
	break;
	
	case 'hirdetesek':
	require('system/core/node/node.advertisments.inc.php');
	break;
	
	
	case 'jogi':
	require('system/core/node/node.joginyilatkozat.inc.php');
	break;
	
	case 'disclaimer':
	require('system/core/nide/node.disclaimer.inc.php');
	break;


	default:
	require('system/core/node/node.inc.php');
	break;
	
	
	
	}

?>
