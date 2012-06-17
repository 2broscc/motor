<?php

/*

company_links_insert query
@ 2011.01.20

*/

require("../datas/beallit.php");

mysql_select_db("".$cfg['mysqldb']."", $con);

$sql="INSERT INTO sed_company_links (cl_text, cl_title, cl_cat)

VALUES ('$_POST[cl_text]','$_POST[cl_title]','$_POST[cl_cat]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "added!";


mysql_close($con);

?> 

