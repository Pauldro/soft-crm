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
            $include = $config->paths->content.'customer/cust-page/orders/orders-panel.php';
            break;
        case 'salesrep':
            $include = $config->paths->content.'salesrep/orders/orders-panel.php';
            break;
		case 'search':
			$include = $config->paths->content.'recent-orders/ajax/load/order-search-modal.php';

			break;

    }


    if ($config->ajax) {
        include($include);
    } else {
        $title = ''; $modalbody = $include;
        include $config->paths->content."common/include-blank-page.php";
    }


?>
