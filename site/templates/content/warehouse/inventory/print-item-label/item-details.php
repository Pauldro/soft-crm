<table class="table table-condensed table-striped">
	<tr>
		<td>Item ID</td>
		<td><?= $item->itemid; ?></td>
	</tr>
	<?php if ($item->is_lotted() || $item->is_serialized()) : ?>
		<tr>
			<td><?= strtoupper($item->get_itemtypepropertydesc()); ?></td>
			<td><?= $item->get_itemidentifier(); ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Whse</td>
		<td><?= $whsesession->whseid; ?></td>
	</tr>
</table>
