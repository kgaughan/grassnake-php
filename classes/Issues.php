<?php
class Issues {

	public static function add($project_id, $priority_id, $title, $message) {
		global $db;

		$assigned_user_id = Projects::get_lead($project_id);
		$id = $db->insert('issues',
			compact('project_id', 'title', 'priority_id', 'assigned_user_id'));
		self::add_message($id, $message);
		self::watch($id);
		if ($assigned_user_id != Users::current()->get_id()) {
			self::watch($id, $assigned_user_id);
		}

		return $id;
	}

	public static function get_all() {
		global $db;

		return $db->query_all("
			SELECT		issues.id, title, project_id, project, status, priority,
						COUNT(*) AS messages, MAX(posted) AS updated,
						assigned_user_id, watches.user_id IS NOT NULL AS watched
			FROM		issues
			JOIN		projects   ON projects.id      = project_id
			JOIN		priorities ON priorities.id    = priority_id
			JOIN		statuses   ON statuses.id      = status_id
			JOIN		messages   ON issues.id        = messages.issue_id
			LEFT JOIN	watches    ON watches.issue_id = issues.id AND watches.user_id = %d
			GROUP BY	issues.id
			ORDER BY	issues.id ASC
			", Users::current()->get_id());
	}

	public static function get_details($id) {
		global $db;

		return $db->query_row("
			SELECT		project_id, project,
						assigned_user_id,
						title,
						status_id, priority_id,
						status, priority,
						last_updated,
						IF(watches.user_id IS NULL, 0, 1) AS watched
			FROM		issues
			JOIN		projects   ON projects.id      = project_id
			JOIN		priorities ON priorities.id    = priority_id
			JOIN		statuses   ON statuses.id      = status_id
			LEFT JOIN	watches    ON watches.issue_id = issues.id AND watches.user_id = %d
			WHERE		issues.id = %d
			", Users::current()->get_id(), $id);
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

		return $db->execute("
			INSERT INTO messages (
				issue_id, user_id, posted, message
			) VALUES (
				%d, %d, NOW(), %s
			)
			", $id, Users::current()->get_id(), $message);
	}

	public static function watch($issue_id, $user_id=null) {
		global $db;
		if (is_null($user_id)) {
			$user_id = Users::current()->get_id();
		}

		// Just in case...
		self::unwatch($issue_id, $user_id);

		$db->insert('watches', compact('user_id', 'issue_id'));
	}

	public static function unwatch($issue_id, $user_id=null) {
		global $db;
		if (is_null($user_id)) {
			$user_id = Users::current()->get_id();
		}

		$db->execute("DELETE FROM watches WHERE user_id = %d AND issue_id = %d", $user_id, $issue_id);
	}

	public static function get_watchers($id) {
		global $db;
		return $db->query_list("SELECT user_id FROM watches WHERE issue_id = %d", $id);
	}

	public static function translate_status($id) {
		global $db;
		return $db->query_value("SELECT status FROM statuses WHERE id = %d", $id);
	}

	public static function translate_priority($id) {
		global $db;
		return $db->query_value("SELECT priority FROM priorities WHERE id = %d", $id);
	}

	public static function update($id, $priority_id, $status_id, $assigned_user_id) {
		global $db;
		$db->update('issues',
			compact('priority_id', 'status_id', 'assigned_user_id'),
			array('id' => array('=', $id)));
		self::watch($id, $assigned_user_id);
	}

	public static function get_all_for_project($id) {
		global $db;

		return $db->query_all("
			SELECT		issues.id, title, priority, status,
						COUNT(*) AS messages, MAX(posted) AS updated,
						assigned_user_id, watches.user_id IS NOT NULL AS watched
			FROM		issues
			JOIN		priorities ON priorities.id    = priority_id
			JOIN		statuses   ON statuses.id      = status_id
			JOIN		messages   ON issues.id        = messages.issue_id
			LEFT JOIN	watches    ON watches.issue_id = issues.id AND watches.user_id = %d
			WHERE		project_id = %d
			GROUP BY	issues.id
			ORDER BY	is_open DESC, priorities.ordering ASC, issues.id ASC
			", Users::current()->get_id(), $id);
	}

	public function get_statuses() {
		global $db;

		return $db->query_map("SELECT id, status FROM statuses ORDER BY ordering ASC");
	}

	public function get_priorities() {
		global $db;

		return $db->query_map("SELECT id, priority FROM priorities ORDER BY ordering ASC");
	}
}
