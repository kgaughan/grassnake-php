<?php
class ProjectHandler extends AFK_HandlerBase {

	public function on_get(AFK_Context $ctx) {
		if ($ctx->pid == '') {
			$ctx->projects = Projects::get_active_details();
			$ctx->page_title = 'Active Projects';
			$ctx->change_view('list');
		} else {
			$ctx->name = Projects::get_name($ctx->pid);
			if (!$ctx->name) {
				$ctx->not_found('No such project.');
			}
			$ctx->issues = Issues::get_all_for_project($ctx->pid);
			Users::preload(collect_column($ctx->issues, 'assigned_user_id'));
			$ctx->page_title = $ctx->name;
		}
	}

	public function on_post(AFK_Context $ctx) {
		Users::prerequisites('post');

		$ctx->allow_rendering(false);
		if ($ctx->pid == '') {
			$ctx->name = trim($ctx->name);
			$ctx->redirect(303, Projects::add($ctx->name, $ctx->user));
		}
	}
}
