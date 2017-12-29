<div class="row">
	<div class="col-sm-2">
		<?php include $config->paths->content.'cust-information/ci-buttons.php'; ?>
	</div>
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-6">
				<?= $tableformatter->generate_customertable($customer); ?>
			</div>
			<div class="col-sm-6">
				<?= $tableformatter->generate_shiptotable($customer); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<?= $tableformatter->generate_tableleft() ; ?>
			</div>
			<div class="col-sm-6">
				<?= $tableformatter->generate_tableright() ; ?>
			</div>
		</div>
	</div>
</div>

<?php include $config->paths->content."cust-information/cust-sales-data.php"; ?>
<?php if ($appconfig->has_crm) : ?>
	<div class="row">
		<div class="col-xs-12">
			<?php include $config->paths->content.'customer/cust-page/actions/actions-panel.php'; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'customer/cust-page/customer-contacts.php'; ?>
		</div>
	</div>
<?php endif; ?>
<?php if (has_dpluspermission($user->loginid, 'eso')) : ?>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'customer/cust-page/orders/orders-panel.php'; ?>
		</div>
	</div>
<?php endif; ?>
<?php if (has_dpluspermission($user->loginid, 'eqo')) : ?>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'customer/cust-page/quotes/quotes-panel.php'; ?>
		</div>
	</div>
<?php endif; ?>
