<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/bestdeal/tb2.bestdeal.php
Version=1.0
Updated=30-05-07
Type=Plugin
Author=J3ll3nl
Description=Textboxer for bestdeal.
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

require_once("plugins/textboxer2/inc/textboxer2.lang.php");
require_once("plugins/textboxer2/inc/textboxer2.inc.php");

$tb2DropdownIcons = array(-1,49,1,7,10,15,19,23,35);
$tb2MaxSmilieDropdownHeight = 300; 	// Height in px for smilie dropdown
$tb2InitialSmilieLimit = 20;		// Smilies loaded by default to dropdown
$tb2TextareaRows = 10;				// Rows of the textarea
$tb2ParseBBcodes = $ParseBBcodes;
$tb2ParseSmilies = $ParseSmilies;
$tb2ParseBR = $ParseBR;
?>
