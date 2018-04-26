<?php
	$message = "Rescheduling task for {replace} ";
	$page->title = $task->generate_message($message);
	$page->body = $config->paths->content."actions/tasks/forms/reschedule-task-form.php";
