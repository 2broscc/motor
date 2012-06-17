<?php

	// ============== 1 ===========/ Get info from mysql /=========== 1 ===========//
	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_id='$p'");
	
	$iteminfo = sed_sql_fetcharray($sql_getitem);
	
	$sendmail_title = $L['bd_pretitle'].$iteminfo['bditem_name']." - " .$iteminfo['bditem_shortdesc'];
	
	// ============== 4 ===========/ Send mail /=========== 4 ===========//
	if ($action=='send')
	{
	
	$sendmail_sender = $usr['id'];
	$sendmail_recipient = $id;
	$sendmail_title = sed_import('sendmail_title','P','TXT');
	$sendmail_body = sed_import('sendmail_textboxer','P','TXT');
	
	$error_string .= (strlen($sendmail_title)<10) ? $L['bd_titletoshort']."<br />" : '';
	$error_string .= (strlen($sendmail_body)<10) ? $L['bd_bodytoshort']."<br />" : '';
	
	if (empty($error_string))
		{
		
		send_mail($sendmail_sender,$sendmail_recipient, $sendmail_title, $sendmail_body);
		
		header("Location: plug.php?e=bestdeal&id=".$iteminfo['bditem_id']);
		exit;		
		}
	}
	// ============== 2 ==========/ Make a new template / =========== 2 ========== //

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.sendmail.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.sendmail.tpl";	
		
		if (file_exists($path_plugin_path))
		{
			$path_skin= $path_plugin_path;
		}
		elseif (file_exists($path_skin_path))
		{
			$path_skin = $path_skin_path;
		}
		else
		{
			header("Location: message.php?msg=907");
			exit;
		}	
		$t = new XTemplate($path_skin);
	
	// ============ 3===========/ TAGS everyone /========== 3 =======================
		
		
		
		$send_mail_form_textboxer = sed_textboxer2('sendmail_textboxer', 'newmail', sed_cc($sendmail_body), $tb2TextareaRows, $tb2TextareaCols, 'XXXXXXXXXXXXXXXXXXXX', $tb2ParseBBcodes, $tb2ParseSmilies, $tb2ParseBR, $tb2Buttons, $tb2DropdownIcons, $tb2MaxSmilieDropdownHeight, $tb2InitialSmilieLimit).$pfs;
		
		if (!empty($error_string))
		{
		$t->assign("SEND_MAIL_ERROR_BODY",$error_string);
		$t->parse("MAIN.SEND_MAIL_ERROR");
		}
		
		$t-> assign(array(
		"SEND_MAIL_TITLE" => "<a href=\"plug.php?e=bestdeal&amp;id=".$iteminfo['bditem_id']. "\">".$iteminfo['bditem_name']."</a>".$L['bd_mailtitle'].userinfo($id),
		"SEND_MAIL_SUBTITLE" => "",
		"SEND_MAIL_FORM_TOUSER" => userinfo($id),
		"SEND_MAIL_FORM_TITLE" => "<input type=\"text\" class=\"text\" name=\"sendmail_title
\" value=\"".sed_cc($sendmail_title
)."\" size=\"50\" maxlength=\"50\" />",
		"SEND_MAIL_FORM_TEXTBOXER" => $send_mail_form_textboxer,
		"SEND_MAIL_FORM_SEND" => "plug.php?e=bestdeal&amp;page=sendmail&amp;id=".$iteminfo['bditem_user']."&amp;pn=".$iteminfo['bditem_id']."&amp;a=send",
		));

?>
