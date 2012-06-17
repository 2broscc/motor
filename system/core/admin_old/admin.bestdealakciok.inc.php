<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.tools.inc.php
Version=110
Updated=2006-jun-06
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=bestdealakciok", $L['RidlineMTB']);

$adminmain .= "<h2>Bestdeal Akciók</h2>";
$adminmain .= "<html>

<form action=\"queries/bestdealakciok_insert.php\" method=\"post\">
<br>
<br>
URL:<input type=\"text\" value=\"\" name=\"url\" /><br>
CÍM:<input type=\"text\" value=\"\" name=\"title\" /><br>
Szöveg:<br><textarea name=\"content\" rows=\"5\" cols=\"100%\">Szöveg...</textarea>
<br>
<input type=\"submit\" />
</form>

</html>";

/*
$result = mysql_query("SELECT * FROM $db_akciok ORDER BY akciokID DESC ");
	
	while ( $slider_row1 = mysql_fetch_array($result)) {
	
	echo $slider_row1['url'];
	echo $slider_row1['title'];
	echo $slider_row1['content'];

	}

*/
?>
