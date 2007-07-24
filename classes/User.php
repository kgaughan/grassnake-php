<?php
class User extends AFK_User {

	private $email;
	private $name;

	public function __construct($id, $email, $name) {
		parent::__construct($id, $name);
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

	public static function comparator(User $a, User $b) {
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
