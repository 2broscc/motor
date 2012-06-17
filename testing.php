<?

/*

Filename: testing.php
Re-programmed by 2bros cc
Date:04-14-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu

This file has added by 2bros cc

*/


define('SED_CODE', TRUE);

require('system/functions.php');
require('system/templates.php');
require('datas/beallit.php');
require('system/common.php');

switch($m) {


	default:
	require("system/test.inc.php");
	break;



}
/*================common skins stuff testing=============*/

/*
 echo "user_skin_dir:";
 
 echo $user_skin_dir = $cfg['default_skin_dir']; 
 echo "<br>";
 
  echo "name of the skin:";
 echo $user_skin = $usr['skin'];
  echo "<br>";
 
  echo "user_raw?!:";
 echo $user_skin_raw = $usr['skin_raw'];
  echo "<br>";
 
  echo "user_lang:  ";
 echo "$user_lang.lang.php";
 echo "<br>";
  echo "<br>";
   echo "<br>";
 
 echo $m = "$user_skin_dir/$user_skin/$user_sking_raw.$user_lang.lang.php";
 
 echo "<hr>";

*/



echo "screen resolution:";
echo "<br>";


if(!isset($_GET['r']))  { 
echo "
<script language=\"JavaScript\"> 
<!--  
document.location=\"$PHP_SELF?r=1&width=\"+screen.width+\"&height=\"+screen.height; 
//--> 
</script>"; 
} 

else {     

// Code to be displayed if resolutoin is detected 
     if(isset($_GET['width']) && isset($_GET['height'])) { 
	 
	//echo	$width = $_GET['width'];
		


			if ($width =="1024" || $width > "1024") {
			
						echo "1024 a felbontás vagy nagyobb";
		
			}
			
			else {
			
			
			
			}
			
		


			  // Resolution  detected 
     } 
     else { 
               // Resolution not detected 
     } 
} 

?>
