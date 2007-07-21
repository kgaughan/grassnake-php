<?php
class WatchHandler extends AFK_HandlerBase {

	public function on_post_new(AFK_Context $ctx) {
		Issues::watch($ctx->id);
	}

	public function on_delete_watch(AFK_Context $ctx) {
		Issues::unwatch($ctx->id);
	}
}
?>
