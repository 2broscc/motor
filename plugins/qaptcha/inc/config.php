<?php
/**
 * @copyright Copyright (c) 2008-2009, Vladimir Sibirov. All rights reserved. Distributed under BSD License.
 */

$db_qaptcha = 'sed_qaptcha';
file_exists($cfg['plugins_dir']."/qaptcha/lang/qaptcha.$lang.lang.php") ? require_once($cfg['plugins_dir']."/qaptcha/lang/qaptcha.$lang.lang.php") : require_once($cfg['plugins_dir'].'/qaptcha/lang/qaptcha.en.lang.php');
?>