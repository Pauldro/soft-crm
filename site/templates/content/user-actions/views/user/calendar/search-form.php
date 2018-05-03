<form action="<?= $actionpanel->generate_refreshurl(); ?>" class="form-ajax" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
    <input type="hidden" name="filter" value="filter">
    <div class="row">
        <div class="col-sm-2 form-group">
            <label class="control-label">Go to Month</label>
            <div class="input-group date" style="width: 180px;">
                <?php $name = 'month'; $value = ''; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i> Apply Filter</button>
        </div>
        <div class="col-xs-6">
            <?php if ($input->get->filter) : ?>
                <a href="#" class="btn btn-sm btn-warning btn-block"><i class="fa fa-times" aria-hidden="true"></i> Clear Filter</a>
            <?php endif; ?>
        </div>
    </div>
</form>

<form action="<?= $actionpanel->generate_refreshurl(); ?>" class="form-ajax" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
    <input type="hidden" name="filter" value="filter">
    <input type="hidden" name="view" value="day">
    <div class="row">
        <div class="col-sm-2 form-group">
            <label class="control-label">Go to Date</label>
            <div class="input-group date" style="width: 180px;">
                <?php $name = 'day'; $value = ''; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i> Go</button>
        </div>
    </div>
</form>
