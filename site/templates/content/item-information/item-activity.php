<?php
	$activityfile = $config->jsonfilepath.session_id()."-iiactivity.json";
	//$activityfile = $config->jsonfilepath."iiact-iiactivity.json";
	
	if ($config->ajax) {
		echo '<p>' . makeprintlink($config->filename, 'View Printable Version') . '</p>';
	}
?>

<?php if (file_exists($activityfile)) : ?>
	<?php $activityjson = json_decode(file_get_contents($activityfile), true); ?>
	<?php if (!$activityjson) {$activityjson = array('error' => true, 'errormsg' => 'The item activity JSON contains errors');} ?>
	<div>
		<?php if ($activityjson['error']) : ?>
			<div class="alert alert-warning" role="alert"><?php echo $activityjson['errormsg']; ?></div>
		<?php else : ?>
			<?php $columns = array_keys($activityjson['columns']); ?>
			<?php foreach($activityjson['data'] as $warehouse) : ?>
				<h3><?php echo $warehouse['Whse Name']; ?></h3>
				<table class="table table-striped table-bordered table-condensed table-excel">
					<thead>
						<?php foreach($activityjson['columns'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</thead>
					<tbody>
						<?php foreach($warehouse['orders'] as $order) : ?>
							<tr>
								<?php foreach($columns as $column) : ?>
									<td class="<?= $config->textjustify[$activityjson['columns'][$column]['datajustify']]; ?>"><?php echo $order[$column]; ?></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
