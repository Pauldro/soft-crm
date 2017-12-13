<?php
	$datetypes = array('m/d/y' => 'MM/DD/YY', 'm/d/Y' => 'MM/DD/YYYY', 'm/d' => 'MM/DD', 'm/Y' => 'MM/YYYY')
?>
<div class="formatter-response">
	<div class="message"></div>
</div>

<form action="<?= $page->fullURL; ?>" method="POST" class="screen-formatter-form1">
    <input type="hidden" name="action" value="save-formatter">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><?php echo $page->title; ?></h3> </div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<div class="formatter-container">
					<div>
						<ul class="nav nav-tabs" role="tablist">
							<?php foreach ($tableformatter->datasections as $datasection => $label) : ?>
								<?php $class = ($datasection == key($tableformatter->datasections)) ? 'active' : ''; ?>
								<li role="presentation" class="<?= $class; ?>"><a href="#<?= $datasection; ?>" aria-controls="<?= $datasection; ?>" role="tab" data-toggle="tab"><?= $label; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($tableformatter->datasections as $datasection => $label) : ?>
								<?php $class = ($datasection == key($tableformatter->datasections)) ? 'active' : ''; ?>
								<div role="tabpanel" class="tab-pane <?= $class; ?>" id="<?= $datasection; ?>">
									<?php include $config->paths->content."item-information/screen-formatters/forms/table.php";  ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<button type="button" class="btn btn-info" onclick="preview_tableformatter('.screen-formatter-form')"><i class="fa fa-table" aria-hidden="true"></i> Preview Table</button>
	<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save Configuration</button>
</form>
