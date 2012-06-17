<?PHP

/*

Filename: message.php
CMS Framework based on Seditio v121 
Re-programmed by 2bros cc
Date:02-02-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

*/

define('SED_CODE', TRUE);
define('SED_MESSAGE', TRUE);
$location = 'Messages';
$z = 'message';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

switch($m)
	{
	default:
	require('system/core/message/message.inc.php');
	break;
	}

?>
