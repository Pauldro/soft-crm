<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr> <th>Date</th> <th>Amount</th> <th>View</th> </tr>
	</thead>
	<tbody>
		<?php foreach ($bookings as $booking) : ?>
			<tr>
				<td>
					<?= Dplus\Base\DplusDateTime::format_date($booking['bookdate']); ?>
				</td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($booking['amount']); ?></td>
				<td class="text-right">
					<a href="<?= $bookingspanel->generate_viewsalesordersbydayURL($booking['bookdate']); ?>" class="btn btn-primary btn-sm load-into-modal info-screen" data-modal="<?= $bookingspanel->modal; ?>">
						<i class="fa fa-external-link" aria-hidden="true"></i> View Sales Orders
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
