<?php
class IssueHandler extends AFK_HandlerBase {

	public function on_get(AFK_Context $ctx) {
		if ($ctx->iid == '') {
			$ctx->issues = Issues::get_all();
			Users::preload(collect_column($ctx->issues, 'assigned_user_id'));
			$ctx->page_title = 'All Issues';
			$ctx->change_view('list');
		} else {
			$issue = Issues::get_details($ctx->iid);
			if (!$issue) {
				$ctx->not_found('No such issue.');
			}
			$ctx->merge($issue);
			$ctx->resolutions = $this->get_resolutions();
			$ctx->priorities = $this->get_priorities();
			$ctx->messages = Issues::get_messages($ctx->iid);
			Users::preload(collect_column($ctx->messages, 'user_id'));
			$ctx->devs = Users::get_developers();
			$ctx->page_title = $issue['title'];
		}
	}

	public function on_post(AFK_Context $ctx) {
		Users::prerequisites('post');

		$ctx->allow_rendering(false);
		if ($ctx->pid != '') {
			// Posting a new issue.
			$ctx->title = trim($ctx->title);
			$iid = Issues::add($ctx->pid, $ctx->priority, $ctx->title, $ctx->message);
			trigger_event('issue_posted', array(
				'iid'         => $iid,
				'title'       => $ctx->title,
				'message'     => $ctx->message,
				'priority'    => $ctx->priority));
			$ctx->redirect(303, $ctx->HTTP_REFERER);
		} elseif ($ctx->iid != '') {
			// Posting a message to an issue or altering its status.
			$issue = Issues::get_details($ctx->iid);
			if (!$issue) {
				$ctx->not_found('No such issue.');
			}
			Issues::update($ctx->iid, $ctx->priority, $ctx->resolution, $ctx->user);
			if (trim($ctx->message != '')) {
				Issues::add_message($ctx->iid, $ctx->message);
				trigger_event('message_posted', array(
					'old_details' => $issue,
					'message'     => $ctx->message,
					'priority'    => $ctx->priority,
					'resolution'  => $ctx->resolution,
					'user'        => $ctx->user));
			} elseif ($ctx->priority != $issue['priority_id'] ||
					$ctx->resolution != $issue['resolution_id'] ||
					$ctx->user != $issue['assigned_user_id']) {
				trigger_event('issue_status_changed', array(
					'old_details' => $issue,
					'priority'    => $ctx->priority,
					'resolution'  => $ctx->resolution,
					'user'        => $ctx->user));
			}
			$ctx->redirect();
		}
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
