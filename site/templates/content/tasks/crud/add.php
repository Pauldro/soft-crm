<?php
	header('Content-Type: application/json');

    if (isset($input->post->custlink)) {
        $date = date("Y-m-d H:i:s");
        $custID = $input->post->text('custlink');
        $shipID = $input->post->text('shiptolink');
        $contactID = $input->post->text('contactlink');
        $ordn = $input->post->text('salesorderlink');
        $qnbr = $input->post->text('quotelink');
        $noteID = $input->post->text('notelink');
        $textbody = $input->post->text('textbody');
        $tasktype = $input->post->text('tasktype');
		$taskID = '';
        $maxrec = get_user_task_maxrec($user->loginid);
        $duedate = date("Y-m-d H:i:s", strtotime($input->post->text('duedate')));
        $results = writetask($user->loginid, $date, $custID, $shipID, $contactID, $ordn, $qnbr, $noteID, $textbody, $tasktype, $duedate, $user->loginid);
        $session->insertedid = $results['insertedid'];
        $session->sql = $results['sql'];
		$taskID =  $results['insertedid'];

		if ($results['insertedid'] > $maxrec) {
			$error = false;
			$message = "<strong>Success!</strong><br> Your task for {replace} has been created";
			$icon = "glyphicon glyphicon-floppy-saved";
			$message = createmessage($message, $custID, $shipID, $contactID, $taskID, $noteID, $ordn, $qnbr);
		} else {
			$error = true;
			$message = "<strong>Error!</strong><br> Your task could not be created";
			$icon = "glyphicon glyphicon-warning-sign";
		}

		$json = array (
				'response' => array (
						'error' => $error,
						'notifytype' => 'success',
						'message' => $message,
						'icon' => $icon,
						'taskid' => $taskID

				)
			);
	} else {
		$json = array (
				'response' => array (
						'error' => true,
						'notifytype' => 'danger',
						'message' => '<strong>Error!</strong><br> Your task could not be created',
						'icon' => 'glyphicon glyphicon-warning-sign'
				)
			);
	}
    echo json_encode($json);
