<?php 
	include "{$config->paths->content}warehouse/session.js.php"; 
	$itemuoms = BarcodedItem::find_distinct_unitofmeasure($item->itemid);
?>
<div>
	<form action="<?= $config->pages->menu_inventory."redir/"; ?>" method="POST" class="physical-count-form">
		<input type="hidden" name="action" value="physical-count">
		<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
		<input type="hidden" name="itemID" value="<?= $item->itemid; ?>">
		<input type="hidden" name="<?= $item->get_itemtypeproperty(); ?>" value="<?= $item->get_itemidentifier(); ?>">
		<input type="hidden" name="binID" value="<?= $binID; ?>">
		
		<table class="table table-striped">
			<tr>
				<td>Bin</td>
				<td><?= $binID; ?></td>
			</tr>
			<tr>
				<td>Item</td>
				<td><?= $item->get_itemidentifier(); ?></td>
			</tr>
			<tr>
				<td>Item ID</td>
				<td colspan="2"><?= $item->itemid; ?></td>
			</tr>
			<tr>
				<td>Item Description</td>
				<td><?= $item->desc1; ?></td>
			</tr>
			<?php if ($item->is_lotted() || $item->is_serialized()) : ?>
				<tr>
					<td><?= strtoupper($item->get_itemtypepropertydesc()); ?></td>
					<td><?= $item->get_itemidentifier(); ?></td>
				</tr>
			<?php endif; ?>
		</table>
		<table class="table table-striped">
			<tr>
				<td>Unit of Measure</td>
				<td>UoM Qty</td>
				<td>Count Qty</td>
				<td>Total Qty</td>
			</tr>
			<?php foreach ($itemuoms as $itemuom) : ?>
				<tr class="uom-row">
					<td data-uom="<?= $itemuom->uom; ?>"><?= $itemuom->uom; ?></td>
					<td data-unitqty="<?= $itemuom->unitqty; ?>"><?= $itemuom->unitqty; ?></td>
					<td>
						<input type="number" class="form-control input-sm text-right uom-value" name="<?= strtolower($itemuom->uom)."-qty"; ?>" value="0">
					</td>
					<td class="uom-total-qty text-right">0</td>
				</tr>
			<?php endforeach; ?>
			<tr class="bg-info">
				<td></td>
				<td></td>
				<td class="text-center">Total</td>
				<td class="text-right physical-count-total">0</td>
			</tr>
		</table>
		<button class="btn btn-sm not-round btn-emerald"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
	</form>
</div>
