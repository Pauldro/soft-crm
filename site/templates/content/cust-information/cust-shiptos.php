<?php
	$shiptofile = $config->jsonfilepath.session_id()."-cishiptolist.json";
	//$shiptofile = $config->jsonfilepath."cislist-cishiptolist.json";
 ?>

<?php if (file_exists($shiptofile)) : ?>
	<?php $shiptojson = json_decode(file_get_contents($shiptofile), true);  ?>
	<?php if (!$shiptojson) { $shiptojson = array('error' => true, 'errormsg' => 'The customer Ship-tos Inquiry JSON contains errors');} ?>
	<?php if ($shiptojson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $shiptojson['errormsg']; ?></div>
	<?php else : ?>
		<?php if (sizeof($shiptojson['data']) > 0) : ?>
			<?php $columns = array_keys($shiptojson['columns']); ?>
			<?php $link = $config->pages->customer.'redir/?action=ci-customer&custID='.$custID; ?>
			<?php if ($input->get->shipID) : ?>
				<a href="<?= $link; ?>" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-remove"></i> Clear Ship-to</a>
			<?php endif; ?>

			<table class="table table-striped table-bordered table-condensed table-excel" id="shiptolist">
				<thead>
					<tr>
						<?php foreach ($columns as $column) : ?>
							<th class="<?= $config->textjustify[$shiptojson['columns'][$column]['headingjustify']]; ?>">
								<?php echo $shiptojson['columns'][$column]['heading']; ?>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($shiptojson['data'] as $shipto) : ?>
						<tr>
							<?php foreach ($columns as $column) : ?>
								<?php if ($column == 'shipid') : ?>
									<td class="<?= $config->textjustify[$shiptojson['columns'][$column]['datajustify']]; ?>">
										<?php if (100 == 1) : ?>
											<button class="btn btn-primary btn-sm" onclick="loadshiptoinfo('<?= $custID; ?>', '<?= $shipto['shipid']; ?>')">
												<?php echo $shipto[$column]; ?>
											</button>
										<?php endif; ?>
										<?php $link = $config->pages->customer.'redir/?action=ci-shipto-info&custID='.$custID.'&shipID='.$shipto['shipid']; ?>
										<a href="<?= $link; ?>" class="btn btn-sm btn-primary"><?php echo $shipto[$column]; ?></a>
									</td>
								<?php else : ?>
									<td class="<?= $config->textjustify[$shiptojson['columns'][$column]['datajustify']]; ?>">
										<?php echo $shipto[$column]; ?>
									</td>
								<?php endif; ?>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<script>
				$('#shiptolist').dataTable();
			</script>
		<?php else : ?>
			 <div class="alert alert-warning" role="alert">Customer has no Shiptos</div>
		<?php endif; ?>
		<?php $columns = array_keys($shiptojson['columns']); ?>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
