<?php
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');
	$sessionID = $input->get->sessionID ? $input->$requestmethod->text('sessionID') : session_id();
	
	$session->{'from-redirect'} = $page->url;
	$session->remove('order-search');
	$filename = $sessionID;

	/**
	* WAREHOUSE REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	* 	case 'initiate-whse':
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		break;
	*	case 'logout':
	*		DBNAME=$config->dplusdbname
	*		LOGOUT
	*		break;
	* }
	*
	**/
	switch ($action) {
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			echo $login['loginid'];
			$data = array("DBNAME=$config->dplusdbname", "LOGIN=$loginID");
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
	}
	
	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
