
<form action="<?php echo $config->pages->ajax."load/ci/search-results/"; ?>" method="get" id="ci-search-customers">
	<input type="text" class="form-control ci-cust-search" name="q">
	<div>
		<?php include $config->paths->content."cust-information/cust-search-results.php"; ?>
	</div>
</form>

	<a href="<?= $config->pages->customer."redir/?action=ci-customer&custID=BECKER"; ?>" class="btn btn-info">BECKER </a>
	<br><br>
	<a href="<?= $config->pages->customer."redir/?action=ci-customer&custID=RYAN"; ?>" class="btn btn-info">RYAN </a>
