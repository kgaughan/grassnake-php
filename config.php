<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'grasssnake');

define('APP_VERSION', '0.0.0');

function routes() {
	$r = new AFK_Routes();

	$r->route('/',      array('_handler' => 'Root', '_view' => 'console'));
	$r->route('/about', array('_handler' => 'Root', '_view' => 'about'));

	$r->route('/projects/{id}', array('_handler' => 'Project'), array('id' => '\d*'));
	$r->route('/issues/{id}',   array('_handler' => 'Issue'),   array('id' => '\d*'));

	$r->route('/watches/',
		array('_handler' => 'Watch', '_view' => 'new'));
	$r->route('/watches/{id}',
		array('_handler' => 'Watch', '_view' => 'watch'),
		array('id' => '\d+'));

	$r->fallback(array('_handler' => 'AFK_Default'));
	return $r;
}

function init() {
	global $db;

	error_reporting(E_ALL);
	date_default_timezone_set('UTC');
	AFK::load_helper('core', 'html', 'slots');

	if (defined('DB_NAME') && DB_NAME != '') {
		$db = new DB_MySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$db->set_logger(new DB_BasicLogger);
	}

	session_start();

	AFK_Users::set_implementation(new IPUsers());

	return array();
}
?>
