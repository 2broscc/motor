<?php

require("../datas/beallit.php");

mysql_select_db("".$cfg['mysqldb']."", $con);

$sql="INSERT INTO sed_slider (url, title, pageid)

VALUES ('$_POST[url]','$_POST[title]','$_POST[pageid]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";


mysql_close($con);

?> 

