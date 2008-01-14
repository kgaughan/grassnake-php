<?php
class IssueHandler extends AFK_HandlerBase {

	public function on_get(AFK_Context $ctx) {
		if ($ctx->iid == '') {
			$this->prepare_all_issues($ctx);
			$ctx->page_title = 'All Issues';
			$ctx->change_view('list');
		} else {
			$this->prepare_issue($ctx);
			$ctx->page_title = $ctx->title;
		}
	}

	private function prepare_all_issues(AFK_Context $ctx) {
		$ctx->issues = Issues::get_all();
		Users::preload(collect_column($ctx->issues, 'assigned_user_id'));
	}

	private function prepare_issue(AFK_Context $ctx) {
		$ctx->merge_or_not_found(Issues::get_details($ctx->iid), 'No such issue.');
		$ctx->messages = Issues::get_messages($ctx->iid);
		Users::preload(collect_column($ctx->messages, 'user_id'));
	}

	public function on_post(AFK_Context $ctx) {
		Users::prerequisites('post');

		$ctx->allow_rendering(false);
		if ($ctx->pid != '') {
			// Posting a new issue.
			$ctx->title = trim($ctx->title);
			$this->save_issue($ctx, $ctx->pid, $ctx->priority, $ctx->title, $ctx->message);
			$ctx->redirect(303, $ctx->HTTP_REFERER);
		} elseif ($ctx->iid != '') {
			// Posting a message to an issue or altering its status.
			$issue = Issues::get_details($ctx->iid);
			if (!$issue) {
				$ctx->not_found('No such issue.');
			}
			Issues::update($ctx->iid, $ctx->priority, $ctx->status, $ctx->user);
			$data = array(
				'project'              => $issue['project'],
				'title'                => $issue['title'],
				'issue_id'             => $ctx->iid,
				'old_priority_id'      => $issue['priority_id'],
				'old_status_id'        => $issue['status_id'],
				'old_assigned_user_id' => $issue['assigned_user_id'],
				'priority_id'          => $ctx->priority,
				'status_id'            => $ctx->status,
				'assigned_user_id'     => $ctx->user,
				'url'                  => $ctx->base_url("issues", $ctx->iid));
			if (trim($ctx->message) !== '') {
				Issues::add_message($ctx->iid, $ctx->message);
				$data['message'] = $ctx->message;
				trigger_event('message_posted', $data);
			} elseif ($ctx->priority != $issue['priority_id'] ||
					$ctx->status != $issue['status_id'] ||
					$ctx->user != $issue['assigned_user_id']) {
				trigger_event('issue_status_changed', $data);
			}
			$ctx->redirect();
		}
	}

	private function save_issue(AFK_Context $ctx, $project_id, $priority_id, $title, $message) {
		$issue_id = Issues::add($project_id, $priority_id, $title, $message);
		$url = $ctx->base_url("issues", $issue_id);
		$project = Projects::get_name($project_id);
		trigger_event('issue_posted', compact('project', 'title', 'message', 'project_id', 'issue_id', 'priority_id', 'url'));
		return $issue_id;
	}
}
