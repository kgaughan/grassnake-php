<?php
class WatchHandler extends AFK_HandlerBase {

	public function on_post_new(AFK_Context $ctx) {
		Issues::watch($ctx->id);
		$ctx->allow_rendering(false);
		$ctx->redirect(303, $ctx->HTTP_REFERER);
	}

	public function on_delete_watch(AFK_Context $ctx) {
		Issues::unwatch($ctx->id);
		$ctx->allow_rendering(false);
		$ctx->redirect(303, $ctx->HTTP_REFERER);
	}
}
?>
