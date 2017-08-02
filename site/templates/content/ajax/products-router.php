<?php
	$qnbr = $input->get->text('qnbr');
	$title = '';
    $filteron = $input->urlSegment(3);
    switch ($filteron) {
        case 'item-search-results':
            $custID = $input->get->text('custID');
            $shipID = '';
            $include = $config->paths->content.'products/ajax/load/product-results/product-results.php';
			switch($input->urlSegment4) {
				case 'cart':
					break;
				case 'order':
					break;
				case 'quote':
					$title = 'Add item to quote # ' . $qnbr;
					break;
			}
            break;
        case 'non-stock':
            switch($input->urlSegment4) {
				default:
					//$include = $config->paths->content.'products/non-stock/non-stock-item-form.php';
					$modaltitle = 'Add Non-stock Item';
					$modalbody = $config->paths->content.'products/non-stock/non-stock-item-form.php';
					$include = $config->paths->content.'common/modals/include-ajax-modal-content.php';
					break;
            }
            break;

    }



	if ($config->ajax) {
		include ($include);
	} else {
		$modalbody = $include;
		include $config->paths->content."common/include-blank-page.php";
	}
?>
