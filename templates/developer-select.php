<?php
if (!isset($assigned_user_id)) {
	$assigned_user_id = null;
}
if (count($devs) == 1) {
	echo '<input type="hidden" name="user_id" id="user_id" value="', $devs[0]->get_id(), '">';
	ee($devs[0]->get_username());
} else {
	echo '<select name="user_id" id="user_id">';
	foreach ($devs as $dev) {
		echo '<option value="', $dev->get_id(), '"';
		if ($dev->get_id() == $assigned_user_id) {
			echo ' selected="selected"';
		}
		echo '>', e($dev->get_username()), '</option>';
	}
	echo '</select>';
}
