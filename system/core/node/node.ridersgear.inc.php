<?PHP

/*ridersgear*/

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=forums.php
Version=121
Updated=2007-mar-20
Type=Core
Author=Neocrome
Description=Forums
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', 'any');
sed_block($usr['auth_read']);

$id = sed_import('id','G','INT');
$s = sed_import('s','G','ALP');
$q = sed_import('q','G','INT');
$p = sed_import('p','G','INT');
$d = sed_import('d','G','INT');
$o = sed_import('o','G','ALP');
$w = sed_import('w','G','ALP',4);
$c = sed_import('c','G','ALP');
$quote = sed_import('quote','G','INT');
$poll = sed_import('poll','G','INT');
$vote = sed_import('vote','G','INT');
$unread_done = FALSE;
$filter_cats = FALSE;
$ce = explode('_', $s);
$sys['sublocation'] = $L['Home'];


require("system/header.php");

$mskin = "$user_skin_dir/".$skin."/forums.sections.tpl";
$t = new XTemplate($mskin);

$t->assign(array(
	"FORUMS_SECTIONS_PAGETITLE" => "<a href=\"forums.php\">".$L['Forums']."</a>",
	"FORUMS_SECTIONS_MARKALL" =>  $out['markall'],
	"FORUMS_SECTIONS_GMTTIME" => $L['Alltimesare']." ".$usr['timetext'],
	"FORUMS_SECTIONS_WHOSONLINE" => $out['whosonline']." : ".$out['whosonline_reg_list']
		));


$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
