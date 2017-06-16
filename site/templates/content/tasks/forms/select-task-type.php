<?php foreach ($tasktypes as $tasktype) : ?>
	<button class="btn btn-default select-button-choice btn-sm" type="button" data-value="<?= $tasktype->value; ?>"><?= $tasktype->icon." ".$tasktype->label; ?></button>
<?php endforeach; ?>
<input type="hidden" class="select-button-value required" name="tasktype" value="">
