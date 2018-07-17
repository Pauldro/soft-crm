<?php
    $signinlog = new SigninLog();
    $day = $input->get->day ? date('m/d/Y', strtotime($input->get->text('day'))) : $day = date('m/d/Y');

    $url = new Purl\Url($page->fullURL->getUrl());
?>

<form action="$url" method="get" data-ordertype="sales-orders" data-loadinto="#user-signin-table" data-focus="#user-signin-table" data-modal="#ajax-modal" class="signin-search-form allow-enterkey-submit">
	<input type="hidden" name="filter" value="filter">

	<div class="row">
        <div class="col-sm-2">
			<h4>Date</h4>
			<?php $name = 'date[]'; $value = $signinlog->get_filtervalue('date'); ?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">From Date </label>

			<?php $name = 'date[]'; $value = $signinlog->get_filtervalue('date', 1);?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">Through Date </label>
		</div>
		<div class="col-sm-2">
			<h4>User</h4>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="user[]" value="<?= $signinlog->get_filtervalue('user'); ?>" placeholder="From User">
			</div>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="user[]" value="<?= $signinlog->get_filtervalue('user', 1); ?>" placeholder="Through User">
			</div>
		</div>
		<div class="col-sm-2">
			<h4>Session ID</h4>
			<input class="form-control inline input-sm" type="text" name="sessionid[]" value="<?= $signinlog->get_filtervalue('sessionid'); ?>" placeholder="Session ID">
		</div>
	</div>
	</br>
	<div class="form-group">
		<button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>

<table class="table table-striped table-bordered table-condensed" id="user-signin-table">
	<thead>
		<th>Date</th>
        <th>User</th>
        <th>SessionID</th>
	</thead>
	<tbody>
        <?php $signinlog->get_daysignins($day); ?>
		<?php foreach ($signinlog->logs as $log) : ?>
    		<tr>
                <td><?= $log->date; ?></td>
    			<td><?= $log->user; ?></td>
                <td><?= $log->sessionid; ?></td>
    		</tr>
        <?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
    $("body").on("submit", ".signin-search-form", function(e)  { //FIXME Barbara - changed from order-search-form
        e.preventDefault();
        var form = $(this);
        var loadinto = form.data('loadinto');
        var focuson = form.data('focus');
        var action = URI(form.attr('action'));
        var queries = URI.parseQuery(URI(action).search())
        var orderby = queries.orderby; // Keep the orderby param value before clearing it
        var href = action.query('').query(form.serialize()).query(cleanparams).query(remove_emptyparams);
        if (Object.keys(href.query(true)).length == 1) {
            href.query('');
        }

        if (orderby) {
            href = href.addQuery('orderby', orderby);
        }

        href = href.toString(); // Add orderby param

        $(loadinto).loadin(href, function() {
            if (focuson.length > 0) {
                $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
            }
        });
    });
</script>
