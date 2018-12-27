<tr class="detail">
    <th colspan="2" class="text-center">Item ID</th>
    <th colspan="2">Description</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Ext Price</th>
    <th>Notes</th>
    <th></th>
    <th></th>
</tr>

<?php $details = $quotepanel->get_quotedetails($quote); ?>

<?php foreach ($details as $detail) : ?>
    <tr class="detail">
        <td colspan="2" class="text-center">
            <?= $quotepanel->generate_detailvieweditlink($quote, $detail); ?>
        </td>
        <td colspan="2">
            <?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid."<br>";} ?>
            <?= $detail->desc1; ?>
        </td>
        <td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice); ?></td>
        <td class="text-right"><?= intval($detail->quotqty); ?></td>
        <td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice * $detail->quotqty); ?></td>
        <td></td>
        <td>
            <?php if ($detail->has_notes()) : ?>
				<a href="<?= $quotepanel->generate_dplusnotesrequestURL($quote, $detail->linenbr); ?>" class="load-notes" title="View and Create Quote Notes" data-modal="<?= $quotepanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php else : ?>
				<a href="<?= $quotepanel->generate_dplusnotesrequestURL($quote, $detail->linenbr); ?>" class="load-notes text-muted" title="Create Quote Notes" data-modal="<?= $quotepanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php endif; ?>
        </td>
        <td></td>
    </tr>
<?php endforeach; ?>
