<?php include __DIR__."/item-form.php"; ?>
<?php if ($resultscount > 0) : ?>
	<div class="form-group">
		<a href="<?= $page->url; ?>" class="btn btn-primary not-round">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Return to Item Inquiry
		</a>
		&nbsp; &nbsp;
		<a href="<?= $page->child('template=warehouse-print')->url."?scan=$scan"; ?>" class="btn btn-primary not-round">
			<i class="fa fa-print" aria-hidden="true"></i> View Printable List
		</a>
	</div>
<?php endif; ?>
<?php include __DIR__."/inventory-results-list.php"; ?>
