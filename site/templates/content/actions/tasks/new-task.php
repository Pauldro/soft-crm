<?php
	$tasklinks = UserAction::generate_classarray();
	$tasklinks['actiontype'] = 'task';
	$tasklinks['customerlink'] = $custID;
	$tasklinks['shiptolink'] = $shipID;
	$tasklinks['contactlink'] = $contactID;
	$tasklinks['salesorderlink'] = $ordn;
	$tasklinks['quotelink'] = $qnbr;
	$tasklinks['actionlink'] = $actionID;

	if (empty($tasklinks['customerlink'])) {
		if (!empty($tasklinks['salesorderlink'])) {
			$tasklinks['customerlink'] = get_custid_from_order(session_id(), $tasklinks['salesorderlink']);
			$tasklinks['shiptolink'] = get_shiptoid_from_order(session_id(), $tasklinks['salesorderlink']);
		} elseif (!empty($tasklinks['quotelink'])) {
			$tasklinks['customerlink'] = getquotecustomer(session_id(), $tasklinks['quotelink'], false);
			$tasklinks['shiptolink'] = getquoteshipto(session_id(), $tasklinks['salesorderlink'], false);
		}
	}

	if (!empty($tasklinks['customerlink']) && $config->cptechcustomer == 'stempf') {
		$tasklinks['assignedto'] = get_customersalesperson($tasklinks['customerlink'], $tasklinks['shiptolink'], false);
	} else {
		$tasklinks['assignedto'] = $user->loginid;
	}
	
	$task = UserAction::create_fromarray($tasklinks);

	$message = "Creating a task for {replace} ";
	$page->title = $task->generate_message($message);
	$page->body = $config->paths->content."actions/tasks/forms/new-task-form.php";

	if ($config->ajax) {
		include $config->paths->content."common/modals/include-ajax-modal.php";
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}

?>
