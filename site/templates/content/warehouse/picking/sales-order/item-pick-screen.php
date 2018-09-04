<?php include "{$config->paths->content}warehouse/picking/sales-order/item.js.php"; ?>
<div>
	<h2>Head to <?= $pickitem->bin; ?></h2>
	<table class="table table-condensed table-striped">
		<tr>
			<td class="control-label">Order #</td> <td class="text-right"><?= $pickitem->ordn; ?></td>
		</tr>
		<tr>
			<td class="control-label">Bin #</td> <td class="text-right"><?= $pickitem->bin; ?></td>
		</tr>
		<tr>
			<td class="control-label">Item ID</td> <td class="text-right"><?= $pickitem->itemid; ?></td>
		</tr>
		<tr>
			<td class="control-label">Qty Needed</td> <td class="text-right"><?= $pickitem->qtyordered; ?></td>
		</tr>
		<tr>
			<td class="control-label">Qty In Cart</td> <td class="text-right"><?= $pickitem->get_pickedtotal(); ?></td>
		</tr>
		<tr class="<?= $pickitem->has_pickedtoomuch() ? 'bg-warning' : (($pickitem->has_qtyremaining()) ? '' : 'bg-success'); ?>">
			<td class="control-label">Qty Remaining</td> <td class="text-right"><?= $pickitem->get_qtyremaining(); ?></td>
		</tr>
	</table>
    <h3 class="text-center">Barcodes Scanned</h3>
	<?php $pickedbarcodes = $whsesession->get_orderpickeditems($pickitem->itemid); ?>
	<table class="table table-condensed table-striped">
		<tr>
			<th>Barcode</th>
			<th>Qty</th>
			<th class="text-center">Duplicate</th>
			<th class="text-center">Remove</th>
		</tr>
		<?php foreach ($pickedbarcodes as $pickedbarcode) : ?>
			<tr>
				<td><?= $pickedbarcode['barcode']; ?></td>
				<td class="text-right"><?= $pickedbarcode['qty']; ?></td>
				<td class="text-center">
					<a href="<?= $whsesession->generate_addbarcodeurl($pickitem, $pickedbarcode['barcode']); ?>" class="btn btn-sm btn-emerald">
						<i class="fa fa-repeat" aria-hidden="true"></i> Duplicate
					</a>
				</td>
				<td class="text-center">
					<a href="<?= $whsesession->generate_removebarcodeurl($pickitem, $pickedbarcode['barcode']); ?>" class="btn btn-sm btn-danger">
						<i class="fa fa-trash" aria-hidden="true"></i> Remove
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php if (DplusWire::wire('notices')->hasErrors()) : ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong>
			<?php foreach (DplusWire::wire('notices') as $notice) : ?>
				<?= $notice->text; ?><br>
			<?php endforeach; ?>
			<?= $session->removeNotices(); ?>
		</div>
	<?php endif; ?>
	<form action="<?= "{$config->pages->salesorderpicking}redir/"; ?>" method="POST" class="allow-enterkey-submit">
		<input type="hidden" name="action" value="add-barcode">
        <div class="input-group form-group">
            <input class="form-control" name="barcode" placeholder="Barcode" type="text" autofocus>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-emerald not-round">
					<i class="fa fa-plus" aria-hidden="true"></i> Add
				</button>
            </span>
        </div>
    </form>
	<a href="<?= $whsesession->generate_finishitemurl($pickitem); ?>" class="btn btn-emerald finish-item">
		<i class="fa fa-check-square" aria-hidden="true"></i> Submit Item
	</a>
	<a href="<?= $whsesession->generate_skipitemurl($pickitem); ?>" class="btn btn-emerald finish-item">
		<i class="fa fa-check-square" aria-hidden="true"></i> Skip Item
	</a>
</div>
