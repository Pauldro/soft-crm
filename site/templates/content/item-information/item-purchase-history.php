<?php
	//WAS item-purchase-history-formatted
	$historyfile = $config->jsonfilepath.session_id()."-iipurchhist.json";
	//$historyfile = $config->jsonfilepath."iish-iipurchhist.json";

	if (checkformatterifexists($user->loginid, 'ii-purchase-history', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ii-purchase-history', false), true);
	} else {
		$default = $config->paths->content."item-information/screen-formatters/default/ii-purchase-history.json";
		$defaultjson = json_decode(file_get_contents($default), true);
	}

	$detailcolumns = array_keys($defaultjson['detail']['columns']);
	$lotserialcolumns = array_keys($defaultjson['lotserial']['columns']);
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/iiphfmattbl.json"), true);

	$table = array(
				'maxcolumns' => $defaultjson['cols'],
				'detail' => array('maxrows' => $defaultjson['detail']['rows'], 'rows' => array()),
				'lotserial' => array('maxrows' => $defaultjson['lotserial']['rows'], 'rows' => array())
				  );


	for ($i = 1; $i < $defaultjson['detail']['rows'] + 1; $i++) {
		$table['detail']['rows'][$i] = array('columns' => array());
		foreach($detailcolumns as $column) {
			if ($defaultjson['detail']['columns'][$column]['line'] == $i) {
				$table['detail']['rows'][$i]['columns'][$defaultjson['detail']['columns'][$column]['column']] = array('id' => $column, 'label' => $defaultjson['detail']['columns'][$column]['label'], 'column' => $defaultjson['detail']['columns'][$column]['column'], 'col-length' => $defaultjson['detail']['columns'][$column]['col-length'], 'before-decimal' => $defaultjson['detail']['columns'][$column]['before-decimal'], 'after-decimal' => $defaultjson['detail']['columns'][$column]['after-decimal'], 'date-format' => $defaultjson['detail']['columns'][$column]['date-format']);
			}
		}
	}

	for ($i = 1; $i < $defaultjson['lotserial']['rows'] + 1; $i++) {
		$table['lotserial']['rows'][$i] = array('columns' => array());
		foreach($lotserialcolumns as $column) {
			if ($defaultjson['lotserial']['columns'][$column]['line'] == $i) {
				$table['lotserial']['rows'][$i]['columns'][$defaultjson['lotserial']['columns'][$column]['column']] = array('id' => $column, 'label' => $defaultjson['lotserial']['columns'][$column]['label'], 'column' => $defaultjson['lotserial']['columns'][$column]['column'], 'col-length' => $defaultjson['lotserial']['columns'][$column]['col-length'], 'before-decimal' => $defaultjson['lotserial']['columns'][$column]['before-decimal'], 'after-decimal' => $defaultjson['lotserial']['columns'][$column]['after-decimal'], 'date-format' => $defaultjson['lotserial']['columns'][$column]['date-format']);
			}
		}
	}


?>
<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" class="h4" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>

<?php if (file_exists($historyfile)) : ?>
    <?php $historyjson = json_decode(file_get_contents($historyfile), true);  ?>
    <?php if (!$historyjson) { $historyjson = array('error' => true, 'errormsg' => 'The Purchase History JSON contains errors');} ?>

    <?php if ($historyjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $historyjson['errormsg']; ?></div>
    <?php else : ?>
      	<?php foreach ($historyjson['data'] as $whse) : ?>
      		<div>
      			<h3><?= $whse['Whse Name']; ?></h3>
      			<?php include $config->paths->content."/item-information/tables/purchase-history-formatted.php"; ?>
      		</div>
      	<?php endforeach; ?>

     	<script>
			$(function() {
				<?php foreach ($historyjson['data'] as $whse) : ?>
					<?php if ($whse != $historyjson['data']['zz'] && $defaultjson['detail']['rows'] < 2) : ?>
						//$('<?= '#'.$whse['Whse Name']; ?>').DataTable();
					<?php endif; ?>
				<?php endforeach; ?>
			});

		</script>
    <?php endif; ?>

<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
