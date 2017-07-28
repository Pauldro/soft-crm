<?php
	$custID = $shipID = '';
	if ($input->post->action) {
		$action = $input->post->text('action');
		$itemid = $input->post->text('itemid');
		$qty = $input->post->text('qty');
	} else {
		$action = $input->get->text('action');
		$itemid = $input->get->text('itemid');
		$qty = $input->get->text('qty');
	}

	if ($qty == '' || $qty == false) {$qty = "1"; }

	if ($input->post->custID) { $custID = $input->post->custID; } elseif($input->get->custID) {$custID = $input->get->text('custID');} else {$custID = $session->custID;}
	if ($input->post->shipID) { $shipID = $input->post->shipID; } elseif($input->get->shipID) { $shipID = $input->get->text('shipID'); } else {$shipID = $session->shipID;}

	if ($custID != '') {$session->custID = $custID;} if ($shipID != '') {$session->shipID = $shipID;}

	$filename = session_id();

	/**
	* CART REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'add-to-cart':
	*		DBNAME=$config->DBNAME
	*		CARTDET
	*		ITEMID=$itemid
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		WHSE=$whse  **OPTIONAL
	*		break;
	*	case 'reorder':
	*		DBNAME=$config->DBNAME
	*		CARTDET
	*		ITEMID=$itemid
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		WHSE=$whse  **OPTIONAL
	*		break;
	*	case 'reorder':
	*		DBNAME=$config->DBNAME
	*		CARTDET
	*		ITEMID=$itemid
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		WHSE=$whse  **OPTIONAL
	*		break;
	*	case 'remove':
	*		DBNAME=$config->DBNAME
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'update-line':
	*		DBNAME=$config->DBNAME
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'create-sales-order':
	*		DBNAME=$config->DBNAME
	*		CREATESO
	*		break;
	*	case 'create-quote':
	*		DBNAME=$config->DBNAME
	*		CREATEQT
	*		break;
	* }
	*
	**/

    switch ($action) {
        case 'add-to-cart':
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'ITEMID' => $itemid, 'QTY' => $qty);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }


			if ($input->post->whse) { if ($input->post->whse != '') { $data['WHSE'] = $input->post->whse; } }
			$session->data = $data;
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemid . ' to your cart';
            $session->loc = $input->post->page;
            break;
		case 'reorder':
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'ITEMID' => $itemid, 'QTY' => $qty);
			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			if ($input->post->whse) { if ($input->post->whse != '') { $data['WHSE'] = $input->post->whse; } }
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemid . ' to your cart';
            $session->loc = $input->post->page;
			break;
		case 'update-line':
			$linenbr = $input->post->text('linenbr');
			$cartdetail = getcartline(session_id(), $linenbr, false);
			$cartdetail['price'] = $input->post->text('price');
			$cartdetail['discpct'] =  $input->post->text('discount');
			$cartdetail['qtyordered'] = $qty;
			$cartdetail['rshipdate'] = $input->post->text('rqst-date');
			$cartdetail['whse'] = $input->post->text('whse');
			$cartdetail['spcord'] = $input->post->text('specialorder');
			$cartdetail['linenbr'] = $input->post->text('linenbr');

			$session->sql = edit_cartline(session_id(), $cartdetail, false);
			$session->loc = $input->post->text('page');
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'LINENO' => $input->post->linenbr);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			$session->loc = $config->pages->cart;
			break;
		case 'remove-line':
			$linenbr = $input->post->text('linenbr');
			$cartdetail = getcartline(session_id(), $linenbr, false);
			$cartdetail['qtyordered'] = '0';
			$session->sql = edit_cartline(session_id(), $cartdetail, false);
			$session->loc = $config->pages->cart;
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'LINENO' => $input->post->linenbr);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			break;
        case 'create-sales-order':
			$data = array('DBNAME' => $config->dbName, 'CREATESO' => false);
           	$session->loc = $config->pages->orders . "redir/?action=edit-new-order";
            break;
		case 'create-quote':
			$data = array('DBNAME' => $config->dbName, 'CREATEQT' => false);
           	$session->loc = $config->pages->quotes . "redir/?action=edit-new-quote";
            break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);

 	exit;
