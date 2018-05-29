<div id="no-more-tables">
    <table class="table-condensed cf order-details">
        <thead class="cf">
            <tr>
                <th>Item / Description</th>
                <th class="numeric text-right">Qty</th> <th class="numeric text-right" width="90">Price</th> <th class="numeric text-right" >Total</th>
                <th class="numeric text-right">Shipped</th> <th class="text-center">Rqstd Ship</th> <th class="text-center">WH</th>
                <th>
                	<div class="row">
                    	<div class="col-xs-2 action-padding">Details</div><div class="col-xs-2 action-padding">Docs</div> <div class="col-xs-2 action-padding">Notes</div> <div class="col-xs-6 action-padding">Edit</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
       		<?php $order_details = $editorderdisplay->get_orderdetails($order) ?>
            <?php foreach ($order_details as $detail) : ?>
            <tr class="numeric">
                <td data-title="ItemID/Desc">
                    <?= $detail->itemid; ?>
                    <?php if ($detail->errormsg != '') : ?>
                        <div class="btn-sm btn-danger">
                          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
                        </div>
                    <?php else : ?>
                        <?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid;} ?>
                        <br> <?= $detail->desc1; ?>
					<?php endif; ?>
                </td>
                <td data-title="Ordered" class="text-right">
                    <input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->qty + 0; ?>">
                </td>
                <td data-title="Price" class="text-right">
                    <input class="input-xs text-right" size="10" type="text" name="" value="<?= formatMoney($detail->price); ?>">
                </td>
                <td data-title="Total" class="text-right">$ <?= formatMoney($detail->totalprice); ?></td>
                <td data-title="Shipped" class="text-right"><?= $detail->qtyshipped + 0; ?></td>
                <td data-title="Rqstd Date" class="text-center"><?= $detail->rshipdate; ?></td>
                <td data-title="WH" class="text-center"><?= $detail->whse; ?></td>
                <td class="action">
                    <div class="row">
                        <div class="col-xs-2 action-padding">
                            <span class="visible-xs-block action-label">Details</span>
							<?= $editorderdisplay->generate_viewdetaillink($order, $detail); ?>
                        </div>
                        <div class="col-xs-2 action-padding">
                            <span class="visible-xs-block action-label">Documents</span> <?= $editorderdisplay->generate_loaddocumentslink($order, $detail); ?></div>
                        <div class="col-xs-2 action-padding">
                            <span class="visible-xs-block action-label">Notes</span> <?= $editorderdisplay->generate_loaddplusnoteslink($order, $detail->linenbr); ?></div>
                        <div class="col-xs-6 action-padding">
                            <span class="visible-xs-block action-label">Update</span>
                            <?= $editorderdisplay->generate_detailvieweditlink($order, $detail); ?>
                            <?php if ($editorderdisplay->canedit) : ?>
                                <?= $editorderdisplay->generate_deletedetailform($order, $detail); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
			<?php endforeach; ?>
            <!-- NEW ITEM SECTION -->
            <tr class="numeric">
                <td data-title="ItemID/Desc">
                    <input class="input-xs" size="30" type="text" name="" value="Add new Item">
                </td>
                <td data-title="Ordered" class="text-right">
                    <input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->qty + 0; ?>">
                </td>
                <td data-title="Price" class="text-right">
                    <input class="input-xs text-right" size="10" type="text" name="" value="<?= formatMoney($detail->price); ?>">
                </td>
                <td data-title="Total" class="text-right">$ </td>
                <td data-title="Shipped" class="text-right"></td>
                <td data-title="Rqstd Date" class="text-center"></td>
                <td data-title="WH" class="text-center"></td>
                <td class="action">
                    <div class="row">
                        <div class="col-xs-2 action-padding"><span class="visible-xs-block action-label">Details</span></div>
                        <div class="col-xs-2 action-padding"><span class="visible-xs-block action-label">Documents</span></div>
                        <div class="col-xs-2 action-padding"><span class="visible-xs-block action-label">Notes</span></div>
                        <div class="col-xs-6 action-padding"><span class="visible-xs-block action-label">Update</span>
                            <button type="button" class="btn btn-sm btn-primary" name="button">
                                <span><i class="fa fa-plus"></i></span>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
