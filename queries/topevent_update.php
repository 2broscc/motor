<?php

require("../datas/beallit.php");

mysql_select_db("".$cfg['mysqldb']."", $con);

mysql_query("UPDATE sed_topeventhandler SET topevent_onoff = '$_POST[topevent_onoff]'  ");
mysql_query("UPDATE sed_topeventhandler SET topevent_counter = '$_POST[topevent_counter]' ");
mysql_query("UPDATE sed_topeventhandler SET topevent_counter_settime = '$_POST[topevent_counter_settime]' ");
mysql_query("UPDATE sed_topeventhandler SET topevent_counter_title = '$_POST[topevent_counter_title]' ");
mysql_query("UPDATE sed_topeventhandler SET topevent_image = '$_POST[topevent_image]' ");
mysql_query("UPDATE sed_topeventhandler SET topevent_linkid = '$_POST[topevent_linkid]' ");

mysql_query("UPDATE sed_topeventhandler SET topevent_descrip = '$_POST[topevent_descrip]' ");

mysql_query("UPDATE sed_topeventhandler SET topevent_links = '$_POST[topevent_links]' ");


echo "1 record added";

mysql_close($con);

?> 



