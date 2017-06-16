<?php
	$taskpanel = new TaskPanel('cust', '#tasks-panel', '#tasks-panel', '#ajax-modal', $config->ajax);
	$taskpanel->setupcustomerpanel($custID, $shipID);
	if ($input->get->completed) {
		$taskpanel->setupcompletetasks();
	}
	$taskpanel->count = get_linked_task_count($user->loginid, $custID, $shipID, '', '', '', '', $taskpanel->completed, false);
	include $config->paths->content."tasks/tasks-panel.php";

?>
