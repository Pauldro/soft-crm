<?php
	if ($input->get->day) {
		$day = $input->get->text('day');
	} else {
		$day = date('m/d/Y');
	}
?>
<div class="panel-body">
	<h3><?= date('l, M jS Y', strtotime($day)); ?></h3>
	<div class="row">
		<div class="col-sm-6">
			<?php if (date('m/d/Y', strtotime($day)) != date('m/d/Y')) : ?>
				<a href="<?= $actionpanel->generate_dayviewurl(date('m/d/Y')); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel"><b>Go to Today</b> <i class="glyphicon glyphicon-calendar"></i></a>
			<?php endif; ?>
			<a href="<?= $actionpanel->generate_calendarviewurl(); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel"><b>View Calendar</b></a> <i class="fa fa-calendar" aria-hidden="true"></i>
		</div>
		<div class="col-sm-6">
			<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#<?= $actionpanel->panelid.'-filter'; ?>" aria-expanded="false" aria-controls="<?= $actionpanel->panelid.'-filter'; ?>">
				Toggle Filter
			</button>
		</div>
	</div>
	<div class="<?= $input->get->filter ? '' : 'collapse'; ?> form-group" id="<?= $actionpanel->panelid.'-filter'; ?>">
		<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/day/search-form.php"; ?>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/day/tables/$actionpanel->actiontype.php"; ?>
		</div>
		<div class="col-sm-6">
			<h3>Overview</h3>
			<table class="table table-condensed table-striped table-bordered">
				<tr>
					<td>Notes Created</td> <td><?= $actionpanel->count_daynotes($day); ?></td>
				</tr>
				<tr>
					<td>Tasks Scheduled for <?= date('m/d/Y', strtotime($day)); ?></td> <td><?= $actionpanel->count_dayscheduledtasks($day); ?></td>
				</tr>
				<tr>
					<td>Tasks Completed</td> <td><?= $actionpanel->count_daycompletedtasks($day); ?></td>
				</tr>
				<tr>
					<td>Tasks Rescheduled</td> <td><?= $actionpanel->count_dayrescheduledtasks($day); ?></td>
				</tr>
			</table>
			<?= $actionpanel->count_dayrescheduledtasks($day, true); ?>
		</div>
	</div>
</div>
