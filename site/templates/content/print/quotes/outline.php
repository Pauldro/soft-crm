<div class="row">
	<div class="col-xs-6">
		<img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->companydisplayname.' logo'; ?>">
	</div>
	<div class="col-xs-6 text-right">
		<h1>Quote # <?= $quote->quotnbr; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<?= $pages->get('/config/')->print_address; ?>
		<?php if (!$input->get->print) : ?>
			<a href="<?= $emailurl->getUrl(); ?>" class="btn btn-primary load-into-modal hidden-print" data-modal="#ajax-modal"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> Send as Email</a>
		<?php endif; ?>
	</div>

	<div class="col-xs-6">
		<table class="table table-bordered table-striped table-condensed small">
			<tr> <td>Quote Date</td> <td><?= $quote->quotdate; ?></td> </tr>
			<tr> <td>Expire Date</td> <td><?= $quote->expdate; ?></td> </tr>
			<tr><td>Customer ID</td> <td><?= $quote->custid; ?></td></tr>
			<tr> <td>Customer PO</td> <td><?= $quote->custpo; ?></td> </tr>
			<tr><td>Shipping Method</td> <td><?= $quote->shipviadesc; ?></td></tr>
			<tr><td>Payment Terms</td> <td><?= $quote->termcodedesc; ?></td></tr>
			<tr><td>Salesperson</td> <td><?= $quote->sp1name; ?></td></tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<div class="address-header"><h4>Bill To </h4></div>
		<address>
			<?= $quote->billname; ?><br>
			<?= $quote->billaddress; ?><br>
			<?php if (strlen($quote->billaddress2) > 0) : ?>
				<?= $quote->billaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->billcity.", ".$quote->billstate." ".$quote->billzip; ?>
		</address>
	</div>
	<div class="col-xs-6">
		<div class="address-header"><h4>Ship To </h4></div>
		<address>
			<?php if (strlen($quote->shipname) > 0) : ?>
				<?= $quote->shipname; ?><br>
			<?php endif; ?>
			<?= $quote->shipaddress; ?><br>
			<?php if (strlen($quote->shipaddress2) > 0) : ?>
				<?= $quote->shipaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->shipcity.", ".$quote->shipstate." ".$quote->shipzip; ?>
		</address>
	</div>
</div>
<table class="table table-bordered table-striped table-condensed small">
	 <tr class="detail item-header">
		 <th class="text-right">Qty</th>
		<th class="text-center">Item</th>
		<th class="text-center">Description</th>
		<th class="text-center">U/M</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php $details = $quotedisplay->get_quotedetails($quote); ?>
	<?php foreach ($details as $detail) : ?>
		<tr class="detail">
			<td class="text-right"> <?= intval($detail->quotqty); ?> </td>
			<td class="text-center"><?= $detail->itemid; ?></td>
			<td><?= $detail->desc1; ?></td>
			<td><?=$detail->uom; ?></td>
			<td class="text-right">$ <?= formatmoney($detail->quotprice); ?></td>
			<td class="text-right">$ <?= formatmoney($detail->quotprice * intval($detail->quotqty)) ?> </td>
		</tr>
	<?php endforeach; ?>
	<tr class="first-txn-row">
		<td></td> <td><b>Subtotal</b></td> <td></td> <td></td> <td colspan="2" class="text-right">$ <?= formatmoney($quote->subtotal); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Tax</b></td> <td></td> <td></td> <td colspan="2" class="text-right">$ <?= formatmoney($quote->salestax); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Freight</b></td> <td></td> <td></td> <td colspan="2"  class="text-right">$ <?= formatmoney($quote->freight); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Misc.</b></td> <td></td> <td></td> <td colspan="2"  class="text-right">$ <?= formatmoney($quote->misccost); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Total</b></td> <td></td> <td></td> <td colspan="2"  class="text-right">$ <?= formatmoney($quote->ordertotal); ?></td>
	</tr>
</table>
