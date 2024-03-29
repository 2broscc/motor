<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/contactus/contactus.php
Version=102
Updated=2006-apr-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=contactus
Part=main
File=contactus
Hooks=standalone
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE') || !defined('SED_PLUG')) { sed_diefatal('Wrong URL.'); }

$a = sed_import('a','P','ALP');
$recipient = sed_import('recipient','P','INT');
$subject = sed_import('subject','P','INT');
$message = sed_import('message','P','TXT');
if (empty($message)) { $message = sed_import('message','G','TXT'); }
$name = sed_import('name','P','STX');
$email = sed_import('email','P','STX');
$mailverify  = sed_import('mailverify','P','TXT');

$plugin_title = $L['plu_title'];


if ($a=="send") {

	if (!is_numeric($recipient) || !is_numeric($subject) || empty($message) || empty($name) || empty($email))
		{ $error = $L['plu_empty']."<br />\n"; }

	if (!ereg("([[:alnum:]\.\-]+)(\@[[:alnum:]\.\-]+\.+)", $email))
		{ $error .= $L['plu_wrongemail']."<br />\n"; }

	require("inc/php-captcha.inc.php");

	if (!PhpCaptcha::Validate($mailverify))
		{
			$error .= $L['plu_wrongimg']."<br />\n";
		}

	if (empty($error))
		{

		sed_shield_protect();
		$cfgrecipients = explode(";", $cfg['plugin']['contactus']['email']);
		$rectr = trim($cfgrecipients[$recipient]);
		$cfgsubjects = explode(";", $cfg['plugin']['contactus']['subjects']);
		$subrt = trim($cfgsubjects[$subject]);

		$headers = ("From: ".$name." <".$email.">\n"."Reply-To: <".$email.">\n"."Content-Type: text/plain; charset=".$cfg['charset']."\n");
		$body = $L['plu_notice']." ".$name."\n";
		$body .= $L['plu_message'].": \n\n".$message;
		sed_mail($rectr, $subrt, $body, $headers);
		
		$ok = $L['plu_ok'];
		unset($recipient, $subject, $message, $name, $email);
		sed_shield_update(60, "New message");

		}

}

if (!empty($error)) { $plugin_body .= "<span style=\"color: #FF0000;\">".$error."</span>"; }
if (!empty($ok)) { $plugin_body .= "<span>".$ok."</span>"; }

$plugin_body .= "<div>";
$plugin_body .= "Taralommal, szerzői jogokkal kapcsolatos kérdések:";
$plugin_body .= "E-mail: copyright@ridelinemtb.info<br>";
$plugin_body .= "<br>";
$plugin_body .= "Hírdetések,reklámok az oldalon:<br>";
$plugin_body .= "E-mail: relamok@ridelinemtb.info";
$plugin_body .= "<br>";
$plugin_body .= "Általános információk:<br>";
$plugin_body .= "E-mail: info@ridelinemtb.info";
$plugin_body .= "<br>";
$plugin_body .= "Rideguide:<br>";
$plugin_body .= "E-mail: rideguide@ridelinemtb.info";
//$plugin_body .= "<hr>";




$plugin_body .= "</div>";

$plugin_body .= "<br>";
$plugin_body .= "<a href=\"javascript:animatedcollapse.toggle('contactform')\">Az online contact formot használom!</a>";
//contact form start
$plugin_body .= "<div id=\"contactform\" style=\"display:none\">";

$plugin_body .= "<form action=\"plug.php?e=contactus\" method=\"post\">\n";
$plugin_body .= "<table class=\"cells\">";
$plugin_body .= "<tr><td>".$L['plu_recipient'].": </td><td>";

//Build recipients array and selectbox

$cfgrecipients = explode(";", $cfg['plugin']['contactus']['email']);
$plugin_body .= "<select name=\"recipient\">\n";
$iii=0;
foreach($cfgrecipients as $x) {
if (!empty($x)) {
	$recipients[$iii] = trim($x);
	$whatdel = strrchr($recipients[$iii], "<");
	$recipients[$iii] = str_replace($whatdel, "", $recipients[$iii]); 
	$recipients[$iii] = trim($recipients[$iii]);
	if ($iii==$recipient || (empty($recipient) && $iii==0)) {
	$plugin_body .= "<option value=\"".$iii."\" selected=\"selected\">".$recipients[$iii]."</option>\n";
	} else {
	$plugin_body .= "<option value=\"".$iii."\">".$recipients[$iii]."</option>\n";
	}
	$iii++;
}
}
$plugin_body .= "</select>\n";

$plugin_body .= "</td></tr>";
$plugin_body .= "<tr><td>".$L['plu_subject'].": </td><td>";

//Build subjects array and selectbox

$cfgsubjects = explode(";", $cfg['plugin']['contactus']['subjects']);
$plugin_body .= "<select name=\"subject\">\n";
$iii=0;
foreach($cfgsubjects as $x) {
if (!empty($x)) {
	$subjects[$iii] = trim($x);
	if ($iii==$subject || (empty($subject) && $iii==0)) {
	$plugin_body .= "<option value=\"".$iii."\" selected=\"selected\">".$subjects[$iii]."</option>\n";
	} else {
	$plugin_body .= "<option value=\"".$iii."\">".$subjects[$iii]."</option>\n";
	}
	$iii++;
}
}
$plugin_body .= "</select>\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td>".$L['plu_sendername'].": </td><td>\n";
$inname = (empty($name)) ? $usr['name'] : sed_cc($name);
$plugin_body .= "<input type=\"text\" name=\"name\" value=\"".$inname."\" size=\"32\" maxlength=\"64\" class=\"text\" />\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td>".$L['plu_sendermail'].": </td><td>\n";
$inemail = (empty($email)) ? $usr['profile']['user_email'] : sed_cc($email);
$plugin_body .= "<input type=\"text\" name=\"email\" value=\"".$inemail."\" size=\"32\" maxlength=\"64\" class=\"text\" />\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td>".$L['plu_message'].": </td><td>\n";
//$plugin_body .= "<textarea rows=\"24\" cols=\"56\" name=\"message\">".sed_cc($message)."</textarea>\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td>".$L['plu_imgverify'].": </td><td>\n";
$plugin_body .= "<img src='plugins/contactus/inc/captcha.php' width='200' height='60' alt='CAPTCHA'>\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td>".$L['plu_mailverify'].": </td><td>\n";
$plugin_body .= "<input name=\"mailverify\" type=\"text\" id=\"mailverify\" size=\"10\" maxlength=\"6\">\n";
$plugin_body .= "</td></tr>\n";

$plugin_body .= "<tr><td colspan=\"2\" align=\"center\">\n";
$plugin_body .= "<input type=\"hidden\" name=\"a\" value=\"send\" />\n";
$plugin_body .= "<input type=\"submit\" class=\"submit\" value=\"".$L['plu_send']."\" />\n";
$plugin_body .= "</td></tr>\n";
$plugin_body .= "</table>\n";
$plugin_body .= "</form>\n";

$plugin_body .= "</div>";

//contact form end

?>