<div id="no-more-tables" class="form-group">
	<table class="table-condensed cf order-details numeric">
		<thead class="cf">
			<tr>
				<th>Item</th> <th class="text-center">WH</th> <th class="numeric text-right">Qty</th> <th class="numeric text-right">Price</th> <th class="numeric text-right">Total</th>
				<th class="text-center">Rqst Date</th>
				<th>
					<div class="row">
						<div class="col-xs-3">Details</div><div class="col-xs-2">Docs</div> <div class="col-xs-2">Notes</div> <div class="col-xs-5">Edit</div>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $details = get_cartdetails(session_id(), true); ?>
			<?php foreach ($details as $detail) : ?>
				<tr class="cart-item">
					<td data-title="ItemID/Desc">
						<?php if ($detail->has_error()) : ?>
							<div class="btn-sm btn-danger">
							  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
							</div>
						<?php else : ?>
							<?= $detail->itemid; ?>
							<?= (strlen($detail->vendoritemid)) ? $detail->vendoritemid : ''; ?>
							<br> <small><?= $detail->desc1; ?></small>
						<?php endif; ?>
					</td>
					<td data-title="WH" class="text-center"><?= $detail->whse; ?></td>
					<td data-title="Qty" class="text-right">
						<input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->qty + 0; ?>">
					</td>
					<td data-title="Price" class="text-right">
						<input class="input-xs text-right" size="10" type="text" name="" value="<?= $page->stringerbell->format_money($detail->price); ?>">
					</td>
					<td data-title="Total" class="text-right">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></td>
					<td data-title="Rqstd Date"  class="text-center"><?= $detail->rshipdate; ?></td>
					<td class="action">
						<div class="row">
							<div class="col-xs-3"> <span class="visible-xs-block action-label">Details</span>
								<a href="<?= $config->pages->ajax."load/view-detail/cart/?line=".$detail->linenbr; ?>" class="btn btn-sm btn-primary view-item-details" data-itemid="<?= $detail->itemid; ?>" data-kit="<?= $detail->kititemflag; ?>" data-modal="#ajax-modal"><i class="material-icons">&#xE8DE;</i></a>
							</div>
							<div class="col-xs-2"> <span class="visible-xs-block action-label">Docs</span> <span class="text-muted"><i class="material-icons md-36">&#xE873;</i></span> </div>
							<div class="col-xs-2"> <span class="visible-xs-block action-label">Notes</span> <?= $cartdisplay->generate_loaddplusnoteslink($cart, $detail->linenbr); ?></div>
							<div class="col-xs-5"> <span class="visible-xs-block action-label">Edit</span>
								<?= $cartdisplay->generate_detailvieweditlink($cart, $detail); ?>
								<form class="inline-block" action="<?= $config->pages->cart."redir/"; ?>" method="post">
									<input type="hidden" name="action" value="remove-line">
									<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
									<button type="submit" class="btn btn-md btn-danger" name="button">
										<span class="glyphicon glyphicon-trash"></span><span class="sr-only">Delete</span>
									</button>
								</form>
							</div>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>

<br>
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#item-lookup-modal">
	<span class="glyphicon glyphicon-plus"></span> Add Item
</button> -->
<br>


<!-- FORM WITHOUT TABLE -->
<hr class="detail-line-header">
<div class="row detail-line-header">
	<strong>
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-4">Item / Description</div>
				<div class="col-sm-1 text-left">WH</div>
				<div class="col-sm-1 text-right">Qty</div>
				<div class="col-sm-2 text-center">Price</div>
				<div class="col-sm-2">Total</div>
				<div class="col-sm-2">Rqst Date</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-6">Details</div>
				<div class="col-sm-6">Edit</div>
			</div>
		</div>
	</strong>
</div>
<hr>

<?php $details = get_cartdetails(session_id(), true); ?>
<?php foreach ($details as $detail) : ?>
<form action="index.html" method="post">
	<div class="row">
		<div class="col-xs-9">
			<div class="row">
				<div class="col-md-4 form-group">
					<span class="detail-line-field-name">Item/Description:</span>
					<span class="detail-line-field numeric">
						<?php if ($detail->has_error()) : ?>
							<div class="btn-sm btn-danger">
							  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
							</div>
						<?php else : ?>
							<?= $detail->itemid; ?>
							<?= (strlen($detail->vendoritemid)) ? $detail->vendoritemid : ''; ?>
							<br> <small><?= $detail->desc1; ?></small>
						<?php endif; ?>
					</span>
				</div>
				<div class="col-md-1 form-group">
					<span class="detail-line-field-name">WH:</span>
					<span class="detail-line-field numeric"><?= $detail->whse; ?></span>
				</div>
				<div class="col-md-1 form-group">
					<span class="detail-line-field-name">Qty:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right" type="text" size="6" name="" value="<?= $detail->qty + 0; ?>">
					</span>
				</div>
				<div class="col-md-2 form-group">
					<span class="detail-line-field-name">Price:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right" type="text" size="10" name="" value="<?= $page->stringerbell->format_money($detail->price); ?>">
					</span>
				</div>
				<div class="col-md-2 form-group">
					<span class="detail-line-field-name">Total:</span>
					<span class="detail-line-field numeric">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></span>
				</div>
				<div class="col-md-2 form-group">
					<span class="detail-line-field-name">Rqst Date:</span>
					<span class="detail-line-field numeric"><?= $detail->rshipdate; ?></span>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3">
			<div class="row">
				<div class="col-xs-6">
					<a href="<?= $config->pages->ajax."load/view-detail/cart/?line=".$detail->linenbr; ?>" class="btn btn-xs btn-primary view-item-details detail-line-icon" data-itemid="<?= $detail->itemid; ?>" data-kit="<?= $detail->kititemflag; ?>" data-modal="#ajax-modal"><i class="material-icons">&#xE8DE;</i></a>
					<span class="text-muted detail-line-icon"><i class="material-icons md-36">&#xE873;</i></span><?= $cartdisplay->generate_loaddplusnoteslink($cart, $detail->linenbr); ?>
				</div>

				<div class="col-xs-6">
					<?= $cartdisplay->generate_detailvieweditlink($cart, $detail); ?>
					<!-- TODO: delete button needs new link rather than form? -->
					<button type="submit" class="btn btn-md btn-danger detail-line-icon" name="button">
						<span class="glyphicon glyphicon-trash"></span><span class="sr-only">Delete</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<hr>
<?php endforeach; ?>

	<div class="row">
		<div class="col-xs-9">
			<div class="row">
				<div class="col-md-4 form-group">
					<span class="detail-line-field-name">Item/Description:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs" type="text" name="" value="Add an Item">
					</span>
				</div>
				<div class="col-md-1 form-group">
				</div>
				<div class="col-md-1 form-group">
					<span class="detail-line-field-name">Qty:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right" type="text" size="6" name="" value="2">
					</span>
				</div>
				<div class="col-md-2 form-group">
					<span class="detail-line-field-name">Price:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right" type="text" size="10" name="" value="30.00">
					</span>
				</div>
				<div class="col-md-2 form-group">
				</div>
				<div class="col-md-2 form-group">
				</div>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3">
			<div class="row">
				<div class="col-xs-6">
				</div>
				<div class="col-xs-6">
					<button type="button" class="btn btn-md btn-primary"  data-toggle="modal" data-target="#item-lookup-modal">
						<span class="glyphicon glyphicon-plus"></span><span class="sr-only">Add Item</span>
					</button>
				</div>
			</div>
		</div>
	</div>

	<hr>
</form>
