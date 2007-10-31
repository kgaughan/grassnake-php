<?php
class RootHandler extends AFK_HandlerBase {

	public function on_get_console(AFK_Context $ctx) {
		global $db;

		$user_id = Users::current()->get_id();

		$ctx->issues = $db->query_all("
			SELECT		issues.id, title, project_id, project, priority, last_updated
			FROM		issues
			JOIN		projects   ON projects.id    = project_id
			JOIN		priorities ON priorities.id  = priority_id
			JOIN		statuses   ON statuses.id    = status_id
			WHERE		is_open = 1 AND assigned_user_id = %d
			ORDER BY	priorities.ordering ASC, last_updated DESC
			", $user_id);

		$ctx->watches = $db->query_all('
			SELECT		issues.id, title, project_id, project, priority, status,
						last_updated
			FROM		issues
			JOIN		watches    ON issue_id       = issues.id
			JOIN		projects   ON projects.id    = project_id
			JOIN		priorities ON priorities.id  = priority_id
			JOIN		statuses   ON statuses.id    = status_id
			WHERE		watches.user_id = %1$d AND assigned_user_id <> %1$d
			ORDER BY	last_updated DESC
			', $user_id);
	}

	public function on_get_about(AFK_Context $ctx) {
		$ctx->page_title = 'About';
	}
}
