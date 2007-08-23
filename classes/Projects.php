<?php
class Projects {

	public static function add($project, $lead_user_id) {
		global $db;

		return $db->insert('projects', compact('project', 'lead_user_id'));
	}

	public static function get_active() {
		global $db;

		return $db->query_map("
			SELECT		projects.id, project
			FROM		projects
			WHERE		is_active = 1
			ORDER BY	project ASC");
	}

	public static function get_active_details() {
		global $db;

		return $db->query_all("
			SELECT		projects.id, project,
						lead_user_id,
						COUNT(issues.id) AS issues,
						COALESCE(SUM(resolution_id IN (0, 1, 2)), 0) AS open,
						COALESCE(SUM(resolution_id = 0), 0) AS untriaged,
						COALESCE(SUM(resolution_id = 2), 0) AS suspended
			FROM		projects
			LEFT JOIN	issues ON issues.project_id = projects.id
			WHERE		is_active = 1
			GROUP BY	projects.id
			ORDER BY	project ASC");
	}

	public static function get_name($id) {
		global $db;

		return $db->query_value("SELECT project FROM projects WHERE id = %d", $id);
	}

	public static function get_lead($id) {
		global $db;

		return $db->query_value("SELECT lead_user_id FROM projects WHERE id = %d", $id);
	}
}
?>
