<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.moreconfig.inc.php
Version=110
Updated=2010-may-21
Type=Core.admin
Author=P�ter@2bros creative consultant
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=moreconfig", $L['moreconfig']);


$p = sed_import('p','G','ALP');

$adminmain .= "<br>";
$adminmain .= "Tov�bbi konfigur�ci�s be�ll�t�sok:";
$adminmain .= "<br>";
$adminmain .= "<hr>";
$adminmain .= "<br>";
$adminmain .= "<br>";
$adminmain .="<hr>";
$adminmain .="<br>Kezd�lap �tir�ny�t�s:<br>";
$adminmain .="<form action=\"queries/redirmode_update.php\" method=\"post\">
<select size=\"1\" name=\"redir_states\">
<option value=\"0\">�tir�ny�t</option>
<option value=\"1\">Fizetett rekl�m*nem megy m�g!</option>
<option value=\"2\">Kiemelt vide�</option>
</select>
Kiemelt vide� id: <input type=\"text\" value=\"0 vagy 1 lehet!\" name=\"topevent_onoff\" />
<input type=\"submit\" />
</form>";




?>
