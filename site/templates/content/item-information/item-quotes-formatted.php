<?php 
	
	include $config->paths->assets."classes/Table.php"; 
	include $config->paths->content."item-information/functions/ii-functions.php";
	$quotesfile = $config->jsonfilepath.session_id()."-iiquote.json";
	//$quotesfile = $config->jsonfilepath."iiqt-iiquote.json"; 
	


	if (checkformatterifexists($user->loginid, 'ii-quote', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ii-quote', false), true);
	} else {
		$default = $config->paths->content."item-information/screen-formatters/default/ii-quote.json";
		$defaultjson = json_decode(file_get_contents($default), true); 
	}
	
	$detailcolumns = array_keys($defaultjson['detail']['columns']);
	$headercolumns = array_keys($defaultjson['header']['columns']);
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/iiqtfmattbl.json"), true);

	$table = array(
				'maxcolumns' => $defaultjson['cols'], 
				'detail' => array('maxrows' => $defaultjson['detail']['rows'], 'rows' => array()), 
				'header' => array('maxrows' => $defaultjson['header']['rows'], 'rows' => array())
				  );

	for ($i = 1; $i < $defaultjson['detail']['rows'] + 1; $i++) {
		$table['detail']['rows'][$i] = array('columns' => array());
		$count = 1;
		foreach($detailcolumns as $column) {
			if ($defaultjson['detail']['columns'][$column]['line'] == $i) {
				$table['detail']['rows'][$i]['columns'][$defaultjson['detail']['columns'][$column]['column']] = array('id' => $column, 'label' => $defaultjson['detail']['columns'][$column]['label'], 'column' => $defaultjson['detail']['columns'][$column]['column'], 'col-length' => $defaultjson['detail']['columns'][$column]['col-length'], 'before-decimal' => $defaultjson['detail']['columns'][$column]['before-decimal'], 'after-decimal' => $defaultjson['detail']['columns'][$column]['after-decimal'], 'date-format' => $defaultjson['detail']['columns'][$column]['date-format']);
				$count++;
			}
		}
	}

	for ($i = 1; $i < $defaultjson['header']['rows'] + 1; $i++) {
		$table['header']['rows'][$i] = array('columns' => array());
		foreach($headercolumns as $column) {
			if ($defaultjson['header']['columns'][$column]['line'] == $i) {
				$table['header']['rows'][$i]['columns'][$defaultjson['header']['columns'][$column]['column']] = array('id' => $column, 'label' => $defaultjson['header']['columns'][$column]['label'], 'column' => $defaultjson['header']['columns'][$column]['column'], 'col-length' => $defaultjson['header']['columns'][$column]['col-length'], 'before-decimal' => $defaultjson['header']['columns'][$column]['before-decimal'], 'after-decimal' => $defaultjson['header']['columns'][$column]['after-decimal'], 'date-format' => $defaultjson['header']['columns'][$column]['date-format']);
			}
		}
	}

	
?>

<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>
<?php if (file_exists($quotesfile)) : ?>
    <?php $quotejson = json_decode(file_get_contents($quotesfile), true);  ?>
    <?php if (!$quotejson) { $quotejson = array('error' => true, 'errormsg' => 'The quote JSON contains errors');} ?>

    <?php if ($quotejson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $quotejson['errormsg']; ?></div>
    <?php else : ?>
       <?php foreach ($quotejson['data'] as $whse) : ?>
      		<div>
      			<h3><?= $whse['Whse Name']; ?></h3>
      			<?php include $config->paths->content."/item-information/tables/quote-formatted.php"; ?>
      		</div>
      	<?php endforeach; ?>

    <?php endif; ?>

<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>

