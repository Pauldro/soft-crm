use Purl\Url;

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
	*	case 'initiate-pick':
	*		DBNAME=$config->dbName
	*		LOGIN=$user->loginid
	*		break;
	*	case 'start-order':
	*		DBNAME=$config->dbName
	*		STARTORDER
	*		ORDERNBR=$ordn
	*		break;
	*	case 'select-bin':
	*		DBNAME=$config->dbName
	*		SETBIN=$bin
	*		break;
	*	case 'next-bin':
	*		DBNAME=$config->dbName
	*		NEXTBIN
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'initiate-pick':
			$login = get_loginrecord($sessionID);
			$data = array('DBNAME' => $config->dbName, 'LOGIN' => $login['loginid']);
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'logout':
			$data = array('DBNAME' => $config->dbName, 'LOGOUT' => false);
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'start-order':
			$ordn = $input->$requestmethod->text('ordn');
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$data = array('DBNAME' => $config->dbName, 'STARTORDER' => false, 'ORDERNBR' => $ordn);
			$url->query->set('ordn', $ordn);
			$session->loc = $url->getUrl();
			break;
		case 'select-bin':
			$bin = strtoupper($input->$requestmethod->text('bin'));
			$data = array('DBNAME' => $config->dbName, 'SETBIN' => $bin);
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'next-bin':
			$data = array('DBNAME' => $config->dbName, 'NEXTBIN' => false);
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-item':
			$item = Pick_SalesOrderDetail::load(session_id());
			$data = array('DBNAME' => $config->dbName, 'ACCEPTITEM' => false, 'ORDERNBR' => $item->ordernbr, 'LINENBR' => $item->linenbr, 'ITEMID' => $item->itemnbr, 'ITEMQTY' => $item->get_userpickedtotal());
			$session->loc = "{$config->pages->salesorderpicking}?ordn=$item->ordernbr";
			break;
		case 'skip-item':
			$whsesession = WhseSession::load(session_id());
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$data = array('DBNAME' => $config->dbName, 'SKIPITEM' => false, 'ORDERNBR' => $pickitem->ordn, 'LINENBR' => $pickitem->linenbr);
			$session->loc = "{$config->pages->salesorderpicking}?ordn=$pickitem->ordernbr";
			break;
		case 'finish-order':
			$whsesession = WhseSession::load(session_id());
			$data = array('DBNAME' => $config->dbName, 'COMPLETEORDER' => false, 'ORDERNBR' => $whsesession->ordn);
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'exit-order':
			$whsesession = WhseSession::load(session_id());
			$data = array('DBNAME' => $config->dbName, 'STOPORDER' => false, 'ORDERNBR' => $whsesession->ordn);
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'remove-order-locks':
			$ordn = $input->$requestmethod->text('ordn');
			$data = array('DBNAME' => $config->dbName, 'REFRESHPD' => false, 'ORDERNBR' => $ordn);
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'add-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->add_barcode($barcode);
			$session->loc = "{$config->pages->salesorderpicking}?ordn=$pickitem->ordernbr";
			break;
		case 'remove-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->remove_barcode($barcode);
			$session->sql = $pickitem->remove_barcode($barcode, true);
			$session->loc = "{$config->pages->salesorderpicking}?ordn=$pickitem->ordernbr";
			break;
	}
	
	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
