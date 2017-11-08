<?php
	$actionlinks = UserAction::generate_classarray();
	$actionlinks['actiontype'] = 'action';
	$actionlinks['customerlink'] = $custID;
	$actionlinks['shiptolink'] = $shipID;
	$actionlinks['contactlink'] = $contactID;
	$actionlinks['salesorderlink'] = $ordn;
	$actionlinks['quotelink'] = $qnbr;
	$actionlinks['notelink'] = $noteID;
	$actionlinks['tasklink'] = $taskID;
	$actionlinks['actionlink'] = $actionID;

	if (empty($actionlinks['customerlink'])) {
		if (!empty($actionlinks['salesorderlink'])) {
			$actionlinks['customerlink'] = get_custid_from_order(session_id(), $actionlinks['salesorderlink']);
			$actionlinks['shiptolink'] = get_shiptoid_from_order(session_id(), $actionlinks['salesorderlink']);
		} elseif (!empty($actionlinks['quotelink'])) {
			$actionlinks['customerlink'] = getquotecustomer(session_id(), $actionlinks['quotelink']);
			$actionlinks['shiptolink'] = getquoteshipto(session_id(), $actionlinks['salesorderlink'], false);
		}
	}

	if (!empty($actionlinks['customerlink']) && $config->cptechcustomer == 'stempf') {
		$actionlinks['assignedto'] = get_customersalesperson($actionlinks['customerlink'], $actionlinks['shiptolink'], false);
	} else {
		$actionlinks['assignedto'] = $user->loginid;
	}
	
	$action = UserAction::create_fromarray($actionlinks);

	$message = "Creating an action for {replace}";
	$page->title = $action->generate_message($message);

	if ($config->ajax) {
		if ($config->modal) {
			$page->body = $config->paths->content."actions/actions/forms/new-action-form.php";
			include $config->paths->content."common/modals/include-ajax-modal.php";
		}
	} else {
		$page->body = $config->paths->content."actions/actions/forms/new-action-form.php";
		include $config->paths->content."common/include-blank-page.php";
	}

?>
