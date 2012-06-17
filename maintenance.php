<?PHP

/*

Filename: maintenance.php
CMS Framework based on Seditio v121 
Re-programmed by 2bros cc
Date:02-03-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com



*/

define('SED_CODE', TRUE);
define('SED_INDEX', TRUE);
//$location = 'Home';
$z = 'maintenance';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');


	switch ($m) {
	default:
	require('system/core/maintenace/maintenace.inc.php');
	break;

		}



?>
