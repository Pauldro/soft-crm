<?php
    $standfile = $config->jsonfilepath.session_id()."-cistandordr.json";
    //$standfile = $config->jsonfilepath."cistand-cistandordr.json";
 ?>

<?php if (file_exists($standfile)) : ?>
    <?php $standingjson = json_decode(file_get_contents($standfile), true);  ?>
    <?php if (!$standingjson) { $standingjson = array('error' => true, 'errormsg' => 'The customer shiptos Inquiry Single JSON contains errors');} ?>
    <?php if ($standingjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $standingjson['errormsg']; ?></div>
    <?php else : ?>
		<?php $custcolumns = array_keys($standingjson['columns']['custinfo']); ?>
		<?php $itemcolumns = array_keys($standingjson['columns']['iteminfo']); ?>

		<div class="row">
			<div class="col-xs-12">
				<?php foreach ($standingjson['data'] as $order) : ?>
					<?php include $config->paths->content."cust-information/tables/standing-order.php"; ?>
				<?php endforeach; ?>
			</div>
		</div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
