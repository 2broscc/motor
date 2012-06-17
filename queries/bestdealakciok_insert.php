<?php

/* Bestdeal plugin - Akciok part insertation query */

require("../datas/beallit.php");
mysql_select_db("".$cfg['mysqldb']."", $con);
  
/*
mysql_query("UPDATE $db_name  SET url = '$_POST[url]'");
//mysql_query("DELETE FROM $dbnaem WHERE LastName='Griffin'");
*/

mysql_query("INSERT $db_akciok	  SET url = '$_POST[url]',title = '$_POST[title]', content = '$_POST[content]' ");
$back_btn = "<a href=\"javascript:history.go(-1)\">Vissza</a>";
print("Added the requested data to the sql database,$back_btn!");


mysql_close($con);
?> 



