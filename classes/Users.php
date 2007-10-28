<?php
class Users extends AFK_Users {

	public static function get_developers() {
		global $db;
		$dev_ids = $db->query_list("SELECT id FROM users WHERE is_dev");
		self::preload($dev_ids);
		$devs = array();
		foreach ($dev_ids as $id) {
			$devs[] = self::get($id);
		}
		usort($devs, array('User', 'comparator'));
		return $devs;
	}

	protected function get_current_user_id() {
		global $db;
		static $id = null;

		if (is_null($id)) {
			$id = $db->query_value("SELECT user_id FROM user_ips WHERE ip = %u",
				ip2long($_SERVER['REMOTE_ADDR']));
			if (is_null($id)) {
				$id = 0;
			}
		}

		if ($id == 0) {
			$this->require_auth();
		}

		return $id;
	}

	protected function load(array $ids) {
		global $db;

		$db->query("SELECT id, email, name FROM users WHERE id IN (%s)", $ids);
		while ($r = $db->fetch()) {
			$user = new User($r['id'], $r['email'], $r['name']);
			$user->add_capabilities(array('post'));
			$this->add($user);
		}
	}
}
