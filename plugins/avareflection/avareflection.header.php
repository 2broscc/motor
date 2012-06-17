<?php
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=avareflection
Part=header
File=avareflection.header
Hooks=header.main
Tags=header.tpl:{HEADER_COMPOPUP}
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$out['compopup'] .= <<<HTM
<script type="text/javascript" src="{$cfg['plugins_dir']}/avareflection/js/reflection.js"></script>
HTM;
?>