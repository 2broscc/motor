<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=list.php
Version=101
Updated=2006-mar-15
Type=Core
Author=Neocrome
Description=Pages loader
[END_SED]
==================== */

define('SED_CODE', TRUE);
define('SED_LIST', TRUE);
$location = 'Pages';
$z = 'page';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

sed_dieifdisabled($cfg['disable_page']);

switch($m)
	{
	default:
	require('system/core/list/list.inc.php');
	break;
	}

?>
