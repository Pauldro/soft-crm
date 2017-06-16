<?php 
	
	include $config->paths->assets."classes/Table.php"; 
	include $config->paths->content."item-information/functions/ii-functions.php";
	$invoicefile = $config->jsonfilepath.session_id()."-ciopeninv.json";
	//$invoicefile = $config->jsonfilepath."cioi-ciopeninv.json"; 
	


	if (checkformatterifexists($user->loginid, 'ci-open-invoice', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ci-open-invoice', false), true);
	} else {
		$default = $config->paths->content."cust-information/screen-formatters/default/ci-open-invoices.json";
		$defaultjson = json_decode(file_get_contents($default), true); 
	}
	
	$columns = array_keys($defaultjson['detail']['columns']);
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/cioifmattbl.json"), true);

	$table = array('maxcolumns' => $defaultjson['cols'], 'detail' => array('maxrows' => $defaultjson['detail']['rows'], 'rows' => array()), );
	for ($i = 1; $i < $defaultjson['detail']['rows'] + 1; $i++) {
		$table['detail']['rows'][$i] = array('columns' => array());
		$count = 1;
		foreach($columns as $column) {
			if ($defaultjson['detail']['columns'][$column]['line'] == $i) {
				$table['detail']['rows'][$i]['columns'][$defaultjson['detail']['columns'][$column]['column']] = array('id' => $column, 'label' => $defaultjson['detail']['columns'][$column]['label'], 'column' => $defaultjson['detail']['columns'][$column]['column'], 'col-length' => $defaultjson['detail']['columns'][$column]['col-length'], 'before-decimal' => $defaultjson['detail']['columns'][$column]['before-decimal'], 'after-decimal' => $defaultjson['detail']['columns'][$column]['after-decimal'], 'date-format' => $defaultjson['detail']['columns'][$column]['date-format']);
				$count++;
			}
		}
	}

	
?>
<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>
<?php if (file_exists($invoicefile)) : ?>
    <?php $invoicejson = json_decode(file_get_contents($invoicefile), true);  ?>
    <?php if (!$invoicejson) { $invoicejson= array('error' => true, 'errormsg' => 'The open invoice JSON contains errors');} ?>

    <?php if ($invoicejson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $invoicejson['errormsg']; ?></div>
    <?php else : ?>
    	<?php include $config->paths->content."/cust-information/tables/open-invoices-formatted.php"; ?>
   		<script>
			$(function() {
				$('#invoices').DataTable();
			})
		</script>
    <?php endif; ?>

<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>

