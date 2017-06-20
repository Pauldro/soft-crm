<?php
 	header('Content-Type: application/json');
    $ordn = $input->get->text('ordn');


	switch ($input->urlSegment3) {
		case 'orderhead':
			$order = get_orderhead(session_id(), $ordn, false);
			echo json_encode(array("response" => array("order" => $order)));
			break;
		case 'details':
			$orderdetails = getorderdetails(session_id(), $ordn, false);
    		echo json_encode(array("response" => array("orderdetails" => $orderdetails)));
			break;
	}
