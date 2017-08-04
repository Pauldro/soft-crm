<?php
	$custID = $shipID = '';
    if ($input->post->action) { $action = $input->post->text('action'); } else { $action = $input->get->text('action'); }
	if ($input->post->itemid) { $itemid = $input->post->itemid; } else { $itemid = $input->get->text('itemid'); }

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
	*		ITEMID=$itemid
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
	*		ITEMID=$itemid
	*		CUSTID=$custID
	*		break;
	*	case 'ii-pricing':
	*		DBNAME=$config->DBNAME
	*		IIPRICE
	*		ITEMID=$itemid
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'ii-costing':
	*		DBNAME=$config->DBNAME
	*		IICOST
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-purchase-order':
	*		DBNAME=$config->DBNAME
	*		IIPURCHORDR
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-quotes':
	*		DBNAME=$config->DBNAME
	*		IIQUOTE
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-purchase-history':
	*		DBNAME=$config->DBNAME
	*		IIPURCHHIST
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-where-used':
	*		DBNAME=$config->DBNAME
	*		IIWHEREUSED
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-kit-components':
	*		DBNAME=$config->DBNAME
	*		IIKIT
	*		ITEMID=$itemid
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-item-bom':
	*		DBNAME=$config->DBNAME
	*		IIBOMSINGLE|IIBOMCONS
	*		ITEMID=$itemid
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-usage':
	*		DBNAME=$config->DBNAME
	*		IIUSAGE
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-notes':
	*		DBNAME=$config->DBNAME
	*		IINOTES
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-misc':
	*		DBNAME=$config->DBNAME
	*		IIMISC
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-general':
	*		//TODO replace ii-usage, ii-notes, ii-misc
	*		break;
	*	case 'ii-activity':
	*		DBNAME=$config->DBNAME
	*		IIACTIVITY
	*		ITEMID=$itemid
	*		DATE=$date
	*		break;
	*	case 'ii-requirements':
	*		DBNAME=$config->DBNAME
	*		IIREQUIRE
	*		ITEMID=$itemid
	*		WHSE=$whse
	*		REQAVL=REQ|AVL
	*		break;
	*	case 'ii-lot-serial':
	*		DBNAME=$config->DBNAME
	*		IILOTSER
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-sales-order':
	*		DBNAME=$config->DBNAME
	*		IISALESORDR
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-sales-history':
	*		DBNAME=$config->DBNAME
	*		IISALESHIST
	*		ITEMID=$itemid
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		DATE=$date
	*		break;
	*	case 'ii-stock':
	*		DBNAME=$config->DBNAME
	*		IISTKBYWHSE
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-substitutes':
	*		DBNAME=$config->DBNAME
	*		IISUB
	*		ITEMID=$itemid
	*		break;
	*	case 'ii-documents':
	*		DBNAME=$config->DBNAME
	*		DOCVIEW
	*		FLD1CD=IT
	*		FLD1DATA=$itemid
	*		FLD21DESC=$desc
	*		break;
	*	case 'ii-order-documents':
	*		DBNAME=$config->DBNAME
	*		DOCVIEW
	*		FLD1CD=SO
	*		FLD1DATA=$ordn
	*		FLD2CD=IT
	*		FLD2DATA=$itemid
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
			$data = array('DBNAME' => $config->dbName, 'IISELECT' => false, 'ITEMID' => $itemid);
			$session->loc = $config->pages->iteminfo."?itemid=".urlencode($itemid);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
            if ($custID != '') {$data['CUSTID'] = $custID; $session->loc .= "&custID=".urlencode($custID); }
			if ($shipID != '') {$data['SHIPID'] = $shipID; $session->loc .= "&shipID=".urlencode($shipID); }
            break;
        case 'item-info':
            if ($input->post->q) { $query = $input->post->q; } else { $query = $input->get->text('q'); }
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID == '') { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dbName, 'ITNOSRCH' => $query, 'ITEMID' => $itemid, 'CUSTID' => $custID);
            $session->loc = $config->page->index;
            break;
        case 'get-item-price':
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID == '') { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dbName, 'IIPRICING' => false, 'ITEMID' => $itemid, 'CUSTID' => $custID);
            $session->loc = $config->page->index;
            break;
		case 'ii-pricing': //II INFORMATION
			$data = array('DBNAME' => $config->dbName, 'IIPRICE' => false, 'ITEMID' => $itemid);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
			if ($custID != '') {$data['CUSTID'] = $custID; } if ($shipID != '') {$data['SHIPID'] = $shipID; }
			$session->loc = $config->page->index;
            break;
		case 'ii-costing':
			$data = array('DBNAME' => $config->dbName, 'IICOST' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-purchase-order':
			$data = array('DBNAME' => $config->dbName, 'IIPURCHORDR' => false, 'ITEMID' => $itemid);
			$session->loc = $config->page->index;
            break;
		case 'ii-quotes':
			$data = array('DBNAME' => $config->dbName, 'IIQUOTE' => false, 'ITEMID' => $itemid);
			if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
			if ($custID != '') {$data['CUSTID'] = $custID; }
            $session->loc = $config->page->index;
            break;
		case 'ii-purchase-history':
			$data = array('DBNAME' => $config->dbName, 'IIPURCHHIST' => false, 'ITEMID' => $itemid);
			$session->loc = $config->page->index;
            break;
		case 'ii-where-used':
			$data = array('DBNAME' => $config->dbName, 'IIWHEREUSED' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-kit-components':
			if ($input->post->qty) { $qty = $input->post->qty; } else { $qty = $input->get->text('qty'); }
			$data = array('DBNAME' => $config->dbName, 'IIKIT' => false, 'ITEMID' => $itemid, 'QTYNEEDED' => $qty);
            $session->loc = $config->page->index;
            break;
		case 'ii-item-bom':
            if ($input->post->qty) { $qty = $input->post->qty; } else { $qty = $input->get->text('qty'); }
            if ($input->post->bom) { $bom = $input->post->bom; } else { $bom = $input->get->text('bom'); }
            if ($bom == 'single') {
				$data = array('DBNAME' => $config->dbName, 'IIBOMSINGLE' => false, 'ITEMID' => $itemid, 'QTYNEEDED' => $qty);
            } elseif ($bom == 'consolidated') {
				$data = array('DBNAME' => $config->dbName, 'IIBOMCONS' => false, 'ITEMID' => $itemid, 'QTYNEEDED' => $qty);
            }
            $session->loc = $config->page->index;
            break;
		case 'ii-usage':
			$data = array('DBNAME' => $config->dbName, 'IIUSAGE' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
        case 'ii-notes':
			$data = array('DBNAME' => $config->dbName, 'IINOTES' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-misc':
			$data = array('DBNAME' => $config->dbName, 'IIMISC' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-general':
			//TODO replace ii-usage, ii-notes, ii-misc
			break;
		case 'ii-activity':
            $custID = $shipID = $date = '';
			$data = array('DBNAME' => $config->dbName, 'IIACTIVITY' => false, 'ITEMID' => $itemid);
            if ($input->post->date) { $date = $input->post->date; } else { $date = $input->get->text('date'); }
            if ($date != '') {$data['DATE'] = date('Ymd', strtotime($date)); }
			$session->loc = $config->page->index;
            break;
		case 'ii-requirements':
            if ($input->post->whse) { $whse = $input->post->whse; } else { $whse = $input->get->text('whse'); }
            if ($input->post->screentype) { $screentype = $input->post->screentype; } else { $screentype = $input->get->text('screentype'); }
            //screen type would be REQ or AVL
			$data = array('DBNAME' => $config->dbName, 'IIREQUIRE' => false, 'ITEMID' => $itemid, 'WHSE' => $whse, 'REQAVL' => $screentype);
            $session->loc = $config->page->index;
            break;
		case 'ii-lot-serial':
			$data = array('DBNAME' => $config->dbName, 'IILOTSER' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-sales-order':
			$data = array('DBNAME' => $config->dbName, 'IISALESORDR' => false, 'ITEMID' => $itemid);
			$session->loc = $config->page->index;
            break;
		case 'ii-sales-history':
            $date = '';
			$data = array('DBNAME' => $config->dbName, 'IISALESHIST' => false, 'ITEMID' => $itemid);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
			if ($input->post->date) { $date = $input->post->date; } else { $date = $input->get->text('date'); }
            if ($custID != '') {$data['CUSTID'] = $custID; } if ($shipID != '') {$data['SHIPID'] = $shipID; }
            if ($date != '') { $data['DATE'] = date('Ymd', strtotime($date)); }
            $session->loc = $config->page->index;
            break;
       case 'ii-stock':
			$data = array('DBNAME' => $config->dbName, 'IISTKBYWHSE' => false, 'ITEMID' => $itemid);
			$session->loc = $config->page->index;
            break;
        case 'ii-substitutes':
			$data = array('DBNAME' => $config->dbName, 'IISUB' => false, 'ITEMID' => $itemid);
            $session->loc = $config->page->index;
            break;
		case 'ii-documents':
			$desc = getitemdescription($itemid, false);
			$session->sql = getitemdescription($itemid, true);
			$data = array('DBNAME' => $config->dbName, 'DOCVIEW' => false, 'FLD1CD' => 'IT', 'FLD1DATA' => $itemid, 'FLD1DESC' => $desc);
            $session->loc = $config->page->index;
            break;
		case 'ii-order-documents':
			$ordn = $input->get->text('ordn');
			$data = array('DBNAME' => $config->dbName, 'DOCVIEW' => false, 'FLD1CD' => 'SO', 'FLD1DATA' => $ordn, 'FLD2CD' => 'IT', 'FLD2DATA' => $itemid);
            $session->loc = $config->page->index;
            break;
    }

    writedplusfile($data, $filename);
	header("location: /cgi-bin/" . $config->cgi . "?fname=" . $filename);
 	exit;
?>
