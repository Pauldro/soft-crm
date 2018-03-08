<form action="<?= $quotepanel->pageurl->getUrl(); ?>" method="get" data-ordertype="quotes" data-loadinto="#quotes-panel" data-focus="#quotes-panel" data-modal="#ajax-modal" class="orders-search-form">
    <input type="hidden" name="filter" value="filter">
	
	<div class="row">
		<div class="col-sm-2">
			<h4>Quote # :</h4>
		    <input class="form-control form-group inline input-sm" type="text" name="quotnbr[]" value="<?= $quotepanel->get_filtervalue('quotnbr'); ?>" placeholder="From Quote #">
		    <input class="form-control form-group inline input-sm" type="text" name="quotnbr[]" value="<?= $quotepanel->get_filtervalue('quotnbr', 1); ?>" placeholder="Through Quote #">
		</div>
		<div class="col-sm-2">
			<h4>Cust ID</h4>
			<input class="form-control form-group inline input-sm" type="text" name="custid[]" value="<?= $quotepanel->get_filtervalue('custid'); ?>" placeholder="From CustID">
			<input class="form-control form-group inline input-sm" type="text" name="custid[]" value="<?= $quotepanel->get_filtervalue('custid', 1); ?>" placeholder="Through CustID">
		</div>
		<div class="col-sm-2">
			<h4>Quote Total :</h4>
		    <input class="form-control form-group inline input-sm" type="text" name="ordertotal[]" value="<?= $quotepanel->get_filtervalue('ordertotal'); ?>" placeholder="From Quote Total">
		    <input class="form-control form-group inline input-sm" type="text" name="ordertotal[]" value="<?= $quotepanel->get_filtervalue('ordertotal', 1); ?>" placeholder="Through Quote Total">
		</div>
		<div class="col-sm-2">
			<h4>Quote Date :</h4>
		    <?php $name = 'quotdate[]'; $value = $quotepanel->get_filtervalue('quotdate'); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">From Date </label>
		    <?php $name = 'quotdate[]'; $value = $quotepanel->get_filtervalue('quotdate', 1); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">Through Date </label>
		</div>
		<div class="col-sm-2">
			<h4>Review Date :</h4>
		    <?php $name = 'revdate[]'; $value = $quotepanel->get_filtervalue('revdate'); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">From Date </label>
		    <?php $name = 'revdate[]'; $value = $quotepanel->get_filtervalue('revdate', 1); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">Through Date </label>
		</div>
		<div class="col-sm-2">
			<h4>Expire Date :</h4>
		    <?php $name = 'expdate[]'; $value = $quotepanel->get_filtervalue('expdate'); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">From Date </label>
		    <?php $name = 'expdate[]'; $value = $quotepanel->get_filtervalue('expdate', 1); ?>
		    <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="small text-muted">Through Date </label>
		</div>
	</div>
    </br>
    <div class="form-group">
    	<button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
    <?php if ($input->get->filter) : ?>
        <div>
            <?= $quotepanel->generate_clearsearchlink(); ?>
        </div>
    <?php endif; ?>
</form>
