<?php
	use Dplus\Dpluso\Customer\CustomerIndex;
	$url = new Purl\Url($page->fullURL->getUrl());
	$url->path = $config->pages->ajax."load/customers/cust-index/";
	$custindex = new CustomerIndex($url, '#cust-index', '#cust-index');
	$states = $custindex->get_statesbylogin();
?>
<?php echo $url->url; ?>
<div id="cust-index">
	<form action="<?= $config->pages->ajax."load/customers/cust-index/"; ?>" method="POST" id="cust-index-search-form" class="allow-enterkey-submit">
	    <div class="form-group">
	        <?php if ($input->get->function) : ?>
	        	<input type="hidden" name="function" class="function" value="<?= $input->get->text('function'); ?>">
	        <?php endif; ?>
			<?php if  ($input->get->field) : ?>
				<input type="hidden" name="field" class="field" value="<?= $input->get->text('field'); ?>">
			<?php endif; ?>
	        <div class="input-group">
	            <input type="text" class="form-control cust-index-search" name="q" placeholder="Type customer phone, name, ID, contact">
	            <span class="input-group-btn">
	            	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
	            </span>
	        </div>
	    </div>
		<div class="row mb-5">
				<div class="col-sm-12">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#cust-search-div" aria-expanded="false" aria-controls="cust-search-div">Toggle State Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>

			<div id="cust-search-div" class="collapse">
				<?php include $config->paths->content."customer/ajax/load/cust-index/state-search-form.php"; ?>
			</div>
	</form>
	<div>
		<?php
			if (!empty($input->get->q) || !empty($input->get->function)) {
				switch ($dplusfunction) {
					case 'ca':
						include $config->paths->content."customer/ajax/load/cust-index/cart-cust-list.php";
						break;
					case 'ci':
						include $config->paths->content."customer/ajax/load/cust-index/ci-cust-list.php";
						break;
					case 'ii':
						include $config->paths->content."customer/ajax/load/cust-index/ii-cust-list.php";
						break;
					case 'os':
						include $config->paths->content."customer/ajax/load/cust-index/order-search-cust-list.php";
						break;
				}
			} else {
				include $config->paths->content."customer/ajax/load/cust-index/ci-cust-list.php";
			}
		?>
	</div>
	<?php if (100 == 1) : ?>
	    <?php if ($dplusfunction == 'ci') : ?>
	        <div class="row form-group">
	        	<div class="col-xs-12">
	        		<a href="<?= $config->pages->customer.'add/'; ?>" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> Add new Customer</a>
	        	</div>
	        </div>
	    <?php endif; ?>
	<?php endif; ?>
</div>
