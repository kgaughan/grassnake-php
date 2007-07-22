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

	protected function load($ids) {
		global $db;

		if (!$this->has(0)) {
			$this->add(new User(0, '---', 'Anonymous Hero'));
		}

		$db->query("SELECT id, email, name FROM users WHERE id IN (%s)", $ids);
		while ($r = $db->fetch()) {
			$user = new User($r['id'], $r['email'], $r['name']);
			$user->add_capabilities(array('post'));
			$this->add($user);
		}
	}
}
?>
