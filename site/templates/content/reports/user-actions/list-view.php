<div>
	<div class="form-group">
		<?php include __DIR__."/filter-form.php"; ?>
	</div>
	<div class="table-responsive">
		<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/list/tables/$actionpanel->actiontype.php"; ?>
	</div>
	<?= $paginator; ?>
</div>
