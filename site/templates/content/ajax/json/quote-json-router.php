<?php 
 	header('Content-Type: application/json');
    $qnbr = $input->get->text('qnbr');
    
	switch ($input->urlSegment3) {
		case 'quotehead':
			$quote = get_quotehead(session_id(), $qnbr, false);
			echo json_encode(array("response" => array("quote" => $quote)));
			break;
		case 'details': 
			$quotedetails = get_quote_details(session_id(), $qnbr, false);
    		echo json_encode(array("response" => array("quotedetails" => $quotedetails)));
			break;
	}