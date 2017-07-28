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

	if ($config->ajax) {
		$message = "Creating an action for {replace} ";
		// TODO FIX CREATE MESSAGE TO HAVE IT COME FROM USERACTION
		$modaltitle = $action->createmessage($message);
		$modalbody = $config->paths->content."actions/actions/forms/new-action-form.php";
		include $config->paths->content."common/modals/include-ajax-modal.php";
	} else {
		include $config->paths->content."actions/actions/forms/new-action-form.php";
	}

?>
