<?php
/* ====================
Copyright (c) 2008-2009, Vladimir Sibirov.
All rights reserved. Distributed under BSD License.

[BEGIN_SED_EXTPLUGIN]
Code=qaptcha
Name=QAPTCHA
Description=Question-based CAPTCHA
Version=0.2
Date=2009-jan-30
Author=Trustmaster
Copyright=(c) Vladimir Sibirov
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]
==================== */
if ( !defined('SED_CODE') ) { die("Wrong URL."); }

if($action == 'install')
{
	$script = "CREATE TABLE sed_qaptcha (
	qst_id INT NOT NULL AUTO_INCREMENT,
	qst_text VARCHAR(255) NOT NULL,
	qst_answer	VARCHAR(255) NOT NULL,
	PRIMARY KEY(qst_id)
	);
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('What is the name of our planet?', 'earth');
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('The name of USA, Canada, Australia currency is', 'dollar');
	INSERT INTO sed_qaptcha (qst_text, qst_answer)
	VALUES ('A horse-like animal with black and white lines', 'zebra')";
	$queries = explode(";\n", $script);
	foreach($queries as $query)
	{
		sed_sql_query($query);
	}
}
elseif($action == 'uninstall')
{
	sed_sql_query("DROP TABLE sed_qaptcha");
}
?>