<?php
	$actionlinks = UserAction::getlinkarray();
	$actionlinks['actiontype'] = 'action';
	$actionlinks['customerlink'] = $custID;
	$actionlinks['shiptolink'] = $shipID;
	$actionlinks['contactlink'] = $contactID;
	$actionlinks['salesorderlink'] = $ordn;
	$actionlinks['quotelink'] = $qnbr;
	$actionlinks['notelink'] = $noteID;
	$actionlinks['tasklink'] = $taskID;
	$actionlinks['actionlink'] = $actionID;

	$action = UserAction::blankuseraction($actionlinks);
	
	$message = "Creating an action for {replace}";
	$page->title = $action->createmessage($message);

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
