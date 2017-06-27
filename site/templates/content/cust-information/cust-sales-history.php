<?php

	include_once $config->paths->assets."classes/Table.php";
	include_once $config->paths->content."item-information/functions/ii-functions.php";
	$salesfile = $config->jsonfilepath.session_id()."-cisaleshist.json";
	//$salesfile = $config->jsonfilepath."cishist-cisaleshist.json";



	if (checkformatterifexists($user->loginid, 'ci-sales-history', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ci-sales-history', false), true);
	} else {
		$default = $config->paths->content."cust-information/screen-formatters/default/ci-sales-history.json";
		$defaultjson = json_decode(file_get_contents($default), true);
	}

	$detailcolumns = array_keys($defaultjson['detail']['columns']);
	$headercolumns = array_keys($defaultjson['header']['columns']);
	$lotserialcolumns = array_keys($defaultjson['lotserial']['columns']);

	$totalcolumns = array_keys($defaultjson['total']['columns']);
	$shipmentcolumns = array_keys($defaultjson['shipments']['columns']);

	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/cishfmattbl.json"), true);

	$table = array(
				'maxcolumns' => $defaultjson['cols'],
				'header' => array('maxrows' => $defaultjson['header']['rows'], 'rows' => array()),
				'detail' => array('maxrows' => $defaultjson['detail']['rows'], 'rows' => array()),
				'lotserial' => array('maxrows' => $defaultjson['lotserial']['rows'], 'rows' => array()),
				'total' => array('maxrows' => $defaultjson['total']['rows'], 'rows' => array()),
				'shipments' => array('maxrows' => $defaultjson['shipments']['rows'], 'rows' => array()),
				  );

	for ($i = 1; $i < $defaultjson['detail']['rows'] + 1; $i++) {
		$table['detail']['rows'][$i] = array('columns' => array());
		$count = 1;
		foreach($detailcolumns as $column) {
			if ($defaultjson['detail']['columns'][$column]['line'] == $i) {
				$table['detail']['rows'][$i]['columns'][$defaultjson['detail']['columns'][$column]['column']] = array(
																												'id' => $column,
																												'label' => $defaultjson['detail']['columns'][$column]['label'],
																												'column' => $defaultjson['detail']['columns'][$column]['column'],
																												'col-length' => $defaultjson['detail']['columns'][$column]['col-length'],
																												'before-decimal' => $defaultjson['detail']['columns'][$column]['before-decimal'],
																												'after-decimal' => $defaultjson['detail']['columns'][$column]['after-decimal'],
																												'date-format' => $defaultjson['detail']['columns'][$column]['date-format']
																												);
				$count++;
			}
		}
	}

	for ($i = 1; $i < $defaultjson['header']['rows'] + 1; $i++) {
		$table['header']['rows'][$i] = array('columns' => array());
		foreach($headercolumns as $column) {
			if ($defaultjson['header']['columns'][$column]['line'] == $i) {
				$table['header']['rows'][$i]['columns'][$defaultjson['header']['columns'][$column]['column']] = array(
																													'id' => $column,
																													'label' => $defaultjson['header']['columns'][$column]['label'],
																													'column' => $defaultjson['header']['columns'][$column]['column'],
																													'col-length' => $defaultjson['header']['columns'][$column]['col-length'],
																													'before-decimal' => $defaultjson['header']['columns'][$column]['before-decimal'],
																													'after-decimal' => $defaultjson['header']['columns'][$column]['after-decimal'],
																													'date-format' => $defaultjson['header']['columns'][$column]['date-format']
																												);
			}
		}
	}

	foreach ($lotserialcolumns as $column) {
		$table['lotserial']['rows'][1]['columns'][$defaultjson['lotserial']['columns'][$column]['column']] = array(
														'id' => $column,
														'label' => $defaultjson['lotserial']['columns'][$column]['label'],
														'column' => $defaultjson['lotserial']['columns'][$column]['column'],
														'col-length' => $defaultjson['lotserial']['columns'][$column]['col-length'],
														'before-decimal' => $defaultjson['lotserial']['columns'][$column]['before-decimal'],
														'after-decimal' => $defaultjson['lotserial']['columns'][$column]['after-decimal'],
														'date-format' => $defaultjson['lotserial']['columns'][$column]['date-format']
													);

	}


	for ($i = 1; $i < $defaultjson['total']['rows'] + 1; $i++) {
		$table['total']['rows'][$i] = array('columns' => array());
		$count = 1;
		foreach($totalcolumns as $column) {
			if ($defaultjson['total']['columns'][$column]['line'] == $i) {
				$table['total']['rows'][$i]['columns'][$defaultjson['total']['columns'][$column]['column']] = array(
																												'id' => $column,
																												'label' => $defaultjson['total']['columns'][$column]['label'],
																												'column' => $defaultjson['total']['columns'][$column]['column'],
																												'col-length' => $defaultjson['total']['columns'][$column]['col-length'],
																												'before-decimal' => $defaultjson['total']['columns'][$column]['before-decimal'],
																												'after-decimal' => $defaultjson['total']['columns'][$column]['after-decimal'],
																												'date-format' => $defaultjson['total']['columns'][$column]['date-format']
																												);
				$count++;
			}
		}
	}

	for ($i = 1; $i < $defaultjson['shipments']['rows'] + 1; $i++) {
		$table['shipments']['rows'][$i] = array('columns' => array());
		$count = 1;
		foreach($shipmentcolumns as $column) {
			if ($defaultjson['shipments']['columns'][$column]['line'] == $i) {
				$table['shipments']['rows'][$i]['columns'][$defaultjson['shipments']['columns'][$column]['column']] = array(
																												'id' => $column,
																												'label' => $defaultjson['shipments']['columns'][$column]['label'],
																												'column' => $defaultjson['shipments']['columns'][$column]['column'],
																												'col-length' => $defaultjson['shipments']['columns'][$column]['col-length'],
																												'before-decimal' => $defaultjson['shipments']['columns'][$column]['before-decimal'],
																												'after-decimal' => $defaultjson['shipments']['columns'][$column]['after-decimal'],
																												'date-format' => $defaultjson['shipments']['columns'][$column]['date-format']
																												);
				$count++;
			}
		}
	}

	if ($config->ajax) {
		echo '<p>' . makeprintlink($config->filename, 'View Printable Version') . '</p>';
	}
?>
<?php if (file_exists($salesfile)) : ?>
    <?php $quotejson = json_decode(file_get_contents($salesfile), true);  ?>
    <?php if (!$quotejson) { $quotejson = array('error' => true, 'errormsg' => 'The CI Sales History JSON contains errors');} ?>

    <?php if ($quotejson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $quotejson['errormsg']; ?></div>
    <?php else : ?>
       <?php foreach ($quotejson['data'] as $whse) : ?>
      		<div>
      			<h3><?= $whse['Whse Name']; ?></h3>
      			<?php include $config->paths->content."/cust-information/tables/sales-history-formatted.php"; ?>
      		</div>
      	<?php endforeach; ?>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
