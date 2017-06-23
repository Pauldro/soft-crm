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

	/**
	*  QUOTE REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'get-quote-details':
	*		DBNAME=$config->DBNAME
	*		QUOTDET=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'get-quote-details-print':
	*		DBNAME=$config->DBNAME
	*		QUOTDET=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'save-quotehead':
	*		DBNAME=$config->DBNAME
	*		QUOTEHEAD
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'add-to-quote':
	*		DBNAME=$config->DBNAME
	*		QUOTEDETAIL
	*		QUOTNO=$qnbr
	*		ITEMID=$itemID
	*		QTY=$qty
	*		break;
	*	case 'update-line':
	*		DBNAME=$config->DBNAME
	*		QUOTEDETAIL
	*		QUOTNO=$qnbr
	*		LINENO=$linenbr
	*		break;
	*	case 'unlock-quote':
	*		$data = array('UNLOCKING QUOTE' => '');
	*		break;
	*	default:
	*		break;
	* }
	*
	**/





	switch ($action) {
		case 'get-quote-details':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'QUOTDET' => $qnbr, 'CUSTID' => $custID);
			if ($input->get->lock) {
				$session->loc= $config->pages->editquote."?qnbr=".$qnbr;
			} else {
				$session->loc= $config->pages->editquote."?qnbr=".$qnbr; //TODO change to dashboard
			}
			break;
		case 'get-quote-details-print':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dbName, 'QUOTDET' => $qnbr, 'CUSTID' => $custID);
			$session->loc = $config->pages->print."quote/?qnbr=".$qnbr;
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
			$data = array('DBNAME' => $config->dbName, 'QUOTEHEAD' => false, 'QUOTENO' => $qnbr);
			$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr.$linkaddon;
			break;
		case 'add-to-quote':
			$qnbr = $input->post->text('qnbr');
			$itemid = $input->post->text('itemid');
			$qty = $input->post->text('qty');
			$data = array('DBNAME' => $config->dbName, 'QUOTEDETAIL' => false, 'QUOTNO' => $qnbr, 'ITEMID' => $itemid, 'QTY' => $qty);
			break;
		case 'update-line':
			$qnbr = $input->post->text('qnbr');
			$linenbr = $input->post->text('linenbr');
			$quotedetail = getquotelinedetail(session_id(), $qnbr, $linenbr, false);
			$quotedetail['price'] = $input->post->text('price');
			$quotedetail['discpct'] =  $input->post->text('discount');
			$quotedetail['qtyordered'] = $input->post->text('qty');
			$quotedetail['rshipdate'] = $input->post->text('rqst-date');
			$quotedetail['whse'] = $input->post->text('whse');

			$session->sql = edit_quoteline(session_id(), $qnbr, $linenbr, $quotedetail, true);
			$data = array('DBNAME' => $config->dbName, 'QUOTEDETAIL' => false, 'QUOTNO' => $qnbr, 'LINENO' => $linenbr);
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
			$data = array('UNLOCKING QUOTE' => '');
			$session->loc = $config->pages->customer.urlencode($custID)."/";
			if ($shipID != '') { $session->loc .= "shipto-".urlencode($shipID)."/"; }
			break;
		default:
			break;
	}

	writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);

 	exit;


	?>
