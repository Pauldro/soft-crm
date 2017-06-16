<?php
	$custID = $input->get->text('custID');
	if ($input->post->action) { $action = $input->post->text('action'); } else { $action = $input->get->text('action'); }
	if ($input->get->page) { $pagenumber = $input->get->int('page'); } else { $pagenumber = 1; }
	if ($input->get->orderby) { $sortaddon = '&orderby=' . $input->get->text('orderby'); } else { $sortaddon = ''; }


	$session->{'from-redirect'} = $page->url;
	$session->remove('order-search');
	$link_addon = $sortaddon;

	$filename = session_id();
	switch ($action) {
		case 'load-customer':
			$session->loc = $config->pages->customer . urlencode($custID)."/";
			if ($input->get->shipID) { $session->loc .= "shipto-".$input->get->shipID."/"; }
			$data = array('DBNAME' => $config->dbName, 'CUSTID' => $custID);
			break;
		case 'set-shopping-customer':
			if ($input->post->custID) { $custID = $input->post->custID; }
			$session->{'new-shopping-customer'} = get_customer_name($input->post->text('custID'));
			break;
		case 'shop-as-customer':
			if ($input->post->custID) { $custID = $input->post->custID; } $session->custID = $custID;
			if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
			$data = array('DBNAME' => $config->dbName, 'CARTCUST' => false, 'CUSTID' => $custID);
			$session->{'new-shopping-customer'} = get_customer_name($custID);
            if ($shipID != '') {$data['SHIPID'] = $shipID; $session->shipID = $shipID; get_customer_name($custID) . " Ship-to: " . $shipID;}
			if (getcartheadcount(session_id(), false) == 0) { $session->sql = insertcarthead(session_id(), $custID, $shipID, false);}
			if ($input->post->page) {
				$session->loc = urldecode($input->post->page);
			} elseif ($input->get->page) {
				$session->loc = urldecode($input->get->text('page'));
			} else {
				$session->loc = $config->pages->index;
			}

			break;
		case 'load-orders':
			$session->remove('ordersearch');
			$data = array('DBNAME' => $config->dbName, 'ORDRHED' => false, 'CUSTID' => $custID, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/orders/cust/".urlencode($custID)."/"."?ordn=".$link_addon;
			$session->{'orders-loaded-for'} = $custID;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
		case 'get-order-details':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDRDET' => $ordn, 'CUSTID' => $custID);
			$session->loc = paginate($config->pages->ajax."load/orders/cust/".urlencode($custID)."/?ordn=".$ordn.$link_addon, $pagenumber, $custID, '');
			if ($input->get->lock == 'lock') {$data['LOCK'] = false; $session->lockedordn = $ordn; $session->loc = $config->pages->editorder."?ordn=".$ordn; }
			if ($input->get->readonly == 'readonly') {$session->loc = $config->pages->editorder."?ordn=".$ordn; }
			break;
		case 'showtracking':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDRTRK' => $ordn, 'CUSTID' => $custID);
			if ($input->get->ajax) {
				$session->loc = $config->pages->ajax."load/order/tracking/?ordn=".$ordn;
			} else {
				$session->loc = paginate($config->pages->ajax."load/orders/cust/".urlencode($custID)."/?ordn=".$ordn.$link_addon."&show=tracking", $pagenumber, $custID, '');
			}
			break;
		case 'get-order-documents':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDDOCS' => $ordn, 'CUSTID' => $custID);
			if ($input->get->ajax) {
				$session->loc = $config->pages->ajax."load/order/documents/?ordn=".$ordn;
			} else {
				if ($input->get->itemdoc) {
					$session->loc = paginate($config->pages->ajax."load/orders/cust/".urlencode($custID)."/?ordn=".$ordn.$link_addon."&show=documents&itemdoc=".$input->get->text('itemdoc'), $pagenumber, $custID, '');
				} else {
					$session->loc = paginate($config->pages->ajax."load/orders/cust/".urlencode($custID)."/?ordn=".$ordn."&show=documents".$link_addon, $pagenumber, $custID, '');
				}
			}
			break;
		case 'search-order-head':
			$session->remove('ordersearch');
			$orderstatus = $input->post->orderstatus;
			$searchtype = $input->post->searchtype;
			$searchterm = $input->post->q;
			$custID = $input->post->text('custID');
			$shipID = $input->post->text('shipID');

			//searchtype is the code the COBOL program looks for when scanning the file made. The code is based on SearchType
			//so if we are searching order# then the searchType will be ORDERNBR and the cobol program will know to fill our mysql based on ordernbr

			$data = array('DBNAME' => $config->dbName, 'ORDRHED' => false, 'CUSTID' => $custID, $searchtype => $searchterm);
			switch ($orderstatus) {
				case 'O':
					$os = 'Open Orders';
					$session->{'ordertype'} = 'O';
					break;
				case 'AS':
					$os = 'Open Orders';
					$session->{'ordertype'} = 'O';
					$orderStatus = 'O';
					break;
				case 'B':
					$os = 'Booked Orders';
					$session->{'ordertype'} = 'B';
					break;
				case 'S':
					$os = 'Shipped Orders';
					$session->{'ordertype'} = 'S';
					break;
				default:
					$os = 'Both Open and Shipped Orders';
					$session->{'ordertype'} = '';
			}
			$data['TYPE'] = $orderstatus;

			if ($searchterm == '' ) {
				$session->ordersearch = 'STUFF';
			} else {
				$session->ordersearch = "'" . $searchterm . "' in " . $os;
			}

			if (($input->post->text('date-from')) != "") {
				$datefrom = $input->post->text('date-from');
				$datethru = "";
				$searchvalu;
				if ($input->post->text('date-through') == "" || $input->post->text('date-through') == NULL) {
					$datethru = date('m/d/Y');
				} else {
					$datethru = $input->post->text('date-through');
				}
				if ($datefrom != date('m/d/Y') || $datethru != date('m/d/Y')) {
					if ($datefrom != "" || $datefrom != NULL) {
						$searchvalu = "Date Range: ".$datefrom.' - '.$datethru;
					}
					$data['DATEFROM'] = $datefrom;
					$data['DATETHRU'] = $datethru;
					$session->ordersearch =  $searchvalu . ' in '.$os;
				}

			}

			$session->loc = $config->pages->ajax."load/orders/cust/".urlencode($custID)."/";
			if ($shipID != '') {$session->loc .= "shipto-".urlencode($shipID)."/";}
			$session->loc .= "?ordn=".$link_addon;
			$session->{'orders-loaded-for'} = $custID;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
		case 'load-quotes':
			$custID = $input->get->text('custID');
			$data = array('DBNAME' => $config->dbName, 'QUOTHED' => false, 'TYPE' => 'QUOTE', 'CUSTID' => $custID);
			$session->loc = $config->pages->ajax."load/quotes/cust/".urlencode($custID)."/?qnbr=".$link_addon;
			$session->{'quotes-loaded-for'} = $custID;
			$session->{'quotes-updated'} = date('m/d/Y h:i A');
			break;
		case 'load-quote-details':
			$qnbr = $input->get->text('qnbr');
			$data = array('DBNAME' => $config->dbName, 'QUOTDET' => $qnbr, 'CUSTID' => $custID);
			$session->loc = $config->pages->ajax."load/quotes/cust/".urlencode($custID)."/?qnbr=".$qnbr.$link_addon;;
			$session->{'quotes-loaded-for'} = $custID;
			$session->{'quotes-updated'} = date('m/d/Y h:i A');
			break;
		case 'ci-buttons':
			$data = array('DBNAME' => $config->dbName, 'CIBUTTONS' => false);
			$session->loc = $config->pages->index;
			break;
		case 'ci-customer':
			$data = array('DBNAME' => $config->dbName, 'CICUSTOMER' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			$session->loc = $config->pages->custinfo."$custID/";
			break;
		case 'ci-shiptos':
			$data = array('DBNAME' => $config->dbName, 'CISHIPTOLIST' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-shipto-info':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dbName, 'CISHIPTOINFO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			$session->loc = $config->pages->custinfo."$custID/shipto-$shipID/";
			break;
		case 'ci-shipto-buttons':
			$data = array('DBNAME' => $config->dbName, 'CISTBUTTONS' => false);
			$session->loc = $config->pages->index;
			break;
		case 'ci-contacts':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dbName, 'CICONTACT' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-documents':
			$custname = get_customer_name($custID);
			$data = array('DBNAME' => $config->dbName, 'DOCVIEW' => false, 'FLD1CD' => 'CU', 'FLD1DATA' => $custID, 'FLD1DESC' => $custname);
			$session->loc = $config->pages->index;
			break;
		case 'ci-standing-orders':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dbName, 'CISTANDORDR' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-credit':
			$data = array('DBNAME' => $config->dbName, 'CICREDIT' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-open-invoices':
			$data = array('DBNAME' => $config->dbName, 'CIOPENINV' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-payment-history':
			$data = array('DBNAME' => $config->dbName, 'CIPAYMENT' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-quote':
			$data = array('DBNAME' => $config->dbName, 'CIQUOTE' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-payments':
			$data = array('DBNAME' => $config->dbName, 'CIPAYMENT' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->index;
			break;
		case 'ci-sales-orders':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dbName, 'CISALESORDR' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'SALESORDRNBR' => '', 'ITEMID' => '');
			$session->loc = $config->pages->index;
			break;
		case 'ci-sales-history':
			$shipID = $input->get->text('shipID');
			$date = $input->get->text('startdate');
			$itemid = $input->get->text('q');
			$startdate = date('Ymd', strtotime($date));
			$data = array('DBNAME' => $config->dbName, 'CISALESHIST' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'DATE' => $startdate, 'SALESORDRNBR' => '', 'ITEMID' => $itemid);
			$session->loc = $config->pages->index;
			break;
		case 'ci-custpo':
			$custpo = $input->get->text('custpo');
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dbName, 'CICUSTPO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'CUSTPO' => $custpo);
			$session->loc = $config->pages->index;
			break;
		default:
			$session->remove('ordersearch');
			$data = array('DBNAME' => $config->dbName, 'ORDRHED' => false, 'CUSTID' => $custID, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/orders/cust/".urlencode($custID)."/";
			$session->loc .= "?ordn=".$link_addon;
			$session->{'orders-loaded-for'} = $custID;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);

 	exit;
