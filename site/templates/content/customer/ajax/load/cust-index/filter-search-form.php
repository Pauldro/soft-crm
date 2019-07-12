<input type="hidden" name="filter" value="filter">

<div class="row">
    <div class="col-sm-6">
        <h3>Type of Customer</h3>
        <div class="row">
            <div class="col-sm-6">
                <input type="checkbox" name="source" value="P" <?= ($custindex->has_filtervalue('source', 'P')) ? 'checked' : ''; ?>>&ensp;
                <label>Prospect</label></br>
            </div>
            <div class="col-sm-6">
                <input type="checkbox" name="source" value="C" <?= ($custindex->has_filtervalue('source', 'C')) ? 'checked' : ''; ?>>&ensp;
                <label>Customer</label></br>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <h3>Last Sale Date</h3>
        <div class="row">
            <div class="col-sm-6">
                <?php $name = 'lastsaledate[]'; $value = $custindex->get_filtervalue('lastsaledate'); ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="small text-muted">From Date </label>
            </div>
            <div class="col-sm-6">
                <?php $name = 'lastsaledate[]'; $value = $custindex->get_filtervalue('lastsaledate', 1); ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="small text-muted">Through Date </label>
            </div>
        </div>
    </div>
</div>
<h3>State</h3>
<div class="row">
    <?php foreach ($states as $state) : ?>
        <div class="col-sm-2">
            <input type="checkbox" name="state[]" value="<?= $state['state']; ?>" <?= ($custindex->has_filtervalue('state', $state['state'])) ? 'checked' : ''; ?>>&ensp;
            <?php if ($state['state'] == '') : ?>
                <label>No State Supplied</label></br>
            <?php else : ?>
                <label><?= $state['state']; ?></label></br>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<br>
<div class="row">
    <div class="col-sm-12 form-group">
        <button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
    <div class="col-sm-12 form-group">
        <?php if ($input->get->filter) : ?>
            <div>
                <a href="<?= $custindex->generate_loadurl(); ?>" class="load-link btn btn-warning btn-block" data-loadinto="#cust-results" data-focus="#cust-results">
                    Clear Search <i class="fa fa-search-minus" aria-hidden="true"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
