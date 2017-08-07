<?php
	$custID = $shipID = '';
    if ($input->post->action) { $action = $input->post->text('action'); } else { $action = $input->get->text('action'); }
	if ($input->post->itemID) { $itemID = $input->post->text('itemID'); } else { $itemID = $input->get->text('itemID'); }

	$filename = session_id();

	/**
	* PRODUCT REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'item-search':
	*		DBNAME=$config->DBNAME
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'ii-select':
	*		DBNAME=$config->DBNAME
	*		IISELECT
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'item-info':
	*		DBNAME=$config->DBNAME
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'get-item-price':
	*		DBNAME=$config->DBNAME
	*		IIPRICING
	*		ITEMID=$itemID
	*		CUSTID=$custID
	*		break;
	*	case 'ii-pricing':
	*		DBNAME=$config->DBNAME
	*		IIPRICE
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'ii-costing':
	*		DBNAME=$config->DBNAME
	*		IICOST
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-order':
	*		DBNAME=$config->DBNAME
	*		IIPURCHORDR
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-quotes':
	*		DBNAME=$config->DBNAME
	*		IIQUOTE
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-history':
	*		DBNAME=$config->DBNAME
	*		IIPURCHHIST
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-where-used':
	*		DBNAME=$config->DBNAME
	*		IIWHEREUSED
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-kit-components':
	*		DBNAME=$config->DBNAME
	*		IIKIT
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-item-bom':
	*		DBNAME=$config->DBNAME
	*		IIBOMSINGLE|IIBOMCONS
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-usage':
	*		DBNAME=$config->DBNAME
	*		IIUSAGE
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-notes':
	*		DBNAME=$config->DBNAME
	*		IINOTES
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-misc':
	*		DBNAME=$config->DBNAME
	*		IIMISC
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-general':
	*		//TODO replace ii-usage, ii-notes, ii-misc
	*		break;
	*	case 'ii-activity':
	*		DBNAME=$config->DBNAME
	*		IIACTIVITY
	*		ITEMID=$itemID
	*		DATE=$date
	*		break;
	*	case 'ii-requirements':
	*		DBNAME=$config->DBNAME
	*		IIREQUIRE
	*		ITEMID=$itemID
	*		WHSE=$whse
	*		REQAVL=REQ|AVL
	*		break;
	*	case 'ii-lot-serial':
	*		DBNAME=$config->DBNAME
	*		IILOTSER
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-order':
	*		DBNAME=$config->DBNAME
	*		IISALESORDR
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-history':
	*		DBNAME=$config->DBNAME
	*		IISALESHIST
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		DATE=$date
	*		break;
	*	case 'ii-stock':
	*		DBNAME=$config->DBNAME
	*		IISTKBYWHSE
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-substitutes':
	*		DBNAME=$config->DBNAME
	*		IISUB
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-documents':
	*		DBNAME=$config->DBNAME
	*		DOCVIEW
	*		FLD1CD=IT
	*		FLD1DATA=$itemID
	*		FLD21DESC=$desc
	*		break;
	*	case 'ii-order-documents':
	*		DBNAME=$config->DBNAME
	*		DOCVIEW
	*		FLD1CD=SO
	*		FLD1DATA=$ordn
	*		FLD2CD=IT
	*		FLD2DATA=$itemID
	*		break;
	* }
	*
	**/
    switch ($action) {
        case 'item-search':
            if ($input->post->q) { $query = $input->post->q; } else { $query = $input->get->text('q'); }
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID == '') { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dbName, 'ITNOSRCH' => $query, 'CUSTID' => $custID);
            $session->loc = $config->page->index;
            break;
		case 'ii-select':
			if ($session->iidate) { $session->remove('iidate'); }
			$data = array('DBNAME' => $config->dbName, 'IISELECT' => false, 'ITEMID' => $itemID);
			$session->loc = $config->pages->iteminfo."?itemID=".urlencode($itemID);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
            if ($custID != '') {$data['CUSTID'] = $custID; $session->loc .= "&custID=".urlencode($custID); }
			if ($shipID != '') {$data['SHIPID'] = $shipID; $session->loc .= "&shipID=".urlencode($shipID); }
            break;
        case 'item-info':
            if ($input->post->q) { $query = $input->post->q; } else { $query = $input->get->text('q'); }
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID == '') { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dbName, 'ITNOSRCH' => $query, 'ITEMID' => $itemID, 'CUSTID' => $custID);
            $session->loc = $config->page->index;
            break;
        case 'get-item-price':
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID == '') { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dbName, 'IIPRICING' => false, 'ITEMID' => $itemID, 'CUSTID' => $custID);
            $session->loc = $config->page->index;
            break;
		case 'ii-pricing': //II INFORMATION
			$data = array('DBNAME' => $config->dbName, 'IIPRICE' => false, 'ITEMID' => $itemID);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
			if ($custID != '') {$data['CUSTID'] = $custID; } if ($shipID != '') {$data['SHIPID'] = $shipID; }
			$session->loc = $config->page->index;
            break;
		case 'ii-costing':
			$data = array('DBNAME' => $config->dbName, 'IICOST' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-purchase-order':
			$data = array('DBNAME' => $config->dbName, 'IIPURCHORDR' => false, 'ITEMID' => $itemID);
			$session->loc = $config->page->index;
            break;
		case 'ii-quotes':
			$data = array('DBNAME' => $config->dbName, 'IIQUOTE' => false, 'ITEMID' => $itemID);
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID != '') {$data['CUSTID'] = $custID; }
            $session->loc = $config->page->index;
            break;
		case 'ii-purchase-history':
			$data = array('DBNAME' => $config->dbName, 'IIPURCHHIST' => false, 'ITEMID' => $itemID);
			$session->loc = $config->page->index;
            break;
		case 'ii-where-used':
			$data = array('DBNAME' => $config->dbName, 'IIWHEREUSED' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-kit-components':
			if ($input->post->qty) { $qty = $input->post->qty; } else { $qty = $input->get->text('qty'); }
			$data = array('DBNAME' => $config->dbName, 'IIKIT' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            $session->loc = $config->page->index;
            break;
		case 'ii-item-bom':
            if ($input->post->qty) { $qty = $input->post->qty; } else { $qty = $input->get->text('qty'); }
            if ($input->post->bom) { $bom = $input->post->bom; } else { $bom = $input->get->text('bom'); }
            if ($bom == 'single') {
				$data = array('DBNAME' => $config->dbName, 'IIBOMSINGLE' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            } elseif ($bom == 'consolidated') {
				$data = array('DBNAME' => $config->dbName, 'IIBOMCONS' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            }
            $session->loc = $config->page->index;
            break;
		case 'ii-usage':
			$data = array('DBNAME' => $config->dbName, 'IIUSAGE' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
        case 'ii-notes':
			$data = array('DBNAME' => $config->dbName, 'IINOTES' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-misc':
			$data = array('DBNAME' => $config->dbName, 'IIMISC' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-general':
			//TODO replace ii-usage, ii-notes, ii-misc
			break;
		case 'ii-activity':
            $custID = $shipID = $date = '';
			$data = array('DBNAME' => $config->dbName, 'IIACTIVITY' => false, 'ITEMID' => $itemID);
            if ($input->post->date) { $date = $input->post->date; } else { $date = $input->get->text('date'); }
            if ($date != '') {$data['DATE'] = date('Ymd', strtotime($date)); }
			$session->loc = $config->page->index;
            break;
		case 'ii-requirements':
            if ($input->post->whse) { $whse = $input->post->whse; } else { $whse = $input->get->text('whse'); }
            if ($input->post->screentype) { $screentype = $input->post->screentype; } else { $screentype = $input->get->text('screentype'); }
            //screen type would be REQ or AVL
			$data = array('DBNAME' => $config->dbName, 'IIREQUIRE' => false, 'ITEMID' => $itemID, 'WHSE' => $whse, 'REQAVL' => $screentype);
            $session->loc = $config->page->index;
            break;
		case 'ii-lot-serial':
			$data = array('DBNAME' => $config->dbName, 'IILOTSER' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-sales-order':
			$data = array('DBNAME' => $config->dbName, 'IISALESORDR' => false, 'ITEMID' => $itemID);
			$session->loc = $config->page->index;
            break;
		case 'ii-sales-history':
            $date = '';
			$data = array('DBNAME' => $config->dbName, 'IISALESHIST' => false, 'ITEMID' => $itemID);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
			if ($input->post->date) { $date = $input->post->date; } else { $date = $input->get->text('date'); }
            if ($custID != '') {$data['CUSTID'] = $custID; } if ($shipID != '') {$data['SHIPID'] = $shipID; }
            if ($date != '') { $data['DATE'] = date('Ymd', strtotime($date)); }
            $session->loc = $config->page->index;
            break;
       case 'ii-stock':
			$data = array('DBNAME' => $config->dbName, 'IISTKBYWHSE' => false, 'ITEMID' => $itemID);
			$session->loc = $config->page->index;
            break;
        case 'ii-substitutes':
			$data = array('DBNAME' => $config->dbName, 'IISUB' => false, 'ITEMID' => $itemID);
            $session->loc = $config->page->index;
            break;
		case 'ii-documents':
			$desc = getitemdescription($itemID, false);
			$session->sql = getitemdescription($itemID, true);
			$data = array('DBNAME' => $config->dbName, 'DOCVIEW' => false, 'FLD1CD' => 'IT', 'FLD1DATA' => $itemID, 'FLD1DESC' => $desc);
            $session->loc = $config->page->index;
            break;
		case 'ii-order-documents':
			$ordn = $input->get->text('ordn');
			$data = array('DBNAME' => $config->dbName, 'DOCVIEW' => false, 'FLD1CD' => 'SO', 'FLD1DATA' => $ordn, 'FLD2CD' => 'IT', 'FLD2DATA' => $itemID);
            $session->loc = $config->page->index;
            break;
    }

    writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);
 	exit;
?>
