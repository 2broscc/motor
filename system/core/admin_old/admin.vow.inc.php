<?PHP



defined('SED_CODE') || defined('SED_ADMIN') or die('Wrong URL');

//if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

/**
video of the week
*/


$adminpath[] = array ("admin.php?m=vow", $L['RidlineMTB']);

	
$vow_result = mysql_query("SELECT * FROM $db_vow ORDER BY videoofweekID DESC LIMIT 1 ");
	while( $row = mysql_fetch_array($vow_result) ) {
	
//echo 	$row['vowvimeo'];
//echo	$row['vow_link'];
	}
	
$p = sed_import('p','G','ALP');


//if ($a == )


$adminmain .="<br>Video of the week:<br>";
$adminmain .="
<form action=\"queries/vow_insert.php\" method=\"post\">



VimeoID: <input type=\"text\" value=\"ide jön a kép\" name=\"vowvimeo\" /></br>
PageID: <input type=\"text\" value=\"Tetszõleges cim\" name=\"vow_link\" /></br>
<input type=\"submit\" />
</form>
";
$adminmain .= "<br>";



?>
