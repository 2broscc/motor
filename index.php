<?PHP

/**
index.php
*/

define('SED_CODE', TRUE);
define('SED_INDEX', TRUE);
$location = 'Home';
$z = 'index';

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');



/*retrieving the cookie*/
//$expire=time()+60*60*24*30;
//setcookie("user", "upcoming", $expire);

//use the isset() function to find out if a cookie has been set:
/*
if (isset($_COOKIE["user"]))

 switch ($m) {
 
	case 'cookies':
	require("system/core/index/cookies.inc.php");
	//print "oops!!! Valami nem jó! Dolgozunk rajta!";
	break;
	

	default:
	require('system/core/index/index.inc.php');
	break;
 
 }
 
 
else

	switch ($m) {
	default:
	require('system/core/index/upcoming.inc.php');
	break;
}
*/

 switch ($m) {
 
 
	case 'mobile':
	require("system/core/mobile/mobile.index.inc.php");
	break;
 
	default:
	require('system/core/index/index.inc.php');
	break;
 
 }





?>
