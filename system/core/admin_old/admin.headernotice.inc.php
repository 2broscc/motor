<?PHP

/*Header notice add form*/

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=headernotice", $L['RidlineMTB']);

//mysql_select_db("".$cfg['mysqldb']."", $con);

$notice = mysql_query("SELECT * FROM $db_notice");

	while($row = mysql_fetch_array($notice)) {
	
$n_status =	$row['notice_status'];
$n_text =	$row['notice_text'];
$n_title = $row['notice_title'];
$n_date = $row['notice_date'];
			
	}

	
$p = sed_import('p','G','ALP');

$adminmain .= "<br>Akci�k hozz�ad�sa: <a href=\"admin.php?m=bestdealakciok\">Akci�k</a><br>";

$adminmain .= "<br>";
$adminmain .= "RidelineMTB be�ll�t�sok";
$adminmain .= "<br>";
$adminmain .= "<hr>";
$adminmain .= "<a href=\"updater.php\">Kiemelt Friss�t�je</a>";
$adminmain .= "<br>";
$adminmain .= "<a href=\"datas/slider/index.php\">Top Img Felt�lt�</a>";
$adminmain .= "<br>";
$adminmain .= "<br>";

$adminmain .= "<hr>";


//header notice

$adminmain .="<br>Header Notice <br>";
$adminmain .="<form action=\"queries/notice_update.php\" method=\"post\">
<select size=\"1\"  name=\"notice_status\" value =\"$n_status\">
<option value=\"0\">Kikapcsol</option>
<option value=\"1\">Bekapcsol</option>
</select>
<br>
C�m:<input type=\"text\" value=\"$n_title\" name=\"notice_title\" /><br>
D�tum:<input type=\"text\" value=\"$n_date\" name=\"notice_date\" /><br>
Sz�veg:<textarea name=\"notice_text\" rows=\"5\" cols=\"100%\">$n_text...</textarea>
<input type=\"submit\" />
</form>";

$adminmain .= "<br>";
?>
