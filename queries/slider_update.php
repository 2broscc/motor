<?php

require("../datas/beallit.php");
$db_name = "sed_slider";

mysql_select_db("".$cfg['mysqldb']."", $con);

mysql_query("UPDATE $db_name  SET url = '$_POST[url]'");
mysql_query("UPDATE $db_name  SET title = '$_POST[title]'");
mysql_query("UPDATE $db_name  SET pageid = '$_POST[pageid]'");



echo "ok";

mysql_close($con);

?> 



