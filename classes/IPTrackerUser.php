<?php
class IPTrackerUser extends TrackerUser {

	public static function get_logged_in_user_id() {
		global $db;
		static $id = null;

		if (is_null($id)) {
			// I've said before I needed a registry, didn't i?
			$id = $db->query_value("SELECT id FROM users WHERE ip = %u",
				ip2long($_SERVER['REMOTE_ADDR']));
			if (is_null($id)) {
				$id = 0;
			}
		}

		return $id;
	}
}
?>
