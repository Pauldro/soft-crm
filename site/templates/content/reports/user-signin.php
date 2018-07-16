<?php
    $signinlog = new SigninLog();
    $day = $input->get->day ? date('m/d/Y', strtotime($input->get->text('day'))) : $day = date('m/d/Y');
?>

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
