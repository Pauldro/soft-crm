<?php
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');
	$sessionID = $input->get->sessionID ? $input->$requestmethod->text('sessionID') : session_id();
	
	$session->{'from-redirect'} = $page->url;
	$session->remove('order-search');
	$filename = $sessionID;

	/**
	* PICKING ORDERS REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	*	case 'load-cust-orders':
	*		DBNAME=$config->dbName
	*		ORDRHED
	*		CUSTID=$custID
	*		TYPE=O  ** OPEN ORDERS
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'initiate-pick':
			$login = get_loginrecord($sessionID);
			$data = array('DBNAME' => $config->dbName, 'LOGIN' => $login['loginid']);
			$session->loc = $config->pages->index;
			break;
		case 'start-order':
			$ordn = $input->$requestmethod->text('ordn');
			$data = array('DBNAME' => $config->dbName, 'STARTORDER' => false, 'ORDERNBR' => $ordn);
			$session->loc = "{$config->pages->salesorderpicking}?ordn=$ordn";
			break;
		case 'select-bin':
			$bin = $input->$requestmethod->text('bin');
			$data = array('DBNAME' => $config->dbName, 'SETBIN' => $bin);
			$session->loc = $input->$requestmethod->text('page');
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgis['whse'] . "?fname=" . $filename);
	exit;
