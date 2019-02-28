<?php use Dplus\Base\DplusDateTime; ?>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr> <th>Date</th> <th>Amount</th> </tr>
	</thead>
	<tbody>
		<?php foreach ($bookings as $booking) : ?>
			<tr>
				<td>
					<?php $monthyear = DplusDateTime::format_date($booking['bookdate'], 'F Y'); ?>
					<a href="<?= $bookingspanel->generate_viewmonthURL($booking['bookdate']); ?>" class="load-and-show" <?= $bookingspanel->ajaxdata; ?> title="View <?= $monthyear; ?> bookings">
						<?= $monthyear; ?>
					</a>
				</td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($booking['amount']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
