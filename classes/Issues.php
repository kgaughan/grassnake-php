<?php
class Issues {

	public static function add($project_id, $priority_id, $title, $message) {
		global $db;

		$id = $db->insert('issues', compact('project_id', 'title', 'priority_id'));
		self::add_message($id, $message);
		self::watch($id);

		return $id;
	}

	public static function get_all() {
		global $db;

		return $db->query_all("
			SELECT		issues.id, title, project_id, project, resolution, priority,
						COUNT(*) AS messages, MAX(posted) AS updated,
						assigned_user_id, watches.user_id IS NOT NULL AS watched
			FROM		issues
			JOIN		projects    ON projects.id      = project_id
			JOIN		priorities  ON priorities.id    = priority_id
			JOIN		resolutions ON resolutions.id   = resolution_id
			JOIN		messages    ON issues.id        = messages.issue_id
			LEFT JOIN	watches		ON watches.issue_id = issues.id
			WHERE		watches.user_id = %d OR watches.user_id IS NULL
			GROUP BY	issues.id
			ORDER BY	is_open ASC, issues.id ASC
			", AFK_User::get_logged_in_user()->get_id());
	}

	public static function get_details($id) {
		global $db;

		return $db->query_row("
			SELECT	project_id, project,
					assigned_user_id,
					title,
					resolution_id, priority_id,
					resolution, priority,
					last_updated
			FROM	issues
			JOIN	projects ON projects.id = project_id
			JOIN	priorities ON priorities.id = priority_id
			JOIN	resolutions ON resolutions.id = resolution_id
			WHERE	issues.id = %d
			", $id);
	}

	public static function get_messages($id) {
		global $db;

		return $db->query_all("
			SELECT	id, user_id, posted, message
			FROM	messages
			WHERE	issue_id = %d
			ORDER BY posted ASC
			", $id);
	}

	public static function add_message($id, $message) {
		global $db;

		$db->execute("
			INSERT INTO messages (
				issue_id, user_id, posted, message
			) VALUES (
				%d, %d, NOW(), %s
			)
			", $id, AFK_User::get_logged_in_user()->get_id(), $message);
	}

	public static function watch($id) {
		global $db;

		// Just in case...
		self::unwatch($id);

		$db->insert('watches', array(
			'user_id' => AFK_User::get_logged_in_user()->get_id(),
			'issue_id' => $id));
	}

	public static function unwatch($id) {
		global $db;
		$db->execute("DELETE FROM watches WHERE user_id = %d AND issue_id = %d",
			AFK_User::get_logged_in_user()->get_id(), $id);
	}

	public static function update($id, $priority_id, $resolution_id, $assigned_user_id) {
		global $db;
		$db->update('issues',
			compact('priority_id', 'resolution_id', 'assigned_user_id'),
			array('id' => array('=', $id)));
	}

	public static function get_all_for_project($id) {
		global $db;

		return $db->query_all("
			SELECT		issues.id, title, priority, resolution,
						COUNT(*) AS messages, MAX(posted) AS updated,
						assigned_user_id, watches.user_id IS NOT NULL AS watched
			FROM		issues
			JOIN		priorities  ON priorities.id    = priority_id
			JOIN		resolutions ON resolutions.id   = resolution_id
			JOIN		messages    ON issues.id        = messages.issue_id
			LEFT JOIN	watches		ON watches.issue_id = issues.id
			WHERE		project_id = %d AND (watches.user_id = %d OR watches.user_id IS NULL)
			GROUP BY	issues.id
			ORDER BY	is_open ASC, issues.id ASC
			", $id, AFK_User::get_logged_in_user()->get_id());
	}
}
?>
