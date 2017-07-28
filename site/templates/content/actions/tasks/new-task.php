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


	if ($config->ajax) {
		$message = "Creating a task for {replace} ";
		// TODO FIX CREATE MESSAGE TO HAVE IT COME FROM USERACTION
    	$modaltitle = createmessage($message, $custID, $shipID, $contactID, $taskID, $noteID, $ordn, $qnbr);
		$modalbody = $config->paths->content."actions/tasks/forms/new-task-form.php";
		include $config->paths->content."common/modals/include-ajax-modal.php";

	} else {
		include $config->paths->content."actions/tasks/forms/new-task-form.php";
	}

?>
