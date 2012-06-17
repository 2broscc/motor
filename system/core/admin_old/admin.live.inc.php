<?PHP

/*Header notice add form*/

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=live", $L['RidlineMTB']);



$notice = mysql_query("SELECT * FROM $db_notice");

	while($row = mysql_fetch_array($notice)) {
	
$n_status =	$row['notice_status'];
$n_text =	$row['notice_text'];
$n_title = $row['notice_title'];
$n_date = $row['notice_date'];
			
	}



$p = sed_import('p','G','ALP');



if ($a == "add") {





}


//live

$adminmain .="<br>Live<br>";

$adminmain .="<form action=\"queries/notice_update.php\" method=\"post\">
<select size=\"1\"  name=\"notice_status\" value =\"$n_status\">
<option value=\"0\">Kikapcsol</option>
<option value=\"1\">Bekapcsol</option>
</select>
<br>
Cím:<input type=\"text\" value=\"$n_title\" name=\"notice_title\" /><br>
Dátum:<input type=\"text\" value=\"$n_date\" name=\"notice_date\" /><br>
Szöveg:<textarea name=\"notice_text\" rows=\"5\" cols=\"100%\">$n_text...</textarea>
<input type=\"submit\" />
</form>";

$adminmain .= "<br>";
?>
