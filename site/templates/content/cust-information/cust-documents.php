<?php
	$docfile = $config->jsonfilepath.session_id()."-docview.json";
	//$docfile = $config->jsonfilepath."iidcv-docview.json";
 ?>

<?php if (file_exists($docfile)) : ?>
	<?php $docjson = json_decode(file_get_contents($docfile), true);  ?>
	<?php if (!$docjson) { $docjson = array('error' => true, 'errormsg' => 'The Cust Documents JSON contains errors');} ?>
	<?php if ($docjson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $docjson['errormsg']; ?></div>
	<?php else : ?>
		<?php $columns = array_keys($docjson['columns']); ?>
		<?php $documents = array_keys($docjson['data']); ?>
		<table class="table table-striped table-condensed table-excel">
			<tr>
				<?php foreach ($columns as $column) : ?>
					<th class="<?= $config->textjustify[$docjson['columns'][$column]['headingjustify']]; ?>"><?php echo $docjson['columns'][$column]['heading']; ?></th>
				<?php endforeach; ?>
				<th>Load Document</th>
			</tr>
			<?php foreach ($documents as $doc) : ?>
				<tr class="doc-<?php echo $doc; ?>">
					<?php foreach ($columns as $column) : ?>
						<td class="<?= $config->textjustify[$docjson['columns'][$column]['datajustify']]; ?>"><?php echo $docjson['data'][$doc][$column]; ?></td>
					<?php endforeach; ?>
					<td>
						<button type="button" class="btn btn-sm btn-primary load-doc" data-doc="<?= $doc; ?>"><i class="fa fa-file-o" aria-hidden="true"></i> Load</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
