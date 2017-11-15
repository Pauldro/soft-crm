<?php
    $actionID = $input->get->text('id');
    $originaltask = get_useraction($actionID, true, false);
    $tasklinks = UserAction::generate_classarray();
	$tasklinks['actiontype'] = 'task';
	$tasklinks['customerlink'] = $originaltask->customerlink;
	$tasklinks['shiptolink'] = $originaltask->shiptolink;
	$tasklinks['contactlink'] = $originaltask->contactlink;
	$tasklinks['salesorderlink'] = $originaltask->salesorderlink;
	$tasklinks['quotelink'] = $originaltask->quotelink;
	$tasklinks['actionlink'] = $originaltask->id;
    $tasklinks['actionsubtype'] = $originaltask->actionsubtype;

    $task = UserAction::create_fromarray($tasklinks);
    
    $message = "Rescheduling a task for {replace}";
    $page->title = $task->generate_message($message);
    $page->body = $config->paths->content."actions/tasks/forms/reschedule-task-form.php";
    
    if ($config->ajax) {
        include $config->paths->content."common/modals/include-ajax-modal.php";
    } else {
        include $page->body;
    }
