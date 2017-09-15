<?php $lotserialfile = $config->jsonfilepath.session_id()."-iilotser.json"; ?>
<?php //$lotserialfile = $config->jsonfilepath."iilot-iilotser.json"; ?>

<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" class="h4" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>

<?php if (file_exists($lotserialfile)) : ?>
    <?php $lotserialjson = json_decode(file_get_contents($lotserialfile), true);  ?>
    <?php if (!$lotserialjson) { $lotserialjson = array('error' => true, 'errormsg' => 'The lot serial JSON contains errors');} ?>
    <?php if ($lotserialjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $lotserialjson['errormsg']; ?></div>
    <?php else : ?>
        <?php $columns = array_keys($lotserialjson['columns']); ?>
        <?php $array = array(); $count = 0;
            foreach ($lotserialjson['columns'] as $column) {
                if ($column['sortavailable'] == 'n') { $array[] = $count; }
                $count++;
            }
        ?>
		<table class="table table-striped table-bordered table-condensed table-excel" id="table">
			<thead>
				<tr>
					<?php foreach($lotserialjson['columns'] as $column) : ?>
						<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lotserialjson['data']['lots'] as $lot) : ?>
					<tr>
						<?php foreach($columns as $column) : ?>
							<td class="<?= $config->textjustify[$lotserialjson['columns'][$column]['datajustify']]; ?>"><?php echo $lot[$column]; ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ($config->ajax) : ?>
			<script>
				$(function() {
					$('#table').DataTable({
						pageLength: 15,
						columnDefs: [
							<?php foreach($array as $colnumber) : ?>
								{
									targets: [<?php echo $colnumber; ?>],
									orderable: false
								},
							<?php endforeach; ?>
						]
					});
				});
			</script>
   		<?php endif; ?>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
