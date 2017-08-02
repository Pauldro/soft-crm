<?php
    $edittype = $input->urlSegment3; // CART || SALE
    $linenbr = $sanitizer->text($input->get->line);
    switch ($edittype) {
        case 'cart':
            $linedetail = getcartline(session_id(), $linenbr, false);
            $title = 'Edit Pricing for '. $linedetail['itemid'];
            $custID = getcartcustomer(session_id(), false);
            $formaction = $config->pages->cart."redir/";
            $linedetail['can-edit'] = true;
            $ordn = '';
			$body = $config->paths->content."edit/pricing/edit-pricing-form.php";
            break;
        case 'order':
            $ordn = $input->get->text('ordn');
            $custID = get_custid_from_order(session_id(), $ordn);
            $linedetail = getorderlinedetail(session_id(), $ordn, $linenbr, false);
            if (caneditorder(session_id(), $ordn, false) && $ordn == getlockedordn(session_id())) {
                $linedetail['can-edit'] = true;
                $formaction = $config->pages->orders."redir/";
                $title = 'Edit Pricing for '. $linedetail['itemid'];
            } else {
                $linedetail['can-edit'] = false;
                $formaction = '';
                $title = 'Viewing Details for '. $linedetail['itemid'];
            }
			$body = $config->paths->content."edit/pricing/edit-pricing-form.php";
            break;
		case 'quote':
			$qnbr = $input->get->text('qnbr');
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$linedetail = get_quoteline(session_id(), $qnbr, $linenbr, false);
			$formaction = $config->pages->quotes."redir/";
            $title = 'Edit Pricing for '. $linedetail['itemid'];
            $linedetail['can-edit'] = true;
			$body = $config->paths->content."edit/pricing/quotes/edit-pricing-form.php";
    }
	if ($config->ajax) {
		$modalbody = $body;
		$modaltitle = $title;
		include $config->paths->content."common/modals/include-add-item-modal.php";
	} else {
		$page->title = $title;
		$modalbody = $body;
		include $config->paths->content."common/include-blank-page.php";
	}


?>
