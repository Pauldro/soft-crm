<div class="text-center form-group hidden-xs">
	<div class="btn-group" role="group" aria-label="View Order Attachments">
		<?php if ($order->has_notes()) : ?>
			<a href="<?= $editorderdisplay->generate_dplusnotesrequestURL($order, 0); ?>" class="btn btn-default load-notes" title="View and Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> View and Create Order Notes
			</a>
		<?php else : ?>
			<a href="<?= $editorderdisplay->generate_dplusnotesrequestURL($order, 0); ?>" class="btn btn-default load-notes" title="Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> Create Order Notes
			</a>
		<?php endif; ?>
		<?= $editorderdisplay->generate_loaddocumentslink($order); ?>
		<?= $editorderdisplay->generate_loadtrackinglink($order); ?>
	</div>
</div>
<div class="text-center form-group hidden-sm hidden-md hidden-lg">
	<div class="btn-group-vertical" role="group" aria-label="View Order Attachments">
		<?php if ($order->has_notes()) : ?>
			<a href="<?= $editorderdisplay->generate_dplusnotesrequestURL($order, 0); ?>" class="btn btn-default load-notes" title="View and Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> View and Create Order Notes
			</a>
		<?php else : ?>
			<a href="<?= $editorderdisplay->generate_dplusnotesrequestURL($order, 0); ?>" class="btn btn-default load-notes" title="Create Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> Create Order Notes
			</a>
		<?php endif; ?>
		<?= $editorderdisplay->generate_loaddocumentslink($order); ?>
		<?= $editorderdisplay->generate_loadtrackinglink($order); ?>
	</div>
</div>
