<?php
	/**
	* CART REDIRECT
	*  @param string $action
	*
	*/

	$custID = $shipID = '';

	if ($input->requestMethod('POST')) {
		$requestmethod = 'post';
	} else {
		$requestmethod = 'get';
	}
	$action = $input->$requestmethod->text('action');

	$custID = $input->$requestmethod->text('custID');
	$shipID = $input->$requestmethod->text('shipID');

	if ($input->$requestmethod->sessionID) {
		$filename = $input->$requestmethod->text('sessionID');
		$sessionID = $input->$requestmethod->text('sessionID');
	} else {
		$filename = session_id();
		$sessionID = session_id();
	}

	/**
	* CART REDIRECT
	*
	* switch ($action) {
	*	case 'add-to-cart':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=$itemID
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		WHSE=$whse  **OPTIONAL
	*		break;
	*	case 'add-nonstock-item':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=N
	*		QTY=$qty
	*		CUSTID=$custID
	*		break;
	*	case 'add-multiple-items':
	*		DBNAME=$config->dplusdbname
	*		CARTADDMULTIPLE
	*		CUSTID=$custID
	*		ITEMID=$custID   QTY=$qty  **REPEAT
	*		break;
	*	case 'reorder':
	*		CARTADDMULTIPLE
	*		CUSTID=$custID || PULL FROM QUOTENBR / ORDN
	*		ITEMID=$custID   QTY=$qty  **REPEAT
	*		break;
	*	case 'update-line':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'remove-line':
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'empty-cart':
	*		DBNAME=$config->dplusdbname
	*		EMPTYCART
	*		break;
	*	case 'create-sales-order':
	*		DBNAME=$config->dplusdbname
	*		CREATESO
	*		break;
	*	case 'create-quote':
	*		DBNAME=$config->dplusdbname
	*		CREATEQT
	*		break;
	* }
	*
	**/

    switch ($action) {
        case 'add-to-cart':
			$itemID = $input->$requestmethod->text('itemID');
			$qty = determine_qty($input, $requestmethod, $itemID); // TODO MAKE IN CART DETAIL
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'ITEMID' => $itemID, 'QTY' => "$qty");
			$data['CUSTID'] = empty($custID) ? $config->defaultweb : $custID;
			if (!empty($shipID)) {$data['SHIPTOID'] = $shipID; }
			if ($input->post->whse) { if (!empty($input->post->whse)) { $data['WHSE'] = $input->post->whse; } }
			$session->data = $data;
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemID . ' to your cart';
            $session->loc = $input->post->page;
            break;
		case 'add-nonstock-item':
			$qty = $input->$requestmethod->text('qty');
			$cartdetail = new CartDetail();
			$cartdetail->set('sessionid', $sessionID);
			$cartdetail->set('linenbr', '0');
			$cartdetail->set('recno', 0);
			$cartdetail->set('orderno', $sessionID);
			$cartdetail->set('vendorid', $input->post->text('vendorID'));
			$cartdetail->set('shipfromid', $input->post->text('shipfromID'));
			$cartdetail->set('vendoritemid', $input->post->text('itemID'));
			$cartdetail->set('desc1', $input->post->text('desc1'));
			$cartdetail->set('desc2', $input->post->text('desc2'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('price', $input->post->text('price'));
			$cartdetail->set('cost', $input->post->text('cost'));
			$cartdetail->set('uom', $input->post->text('uofm'));
			$cartdetail->set('nsitemgroup', $input->post->text('nsitemgroup'));
			$cartdetail->set('ponbr', $input->post->text('ponbr'));
			$cartdetail->set('poref', $input->post->text('poref'));
			$cartdetail->set('spcord', 'S');
			$session->sql = $cartdetail->create();
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'LINENO' => '0', 'ITEMID' => 'N', 'QTY' => $qty, 'CUSTID' => $custID, 'stuff' => 'stuff');
			$session->loc = $config->pages->cart;
			break;
		case 'add-multiple-items':
			$itemids = $input->post->itemID;
			$qtys = $input->post->qty;
			$data = array("DBNAME=$config->dplusdbname", 'CARTADDMULTIPLE', "CUSTID=$custID");

			if (DplusWire::wire('modules')->isInstalled('QtyPerCase')) {
				$case_qtys = $input->post->{'case-qty'};
				$bottle_qtys = $input->post->{'bottle-qty'};
				$qtypercase = Dplus\ProcessWire\DplusWire::wire('modules')->get('QtyPerCase');
				$data = $qtypercase->generate_multipleitemdata($data, $itemids, $case_qtys, $bottle_qtys);
			} else {
				$qtys = $input->post->qty;
				$data = writedataformultitems($data, $itemids, $qtys);
			}
            $session->addtocart = sizeof($itemIDs);
            $session->loc = $config->pages->cart;
			break;
		case 'reorder':
			$from = $input->get->text('from');
			$itemids = array();
			$qtys = array();
			switch ($from) {
				case 'salesorder':
					$ordn = $input->get->text('ordn');
					$custID = SalesOrder::find_custid($ordn);;
					$details = get_orderdetails(session_id(), $ordn, true, false);
					foreach ($details as $detail) {
						$itemids[] = $detail->itemid;
						$qtys[] = $detail->qty;
		 			}
					break;
			}
			$data = array("DBNAME=$config->dplusdbname", 'CARTADDMULTIPLE', "CUSTID=$custID");
			$data = writedataformultitems($data, $itemids, $qtys);
			$session->loc = $config->pages->cart;
			break;
		case 'quick-update-line':
			$linenbr = $input->post->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$qty = determine_qty($input, $requestmethod, $cartdetail->itemid); // TODO MAKE IN CART DETAIL
			$custID = CartQuote::get_cartcustid($sessionID);
			// $cartdetail->set('whse', $input->post->text('whse'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('price', $input->post->text('price'));
			$cartdetail->set('rshipdate', $input->post->text('rqstdate'));
			$session->sql = $cartdetail->update();
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'LINENO' => $linenbr);
			$data['CUSTID'] = empty($custID) ? $config->defaultweb : $custID;
			if (!empty($shipID)) {$data['SHIPTOID'] = $shipID; }
			writedplusfile($data, $sessionID);
			$session->loc = $config->pages->cart;
			break;
		case 'update-line':
			$linenbr = $input->post->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$qty = determine_qty($input, $requestmethod, $cartdetail->itemid); // TODO MAKE IN CART DETAIL
			$cartdetail->set('price', $input->post->text('price'));
			$cartdetail->set('discpct', $input->post->text('discount'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('rshipdate', $input->post->text('rqstdate'));
			$cartdetail->set('whse', $input->post->text('whse'));
			$cartdetail->set('spcord', $input->post->text('specialorder'));
			$cartdetail->set('vendorid', $input->post->text('vendorID'));
			$cartdetail->set('shipfromid', $input->post->text('shipfromID'));
			$cartdetail->set('vendoritemid', $input->post->text('vendoritemID'));
			$cartdetail->set('nsitemgroup', $input->post->text('nsitemgroup'));
			$cartdetail->set('ponbr', $input->post->text('ponbr'));
			$cartdetail->set('poref', $input->post->text('poref'));
			$cartdetail->set('uom', $input->post->text('uofm'));

			if ($cartdetail->spcord != 'N') {
				$cartdetail->set('desc1', $input->post->text('desc1'));
				$cartdetail->set('desc2', $input->post->text('desc2'));
			}
			$session->sql = $cartdetail->update();
			$session->loc = $input->post->text('page');
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'LINENO' => $linenbr);
			$data['CUSTID'] = empty($custID) ? $config->defaultweb : $custID;
			if (!empty($shipID)) {$data['SHIPTOID'] = $shipID; }
			writedplusfile($data, $sessionID);
			$session->loc = $config->pages->cart;
			break;
		case 'remove-line':
			$linenbr = $input->get->text('line');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', '0');
			$session->sql = $cartdetail->update();
			$session->loc = $config->pages->cart;
			$custID = get_custidfromcart(session_id());
			$data = array('DBNAME' => $config->dplusdbname, 'CARTDET' => false, 'LINENO' => $linenbr, 'QTY' => '0');
			$data['CUSTID'] = empty($custID) ? $config->defaultweb : $custID;
			if (!empty($shipID)) {$data['SHIPTOID'] = $shipID; }
			break;
		case 'empty-cart':
			$data = array('DBNAME' => $config->dplusdbname, 'EMPTYCART' => false);
			$session->loc = $config->pages->cart;
			break;
        case 'create-sales-order':
			$data = array('DBNAME' => $config->dplusdbname, 'CREATESO' => false);
           	$session->loc = $config->pages->orders . "redir/?action=edit-new-order";
            break;
		case 'create-quote':
			$data = array('DBNAME' => $config->dplusdbname, 'CREATEQT' => false);
           	$session->loc = $config->pages->quotes . "redir/?action=edit-new-quote";
            break;
	}

	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
