<?php
class IssueHandler extends AFK_HandlerBase {

	public function on_get(AFK_Context $ctx) {
		if ($ctx->id == '') {
			$ctx->issues = Issues::get_all();
			Users::preload(collect_column($ctx->issues, 'assigned_user_id'));
			$ctx->page_title = 'All Issues';
			$ctx->change_view('list');
		} else {
			$issue = Issues::get_details($ctx->id);
			if (!$issue) {
				$ctx->not_found('No such issue.');
			}
			$ctx->merge($issue);
			$ctx->resolutions = $this->get_resolutions();
			$ctx->priorities = $this->get_priorities();
			$ctx->messages = Issues::get_messages($ctx->id);
			Users::preload(collect_column($ctx->messages, 'user_id'));
			$ctx->devs = Users::get_developers();
			$ctx->page_title = $issue['title'];
		}
	}

	public function on_post(AFK_Context $ctx) {
		Users::prerequisites('post');

		if ($ctx->id != '') {
			$issue = Issues::get_details($ctx->id);
			if (!$issue) {
				$ctx->not_found('No such issue.');
			}
			Issues::add_message($ctx->id, $ctx->message);
			Issues::update($ctx->id, $ctx->priority, $ctx->resolution, $ctx->user);
		}
		$ctx->allow_rendering(false);
		$ctx->redirect();
	}

	public function get_resolutions() {
		global $db;

		return $db->query_map("
			SELECT id, resolution
			FROM resolutions
			ORDER BY ordering ASC");
	}

	public function get_priorities() {
		global $db;

		return $db->query_map("
			SELECT	id, priority
			FROM	priorities
			ORDER BY ordering ASC");
	}
}
?>
