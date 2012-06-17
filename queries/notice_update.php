<?php

require("../datas/beallit.php");

mysql_select_db("".$cfg['mysqldb']."", $con);

mysql_query("UPDATE sed_notice SET notice_status = '$_POST[notice_status]'  ");
mysql_query("UPDATE sed_notice SET notice_text = '$_POST[notice_text]'  ");
mysql_query("UPDATE sed_notice SET notice_title = '$_POST[notice_title]'  ");
mysql_query("UPDATE sed_notice SET notice_date = '$_POST[notice_date]'  ");



echo "1 record added";

mysql_close($con);

?> 



