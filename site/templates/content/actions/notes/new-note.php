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
    $page->title = $note->createmessage($message);

	if ($config->ajax) {
		$page->body = $config->paths->content."actions/notes/forms/new-note-form.php";
		include $config->paths->content."common/modals/include-ajax-modal.php";
	} else {
		$page->body = $config->paths->content."actions/notes/forms/new-note-form.php";
		include $config->paths->content."common/include-blank-page.php"; 
	}
?>
