<?php
    $modal = false;
	$modalbody = false;
    switch ($input->urlSegment(3)) { //Parts of order to load
        case 'search-results':
            if ($input->get->q) {$q = $input->get->text('q'); $title = "Searching for '$q'";}
			switch ($input->urlSegment(4)) {
				case 'modal':
					$modal = true;
					$modalcontent = $config->paths->content."cust-information/forms/cust-search-form.php";
					break;
				default:
					$modalbody = $config->paths->content."cust-information/cust-search-results.php";
					break;
			}
            break;
        case 'item-search-results':
            $modalbody = $config->paths->content."cust-information/item-search-results.php";
            break;
		case 'ci-shiptos':
			$custID = $input->get->text('custID');
			$title = 'Viewing ' . get_customer_name($custID) . ' shiptos';
			$modalcontent = $config->paths->content."cust-information/cust-shiptos.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-shipto-info':
			$custID = $input->get->text('custID');
			$shipID = $input->get->text('shipID');
			$title = 'Viewing ' . get_customer_name($custID) . ' shipto ' . $shipID;
			$modalcontent = $config->paths->content."cust-information/cust-shipto-info.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-open-invoices':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Open Invoice Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-open-invoices-formatted.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-standing-orders':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Standing Orders Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-standing-orders.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-payment-history':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Payment History Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-payment-history-formatted.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-documents':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Documents';
			$modalcontent = $config->paths->content."cust-information/cust-documents.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-quotes':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Quote Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-quotes-formatted.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-contacts':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Contacts Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-contacts.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-contacts':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Contacts Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-contacts.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-credit':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Credit Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-credit.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ci-payments':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Credit Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-credit.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
        case 'ci-sales-orders':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Sales Order Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-sales-orders.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
        case 'ci-sales-history':
			$custID = $input->get->text('custID');
            if ($input->urlSegment4 == 'form') {
                $title = get_customer_name($custID) . ' Choose a Starting Date';
    			$modalbody = $config->paths->content."cust-information/forms/cust-sales-history-form.php";
            } else {
                $title = get_customer_name($custID) . ' Sales History Inquiry';
    			$modalcontent = $config->paths->content."cust-information/cust-sales-history.php";
            }

			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
        case 'ci-custpo':
			$custID = $input->get->text('custID');
			$title = get_customer_name($custID) . ' Customer PO Inquiry';
			$modalcontent = $config->paths->content."cust-information/cust-po.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
        default:
            $title = 'Search for a customer';
            if ($input->get->q) {$q = $input->get->text('q');}
            $modal = true;
            $modalbody = $config->paths->content."cust-information/forms/cust-search-form.php";
            break;

    }


	if ($modal) {
        $modaltitle = $title;
		if (!$modalbody) {
			$modalbody = $config->paths->content."item-information/modal-result.php";
		}
        include $config->paths->content."common/modals/include-ajax-modal.php";
    } else {
		if ($config->ajax) {
			include $modalbody;
		} else {
			$page->title = $title;
			$config->styles->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
			$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
			$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
			$config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
			$config->scripts->append($config->urls->templates.'scripts/ci/cust-functions.js');
			$config->scripts->append($config->urls->templates.'scripts/ci/cust-info.js');
			include $config->paths->content."common/include-blank-page.php";
		}

    }



 ?>
