<?php
	/**
	*  QUOTE REDIRECT
	* @param string $action
	*/


	if ($input->post->action) { $action = $input->post->text('action'); } else { $action = $input->get->text('action'); }
	if ($input->get->page) { $pagenumber = $input->get->int('page'); } else { $pagenumber = 1; }
	if ($input->get->orderby) { $sortaddon = '&orderby=' . $input->get->text('orderby'); } else { $sortaddon = ''; }

	$linkaddon = $sortaddon;
	$session->{'from-redirect'} = $page->url;
	$session->remove('quote-search');
	$filename = session_id();

	//TODO merge get-quote-details and get-quote-details-print
	/**
	*  QUOTE REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	* 	case 'load-cust-quotes':
	*		DBNAME=$config->DBNAME
	*		LOADCUSTQUOTEHEAD
	*		TYPE=QUOTE
	*		CUSTID=$custID
	*		break;
	*	case 'load-quote-details':
	*		DBNAME=$config->DBNAME
	*		LOADQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'get-quote-details-print':
	*		DBNAME=$config->DBNAME
	*		LOADQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'edit-quote':
	*		DBNAME=$config->DBNAME
	*		EDITQUOTE=$qnbr
	*		QUOTENO=$qnbr
	*		break;
	*	case 'edit-new-quote':
	*		DBNAME=$config->DBNAME
	*		EDITQUOTE=$qnbr
	*		QUOTENO=$qnbr
	*		break;
	*	case 'save-quotehead':
	*		DBNAME=$config->DBNAME
	*		QUOTEHEAD
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'add-to-quote':
	*		DBNAME=$config->DBNAME
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		ITEMID=$itemID
	*		QTY=$qty
	*		break;
	*	case 'update-line':
	*		DBNAME=$config->DBNAME
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		LINENO=$linenbr
	*		break;
	*	case 'remove-line':
	*		DBNAME=$config->DBNAME
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		LINENO=$linenbr
	*		QTY=0
	*		break;
	*	case 'unlock-quote':
	*		UNLOCKING QUOTE
	*		break;
	*	case 'send-quote-to-order':
	*		SETTING UP QUOTE TO ORDER
	*		break;
	* }
	*
	**/



	switch ($action) {
		case 'load-cust-quotes':
			$custID = $input->get->text('custID');
			$data = array('DBNAME' => $config->dbName, 'LOADCUSTQUOTEHEAD' => false, 'TYPE' => 'QUOTE', 'CUSTID' => $custID);
			$session->loc = $config->pages->ajax."load/quotes/cust/".urlencode($custID)."/?qnbr=".$link_addon;
			$session->{'quotes-loaded-for'} = $custID;
			$session->{'quotes-updated'} = date('m/d/Y h:i A');
			break;
		case 'load-quote-details':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'LOADQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'CUSTID' => $custID);
			if ($input->get->lock) {
				$session->loc= $config->pages->editquote."?qnbr=".$qnbr;
			} else {
				$session->loc = $config->pages->ajax."load/quotes/cust/".urlencode($custID)."/?qnbr=".$qnbr.$link_addon;
			}
			break;
		case 'get-quote-details-print':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'LOADQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'CUSTID' => $custID);
			$session->loc = $config->pages->print."quote/?qnbr=".$qnbr;
			break;
		case 'edit-quote':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'EDITQUOTE' => $qnbr, 'QUOTENO' => $qnbr);
			$session->loc= $config->pages->editquote."?qnbr=".$qnbr;
			break;
		case 'edit-new-quote':
			$qnbr = getcreatedordn(session_id(), false);
			$data = array('DBNAME' => $config->dbName, 'EDITQUOTE' => $qnbr, 'QUOTENO' => $qnbr);
			$session->loc = $config->pages->editquote."?qnbr=".$qnbr;
			break;
		case 'save-quotehead':
			$qnbr = $input->post->text('qnbr');
			$quote = get_quotehead(session_id(), $qnbr, false);
			//$quote['status'] = ''; //TODO ON FORM
			$quote['btname'] = $input->post->text('cust-name');
			$quote['btadr1'] = $input->post->text('cust-address');
			$quote['btadr2'] = $input->post->text('cust-address2');
			$quote['btcity'] = $input->post->text('cust-city');
			$quote['btstate'] = $input->post->text('cust-state');
			$quote['btzip'] = $input->post->text('cust-zip');
			$quote['shiptoid'] = $input->post->text('shiptoid');
			$quote['stname'] = $input->post->text('shiptoname');
			$quote['stadr1'] = $input->post->text('shipto-address');
			$quote['stadr2'] = $input->post->text('shipto-address2');
			$quote['stcity'] = $input->post->text('shipto-city');
			$quote['ststate'] = $input->post->text('shipto-state');
			$quote['stzip'] = $input->post->text('shipto-zip');
			$quote['contact'] = $input->post->text('contact');

			$quote['emailadr'] = $input->post->text('contact-email');
			$quote['careof'] = $input->post->text('careof');
			$quote['revdate'] = $input->post->text('reviewdate');
			$quote['expdate'] = $input->post->text('expiredate');
			$quote['sviacode'] = $input->post->text('shipvia');
			$quote['deliverydesc'] = $input->post->text('delivery');
			$quote['custpo'] = $input->post->text('custpo');
			$quote['custref'] = $input->post->text('reference');

			$quote['telenbr'] = $input->post->text('contact-phone');
			//$extension = $_POST["contact-extension"];
			$quote['faxnbr'] = $input->post->text('contact-fax');

			$session->sql = edit_quotehead(session_id(), $qnbr, $quote, false);
			$data = array('DBNAME' => $config->dbName, 'UPDATEQUOTEHEAD' => false, 'QUOTENO' => $qnbr);
			$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr.$linkaddon;
			break;
		case 'add-to-quote':
			$qnbr = $input->post->text('qnbr');
			$itemID = $input->post->text('itemID');
			$qty = $input->post->text('qty');
			$data = array('DBNAME' => $config->dbName, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'ITEMID' => $itemID, 'QTY' => $qty);
			$session->editdetail = true;
			break;
		case 'update-line':
			if ($input->post) {
				$qnbr = $input->post->text('qnbr');
				$linenbr = $input->post->text('linenbr');
			} else {
				$qnbr = $input->get->text('qnbr');
				$linenbr = $input->get->text('linenbr');
			}

			$quotedetail = getquotelinedetail(session_id(), $qnbr, $linenbr, false);
			$quotedetail['quotprice'] = $input->post->text('price');
			$quotedetail['discpct'] =  $input->post->text('discount');
			$quotedetail['quotunit'] = $input->post->text('qty');
			$quotedetail['ordrqty'] = $input->post->text('qty');
			$quotedetail['rshipdate'] = $input->post->text('rqstdate');
			$quotedetail['whse'] = $input->post->text('whse');
			$quotedetail['spcord'] = $input->post->text('specialorder');
			$quotedetail['linenbr'] = $input->post->text('linenbr');
			$session->sql = edit_quoteline(session_id(), $qnbr, $quotedetail, false);
			$session->detail = $quotedetail;
			$data = array('DBNAME' => $config->dbName, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr);
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'remove-line':
			$qnbr = $input->post->text('qnbr');
			$linenbr = $input->post->text('linenbr');
			$quotedetail = getquotelinedetail(session_id(), $qnbr, $linenbr, false);
			$quotedetail['quotunit'] = '0';
			$quotedetail['linenbr'] = $input->post->text('linenbr');
			$session->sql = edit_quoteline(session_id(), $qnbr, $quotedetail, false);
			$session->detail = $quotedetail;
			$data = array('DBNAME' => $config->dbName, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr, 'QTY' => '0');
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'unlock-quote':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$shipID = getquoteshipto(session_id(), $qnbr, false);
			$data = array('UNLOCKING QUOTE' => false);
			$session->loc = $config->pages->customer.urlencode($custID)."/";
			if ($shipID != '') { $session->loc .= "shipto-".urlencode($shipID)."/"; }
			break;
		case 'send-quote-to-order':
			$qnbr = $input->post->text('qnbr');
			$linenbrs = $input->post->linenbr;
			$session->linecount = $linecount = nextquotelinenbr(session_id(), $qnbr);
			for ($i = 1; $i < $linecount; $i++) {
				$quotedetail = getquotelinedetail(session_id(), $qnbr, $i, false);
				if (in_array($i, $linenbrs)) {
					$quotedetail['ordrqty'] = $quotedetail['quotunit'];
				} else {
					$quotedetail['ordrqty'] = '0';
				}

				$session->sql = edit_quoteline(session_id(), $qnbr, $quotedetail, false);
			}

			$session->custID = $custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'QUOTETOORDER' => false, 'QUOTENO' => $qnbr, 'LINENO' => 'ALL');
			$session->loc = $config->pages->orders."redir/?action=edit-new-order";
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);
 	exit;
?>
