<?php


	if ($input->post->action) { $action = $input->post->text('action'); } else { $action = $input->get->text('action'); }
	if ($input->get->page) { $pagenumber = $input->get->int('page'); } else { $pagenumber = 1; }
	if ($input->get->orderby) { $sortaddon = '&orderby=' . $input->get->text('orderby'); } else { $sortaddon = ''; }

	$link_addon = $sortaddon;
	$session->{'from-redirect'} = $page->url;
	$session->remove('order-search');

	$filename = session_id();
	switch ($action) {
		case 'submit-order-head':
			$ordn = $input->post->text("ordn");
			$order = get_orderhead(session_id(), $ordn, false);


			$intl = $input->post->text("intl");
			$paytype = addslashes($input->post->text("paytype"));

			$order['shiptoid'] = $input->post->text('shiptoid');
			$order['custname'] = $input->post->text('cust-name');
			$order['custpo'] = $input->post->text("custpo");
			$order['sname'] = $input->post->text("shiptoname");
			$order['saddress'] = $input->post->text("shipto-address");
			$order['saddress2'] = $input->post->text("shipto-address2");
			$order['scity'] = $input->post->text("shipto-city");
			$order['sst'] = $input->post->text("shipto-state");
			$order['szip'] = $input->post->text("shipto-zip");
			$order['contact'] = $input->post->text('contact');
			$order['phone'] = $input->post->text("contact-phone");
			$order['extension'] = $input->post->text("contact-extension");
			$order['faxnumber'] = $fax = $input->post->text("contact-fax");
			$order['email'] = $input->post->text("contact-email");
			$order['releasenbr'] = $input->post->text("release-number");
			$order['shipviacd'] = $input->post->text('shipvia');
			$order['rqstdate'] = $input->post->text("rqstdate");
			$order['shipcom'] = $input->post->text("shipcomplete");
			$order['btname'] = $input->post->text('cust-name');
			$order['btadr1'] = $input->post->text('cust-address');
			$order['btadr2'] = $input->post->text('cust-address2');
			$order['btcity'] = $input->post->text('cust-city');
			$order['btstate'] = $input->post->text('cust-state');
			$order['btzip'] = $input->post->text('cust-zip');
			$ccno = '';
			$xpd = '';
			$ccv = '';
			if ($intl == 'Y') {
				$order['phone'] = $input->post->text("office-accesscode") . $input->post->text("office-countrycode") . $input->post->text("intl-office");
				$order['extension'] = $input->post->text("intl-ofice-ext");
				$order['faxnumber'] = $input->post->text("fax-accesscode") . $input->post->text("fax-countrycode") . $input->post->text("intl-fax");
			} else {
				$order['phone'] = $input->post->text("contact-phone");
				$order['extension'] = $input->post->text("contact-extension");
				$order['faxnumber'] = $input->post->text("contact-fax");
			}
			if ($paytype == 'cc') {
				$ccno = $input->post->text("ccno");
				$xpd = $input->post->text("xpd");
				$ccv = $input->post->text("ccv");
			}

			$session->sql = edit_orderhead(session_id(), $ordn, $order, false);
			$session->sql .= '<br>'. edit_orderhead_credit(session_id(), $ordn, $paytype, $ccno, $xpd, $ccv);
			$data = array('DBNAME' => $config->dbName, 'SALESHEAD' => false, 'ORDERNO' => $ordn);
			$session->loc = $config->pages->customer;
			break;
		case 'unlock-order':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$shipID = get_shiptoid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'UNLOCK' => false, 'ORDERNO' => $ordn);
			$session->loc = $config->pages->customer.urlencode($custID)."/";
			if ($shipID != '') { $session->loc .= "shipto-".urlencode($shipID)."/"; }
			break;
		case 'update-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$orderdetail = getorderlinedetail(session_id(), $ordn, $linenbr, false);
			$orderdetail['price'] = $input->post->text('price');
			$orderdetail['discpct'] =  $input->post->text('discount');
			$orderdetail['qtyordered'] = $input->post->text('qty');
			$orderdetail['rshipdate'] = $input->post->text('rqst-date');
			$orderdetail['whse'] = $input->post->text('whse');
			$session->sql = edit_orderline(session_id(), $ordn, $linenbr, $orderdetail, false);
			$data = array('DBNAME' => $config->dbName, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr);
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			$session->editdetail = true;
			break;
		case 'remove':
			$qty = 0;
			$warehouse = $input->post->text('warehouse');
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$price = $input->post->text('price');
			$session->sql = update_qty_and_warehouse(session_id(), $ordn, $linenbr, $qty, $warehouse, $price);
			$session->editdetail = true;
			$data = array('DBNAME' => $config->dbName, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr);
			$session->loc = $input->post->page;
			break;
		case 'add-to-order':
			$itemid = $input->post->text('itemid');
			$qty = $input->post->text('qty'); if ($qty == '') {$qty = 1; }
			$ordn = $input->post->text('ordn');
			$data = array('DBNAME' => $config->dbName, 'SALEDET' => false, 'ORDERNO' => $ordn, 'ITEMID' => $itemid, 'QTY' => $qty);
			$session->loc = $input->post->page;
			break;
		case 'edit-new-order':
			if ($session->custID) { $custID = $session->custID; } else { $custID = $default_web; }
			$ordn = getcreatedordn(session_id(), false);
			$data = array('DBNAME' => $config->dbName, 'ORDRDET' => $ordn, 'CUSTID' => $custID, 'LOCK' => false);
			$session->loc  = $config->pages->edit.'order/?ordn=' . $ordn;
			break;
		case 'get-order-details':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDRDET' => $ordn, 'CUSTID' => $custID);
			if ($input->get->lock) {
				$data['LOCK'] = false;
				$session->loc = $config->pages->editorder."?ordn=".$ordn;
			} else {
				$session->loc = paginate($config->pages->ajax."load/orders/salesrep/?ordn=".$ordn.$link_addon, $pagenumber, "salesrep", '');
				if ($input->get->readonly) {$session->loc = $config->pages->editorder."?ordn=".$ordn; }
			}
			break;
		case 'get-order-details-print':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDRDET' => $ordn, 'CUSTID' => $custID);
			$session->loc = $config->pages->print."order/?ordn=".$ordn;
			break;
		case 'get-documents-edit':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDDOCS' => $ordn, 'CUSTID' => $custID);
			$session->loc = $config->pages->ajax."load/order-documents/?ordn=".$ordn;
			break;
		case 'get-documents':
			$ordn = $input->get->text('ordn');
			$custID = get_custid_from_order(session_id(), $ordn);
			$data = array('DBNAME' => $config->dbName, 'ORDDOCS' => $ordn, 'CUSTID' => $custID);
			if ($input->get->ajax) {
				$session->loc = $config->pages->ajax."load/order-documents/?ordn=".$ordn;
			} else {
				if ($input->get->itemdoc) {
					$session->loc = paginate($config->pages->ajax."load/orders/salesrep/?ordn=".$ordn.$link_addon."&show=documents&itemdoc=".$input->get->text('itemdoc'), $pagenumber, "salesrep", '');
				} else {
					$session->loc = paginate($config->pages->ajax."load/orders/salesrep/?ordn=".$ordn."&show=documents".$link_addon, $pagenumber, "salesrep", '');
				}
			}
			break;
		case 'load-orders':
			$data = array('DBNAME' => $config->dbName, 'REPORDRHED' => false, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/orders/salesrep/".urlencode($custID)."/?ordn=".$link_addon."";
			$session->{'orders-loaded-for'} = $user->loginid;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
		default:
			$data = array('DBNAME' => $config->dbName, 'REPORDRHED' => false, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/orders/salesrep/".urlencode($custID)."/?ordn=".$link_addon."";
			$session->{'orders-loaded-for'} = $user->loginid;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);

 	exit;


	?>
