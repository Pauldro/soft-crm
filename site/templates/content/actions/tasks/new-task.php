<?php
	$tasklinks = UserAction::getlinkarray();
	$tasklinks['actiontype'] = 'task';
	$tasklinks['customerlink'] = $custID;
	$tasklinks['shiptolink'] = $shipID;
	$tasklinks['contactlink'] = $contactID;
	$tasklinks['salesorderlink'] = $ordn;
	$tasklinks['quotelink'] = $qnbr;
	$tasklinks['notelink'] = $noteID;
	$tasklinks['tasklink'] = $taskID;
	$tasklinks['actionlink'] = $taskID;
	$task = UserAction::blankuseraction($tasklinks);

	$message = "Creating a task for {replace} ";
	$page->title = $task->createmessage($message);

	if ($config->ajax) {
		$page->body = $config->paths->content."actions/tasks/forms/new-task-form.php";
		include $config->paths->content."common/modals/include-ajax-modal.php";
	} else {
		$page->body = $config->paths->content."actions/tasks/forms/new-task-form.php";
		include $config->paths->content."common/include-blank-page.php";
	}

?>
