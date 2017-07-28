<?php
    $taskID = $input->get->text('id');
    $originaltask = loaduseraction($taskID, true, false);
    $tasklinks = UserAction::getlinkarray();
	$tasklinks['actiontype'] = 'task';
	$tasklinks['customerlink'] = $originaltask->customerlink;
	$tasklinks['shiptolink'] = $originaltask->shiptolink;
	$tasklinks['contactlink'] =$originaltask->contactlink;
	$tasklinks['salesorderlink'] = $originaltask->salesorderlink;
	$tasklinks['quotelink'] = $originaltask->quotelink;
	$tasklinks['notelink'] = $originaltask->notelink;
	$tasklinks['tasklink'] = $originaltask->tasklink;
	$tasklinks['actionlink'] = $originaltask->id;
    $tasklinks['actionsubtype'] = $originaltask->actionsubtype;

    $task = UserAction::blankuseraction($tasklinks);


    if ($config->ajax) {
        $message = "Rescheduling a task for {replace} ";
        $modaltitle = createmessage($message, $custID, $shipID, $contactID, $taskID, $noteID, $ordn, $qnbr);
        $modalbody = $config->paths->content."actions/tasks/forms/reschedule-task-form.php";
        include $config->paths->content."common/modals/include-ajax-modal.php";
    } else {
        include $config->paths->content."actions/tasks/forms/reschedule-task-form.php";
    }
