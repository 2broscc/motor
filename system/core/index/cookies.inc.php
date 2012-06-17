<?php

/*

Filename: mailer.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:02-02-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

This file has been added by 2bros cc

*/

if (!defined('SED_CODE')) { die('Wrong URL.'); }

require("datas/beallit.php");

include("kiemelt.php");


if ($c == 'delete') {

	setcookie("user", "", time()-3600);

}

echo $_COOKIE["user"];// Print a cookie
print "<br>";
print_r($_COOKIE); //// A way to view all cookies






?>