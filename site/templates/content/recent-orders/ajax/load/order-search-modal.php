<?php
	$searchtype = $sanitizer->text($input->urlSegment(4));
	switch ($searchtype) {
		case 'cust':
			$custID = $input->get->text('custID');
			$shipID = $input->get->text('shipID');
			$includefile = $config->paths->content.'customer/cust-page/orders/order-search-form.php';
			$modaltitle = "Searching through ".get_customer_name($custID)." orders";
			break;
		case 'salesrep':
			//FIX
			break;
	}
?>
<?php
	$custname = get_customer_name($custID);

?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="orders-search-modal-label"><?php echo $modaltitle; ?></h4>
</div>
<div class="modal-body">
	<?php include $includefile; ?>
</div>
