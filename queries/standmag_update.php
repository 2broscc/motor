<?php

require("../datas/beallit.php");
$db_name = "sed_standmag";

mysql_select_db("".$cfg['mysqldb']."", $con);

mysql_query("UPDATE $db_name  SET standmag_title = '$_POST[standmag_title]' ");
echo "Redir states megváltozott!";
mysql_query("UPDATE $db_name  SET standmag_img = '$_POST[standmag_img]' ");
echo "A video id megváltozott";

mysql_close($con);

?> 



