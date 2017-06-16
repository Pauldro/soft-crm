<?php
	$taskpanel = new TaskPanel('user', '#tasks-panel', '#tasks-panel', '#ajax-modal', $config->ajax);
	if ($input->get->completed) {
		$taskpanel->setupcompletetasks();
	}
	$taskpanel->count = get_linked_task_count($user->loginid, '', '', '', '', '', '', $taskpanel->completed, false);
	include $config->paths->content."tasks/tasks-panel.php";

?>
