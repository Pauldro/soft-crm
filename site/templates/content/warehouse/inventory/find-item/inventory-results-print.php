<div>
	<h2 class="text-center"><?= $page->title; ?></h2>
	<?php if ($input->get->text('view') != 'pdf') : ?>
		<a href="<?= $page->parent->url."?binID=$binID"; ?>" class="btn btn-primary">
			<i class="fa fa-undo" aria-hidden="true"></i> Go Back
		</a>
		&nbsp; &nbsp;
		<button type="button" class="btn btn-primary" onclick="window.print()">
			<i class="fa fa-print" aria-hidden="true"></i> Print
		</button>
		<?php if (100 == 1) : ?>
			<a href="<?= $config->documentstorage.$pdfmaker->filename; ?>" class="btn btn-primary" target="_blank">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> View PDF
			</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php include __DIR__."/inventory-results-list.php"; ?>
</div>
