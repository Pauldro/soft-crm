<?php 
	
	include $config->paths->assets."classes/Table.php"; 
	include $config->paths->content."item-information/functions/ii-functions.php";
	$purchasefile = $config->jsonfilepath.session_id()."-iipurchordr.json";
	//$purchasefile = $config->jsonfilepath."iiso-iipurchordr.json"; 
	


	if (checkformatterifexists($user->loginid, 'ii-purchase-order', false)) {
		$defaultjson = json_decode(getformatter($user->loginid, 'ii-purchase-order', false), true);
	} else {
		$default = $config->paths->content."item-information/screen-formatters/default/ii-purchase-order.json";
		$defaultjson = json_decode(file_get_contents($default), true); 
	}
	
	$columns = array_keys($defaultjson['detail']['columns']);
	$fieldsjson = json_decode(file_get_contents($config->companyfiles."json/iipofmattbl.json"), true);

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

<?php if (file_exists($purchasefile)) : ?>
    <?php $ordersjson = json_decode(file_get_contents($purchasefile), true);  ?>
    <?php if (!$ordersjson) { $ordersjson = array('error' => true, 'errormsg' => 'The purchase order JSON contains errors');} ?>

    <?php if ($ordersjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $ordersjson['errormsg']; ?></div>
    <?php else : ?>
       <?php foreach ($ordersjson['data'] as $whse) : ?>
      		<div>
      			<h3><?= $whse['Whse Name']; ?></h3>
      			<?php include $config->paths->content."/item-information/tables/purchase-order-formatted.php"; ?>
      		</div>
      	<?php endforeach; ?>
      	<?php if ($config->ajax) : ?>
			<script>
				$(function() {
					<?php foreach ($ordersjson['data'] as $whse) : ?>
						<?php if ($whse != $ordersjson['data']['zz'] && $defaultjson['detail']['rows'] < 2) : ?>
							$('<?= '#'.$whse['Whse Name']; ?>').DataTable();
						<?php endif; ?>
					<?php endforeach; ?>
				});

			</script>
   		<?php endif; ?>
    <?php endif; ?>

<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>

