<?php
	$notelinks = UserAction::generate_classarray();
	$notelinks['actiontype'] = 'note';
	$notelinks['customerlink'] = $custID;
	$notelinks['shiptolink'] = $shipID;
	$notelinks['contactlink'] = $contactID;
	$notelinks['salesorderlink'] = $ordn;
	$notelinks['quotelink'] = $qnbr;
	$notelinks['notelink'] = $noteID;
	$notelinks['tasklink'] = $taskID;
	$notelinks['actionlink'] = $actionID;

	if (empty($notelinks['customerlink'])) {
		if (!empty($notelinks['salesorderlink'])) {
			$notelinks['customerlink'] = get_custid_from_order(session_id(), $notelinks['salesorderlink']);
			$notelinks['shiptolink'] = get_shiptoid_from_order(session_id(), $notelinks['salesorderlink']);
		} elseif (!empty($notelinks['quotelink'])) {
			$notelinks['customerlink'] = getquotecustomer(session_id(), $notelinks['quotelink']);
			$notelinks['shiptolink'] = getquoteshipto(session_id(), $notelinks['salesorderlink'], false);
		}
	}

	if (!empty($notelinks['customerlink']) && $config->cptechcustomer == 'stempf') {
		$notelinks['assignedto'] = get_customersalesperson($notelinks['customerlink'], $notelinks['shiptolink'], false);
	} else {
		$notelinks['assignedto'] = $user->loginid;
	}
	
	$note = UserAction::create_fromarray($notelinks);

    $message = "Writing Note for {replace} ";
    $page->title = $note->generate_message($message);
	$page->body = $config->paths->content."actions/notes/forms/new-note-form.php";
	
	if ($config->ajax) {
		include $config->paths->content."common/modals/include-ajax-modal.php";
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
?>
