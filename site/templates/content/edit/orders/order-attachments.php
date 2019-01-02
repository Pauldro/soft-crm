<div class="text-center form-group hidden-xs">
	<div class="btn-group" role="group" aria-label="View Order Attachments">
		<!-- Notes Link -->
		<?php if ($order->has_notes()) : ?>
			<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, 0); ?>" class="btn btn-default load-notes" title="View and Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons" aria-hidden="true">&#xE0B9;</i> View and Create Order Notes
			</a>
		<?php else : ?>
			<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, 0); ?>" class="btn btn-default load-notes" title="Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons" aria-hidden="true">&#xE0B9;</i> Create Order Notes
			</a>
		<?php endif; ?>
		
		<!--  Documents Link -->
		<?php if ($order->has_documents()) : ?>
			<a href="<?= $orderpanel->generate_request_documentsURL($order); ?>" class="btn btn-primary load-sales-docs" title="View Documents" data-loadinto=".docs" data-focus=".docs" data-click="#documents-link">
				<i class="fa fa-file-text" aria-hidden="true"></i> Show Documents
			</a>
		<?php else : ?>
			<a href="#" class="btn btn-default" title="No Documents Found">
				<i class="fa fa-file-text" aria-hidden="true"></i> No Documents Found
			</a>
		<?php endif; ?>
		

		<?= $editorderdisplay->generate_loadtrackinglink($order); ?>
	</div>
</div>
<div class="text-center form-group hidden-sm hidden-md hidden-lg">
	<div class="btn-group-vertical" role="group" aria-label="View Order Attachments">
		<?php if ($order->has_notes()) : ?>
			<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, 0); ?>" class="btn btn-default load-notes" title="View and Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons" aria-hidden="true">&#xE0B9;</i> View and Create Order Notes
			</a>
		<?php else : ?>
			<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, 0); ?>" class="btn btn-default load-notes" title="Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons" aria-hidden="true">&#xE0B9;</i> Create Order Notes
			</a>
		<?php endif; ?>
		<!--  Documents Link -->
		<?php if ($order->has_documents()) : ?>
			<a href="<?= $orderpanel->generate_request_documentsURL($order, $detail); ?>" class="btn btn-default load-sales-docs" title="View Documents" data-loadinto=".docs" data-focus=".docs" data-click="#documents-link">
				<i class="fa fa-file-text" aria-hidden="true"></i>
			</a>
		<?php else : ?>
			<a href="#" class="btn btn-default" title="No Documents Found">
				<i class="fa fa-file-text" aria-hidden="true"></i>
			</a>
		<?php endif; ?>
		<?= $editorderdisplay->generate_loadtrackinglink($order); ?>
	</div>
</div>
