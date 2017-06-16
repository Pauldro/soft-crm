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

    switch ($action) {
        case 'add-to-cart':
			$filename = session_id();
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'ITEMID' => $itemid, 'QTY' => $qty);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }

			if ($input->post->whse) { if ($input->post->whse != '') { $data['WHSE'] = $input->post->whse; } }
			$session->data = $data;
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemid . ' to your cart';
            $session->loc = $input->post->page;
            break;
		case 'reorder':
			$filename = session_id();
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'ITEMID' => $itemid, 'QTY' => $qty);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			if ($input->post->whse) { if ($input->post->whse != '') { $data['WHSE'] = $input->post->whse; } }
            $session->addtocart = 'You added ' . $qty . ' of ' . $itemid . ' to your cart';
            $session->loc = $input->post->page;
			break;
		case 'remove' :
			$filename = session_id();
			$session->loc =  $input->post->page;
			$session->sql = set_qty_0(session_id(), $input->post->text('linenbr'));
			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'LINENO' => $input->post->linenbr);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			$session->addtocart = 'You removed '. $itemid . ' from your cart';
			$session->loc = $input->post->page;
			break;
		case 'update-line':
			$filename = session_id();
			if ($input->post->linenbr) { $line = $input->post->linenbr; } else { $line = $input->get->text('linenbr'); }
			if ($input->post->discount) { $discount = $input->post->discount; } else { $discount = $input->get->text('discount'); }
			if ($input->post->rqstdate) { $rqstdate = $input->post->rqstdate; } else { $rqstdate = $input->get->text('rqstdate'); }
			if ($input->post->whse) { $whse = $input->post->whse; } else { $whse = $input->get->text('whse'); }
			if ($input->post->price) { $price = $input->post->price; } else { $price = $input->get->text('price'); }
			$session->sql = update_line_item(session_id(), $qty, $price, $discount, $line, $rqstdate, $whse);
			$session->loc = $input->post->text('page');

			$data = array('DBNAME' => $config->dbName, 'CARTDET' => false, 'LINENO' => $input->post->linenbr);

			if ($custID == '') {$custID = $config->defaultweb;}
			$data['CUSTID'] = $custID; if ($shipID != '') {$data['SHIPTOID'] = $shipID; }
			$session->loc = $input->post->page;
			break;
        case 'create-sales-order':
			$filename = session_id();
			$data = array('DBNAME' => $config->dbName, 'CREATESO' => false);
           	$session->loc = $config->pages->orders . "redir/?action=edit-new-order";
            break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);

 	exit;
