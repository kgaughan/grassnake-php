<?php
abstract class AFK_User {

	private static $impl = null;
	private static $instances = array();

	private $id;
	private $username;
	private $caps = array();

	protected function __construct($id, $username, $caps=array()) {
		$this->id = $id;
		$this->username = $username;
		$this->add_capabilities($caps);
	}

	public function get_id() {
		return $this->id;
	}

	public function get_username() {
		return $this->username;
	}

	public function get_profile() {
		return null;
	}

	public function add_capabilities($to_add) {
		$this->caps = array_unique(array_merge($this->caps, $to_add));
	}

	public function remove_capabilities($to_remove) {
		$this->caps = array_diff($this->caps, $to_remove);
	}

	public function can() {
		$reqs = func_get_args();
		$reqs = array_unique($reqs);
		return count($reqs) == count(array_intersect($this->caps, $reqs));
	}

	public static function get_logged_in_user() {
		$id = call_user_func(array(self::$impl, 'get_logged_in_user_id'));
		return self::get($id);
	}

	public static function get($id) {
		self::preload(array($id));
		if (!isset(self::$instances[$id])) {
			AFK_User::preload(array($id));
			if (!isset(self::$instances[$id])) {
				throw new AFK_Exception("Bad User ID: $id");
			}
		}
		return self::$instances[$id];
	}

	public static function preload($users=array()) {
		if (is_null(self::$impl)) {
			throw new AFK_Exception("No implementation for User specified.");
		}
		$to_load = array_diff($users, array_keys(self::$instances));
		if (count($to_load) > 0) {
			self::merge(call_user_func(array(self::$impl, 'load'), $to_load));
		}
	}

	private static function merge($users) {
		// Can't use array_merge() because it ignores numeric indices.
		foreach ($users as $u) {
			self::$instances[$u->get_id()] = $u;
		}
	}

	public static function set_implementation($cls) {
		if (is_string($cls) && is_subclass_of($cls, __CLASS__)) {
			self::$impl = $cls;
		} else {
			throw AFK_Exception("$cls is not an implementation of " . __CLASS__);
		}
	}
}
?>
