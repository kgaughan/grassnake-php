<?php
class WatchHandler extends AFK_HandlerBase {

	public function on_post_new(AFK_Context $ctx) {
		Users::prerequisites('post');
		Issues::watch($ctx->iid);
		$ctx->allow_rendering(false);
		$ctx->redirect(303, $ctx->HTTP_REFERER);
	}

	public function on_delete_watch(AFK_Context $ctx) {
		Users::prerequisites('post');
		Issues::unwatch($ctx->iid);
		$ctx->allow_rendering(false);
		$ctx->redirect(303, $ctx->HTTP_REFERER);
	}
}
