<?php

	$taskpanel = new TaskPanel('contact', '#tasks-panel', '#tasks-panel', '#ajax-modal', $config->ajax);
	$taskpanel->setupcontactpanel($custID, $shipID, $contactID);
	if ($input->get->completed) {
		$taskpanel->setupcompletetasks();
	}
	$taskpanel->count = get_linked_task_count($user->loginid, $custID, $shipID, $contactID, '', '', '', $taskpanel->completed, false);
	include $config->paths->content."tasks/tasks-panel.php";
?>
