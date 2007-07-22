<?php
class ProjectHandler extends AFK_HandlerBase {

	public function on_get(AFK_Context $ctx) {
		if ($ctx->id == '') {
			$ctx->projects = Projects::get_active();
			$ctx->page_title = 'Active Projects';
			$ctx->change_view('list');
		} else {
			$ctx->name = Projects::get_name($ctx->id);
			if (!$ctx->name) {
				$ctx->not_found('No such project.');
			}
			$ctx->issues = Issues::get_all_for_project($ctx->id);
			AFK_User::preload(collect_column($ctx->issues, 'assigned_user_id'));
			$ctx->page_title = $ctx->name;
		}
	}

	public function on_post(AFK_Context $ctx) {
		AFK_User::prerequisites('post');

		$ctx->allow_rendering(false);
		if ($ctx->id == '') {
			$ctx->redirect(303, Projects::add($ctx->name));
		} else {
			Issues::add($ctx->id, $ctx->priority, $ctx->title, $ctx->message);
			$ctx->redirect(303);
		}
	}
}
?>
