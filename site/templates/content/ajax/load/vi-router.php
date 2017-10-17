<?php
    $shipID = '';
    switch ($input->urlSegment(2)) {
        case 'vi-openinv':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Open Invoices';
            $page->body = $config->paths->content."vend-information/vend-open-invoices.php";
            break;
        case 'vi-payment':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Payment';
            $page->body = $config->paths->content."vend-information/payment-history.php";
            break;
        case 'vi-shipfrom':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Ship-From Information';
            $page->body = $config->paths->content."vend-information/vend-shipfrom.php";
            break;
        default:
            $page->title = 'Search for a customer';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."cust-information/forms/cust-search-form.php";
            break;
    }

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		$config->styles->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
		$config->scripts->append(hashtemplatefile('scripts/libs/datatables.js'));
		$config->scripts->append(hashtemplatefile('scripts/ci/cust-functions.js'));
		$config->scripts->append(hashtemplatefile('scripts/ci/cust-info.js'));
		include $config->paths->content."common/include-blank-page.php";
	}




 ?>
