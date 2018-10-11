<tr>
	<th>Detail</th>
	<th>
		<a href="<?= $orderpanel->generate_tablesortbyurl("ordernumber") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order # <?= $orderpanel->tablesorter->generate_sortsymbol('ordernumber'); ?>
		</a>
	</th>
	<th> Customer </th>
	<th>
		<a href="<?= $orderpanel->generate_tablesortbyurl("custpo") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Customer PO: <?= $orderpanel->tablesorter->generate_sortsymbol('custpo'); ?>
		</a>
	</th>
	<th>Ship-To</th>
	<th>
		<a href="<?= $orderpanel->generate_tablesortbyurl("total_order") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Totals <?= $orderpanel->tablesorter->generate_sortsymbol('total_order'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_tablesortbyurl("order_date") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Date: <?= $orderpanel->tablesorter->generate_sortsymbol('order_date'); ?>
		</a>
	 </th>
	 <th class="text-center">
		<a href="<?= $orderpanel->generate_tablesortbyurl("status") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Status: <?= $orderpanel->tablesorter->generate_sortsymbol('status'); ?>
		</a>
	 </th>
	 <th colspan="3">
		<?= $orderpanel->generate_iconlegend(); ?>
		<?php if (isset($input->get->orderby)) : ?>
			<?= $orderpanel->generate_clearsortlink(); ?>
		<?php endif; ?>
	</th>
</tr>
