<?php
/* ====================
Copyright (c) 2008-2009, Vladimir Sibirov.
All rights reserved. Distributed under BSD License.

[BEGIN_SED_EXTPLUGIN]
Code=qaptcha
Part=register
File=qaptcha.tags
Hooks=users.register.tags
Tags=users.register.tpl:{USERS_REGISTER_QAPTCHA_QUESTION},{USERS_REGISTER_QAPTCHA_INPUT}
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die("Wrong URL."); }

require_once($cfg['plugins_dir'].'/qaptcha/inc/config.php');

$qst_sql = @sed_sql_query("SELECT * FROM $db_qaptcha WHERE qst_id >= (SELECT FLOOR(MAX(qst_id) * RAND()) FROM $db_qaptcha) ORDER BY qst_id LIMIT 1");
if($qst = sed_sql_fetcharray($qst_sql))
{
	$t->assign(array(
	'USERS_REGISTER_QAPTCHA_QUESTION' => $qst['qst_text'],
	'USERS_REGISTER_QAPTCHA_INPUT' => '<input type="hidden" name="rqstid" value="'.$qst['qst_id'].'" /><input type="text" name="rqanswer" id="rqanswer" />'
	));
}
?>