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

$adminpath[] = array ("admin.php?m=rideline", $L['RidlineMTB']);

mysql_select_db("".$cfg['mysqldb']."", $con);

$slider_elem_result = mysql_query("SELECT url,title,pageid FROM sed_slider ");
	while( $slider_row = mysql_fetch_array($slider_elem_result) ) {
	
	$pageid = $slider_row['pageid'];
	$url = $slider_row['url'];
	$title = $slider_row['title'];

	}
	

$limit_akciok = 23;

	/*
$bestdeal_res = sed_sql_query("SELECT * FROM $db_bestdealakcio ORDER by sed_bestdealakcioID DESC LIMIT $limit_akciok ");

while( $row = sed_sql_fetcharray($bestdeal_res) ) {

	$bs_mask = "<div>
	
	<p>".$row['bestdealakico_title']."</p>
	<p>".$row['bestdealakcio_szoveg']."</p>
	<br>
	
	</div>"; 
	
//echo	$row['bestdealakico_title'];
//echo 	$row['bestdealakcio_szoveg'];
	}
	*/



$p = sed_import('p','G','ALP');

$adminmain .= "<br>VOW: <a href=\"admin.php?m=vow\">Video of the Week</a><br>";
$adminmain .= "<br>Akci�k hozz�ad�sa: <a href=\"admin.php?m=bestdealakciok\">Akci�k</a><br>";
$adminmain .= "<br>Header notice: <a href=\"admin.php?m=headernotice\">Headernotice</a><br>";
$adminmain .= "<br>Header notice: <a href=\"admin.php?m=company_links\">Company Links (separated with categories)</a><br>";

$adminmain .= "<br>";
$adminmain .= "Tov�bbi be�ll�t�sok";
$adminmain .= "<br>";
$adminmain .= "<hr>";
$adminmain .= "<a href=\"updater.php\">Kiemelt Friss�t�je</a>";
$adminmain .= "<br>";
$adminmain .= "<a href=\"datas/slider/index.php\">Top Img Felt�lt�</a>";
$adminmain .= "<br>";
$adminmain .= "<br>";

$adminmain .="<hr>";
$adminmain .="<br>Slider img uploader:<br>";
$adminmain .="<form action=\"queries/slider_insert.php\" method=\"post\">
<br>
K�p#1: <input type=\"text\" value=\"\" name=\"url\" />
Title#1: <input type=\"text\" value=\"\" name=\"title\" />
Page id#1: <input type=\"text\" value=\"\" name=\"pageid\" />

<br>
<input type=\"submit\" />
</form>";
$adminmain .= "<br>";
$adminmain .="<hr>";

$adminmain .="<form action=\"queries/topevent_update.php\" method=\"post\">";
$adminmain .="<br>Kiemelt esem�nyek:";
$adminmain .="<select size=\"1\" name=\"topevent_onoff\">
<option value=\"1\">Bekapcsol�s</option>
<option value=\"0\">Kikapcsol�s</option>
</select>
<br>
Visszasz�ml�l�: (be/ki)
<select size=\"1\" name=\"topevent_counter\">
<option value=\"0\">Ki</option>
<option value=\"1\">Be</option>
</select>
Id�pont be�ll�t�sa: <input type=\"text\" value=\"$top_counter_settime\" name=\"topevent_counter_settime\" /> Esem�ny c�me: <input type=\"text\" value=\"$top_counter_title\" name=\"topevent_counter_title\" /> <br>
<b>Seg�ts�g:</b>Az id�pont megadhat�: 10/26/2010 8:00 PM UTC-0500 avagy 10/26/2010 form�tumban is! Az <b>esem�ny c�me</b> fog megjelenni legfel�l!
<br>

<b>K�pes h�r:</b><br>

K�p: <input type=\"text\" size=\"30\" value=\"$topevent_image\" name=\"topevent_image\" />
K�p id: <input type=\"text\" value=\"$topevent_linkid\" name=\"topevent_linkid\" />
<br>
R�vid ismertet�:<br>
<textarea name=\"topevent_descrip\" rows=\"5\" cols=\"100%\">$topevent_text_descipt</textarea>



<input type=\"submit\" />
</form>";


$adminmain .= "<br>";
$adminmain .="<hr>";
$adminmain .="<br>Kezd�lap �tir�ny�t�s:<br>";
$adminmain .="<form action=\"queries/redirmode_update.php\" method=\"post\">
<select size=\"1\"  name=\"redir_states\">
<option value=\"0\">�tir�ny�t</option>
<option value=\"1\">Fizetett rekl�m*nem megy m�g!</option>
<option value=\"2\">Kiemelt vide�</option>
</select>
Kiemelt vide� id: <input type=\"text\" value=\"Csak vimeos id lehet!\" name=\"topevent_onoff\" />
<input type=\"submit\" />
</form>";


/**

probably it is out dated
*/
$adminmain .= "<br>";
$adminmain .="<hr>";
$adminmain .="<br>Magazin issue friss�t�s:<br>";
$adminmain .="<form action=\"queries/redirmode_update.php\" method=\"post\">
Magazin title: <input type=\"text\" value=\"Csak vimeos id lehet!\" name=\"topevent_onoff\" />
Magazin image: <input type=\"text\" value=\"Csak vimeos id lehet!\" name=\"topevent_onoff\" />
<input type=\"submit\" />
</form>";


$adminmain .= "<br>";
$adminmain .="<hr>";
$adminmain .="<br>Akci�k (Ridersgear-ben!)<br>";
$adminmain .="<form action=\"queries/bestdealakcio_insert.php\" method=\"post\">

<div id=\"amsg\">$a_msg</div><br>

<br>
C�m:<input type=\"text\" value=\"\" name=\"bestdealakico_title\" />
Sz�veg:<textarea name=\"bestdealakcio_szoveg\" rows=\"5\" cols=\"100%\">Sz�veg...</textarea>
<br>

<input type=\"submit\" />
</form>";

$adminmain .= "<br>";




?>
