<?php
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
				<div class="row">
					<div class="col-xs-4">
						<label for="">Change Action Type</label>
						<?php $types = $pages->get('/activity/')->children(); ?>
                        <select class="form-control input-sm change-action-type" data-link="<?= $actionpanel->generate_refreshurl(); ?>" <?= $actionpanel->ajaxdata; ?>>
                            <?php $types = $pages->get('/activity/')->children(); ?>
                            <?php foreach ($types as $type) : ?>
								<?php $selected = ($type->name == $actionpanel->actiontype) ? 'selected' : ''; ?>
									<option value="<?= $type->name; ?>" <?= $selected; ?>><?= ucfirst($type->name); ?></option>
                            <?php endforeach; ?>
                        </select>
					</div>
					<div class="col-xs-4">
						<?php if (!$user->hasrestrictions) : ?>
							<label>Change User</label>
							<select class="form-control input-sm change-actions-user" data-link="<?= $actionpanel->generate_refreshurl(true); ?>" <?= $actionpanel->ajaxdata; ?>>
								<?php foreach ($salespersoncodes as $salespersoncode) : ?>
									<?php if ($salespersonjson['data'][$salespersoncode]['splogin'] == $actionpanel->assigneduserID) : ?>
										<option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" selected><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
									<?php else : ?>
										<option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>"><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
									<?php endif; ?>
                                <?php endforeach; ?>
							</select>
						<?php endif; ?>
					</div>
				</div>
            </div>
             <?php include $config->paths->content.'pagination/ajax/pagination-start-no-form.php'; ?>
             <?php //include $config->paths->content.'actions/'.$actionpanel->actiontype.'/lists/'.$actionpanel::$type.'-list.php'; ?>
			 <?= $actionpanel->generate_actiontable(); ?>
             <?= $paginator; ?>
        </div>
    </div>
</div>
