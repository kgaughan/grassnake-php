<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'grasssnake');

define('APP_VERSION', '0.2.0');

function routes() {
	$r = new AFK_Routes(array('pid' => '\d+', 'iid' => '\d+'));

	$r->defaults(array('_handler' => 'Root'));
	$r->route('/', array('_view' => 'console'));
	$r->route('/about', array('_view' => 'about'));

	$r->defaults(array('_handler' => 'Project'));
	$r->route('/projects/');
	$r->route('/projects/{pid}');

	$r->defaults(array('_handler' => 'Issue'));
	$r->route('/issues/');
	$r->route('/issues/{iid}');

	$r->defaults(array('_handler' => 'Watch'));
	$r->route('/watches/', array('_view' => 'new'));
	$r->route('/watches/{iid}', array('_view' => 'watch'));

	return $r;
}

function init() {
	global $db;

	error_reporting(E_ALL);
	date_default_timezone_set('UTC');
	AFK::load_helper('core', 'html', 'slots', 'events', 'forms');

	if (defined('DB_NAME') && DB_NAME != '') {
		$db = new DB_MySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	AFK_Users::set_implementation(new Users());

	AFK_Plugin::load(APP_ROOT . '/plugins', array('mailer'));

	return array();
}
