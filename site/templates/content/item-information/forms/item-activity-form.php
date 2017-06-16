<form action="<?php echo $config->pages->products."redir/"; ?>" id="ii-item-activity-form" method="post">
    <input type="hidden" name="action" value="ii-activity">
    <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
    <div class="row">
        <div class="col-xs-10">
            <div class="form-group">
                <p>Item: <?php echo $itemid; ?></p>
            </div>
            <div class="form-group">
                <label for="">Starting Report Date</label>
                <div class="input-group date">
                	<?php $name = 'date'; $value = '';?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
            
        </div>
    </div>
</form>
