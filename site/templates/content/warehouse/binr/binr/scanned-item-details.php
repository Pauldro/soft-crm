<table class="table table-condensed table-striped">
	<tr>
		<td>Item</td>
		<td><?= $item->get_itemidentifier(); ?></td>
	</tr>
	<tr>
		<td>Item ID</td>
		<td> <?= $item->itemid; ?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?= $item->desc1; ?></td>
	</tr>
	<?php if (!empty($item->desc2)) : ?>
		<tr>
			<td></td>
			<td><?= $item->desc2; ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Origin</td>
		<td><?= strtoupper($item->xorigin); ?></td>
	</tr>
	<tr>
		<td>X-ref Item ID</td>
		<td><?= $item->xitemid; ?></td>
	</tr>
</table>
