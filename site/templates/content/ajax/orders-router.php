<?php
    $filteron = $input->urlSegment(3);
    if ($input->get->ordn) { $ordn = $input->get->text('ordn'); } else { $ordn = NULL; }
    switch ($filteron) {
        case 'cust':
            $custID = $sanitizer->text($input->urlSegment(4));
            $shipID = '';
            if ($input->urlSegment5) {
                if (strpos($input->urlSegment5, 'shipto') !== false) {
                    $shipID = str_replace('shipto-', '', $input->urlSegment5);
                }
            }
            $page->body = $config->paths->content.'customer/cust-page/orders/orders-panel.php';
            break;
        case 'salesrep':
            $page->body = $config->paths->content.'salesrep/orders/orders-panel.php';
            break;
		case 'search':
			$searchtype = $sanitizer->text($input->urlSegment(4));
			switch ($searchtype) {
				case 'cust':
					$custID = $input->get->text('custID');
					$shipID = $input->get->text('shipID');
					$page->body = $config->paths->content.'customer/cust-page/orders/order-search-form.php';
					$page->title = $modaltitle = "Searching through ".get_customer_name($custID)." orders";
					break;
				case 'salesrep':
					//FIX
					break;
			}
			break;
    }


    if ($config->ajax) {
		if ($config->modal) {
			$modalbody = $page->body;
			include $config->paths->content.'common/modals/include-ajax-modal.php';
		} else {
			include($page->body);
		}
        
    } else {
        $title = ''; $modalbody = $page->body;
        include $config->paths->content."common/include-blank-page.php";
    }


?>
