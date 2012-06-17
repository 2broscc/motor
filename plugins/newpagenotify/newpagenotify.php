<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/newpagenotify/newpagenotify.php
Version=100
Updated=2006-apr-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=newpagenotify
Part=main
File=newpagenotify
Hooks=page.add.add.done
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$email_target = $cfg['plugin']['newpagenotify']['email_address'];
$email_title = $cfg['plugin']['newpagenotify']['email_title'];

$email_body = $cfg['plugin']['newpagenotify']['email_body']."\n\n";
$email_body .= $cfg['mainurl']."/admin.php?m=page&s=queue"."\n\n";
$email_body .= $L['Page']." : ".$newpagetitle."\n";
$email_body .= $L['User']." : ".$usr['name'];

sed_mail ($email_target, $email_title, $email_body);

?>
