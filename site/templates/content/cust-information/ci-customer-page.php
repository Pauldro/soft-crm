<!-- <div class="row">
	<div class="col-sm-4">
		<div class="alert alert-info" role="alert">
			<i class="fa fa-info-circle" aria-hidden="true"></i>&ensp;This is a Prospect
		</div>
	</div>
	<div class="col-sm-8">
		<a href="<?= $config->pages->customer.'add-customer-from-prospect/?custID=' . $custID; ?>" class="btn btn-primary pull-right">Create Customer from Prospect&ensp;<i class="fa fa-user-plus" aria-hidden="true"></i></a>
	</div>
</div> -->

<div class="row">
	<div class="col-sm-2 hidden-xs">
		<?php include $config->paths->content.'cust-information/ci-buttons.php'; ?>
	</div>
	<div class="col-sm-10 col-xs-12">
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
<?php if ($appconfig->child('name=dplus')->has_crm) : ?>
	<div class="row">
		<div class="col-xs-12">
			<?php $actionpanel = new Dplus\Dpluso\UserActions\CustomerActionsPanel(session_id(), $page->fullURL, $input); ?>
			<?php $actionpanel->set_customer($customer->custid, $customer->shiptoid); ?>
			<?php include $config->paths->content.'user-actions/user-actions-panel.php'; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'customer/cust-page/customer-contacts.php'; ?>
		</div>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content."cust-information/shipto-sales-data.php"; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'customer/cust-page/bookings/bookings-panel.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'customer/cust-page/sales-orders/orders-panel.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'customer/cust-page/quotes/quotes-panel.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'customer/cust-page/sales-history/sales-history-panel.php'; ?>
	</div>
</div>
<?php
	if ($page->has_bookings) {
		include $config->paths->content."customer/cust-page/bookings/bookings-line-chart.js.php";
	}
?>
