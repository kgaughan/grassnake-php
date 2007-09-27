<?php
if (!isset($assigned_user_id)) {
	$assigned_user_id = null;
}
echo '<select name="user" id="user">';
foreach ($devs as $dev) {
	echo '<option value="', $dev->get_id(), '"';
	if ($dev->get_id() == $assigned_user_id) {
		echo ' selected="selected"';
	}
	echo '>', e($dev->get_username()), '</option>';
}
echo '</select>';
