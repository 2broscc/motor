<?php

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=page.inc.php
Version=126
Updated=2010-april-28
Type=Core
Author=Neocrome
Description=Pages
[END_SED]
==================== */

//if (!defined('SED_CODE')) { die('Wrong URL.'); }

require("../datas/beallit.php");
//$db_name = "sed_redirmode";

$db_name = $db_redirmode;

//mysql_select_db("".$cfg['mysqldb']."", $con);

mysql_query("UPDATE $db_name  SET redir_states = '$_POST[redir_states]' ");
echo "Redir states megváltozott!";
mysql_query("UPDATE $db_name  SET kiemelt_video = '$_POST[kiemelt_video]' ");
echo "A video id megváltozott";

mysql_close($con);

?> 



