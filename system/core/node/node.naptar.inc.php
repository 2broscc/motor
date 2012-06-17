<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=rideline.php
Version=121
Updated=2010-feb-06
Type=Core
Author=Neocrome
Description=RidelineMTB
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', 'any');
sed_block($usr['auth_read']);


require("system/header.php");

print "


<div  id=\"infopanel_container\">
<div id=\"page_title\">
Verseny Naptár
</div>
<div id=\"page_subtitle\">

</div>
</div>

<div id=\"infopanel_bottom\">
<div align=right style=\"padding-top:6px;padding-right:14px;\">
MTB,4X,Slopestyle
</div>
</div>";


print "<div id=\"forum_main\">";

print "<div align=\"center\">";

print "
<div style=\"padding-bottom:5px;\"><div class=\"block_corners\">

<p>Ha szerkesztedni szeretnéd a naptárat, akkor küldd el az esemény idõpontját helyszínét email-ben és feltersszük! <a href=\"mailto:ridelineonline@gmail.com\"><b>ridelineonline[at]gmail[dot]com</b></a></p>

</div></div>";

print "<div class=\"block_corners\">";
print "<iframe src=\"http://www.google.com/calendar/embed?src=magyar.peter1%40gmail.com&ctz=Europe/Budapest\" style=\"border: 0\" width=\"920\" height=\"500\" frameborder=\"0\" scrolling=\"no\"></iframe>";
print "";
print "</div>";
print "</div>";

print "<div id=\"footer_forummainend\"></div>";

require("system/footer.php");

?>
