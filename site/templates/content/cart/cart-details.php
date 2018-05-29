<div id="no-more-tables" class="form-group">
	<table class="table-condensed cf order-details numeric">
		<thead class="cf">
			<tr>
				<th>Item</th> <th class="numeric text-right">Qty</th> <th class="numeric text-right">Price</th> <th class="numeric text-right">Total</th>
				<th class="text-center">Rqstd Date</th> <th class="text-center">WH</th>
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
					<td data-title="Qty" class="text-right">
						<input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->qty + 0; ?>">
					</td>
					<td data-title="Price" class="text-right">
						<input class="input-xs text-right" size="10" type="text" name="" value="<?= $page->stringerbell->format_money($detail->price); ?>">
					</td>
					<td data-title="Total" class="text-right">$ <?= $page->stringerbell->format_money($detail->totalprice); ?></td>
					<td data-title="Rqstd Date"  class="text-center"><?= $detail->rshipdate; ?></td>
					<td data-title="WH" class="text-center"><?= $detail->whse; ?></td>
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

			<!-- ADD ITEM SECTION -->
			<tr>
				<td data-title="ItemID/Desc">
					<input class="input-xs" size="30" type="text" name="" value="Add new Item">
				</td>
				<td data-title="Qty" class="text-right">
					<input class="input-xs text-right" size="8" type="text" name="" value="">
				</td>
				<td data-title="Price" class="text-right">
					<input class="input-xs text-right" size="10" type="text" name="" value="">
				</td>
				<td data-title="Total" class="text-right">$ </td>
				<td data-title="Rqstd Date"  class="text-center"></td>
				<td data-title="WH" class="text-center"></td>
				<td class="action">
					<div class="row">
						<div class="col-xs-3"> <span class="visible-xs-block action-label">Details</span></div>
						<div class="col-xs-2"> <span class="visible-xs-block action-label">Docs</span></div>
						<div class="col-xs-2"> <span class="visible-xs-block action-label">Notes</span></div>
						<div class="col-xs-5"> <span class="visible-xs-block action-label">Edit</span>
							<!-- CURRENTL USING ORIGINAL MODAL FOR ADDING ITEMS -->
							<button type="button" class="btn btn-md btn-primary"  data-toggle="modal" data-target="#item-lookup-modal">
								<span class="glyphicon glyphicon-plus"></span><span class="sr-only">Add Item</span>
							</button>
						</div>
					</div>
				</td>
			</tr>

		</tbody>
	</table>
</div>
<br>
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#item-lookup-modal">
	<span class="glyphicon glyphicon-plus"></span> Add Item
</button> -->
<br>

<div class="row">
	<strong>
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-4">Item</div>
				<div class="col-sm-1 text-right">Qty</div>
				<div class="col-sm-2 text-right">Price</div>
				<div class="col-sm-2 text-right">Total</div>
				<div class="col-sm-2 text-center">Rqst Date</div>
				<div class="col-sm-1 text-center">WH</div>
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
<form class="form-inline" action="index.html" method="post">
	<div class="row">
		<div class="col-sm-9">
			<div class="row numeric">
				<div class="col-sm-4">
					<input class="input-xs" type="text" name="" value="Add new Item">
				</div>
				<div class="col-sm-1 text-right">
					<input class="input-xs text-right" type="text" size="6" name="" value="2">
				</div>
				<div class="col-sm-2 text-right">
					<input class="input-xs text-right" type="text" size="10" name="" value="33.09">
				</div>
				<div class="col-sm-2 text-right">
					$ 100.00
				</div>
				<div class="col-sm-2 text-center">
					05/29/2018
				</div>
				<div class="col-sm-1 text-center">
					BU
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-2"> <span class="visible-xs-block action-label text-right">Details</span>
					<a href="<?= $config->pages->ajax."load/view-detail/cart/?line=".$detail->linenbr; ?>" class="btn btn-xs btn-primary view-item-details" data-itemid="<?= $detail->itemid; ?>" data-kit="<?= $detail->kititemflag; ?>" data-modal="#ajax-modal"><i class="material-icons">&#xE8DE;</i></a>
				</div>
				<div class="col-sm-2"> <span class="visible-xs-block action-label">Docs</span> <span class="text-muted"><i class="material-icons md-36">&#xE873;</i></span> </div>
				<div class="col-sm-2"> <span class="visible-xs-block action-label">Notes</span> <?= $cartdisplay->generate_loaddplusnoteslink($cart, $detail->linenbr); ?></div>

				<div class="col-sm-6">
					<?= $cartdisplay->generate_detailvieweditlink($cart, $detail); ?>
					<form class="inline-block" action="<?= $config->pages->cart."redir/"; ?>" method="post">
						<input type="hidden" name="action" value="remove-line">
						<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
						<button type="submit" class="btn btn-md btn-danger inline-block" name="button">
							<span class="glyphicon glyphicon-trash"></span><span class="sr-only">Delete</span>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</form>
