<?php
	$actionpanel->generate_filter($input);
	$salespersonjson = json_decode(file_get_contents($config->companyfiles."json/salespersontbl.json"), true);
	$salespersoncodes = array_keys($salespersonjson['data']);
	$paginator = new Paginator($actionpanel->pagenbr, $actionpanel->count, $actionpanel->generate_refreshurl(true), $actionpanel->generate_insertafter(), $actionpanel->ajaxdata);
?>
<div class="panel panel-primary not-round" id="<?= $actionpanel->panelid; ?>">
	<div class="panel-heading not-round" id="<?= $actionpanel->panelid.'-heading'; ?>">
		<a href="<?= '#'.$actionpanel->panelbody; ?>" class="panel-link" data-parent="<?= $actionpanel->panelid; ?>" data-toggle="collapse">
			<span class="glyphicon glyphicon-check"></span> &nbsp; <?= $actionpanel->generate_title(); ?> <span class="caret"></span>  &nbsp;&nbsp;<span class="badge"><?= $actionpanel->count; ?></span>
		</a>

		<?php if ($actionpanel->should_haveaddlink()) : ?>
			<?= $actionpanel->generate_addlink(); ?>
		<?php endif; ?>

		<span class="pull-right">&nbsp; &nbsp;&nbsp; &nbsp;</span>
		<?= $actionpanel->generate_refreshlink(); ?>
		<span class="pull-right"><?= $actionpanel->generate_pagenumberdescription(); ?> &nbsp; &nbsp;</span>
	</div>
	<div id="<?= $actionpanel->panelbody; ?>" class="<?= $actionpanel->collapse; ?>">
		<div>
			<div class="panel-body">
				<form action="<?= $actionpanel->pageurl->getUrl(); ?>" method="GET">
					<input type="hidden" name="filter" value="filter">
					<div class="row">
						<div class="col-sm-2 form-group">
							<h4>Action Type</h4>
							<?php $types = $pages->get('/config/actions/types/')->children(); ?>
							<?php foreach ($types as $type) : ?>
								<?php $checked = $actionpanel->has_filtervalue('actiontype', $type->name) ? 'checked' : ''; ?>
								<label><?= ucfirst($type->name); ?></label>
								<input class="pull-right" type="checkbox" name="actiontype[]" value="<?= $type->name; ?>" <?= $checked; ?>><br>
							<?php endforeach; ?>
						</div>
						<div class="col-sm-2 form-group">
							<?php if (!$user->hasrestrictions) : ?>
								<h4 id="actions-assignedto">Assigned To</h4>
								<select name="assignedto" class="selectpicker show-tick form-control input-sm" aria-labelledby="#actions-assignedto" data-style="btn-default btn-sm" multiple>
									<?php foreach ($salespersoncodes as $salespersoncode) : ?>
										<?php $selected = ($actionpanel->has_filtervalue('assignedto', $salespersonjson['data'][$salespersoncode]['splogin'])) ? 'selected' : ''; ?>
										<?php if (!empty($salespersonjson['data'][$salespersoncode]['splogin'])) : ?>
											<option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" <?= $selected; ?>><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							<?php endif; ?>
						</div>
						<div class="col-sm-2">
				            <h4>Date Created</h4>
							<?php $name = 'datecreated[]'; $value = $actionpanel->get_filtervalue('datecreated'); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
				            <label class="small text-muted">From Date </label>
							<?php $name = 'datecreated[]'; $value = $actionpanel->get_filtervalue('datecreated', 1); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
				            <label class="small text-muted">Through Date </label>
				        </div>
						<div class="col-sm-2">
				            <h4>Date Completed</h4>
							<?php $name = 'datecompleted[]'; $value = $actionpanel->get_filtervalue('datecompleted'); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
				            <label class="small text-muted">From Date </label>
							<?php $name = 'datecompleted[]'; $value = $actionpanel->get_filtervalue('datecompleted', 1); ?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
				            <label class="small text-muted">Through Date </label>
				        </div>
						<div class="col-sm-4 form-group">
							<label>Table Legend</label>
							<br>
							<?= $actionpanel->generate_legend(); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i> Apply Filter</button>
						</div>
						<div class="col-xs-6">
							<?php if ($input->get->filter) : ?>
								<a href="#" class="btn btn-sm btn-warning btn-block"><i class="fa fa-times" aria-hidden="true"></i> Clear Filter</a>
							<?php endif; ?>
						</div>
					</div>
				</form>
			</div>
			<div class="table-responsive">
				<?= $actionpanel->generate_actionstable(); ?>
			</div>
			<?= $paginator; ?>
		</div>
	</div>
</div>
<script>
	$(function() {
		<?php if (!empty($actionpanel->filters['assignedto'])) : ?>
			$('.selectpicker').selectpicker('val', <?= json_encode($actionpanel->filters['assignedto']); ?>);
		<?php endif; ?>
		
		$("body").on("click", "[name='actiontype[]']", function(e) {
			var checkbox = $(this);
			var form = checkbox.closest('form');
			if (checkbox.is(':checked')) {
				if (checkbox.val() == 'all') {
					form.find("[name='actiontype[]']").not("[value='all']").prop('checked', false);
				} else {
					form.find("[name='actiontype[]'][value='all']").prop('checked', false);
				}
			}
		});
	});
</script>
