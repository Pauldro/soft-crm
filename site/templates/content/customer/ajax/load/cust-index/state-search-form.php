<input type="hidden" name="filter" value="filter">
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
