<?php $quote = get_quotehead(session_id(), $qnbr, false); ?>
<div id="sales-order-details">
	<div class="form-group"><?php include $config->paths->content.'edit/quotes/quote-details/quote-details.php'; ?></div>
	<div class="text-center">
		<button class="btn btn-primary" data-toggle="modal" data-target="#add-item-modal" data-addtype="quote" data-qnbr="<?= $qnbr; ?>" data-custid="<?= $quote['custid']; ?>"  data-linenumber="<?= sizeof($quote_details) + 1; ?>">
			<span class="glyphicon glyphicon-plus"></span> Add Item
		</button>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-7"></div>
	    <div class="col-xs-6 col-sm-5">
	    	<table class="table-condensed table table-striped">
	        	<tr>
	        		<td>Subtotal</td>
	        		<td class="text-right">$ <?php echo formatmoney($quote['subtotal']); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Tax</td>
	        		<td class="text-right">$ <?php echo formatmoney($quote['salestax']); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Freight</td>
	        		<td class="text-right">$ <?php echo formatmoney($quote['freight']); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Misc.</td>
	        		<td class="text-right">$ <?php echo formatmoney($quote['miscellaneous']); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Total</td>
	        		<td class="text-right">$ <?php echo formatmoney($quote['order_total']); ?></td>
	        	</tr>
	        </table>
	    </div>
	</div>
</div>
