<?PHP

/*

Filename: mailer.php
CMS Framework based on Seditio v121 
Re-programmed by 2bros cc
Date:02-02-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

*/

define('SED_CODE', TRUE);
define('SED_PM', TRUE);
$location = 'Private_Messages';
$z = 'pm';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

sed_dieifdisabled($cfg['disable_pm']);

switch($m)
	{
	case 'send':
	require('system/core/mailer/mailer.send.inc.php');
	break;

	case 'edit':
	require('system/core/mailer/mailer.edit.inc.php');
	break;

	default:
	require('system/core/mailer/mailer.inc.php');
	break;
	}

?>
