<?php 
	header('Content-Type: application/json'); 
	$ordn = $input->get->text('ordn');
	$order = SalesOrderOEHead::load($ordn);
	echo json_encode(array("response" => array("order" => $order->_toArray())));
