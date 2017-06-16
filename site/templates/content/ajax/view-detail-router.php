<?php

    $detailtype = $input->urlSegment3; // CART || ORDER
    $linenbr = $sanitizer->text($input->get->line);
    switch ($detailtype) {
        case 'cart':
            $linedetail = getcartline(session_id(), $linenbr, false);
			$title = 'Details about line #' .$linenbr;
			$modalbody = $config->paths->content."view/details/view-order-details.php";
            break;
        case 'order':
            $ordn = $sanitizer->text($input->get->ordn);
            $linedetail = getorderlinedetail(session_id(), $ordn, $linenbr, false);
			$title = 'Details about line #' .$linenbr;
			$modalbody = $config->paths->content."view/details/view-order-details.php";
            break;
        case 'quote':
            $qnbr = $sanitizer->text($input->get->qnbr);
            $linedetail = getquotelinedetail(session_id(), $qnbr, $linenbr, false);
			$title = 'Details about line #' .$linenbr;
			$modalbody = $config->paths->content."view/details/view-quote-details.php";
            break;
    }



	$modaltitle = $title;
	include $config->paths->content."common/modals/include-add-item-modal.php";

?>
