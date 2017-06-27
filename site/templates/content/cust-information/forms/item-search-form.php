<form action="<?php echo $config->pages->ajax."load/ci/ci-item-search/"; ?>" method="get" id="ci-search-item">
	<input type="text" class="form-control ci-item-search" name="q" autocomplete="off">
	<input type="hidden" name="custid" class="custid" value="<?php echo $custID; ?>" >
	<div>
		<?php include $config->paths->content."cust-information/item-search-results.php"; ?>
	</div>
</form>
