<?php

require("../datas/beallit.php");

mysql_select_db("".$cfg['mysqldb']."", $con);

$sql="INSERT INTO sed_vow (vowvimeo, vow_link) VALUES ('$_POST[vowvimeo]','$_POST[vow_link]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "Video of the Week has benn added!";


mysql_close($con);

?> 



