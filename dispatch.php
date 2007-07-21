<?php
define('APP_ROOT', dirname(__FILE__));
define('APP_TEMPLATE_ROOT', APP_ROOT . '/templates');

require(APP_ROOT . '/lib/afk/afk.php');

AFK::add_class_path(APP_ROOT . '/lib/classes');
AFK::add_class_path(APP_ROOT . '/classes');
AFK::add_class_path(APP_ROOT . '/handlers');

AFK::add_helper_path(APP_ROOT . '/lib/helpers');

include(APP_ROOT . '/config.php');
if (file_exists(APP_ROOT . '/lib/lib.php')) {
	include(APP_ROOT . '/lib/lib.php');
}

AFK::process_request(routes(), init());
?>
