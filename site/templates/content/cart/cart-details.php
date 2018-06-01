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
	<form action="<?= $config->pages->cart.'redir/'; ?>" method="post" class="form-group">
		<input type="hidden" name="action" value="quick-update-line">
		<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
		<div class="row">
			<div class="col-sm-9">
				<div class="row">
					<div class="col-md-4 form-group">
						<span class="detail-line-field-name cart-item">Item/Description:</span>
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
							<input class="form-control input-xs text-right underlined" type="text" size="6" name="qty" value="<?= $detail->qty + 0; ?>">
						</span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Price:</span>
						<span class="detail-line-field numeric">
							<input class="form-control input-xs text-right underlined" type="text" size="10" name="price" value="<?= $page->stringerbell->format_money($detail->price); ?>">
						</span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Total:</span>
						<span class="detail-line-field numeric">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Rqst Date:</span>
						<span class="detail-line-field numeric">
							<div class="input-group date">
								<?php $name = 'rshipdate'; $value = $detail->rshipdate; ?>
								<?php include $config->paths->content."common/date-picker-underlined.php"; ?>
							</div>
						</span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-xs-6">
						<a href="<?= $config->pages->ajax."load/view-detail/cart/?line=".$detail->linenbr; ?>" class="btn btn-xs btn-primary view-item-details detail-line-icon" data-itemid="<?= $detail->itemid; ?>" data-kit="<?= $detail->kititemflag; ?>" data-modal="#ajax-modal"><i class="material-icons">&#xE8DE;</i></a>
						<span class="text-muted detail-line-icon"><i class="material-icons md-36">&#xE873;</i></span>
						<?= $cartdisplay->generate_loaddplusnoteslink($cart, $detail->linenbr); ?>
					</div>

					<div class="col-xs-6">
						<?= $cartdisplay->generate_detailvieweditlink($cart, $detail); ?>
						<a href="<?= $cartdisplay->generate_detaildeleteurl($cart, $detail); ?>" class="btn btn-md btn-danger detail-line-icon">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" name="button" class="btn btn-md btn-info detail-line-icon">
			<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Update Line
		</button>
	</form>
<?php endforeach; ?>
<form action="<?= $config->pages->cart.'redir/'; ?>" method="post" class="quick-entry-add">
	<input type="hidden" name="action" value="add-to-cart">
	<div class="row">
		<div class="col-xs-9">
			<div class="row">
				<div class="col-md-4 form-group">
					<span class="detail-line-field-name">Item/Description:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs underlined" type="text" name="itemID" placeholder="Item ID">
					</span>
				</div>
				<div class="col-md-1 form-group">
				</div>
				<div class="col-md-1 form-group">
					<span class="detail-line-field-name">Qty:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right underlined" type="text" size="6" name="qty" value="">
					</span>
				</div>
				<div class="col-md-2 form-group">
					<span class="detail-line-field-name">Price:</span>
					<span class="detail-line-field numeric">
						<input class="input-xs text-right underlined" type="text" size="10" name="price" value="">
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
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
				<div class="col-xs-6">
					<button type="button" class="btn btn-md btn-primary"  data-toggle="modal" data-target="#item-lookup-modal">
						<span class="glyphicon glyphicon-plus"></span><span class="sr-only">Add Item</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
