<?php
	if ($input->get->ordn) { $ordn = $input->get->text('ordn'); } else { $ordn = NULL; }
	if ($input->get->qnbr) { $qnbr = $input->get->text('qnbr'); } else { $qnbr = NULL; }
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

    }

	

	if ($config->ajax) {
		include($include);
	} else {
		
		$modalbody = $include;
		include $config->paths->content."common/include-blank-page.php";
	}
?>


