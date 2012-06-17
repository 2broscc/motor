<?php
/* ====================
Copyright (c) 2008-2009, Vladimir Sibirov.
All rights reserved. Distributed under BSD License.

[BEGIN_SED_EXTPLUGIN]
Code=qaptcha
Part=validate
File=qaptcha.validate
Hooks=users.register.add.first
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */
if (!defined('SED_CODE')) { die('Wrong URL.'); }

require_once($cfg['plugins_dir'].'/qaptcha/inc/config.php');

$rqstid = sed_import('rqstid', 'P', 'INT');
$rqanswer = sed_sql_prep(sed_import('rqanswer', 'P', 'STX'));

$qst_sql = @sed_sql_query("SELECT * FROM $db_qaptcha WHERE qst_id = $rqstid");
$qst = @sed_sql_fetcharray($qst_sql);
if(mb_strtoupper($rqanswer) != mb_strtoupper($qst['qst_answer']))
{
	$error_string .= $L['qst_failed'].'<br />';
}

?>