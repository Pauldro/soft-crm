<?php

	if ($input->post->action) { $action = $input->post->action; } else { $action = $input->get->text('action'); }
	
	$filename = session_id();
	switch ($action) {
		case 'login': 
			if ($input->post->username) {
				$username = $input->post->text('username');
				$pass = $input->post->text('password');
				$data = array('DBNAME' => $config->dbName, 'LOGPERM' => false, 'LOGINID' => $username, "PSWD" => $pass);
				$session->loc = "login";
			} 
			break;
		case 'logout':
			$data = array('DBNAME' => $config->dbName, 'LOGOUT' => false);
			$session->loc = $config->pages->login;
			
			$session->remove('shipID');
			$session->remove('custID');
			$session->remove('locked-ordernumber');
			break;
		//DELETED CASES add-task get-order-notes write-recent-order-note
			
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);
	
 	exit;
?>