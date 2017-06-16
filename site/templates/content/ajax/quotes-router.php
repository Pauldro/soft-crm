<?php
    $filteron = $input->urlSegment(3);
    switch ($filteron) {
        case 'cust':
            $custID = $sanitizer->text($input->urlSegment(4));
            $shipID = '';
            if ($input->urlSegment5) {
                if (strpos($input->urlSegment5, 'shipto') !== false) {
                    $shipID = str_replace('shipto-', '', $input->urlSegment5);
                }
            }
            $include = $config->paths->content.'customer/cust-page/quotes/quotes-panel.php';
            break;
        case 'salesrep':
            $include = $config->paths->content.'salesrep/orders/orders-panel.php'; //FIX
            break;
		case 'search':
			$include = $config->paths->content.'recent-orders/ajax/load/order-search-modal.php'; //FIX
			break;

    }

	if ($input->get->qnbr) { $qnbr = $input->get->text('qnbr'); } else { $qnbr = NULL; }
	
	if (!$config->ajax) {
        include($config->paths->templates.'_head.php'); // include header markup
        echo '<div class="container page">';
    }

    include($include);

    if (!$config->ajax) {
        echo '</div>';
    	include($config->paths->templates.'_foot.php'); // include footer markup
    }
?>
