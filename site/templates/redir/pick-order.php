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
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			$data = array("DBNAME=$config->dbName", "LOGIN=$loginID");
			break;
		case 'start-pick':
			$data = array("DBNAME=$config->dbName", 'PICKING');
			break;
		case 'start-pick-pack':
			$data = array("DBNAME=$config->dbName", 'PACKING');
			break;
		case 'logout':
			$data = array("DBNAME=$config->dbName", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'start-order':
			$ordn = $input->$requestmethod->text('ordn');
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$data = array("DBNAME=$config->dbName", 'STARTORDER', "ORDERNBR=$ordn");
			$url->query->set('ordn', $ordn);
			$session->loc = $url->getUrl();
			break;
		case 'select-bin':
			$bin = strtoupper($input->$requestmethod->text('bin'));
			$data = array("DBNAME=$config->dbName", "SETBIN=$bin");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'next-bin':
			$data = array("DBNAME=$config->dbName", 'NEXTBIN');
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'add-pallet':
			$data = array("DBNAME=$config->dbName", 'NEWPALLET');
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'set-pallet':
			$palletnbr = $input->$requestmethod->text('palletnbr');
			$data = array("DBNAME=$config->dbName", "GOTOPALLET=$palletnbr");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-item':
			$item = Pick_SalesOrderDetail::load(session_id());
			$totalpicked = $item->get_userpickedtotal();
			$data = array("DBNAME=$config->dbName", 'ACCEPTITEM', "ORDERNBR=$item->ordernbr ", "LINENBR=$item->linenbr", "ITEMID=$item->itemnbr", "ITEMQTY=$totalpicked");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-item-pick-pack':
			$item = Pick_SalesOrderDetail::load(session_id());
			$totals = $item->get_userpickedpallettotals();
			$session->sql = $item->get_userpickedpallettotals(true);
			$data = array("DBNAME=$config->dbName", 'ACCEPTITEM', "ORDERNBR=$item->ordernbr ", "LINENBR=$item->linenbr", "ITEMID=$item->itemnbr");
			foreach ($totals as $total) {
				$pallet = str_pad($total['palletnbr'], 4, ' ');
				$qty = str_pad($total['qty'], 10, ' ');
				$data[] = "PALLETNBR=$pallet|QTY=$qty";
			}
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'skip-item':
			$whsesession = WhseSession::load(session_id());
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$data = array("DBNAME=$config->dbName", 'SKIPITEM', "ORDERNBR=$pickitem->ordn", "LINENBR=$pickitem->linenbr");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-order':
			$whsesession = WhseSession::load(session_id());
			$data = array("DBNAME=$config->dbName", 'COMPLETEORDER', "ORDERNBR=$whsesession->ordn");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->remove('ordn');
			$session->loc = $url->getUrl();
			break;
		case 'exit-order':
			$whsesession = WhseSession::load(session_id());
			$data = array("DBNAME=$config->dbName", 'STOPORDER', "ORDERNBR=$whsesession->ordn");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->remove('ordn');
			$session->loc = $url->getUrl();
			break;
		case 'remove-order-locks':
			$ordn = $input->$requestmethod->text('ordn');
			$data = array("DBNAME=$config->dbName", 'REFRESHPD', "ORDERNBR=$ordn");
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'add-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$palletnbr = $input->$requestmethod->int('palletnbr');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->add_barcode($barcode, $palletnbr);
			$session->sql = $pickitem->add_barcode($barcode, $palletnbr, true);
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'remove-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$palletnbr = $input->$requestmethod->text('palletnbr');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->remove_barcode($barcode, $palletnbr);
			$session->sql = $pickitem->remove_barcode($barcode, $palletnbr, true);
			$session->loc = $input->$requestmethod->text('page');
			break;
	}
	
	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
