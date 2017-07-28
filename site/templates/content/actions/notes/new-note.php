<?php
	$actionlinks = UserAction::getlinkarray();
	$actionlinks['actiontype'] = 'note';
	$actionlinks['customerlink'] = $custID;
	$actionlinks['shiptolink'] = $shipID;
	$actionlinks['contactlink'] = $contactID;
	$actionlinks['salesorderlink'] = $ordn;
	$actionlinks['quotelink'] = $qnbr;
	$actionlinks['notelink'] = $noteID;
	$actionlinks['tasklink'] = $taskID;
	$actionlinks['actionlink'] = $actionID;

	$note = UserAction::blankuseraction($actionlinks);

    $message = "Writing Note for {replace} ";
	// TODO FIX CREATE MESSAGE TO HAVE IT COME FROM USERACTION
    $notetitle = createmessage($message, $custID, $shipID, $contactID, $taskID, $noteID, $ordn, $qnbr);

	if ($config->ajax) {
		$message = "Creating a task for {replace} ";
    	$modaltitle = $notetitle;
		$modalbody = $config->paths->content."actions/notes/forms/new-note-form.php";
		include $config->paths->content."common/modals/include-ajax-modal.php";

	} else {
		include $config->paths->content."actions/notes/forms/new-note-form.php";
	}
?>
