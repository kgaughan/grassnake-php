<?php
class TrackerUser extends AFK_User {

	private $email;
	private $name;

	protected function __construct($id, $email, $name) {
		parent::__construct($id, $email);
		$this->email = $email;
		$this->name = $name;
	}

	public function get_email() {
		return $this->email;
	}

	public function get_name() {
		return $this->name;
	}

	public function can_post() {
		return $this->can('post');
	}

	public function __toString() {
		return $this->get_username();
	}

	public static function get_logged_in_user_id() {
		return 1;
	}

	public static function get_developers() {
		global $db;
		$dev_ids = $db->query_list("SELECT id FROM users WHERE is_dev");
		self::preload($dev_ids);
		$devs = array();
		foreach ($dev_ids as $id) {
			$devs[] = self::get($id);
		}
		usort($devs, array(__CLASS__, 'comparator'));
		return $devs;
	}

	public static function load($ids) {
		global $db;

		if (!self::has(0)) {
			self::add_instance(new TrackerUser(0, null, 'Anonymous Hero'));
		}

		$db->query("SELECT id, email, name FROM users WHERE id IN (%s)", $ids);
		while ($r = $db->fetch()) {
			$user = new TrackerUser($r['id'], $r['email'], $r['name']);
			$user->add_capabilities(array('post'));
			self::add_instance($user);
		}
	}

	public static function comparator(TrackerUser $a, TrackerUser $b) {
		if ($a->get_username() == $a->get_username()) {
			return 0;
		}
		if ($a->get_username() < $b->get_username()) {
			return -1;
		}
		return 1;
	}
}
?>
