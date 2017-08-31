<?php $quote = get_quotehead(session_id(), $qnbr, false);  ?>
<div class="row">
	<div class="col-sm-6">
		<img src="<?php echo $config->urls->files."images/dplus.png"; ?>" alt="">
	</div>
	<div class="col-sm-6 text-right">
		<h1>Quote # <?php echo $qnbr; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-6"></div>

	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr> <td>Quote Date</td> <td><?php echo $quote['quotdate']; ?></td> </tr>
			<tr> <td>Review Date</td> <td><?php echo $quote['revdate']; ?></td> </tr>
			<tr> <td>Expire Date</td> <td><?php echo $quote['expdate']; ?></td> </tr>
			<tr> <td>CustID</td> <td><?php echo $quote['custid']; ?></td> </tr>
            <tr> <td>Terms Code</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>Tax</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>Sales Person</td> <td><?php // TODO ?></td> </tr>
			<tr> <td>Customer PO</td> <td><?php echo $quote['custpo']; ?></td> </tr>
            <tr> <td>Cust Ref</td> <td><?php // TODO  ?></td> </tr>
            <tr> <td>Ship Via</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>FOB</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>Delivery</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>Whse</td> <td><?php // TODO ?></td> </tr>
            <tr> <td>Care Of</td> <td><?php // TODO ?></td> </tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<h4>Bill-to</h4>
		<address>
			<?= $quote['btname']; ?><br>
			<?php echo $quote['btadr1']; ?><br>
			<?php if (strlen($quote['btadr2']) > 0) : ?>
				<?php echo $quote['btadr2']; ?><br>
			<?php endif; ?>
			<?php echo $quote['btcity'].", ".$quote['btstate']." ".$quote['btzip']; ?>
		</address>
	</div>
	<div class="col-sm-6">
		<h4>Ship-to</h4>
		<address>
			<?= $quote['stname']; ?><br>
			<?php echo $quote['stadr1']; ?><br>
			<?php if (strlen($quote['stadr2']) > 0) : ?>
				<?php echo $quote['stadr2']; ?><br>
			<?php endif; ?>
			<?php echo $quote['stcity'].", ".$quote['ststate']." ".$quote['stzip']; ?>
		</address>
	</div>
</div>
<table class="table table-bordered table-striped">
	 <tr class="detail item-header">
		<th class="text-center">Item ID/Cust Item ID</th>  <th class="text-right">Qty</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php  $details = get_quote_details(session_id(), $qnbr, false); ?>
	<?php foreach ($details as $detail) : ?>
		<?php $qtyo = $detail['ordrqty'] + 0; ?>
		<tr class="detail">
			<td class="text-center">
				<?php echo $detail['itemid']; ?>
                <?php if (strlen($detail['vendoritemid'])) { echo ' '.$detail['vendoritemid'];} ?>
                <br>
				<?php echo $detail['desc1']. ' ' . $detail['desc2'] ; ?>
			</td>
			<td class="text-right"> <?php echo $qtyo ; ?> </td>
			<td class="text-right">$ <?php echo formatmoney($detail['ordrprice']); ?></td>
			<td class="text-right">$ <?php echo formatmoney($detail['ordrprice'] * $qtyo) ?> </td>
            <td>
                <a href="<?= $config->pages->ajax."load/edit-detail/quote/?qnbr=".$detail['quotenbr']."&line=".$detail['linenbr']; ?>" class="btn btn-xs btn-warning update-line" data-line="<?= $detail['recno']; ?>" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"  data-custid="<?= $quote['custid']; ?>">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td> <td>Subtotal</td> <td></td> <td class="text-right">$ <?php echo formatmoney($quote['subtotal']); ?></td>

	</tr>
	<tr>
		<td></td><td>Tax</td> <td></td> <td colspan="2" class="text-right">$ <?php echo formatmoney($quote['salestax']); ?></td>

	</tr>
	<tr>
		<td></td><td>Freight</td> <td></td> <td class="text-right">$ <?php echo formatmoney($quote['freight']); ?></td>

	</tr>
	<tr>
		<td></td><td>Misc.</td> <td></td><td class="text-right">$ <?php echo formatmoney($quote['miscellaneous']); ?></td>

	</tr>
	<tr>
		<td></td><td>Total</td> <td></td> <td class="text-right">$ <?php echo formatmoney($quote['order_total']); ?></td>
	</tr>
</table>
