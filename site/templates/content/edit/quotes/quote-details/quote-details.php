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

<?php $quote_details = $editquotedisplay->get_quotedetails($quote); ?>
<?php foreach ($quote_details as $detail) : ?>
    <form action="<?= $config->pages->quotes.'redir/'; ?>" method="post" class="form-group">
        <input type="hidden" name="action" value="quick-update-line">
        <input type="hidden" name="qnbr" value="<?= $qnbr; ?>">
		<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
		<div class="row">
			<div class="col-sm-9">
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
							<input class="input-xs text-right underlined" type="text" size="6" name="quotqty" value="<?= $detail->quotqty + 0; ?>">
						</span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Price:</span>
						<span class="detail-line-field numeric">
							<input class="input-xs text-right underlined" type="text" size="10" name="quotprice" value="<?= $page->stringerbell->format_money($detail->quotprice); ?>">
						</span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Total:</span>
						<span class="detail-line-field numeric">$ <?= $page->stringerbell->format_money($detail->quotprice * $detail->quotqty); ?></span>
					</div>
					<div class="col-md-2 form-group">
						<span class="detail-line-field-name">Rqst Date:</span>
						<span class="detail-line-field numeric">
							<div class="input-group date">
								<?php $name = 'rshipdate'; $value = $detail->rshipdate; ?>
								<?php include $config->paths->content."common/date-picker.php"; ?>
							</div>
						</span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-xs-6">
						<?= $editquotedisplay->generate_viewdetaillink($quote, $detail); ?>
						<?= $editquotedisplay->generate_loaddocumentslink($quote, $detail); ?>
                        <?= $editquotedisplay->generate_loaddplusnoteslink($quote, $detail->linenbr); ?>
					</div>

					<div class="col-xs-6">
                        <?= $editquotedisplay->generate_detailvieweditlink($quote, $detail); ?>
                        <?= $editquotedisplay->generate_deletedetailform($quote, $detail); ?>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" name="button" class="btn btn-md btn-info detail-line-icon">
			<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;Update Line
		</button>
	</form>
<?php endforeach; ?>
<form action="<?= $config->pages->quotes.'redir/'; ?>" method="post" class="quick-entry-add form-group">
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
