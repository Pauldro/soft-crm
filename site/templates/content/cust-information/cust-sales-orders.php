<?php
	include_once $config->paths->content."item-information/functions/ii-functions.php";
	$salesfile = $config->jsonfilepath.session_id()."-cisalesordr.json";
	//$salesfile = $config->jsonfilepath."ciso-cisalesordr.json";



	if (checkformatterifexists($user->loginid, 'ci-sales-order', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ci-sales-order', false), true);
	} else {
		$default = $config->paths->content."cust-information/screen-formatters/default/ci-sales-orders.json";
		$defaultjson = json_decode(file_get_contents($default), true);
	}

	$detailcolumns = array_keys($defaultjson['detail']['columns']);
	$headercolumns = array_keys($defaultjson['header']['columns']);
	$itemstatuscolumns = array_keys($defaultjson['itemstatus']['columns']);
	$purchaseordercolumns = array_keys($defaultjson['purchaseorder']['columns']);
	$totalcolumns = array_keys($defaultjson['total']['columns']);
	$shipmentcolumns = array_keys($defaultjson['shipments']['columns']);

	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/cisofmattbl.json"), true);

	$table = array(
				'maxcolumns' => $defaultjson['cols'],
				'header' => array('maxrows' => $defaultjson['header']['rows'], 'rows' => array()),
				'detail' => array('maxrows' => $defaultjson['detail']['rows'], 'rows' => array()),
				'itemstatus' => array('maxrows' => $defaultjson['itemstatus']['rows'], 'rows' => array()),
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

	foreach ($itemstatuscolumns as $column) {
		$table['itemstatus']['rows'][1]['columns'][$defaultjson['itemstatus']['columns'][$column]['column']] = array(
														'id' => $column,
														'label' => $defaultjson['itemstatus']['columns'][$column]['label'],
														'column' => $defaultjson['itemstatus']['columns'][$column]['column'],
														'col-length' => $defaultjson['itemstatus']['columns'][$column]['col-length'],
														'before-decimal' => $defaultjson['itemstatus']['columns'][$column]['before-decimal'],
														'after-decimal' => $defaultjson['itemstatus']['columns'][$column]['after-decimal'],
														'date-format' => $defaultjson['itemstatus']['columns'][$column]['date-format']
													);

	}

	foreach ($purchaseordercolumns as $column) {
		$table['purchaseorder']['rows'][1]['columns'][$defaultjson['purchaseorder']['columns'][$column]['column']] = array(
														'id' => $column,
														'label' => $defaultjson['purchaseorder']['columns'][$column]['label'],
														'column' => $defaultjson['purchaseorder']['columns'][$column]['column'],
														'col-length' => $defaultjson['purchaseorder']['columns'][$column]['col-length'],
														'before-decimal' => $defaultjson['purchaseorder']['columns'][$column]['before-decimal'],
														'after-decimal' => $defaultjson['purchaseorder']['columns'][$column]['after-decimal'],
														'date-format' => $defaultjson['purchaseorder']['columns'][$column]['date-format']
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
    <?php $salesjson = json_decode(convertfiletojson($salesfile), true);  ?>
    <?php if (!$salesjson) { $salesjson = array('error' => true, 'errormsg' => 'The CI Sales Order JSON contains errors. JSON ERROR: ' . json_last_error());} ?>

    <?php if ($salesjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $salesjson['errormsg']; ?></div>
    <?php else : ?>
       <?php foreach ($salesjson['data'] as $whse) : ?>
      		<div>
      			<h3><?= $whse['Whse Name']; ?></h3>
      			<?php include $config->paths->content."/cust-information/tables/sales-orders-formatted.php"; ?>
      		</div>
      	<?php endforeach; ?>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
