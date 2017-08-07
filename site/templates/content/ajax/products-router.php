<?php
	$qnbr = $input->get->text('qnbr');
    $filteron = $input->urlSegment(3);
    switch ($filteron) {
        case 'item-search-results':
            $custID = $input->get->text('custID');
            $shipID = $input->get->text('shipID');
            $page->body = $config->paths->content.'products/ajax/load/product-results/product-results.php';
			switch($input->urlSegment4) {
				case 'cart':
					break;
				case 'order':
					break;
				case 'quote':
					$page->title = 'Add item to quote # ' . $qnbr;
					break;
			}
            break;
        case 'non-stock':
            switch($input->urlSegment4) {
				default:
					$page->title  = 'Add Non-stock Item';
					$page->body = $config->paths->content.'products/non-stock/non-stock-item-form.php';
					break;
            }
            break;
    }


	if ($config->ajax) {
		if ($config->modal) {
			$modaltitle = $page->title;
			$modalbody = $page->body;
			include $config->paths->content.'common/modals/include-ajax-modal.php';
		} else {
			include($page->body);
		}

    } else {
        $title = $page->title; $modalbody = $page->body;
        include $config->paths->content."common/include-blank-page.php";
    }
?>
