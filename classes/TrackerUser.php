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

	public static function get_logged_in_user_id() {
		return isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
	}

	public static function load($ids) {
		global $db;
		$users = array();

		if (array_search(0, $ids) !== false) {
			$users[0] = new TrackerUser(0, null, 'Anonymous Hero');
		}

		$db->query("SELECT id, email, name FROM users WHERE id IN (%s)", $ids);
		while ($r = $db->fetch()) {
			$user = new TrackerUser($r['id'], $r['email'], $r['name']);
			$user->add_capabilities(array('post'));
			$users[$r['id']] = $user;
		}

		return $users;
	}
}
?>
