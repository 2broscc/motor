<?php
/* ====================
Copyright (c) 2008-2009, Vladimir Sibirov.
All rights reserved. Distributed under BSD License.

[BEGIN_SED_EXTPLUGIN]
Code=qaptcha
Part=admin
File=qaptcha.admin
Hooks=tools
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$act = sed_import('act', 'G', 'ALP');
$id = sed_import('id', 'G', 'INT');

$plugin_title = 'QAPTCHA';

require_once($cfg['plugins_dir'].'/qaptcha/inc/config.php');

if($act == 'add')
{
	$text = sed_sql_prep(sed_import('question', 'P', 'STX'));
	$answer = sed_sql_prep(sed_import('answer', 'P', 'STX'));
	if(!empty($text) && !empty($answer))
	{
		$sql = sed_sql_query("INSERT INTO $db_qaptcha (qst_text, qst_answer) VALUES ('$text', '$answer')");
		if(sed_sql_affectedrows() == 1)
		$plugin_body .= '<div class="error">'.$L['qst_done'].'</div>';
		else
		$plugin_body .= '<div class="error">'.$L['qst_error'].'</div>';
	}
	$plugin_body .= '<a href="'.sed_url('admin', 'm=tools&p=qaptcha').'">'.$L['qst_back'].'</a>';
}
elseif($act == 'del' && $id > 0)
{
	$sql = sed_sql_query("DELETE FROM $db_qaptcha WHERE qst_id = $id");
	if(sed_sql_affectedrows() == 1)
	$plugin_body .= '<div class="error">'.$L['qst_done'].'</div>';
	else
	$plugin_body .= '<div class="error">'.$L['qst_error'].'</div>';
	$plugin_body .= '<a href="'.sed_url('admin', 'm=tools&p=qaptcha').'">'.$L['qst_back'].'</a>';
}
elseif($act == 'edit' && $id > 0)
{
	$text = sed_sql_prep(sed_import('question', 'P', 'STX'));
	$answer = sed_sql_prep(sed_import('answer', 'P', 'STX'));
	if(!empty($text) && !empty($answer))
	{
		$sql = sed_sql_query("UPDATE $db_qaptcha SET qst_text = '$text', qst_answer = '$answer' WHERE qst_id = $id");
		if(sed_sql_affectedrows() == 1)
		$plugin_body .= '<div class="error">'.$L['qst_done'].'</div>';
		else
		$plugin_body .= '<div class="error">'.$L['qst_error'].'</div>';
	}
	elseif($row = sed_sql_fetcharray(sed_sql_query("SELECT * FROM $db_qaptcha WHERE qst_id = $id")))
	{
		$url = sed_url('admin', "m=tools&p=qaptcha&act=edit&id=$id");
		$plugin_body .= <<<END
		<form action="$url" method="post">
		<strong>{$L['qst_question']}:</strong> <input type="text" name="question" value="{$row['qst_text']}" /><br />
		<strong>{$L['qst_answer']}:</strong> <input type="text" name="answer" value="{$row['qst_answer']}" /> <em>{$L['qst_caseins']}</em><br />
		<input type="submit" value="{$L['qst_edit']}" />
		</form>
END;
	}
	$plugin_body .= '<a href="'.sed_url('admin', 'm=tools&p=qaptcha').'">'.$L['qst_back'].'</a>';
}
else
{
	$plugin_body .= <<<END
	<table class="cells"><tr>
	<td class="coltop">{$L['qst_question']}</td>
	<td class="coltop">{$L['qst_answer']}</td>
	<td class="coltop">{$L['qst_edit']}</td>
	<td class="coltop">{$L['qst_remove']}</td>
	</tr>
END;
	$sql = sed_sql_query("SELECT * FROM $db_qaptcha");
	while($row = sed_sql_fetcharray($sql))
	{
		$url1 = sed_url('admin', 'm=tools&p=qaptcha&act=edit&id=' . $row['qst_id']);
		$url2 = sed_url('admin', 'm=tools&p=qaptcha&act=del&id=' . $row['qst_id']);
		$plugin_body .= <<<END
		<tr>
		<td>{$row['qst_text']}</td>
		<td>{$row['qst_answer']}</td>
		<td><a href="$url1">{$L['qst_edit']}</a></td>
		<td><a href="$url2">{$L['qst_remove']}</a></td>
		</tr>
END;
	}
	$url = sed_url('admin', 'm=tools&p=qaptcha&act=add');
	$plugin_body .= <<<END
	</table>
	<h4>{$L['qst_addqst']}</h4>
	<form action="$url" method="post">
	<strong>{$L['qst_question']}:</strong> <input type="text" name="question" /><br />
	<strong>{$L['qst_answer']}:</strong> <input type="text" name="answer" /> <em>{$L['qst_caseins']}</em><br />
	<input type="submit" value="{$L['qst_add']}" />
	</form>
END;
}
?>