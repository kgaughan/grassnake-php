<?php
class RootHandler extends AFK_HandlerBase {

	public function on_get_console(AFK_Context $ctx) {
		global $db;

		$user = AFK_User::get_logged_in_user();

		$ctx->issues = $db->query_all("
			SELECT		issues.id, title, project_id, project, priority
			FROM		issues
			JOIN		projects    ON projects.id    = project_id
			JOIN		priorities  ON priorities.id  = priority_id
			JOIN		resolutions ON resolutions.id = resolution_id
			WHERE		is_open = 1 AND assigned_user_id = %d
			ORDER BY	priorities.ordering DESC
			", $user->get_id());

		$ctx->watches = $db->query_all("
			SELECT		issues.id, title
			FROM		issues
			JOIN		watches ON issue_id = issues.id
			WHERE		user_id = %d
			", $user->get_id());
	}

	public function on_get_about(AFK_Context $ctx) {
		$ctx->page_title = 'About';
	}
}
?>
