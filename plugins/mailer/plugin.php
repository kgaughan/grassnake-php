<?php
/*
 * Mailer - Notifies interested parties of bug updates.
 * by Keith Gaughan
 *
 * Copyright (c) Keith Gaughan, 2007.
 * All Rights Reserved.
 */

/*
 * Mailer listens for the following events:
 *
 *   issue_posted:
 *     iid, title, message, priority
 *
 *   message_posted:
 *     old_details, message, priority, resolution, user
 *
 *   issue_status_changed:
 *     old_details, priority, resolution, user
 *
 * In each case, the contents of old_details is:
 *   project_id, project, assigned_user_id, title,
 *   resolution_id, priority_id, resolution, priority,
 *   last_updated
 */

class Talideon_Mailer extends Plugin {

	protected function get_events() {
		return array(
			'issue_posted',
			'message_posted',
			'issue_status_changed');
	}

	public function issue_posted($evt, $arg) {
		// TODO
	}

	public function message_posted($evt, $arg) {
		// TODO
	}

	public function issue_status_changed($evt, $arg) {
		// TODO
	}
}

// Initialise the plugin.
new Talideon_Mailer();
?>
