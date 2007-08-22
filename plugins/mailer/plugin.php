<?php
/*
 * Mailer - Notifies interested parties of bug updates.
 * by Keith Gaughan
 *
 * Copyright (c) Keith Gaughan, 2007.
 * All Rights Reserved.
 */

class Talideon_Mailer extends Plugin {

	protected function get_events() {
		return array(
			'issue_posted',
			'message_posted',
			'issue_status_changed');
	}

	public function issue_posted($evt, $arg) {
		extract($arg);
		// Listens for issue_posted:
		//   project, title, message, project_id, issue_id, priority_id

		$name     = Users::current()->get_name();
		$message  = wordwrap($message);
		$priority = Issues::translate_priority($priority_id);
		$user_id  = Projects::get_lead($project_id);

		$email = <<<LEFIN
$message

-----------------------------------------------------------------------------
 Posted by  $name
  Priority  $priority
LEFIN;

		$this->mail(
			"[GrassSnake] New issue for $project: $title",
			$email, $issue_id, $user_id);

		return array(false, $arg);
	}

	public function message_posted($evt, $arg) {
		extract($arg);
		// Listens for message_posted:
		//	 project, title, message,
		//   issue_id, assigned_user_id,
		//   priority_id, resolution_id

		$name       = Users::current()->get_name();
		$message    = wordwrap($message);
		$priority   = Issues::translate_priority($priority_id);
		$resolution = Issues::translate_resolution($resolution_id);

		$email = <<<LEFIN
$message

-----------------------------------------------------------------------------
 Posted by  $name
  Priority  $priority
Resolution  $resolution
LEFIN;

		$this->mail(
			"[GrassSnake] New message for $project: $title",
			$email, $issue_id, $assigned_user_id);

		return array(false, $arg);
	}

	public function issue_status_changed($evt, $arg) {
		extract($arg);
		// Listens for issue_status_changed:
		//   project, title, issue_id,
		//   old_priority_id, old_resolution_id, old_assigned_user_id,
		//   priority_id, resolution_id, assigned_user_id

		$who = Users::current()->get_name();
		$email = "$who made the following changes:\r\n\r\n";
		if ($priority_id != $old_priority_id) {
			$old_priority = Issues::translate_priority($old_priority_id);
			$new_priority = Issues::translate_priority($priority_id);
			$email .= " * Priority changed from $old_priority to $new_priority\r\n";
		}
		if ($resolution_id != $old_resolution_id) {
			$old_resolution = Issues::translate_priority($old_resolution_id);
			$new_resolution = Issues::translate_priority($resolution_id);
			$email .= "Resolution changed from $old_resolution to $new_resolution\r\n";
		}
		if ($old_assigned_user_id != $assigned_user_id) {
			$old_name = Users::get($old_assigned_user_id)->get_name();
			$new_name = Users::get($assigned_user_id)->get_name();
			$email .= "Ownership reassigned from $old_name to $new_name.\r\n";
		}

		$this->mail(
			"[GrassSnake] Status change for $project: $title",
			$email, $issue_id, $assigned_user_id);

		return array(false, $arg);
	}

	private function mail($title, $message, $issue_id, $assigned_user_id) {
		$watchers = Issues::get_watcher($issue_id);
		Users::preload($watchers);

		$i = array_search($assigned_user_id, $watchers);
		if ($i !== false) {
			unset($watchers[$i]);
		}

		$to_user = Users::get($assigned_user_id);
		$to = $to_user->get_name() . ' <' . $to_user->get_email() . '>';

		$bccs = array();
		foreach ($watchers as $id) {
			$bccs[] = Users::get($id)->get_email();
		}
		$bcc = implode(', ', $bccs);

		mail($to, $title, "$message\n",
			"From: noreply@blacknight.ie\r\n" .
			"MIME-Version: 1.0\r\n" .
			"Content-Type: text/plain; charset=utf-8\r\n" .
			"X-Mailer: GrassSnake/" . APP_VERSION . "\r\n" .
			"BCC: $bcc\r\n");
	}
}

// Initialise the plugin.
new Talideon_Mailer();
?>
