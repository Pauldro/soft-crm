<?php
	$pricefile = $config->jsonfilepath.session_id()."-iiprice.json";
	//$pricefile = $config->jsonfilepath."iiprc-iiprice.json";
	if ($config->ajax) {
		echo '<p>' . makeprintlink($config->filename, 'View Printable Version') . '</p>';
	}
 ?>

 <?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" class="h4" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>

<?php if (file_exists($pricefile)) : ?>
	<?php $pricejson = json_decode(file_get_contents($pricefile), true);  ?>
	<?php if (!$pricejson) { $pricejson = array('error' => true, 'errormsg' => 'The Item Price JSON contains errors');} ?>
	<?php if ($pricejson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $pricejson['errormsg']; ?>sadf</div>
	<?php else : ?>
		<?php
			$standardpricecolumns = array_keys($pricejson['columns']['standard pricing']);
			$customerpricecolumns = array_keys($pricejson['columns']['customer pricing']);
			$derivedpricecolumns = array_keys($pricejson['columns']['pricing derived from']);
		?>
		<table class="table table-striped table-condensed table-excel">
			<tr> <td><b>Item ID</b></td> <td><?= $pricejson['itemid']; ?></td> <td colspan="2"><?= $pricejson['desc1']; ?></td> </tr>
			<tr> <td></td> <td></td> <td colspan="2"><?= $pricejson['desc2']; ?></td> </tr>
			<tr>
				<td><b>Customer ID</b></td>
				<td colspan="2">
					<?= $pricejson['custid']." - ".$pricejson['cust name']; ?> <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" onclick="iicust('ii-pricing')">Change Customer</button>
				</td>
			</tr>
			<tr>
				<td><b>Cust Price Code</b></td> <td colspan="2"><?= $pricejson['cust price code']." - ".$pricejson['cust price desc']; ?></td> </tr>
			</tr>
		</table>
		<div class="row">
			<div class="col-sm-4">
				<h3>Standard Pricing</h3>
				<table class="table table-striped table-condensed table-excel">
					<tr>
						<?php foreach($pricejson['columns']['standard pricing'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</tr>
					<tr>
						<td><b>Last Price Date: </b></td> <td><?php echo $pricejson['data']['standard pricing']['last price date']; ?></td>
					</tr>
					<?php foreach ($pricejson['data']['standard pricing']['standard breaks'] as $standardpricing) : ?>
						<tr>
							<?php foreach ($standardpricecolumns as $column) : ?>
								<td class="<?= $config->textjustify[$pricejson['columns']['standard pricing'][$column]['datajustify']]; ?>"><?php echo $standardpricing[$column]; ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div class="col-sm-4">
				<h3>Customer Pricing</h3>
				<table class="table table-striped table-condensed table-excel">
					<tr>
						<?php foreach($pricejson['columns']['customer pricing'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</tr>
					<?php foreach ($pricejson['data']['customer pricing']['cust breaks'] as $customerpricing) : ?>
						<tr>
							<?php foreach ($customerpricecolumns as $column) : ?>
								<td class="<?= $config->textjustify[$pricejson['columns']['customer pricing'][$column]['datajustify']]; ?>"><?php echo $customerpricing[$column]; ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div class="col-sm-4">
				<h3>Pricing Derived From</h3>
				<table class="table table-striped table-condensed table-excel">
					<tr>
						<?php foreach($pricejson['columns']['pricing derived from'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</tr>
					<?php foreach ($pricejson['data']['pricing derived from'] as $derivedpricing) : ?>
						<tr>
							<?php foreach ($derivedpricecolumns as $column) : ?>
								<td class="<?= $config->textjustify[$pricejson['columns']['pricing derived from'][$column]['datajustify']]; ?>"><?php echo $derivedpricing[$column]; ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
