<?php
	if ($input->get->ordn) { $ordn = $input->get->text('ordn'); } else { $ordn = NULL; }
	if ($input->get->qnbr) { $qnbr = $input->get->text('qnbr'); } else { $qnbr = NULL; }

    $filteron = $input->urlSegment(3);
    switch ($filteron) {
        case 'dplus':
			$notetype = $sanitizer->text($input->urlSegment(4));
			switch ($notetype) {
				case 'order':
					$include = $config->paths->content.'notes/dplus/sales-order-notes.php';
					break;
				case 'quote':
					$include = $config->paths->content.'notes/dplus/quote-notes.php';
					break;
				case 'cart':
					$include = $config->paths->content.'notes/dplus/cart-notes.php';
					break;
			}
           break;
		case 'crm':
			$notetype = $sanitizer->text($input->urlSegment(4));
			$custID = ''; $shipID = ''; $contactID = ''; $ordn = ''; $qnbr = ''; $taskID = ''; $noteID = '';
			switch ($notetype) {
				case 'cust':
					$custID = $input->get->text('custID');
					if ($input->get->shipID) { $shipID = $input->get->text('shipID'); }
					if ($input->get->contactID) { $shipID = $input->get->text('contactID'); }
					if ($input->get->id) {
						if ($input->get->id == 'new') {
							if ($input->get->task) { $taskID = $sanitizer->text($input->get->task); }
							$include = $config->paths->content.'notes/crm/new-note.php';
						} else {
							$notetitle = "Viewing Note for " . get_customer_name($custID);
							$include = $config->paths->content."notes/crm/load/modal/read-note.php";
						}
					} else {
						$include = $config->paths->content.'customer/cust-page/notes/notes-panel.php';
					}
					break;
			}
			break;
    }



	if ($config->ajax) {
		include($include);
	} else {
		$modalbody = $include;
		$title = '';
		include $config->paths->content.'common/include-blank-page.php';
	}

?>
