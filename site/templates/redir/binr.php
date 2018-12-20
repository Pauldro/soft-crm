<?php
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');
	$sessionID = !empty($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	
	$session->fromredirect = $page->url;
	$filename = $sessionID;
	
	$session->remove('binr');
	
	/**
	* BINR REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	*	case 'initiate-whse':
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		break;
	*	case 'logout':
	*		DBNAME=$config->dplusdbname
	*		LOGOUT
	*		break;
	*	case 'inventory-search:
	*		DBNAME=$config->dplusdbname
	*		INVSEARCH
	*		QUERY=$q
	*		break;
	*	case 'search-item-bins'
	*		DBNAME=$config->dplusdbname
	*		BININFO
	*		ITEMID=$itemID
	*		LOTSERIAL=$lotserial **     // NOTE ONLY FOR LOTTED OR SERIALIZED ITEMS
	*		break;
	*	case 'bin-reassign':
	*		DBNAME=$config->dplusdbname
	*		BINR
	*		ITEMID=$itemID
	*		SERIALNBR=$serialnbr        // NOTE ONLY FOR SERIALIZED ITEMS
	*		LOTNBR=$lotnbr              // NOTE ONLY FOR LOTTED ITEMS
	*		QTY=$qty
	*		FROMBIN=$frombin
	*		TOBIN=$tobin
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			$data = array("DBNAME=$config->dplusdbname", "LOGIN=$loginID");
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'inventory-search':
			$q = $input->$requestmethod->text('scan');
			$data = array("DBNAME=$config->dplusdbname", 'INVSEARCH', "QUERY=$q");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->set('scan', $q);
			$session->loc = $url->getUrl();
			break;
		case 'search-item-bins':
			$itemID = $input->$requestmethod->text('itemID');
			$binID = $input->$requestmethod->text('binID');
			$data = array("DBNAME=$config->dplusdbname", 'BININFO', "ITEMID=$itemID");
			$returnurl = new Purl\Url($input->$requestmethod->text('page'));
			$returnurl->query->remove('scan');
			
			if ($input->$requestmethod->serialnbr || $input->$requestmethod->lotnbr) {
				if ($input->$requestmethod->serialnbr) {
					$lotserial = $input->$requestmethod->text('serialnbr');
					$returnurl->query->set('serialnbr', $lotserial);
				} else {
					$lotserial = $input->$requestmethod->text('lotnbr');
					$returnurl->query->set('lotnbr', $lotserial);
				}
				$data[] = "LOTSERIAL=$lotserial";
			} else {
				$returnurl->query->set('itemID', $itemID);
			}
			
			if (!empty($binID)) {
				$returnurl->query->set('binID', $binID);
			}
			$session->loc = $returnurl->getUrl();
			break;
		case 'bin-reassign':
			$itemID = $input->$requestmethod->text('itemID');
			$frombin = $input->$requestmethod->text('from-bin');
			$qty = $input->$requestmethod->text('qty');
			$tobin = $input->$requestmethod->text('to-bin');
			$data = array("DBNAME=$config->dplusdbname", 'BINR', "ITEMID=$itemID");
			
			if ($input->$requestmethod->serialnbr) {
				$serialnbr = $input->$requestmethod->text('serialnbr');
				$data[] = "SERIALNBR=$serialnbr";
			}
			if ($input->$requestmethod->lotnbr) {
				$lotnbr = $input->$requestmethod->text('lotnbr');
				$data[] = "LOTNBR=$lotnbr";
			}
			$data[] = "QTY=$qty";
			$data[] = "FROMBIN=$frombin";
			$data[] = "TOBIN=$tobin";
			$session->loc = $input->$requestmethod->text('page');
			$session->binr = 'true';
			break;
	}
	
	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
