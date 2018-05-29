<div id="no-more-tables">
    <table class="table-condensed cf order-details numeric">
        <thead class="cf">
            <tr>
                <th>Item / Description</th> <th class="numeric text-right">Qty</th> <th class="numeric text-right" width="90">Price</th> <th class="numeric text-right" width="90">Total</th>
                <th class="text-center">WH</th>
                <th>
                	<div class="row">
                    	<div class="col-xs-3">Details</div><div class="col-xs-3">Docs</div> <div class="col-xs-2">Notes</div> <div class="col-xs-4">Edit</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
       		<?php $quote_details = $editquotedisplay->get_quotedetails($quote); ?>
            <?php foreach ($quote_details as $detail) : ?>
                <tr>
                    <td data-title="Item">
                        <?php if ($detail->errormsg != '') : ?>
                            <div class="btn-sm btn-danger">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
                            </div>
                        <?php else : ?>
                            <?= $detail->itemid; ?>
                            <?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid;} ?>
                            <br> <?= $detail->desc1; ?>
    					<?php endif; ?>
                    </td>
                    <td data-title="Qty" class="text-right">
                        <input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->quotqty + 0; ?>">
                    </td>
                    <td data-title="Price" class="text-right">
                        <input class="input-xs text-right" size="10" type="text" name="" value="<?= formatMoney($detail->quotprice); ?>">
                    </td>
                    <td data-title="Total" class="text-right">$ <?= formatMoney($detail->quotprice * $detail->quotqty); ?></td>
                    <td data-title="WH" class="text-center"><?= $detail->whse; ?></td>
                    <td class="action">
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="visible-xs-block action-label">Details</span>
                                <?= $editquotedisplay->generate_viewdetaillink($quote, $detail); ?>
                            </div>
                            <div class="col-xs-3">
                                <span class="visible-xs-block action-label">Documents</span> <?= $editquotedisplay->generate_loaddocumentslink($quote, $detail); ?></div>
                            <div class="col-xs-2">
                                <span class="visible-xs-block action-label">Notes</span> <?= $editquotedisplay->generate_loaddplusnoteslink($quote, $detail->linenbr); ?></div>
                            <div class="col-xs-4">
                                <span class="visible-xs-block action-label">Edit</span>
                                <?= $editquotedisplay->generate_detailvieweditlink($quote, $detail); ?>
                                &nbsp;
                                <?= $editquotedisplay->generate_deletedetailform($quote, $detail); ?>
                            </div>
                        </div>
                    </td>
                </tr>
			<?php endforeach; ?>
                <!-- ADD ITEM SECTION -->
                <tr>
                    <td data-title="Item">
                        <input class="input-xs" size="30" type="text" name="" value="Add new Item">
                    </td>
                    <td data-title="Qty" class="text-right">
                        <input class="input-xs text-right" size="8" type="text" name="" value="<?= $detail->quotqty + 0; ?>">
                    </td>
                    <td data-title="Price" class="text-right">
                        <input class="input-xs text-right" size="10" type="text" name="" value="<?= formatMoney($detail->quotprice); ?>">
                    </td>
                    <td data-title="Total" class="text-right">$ </td>
                    <td data-title="WH" class="text-center"></td>
                    <td class="action">
                        <div class="row">
                            <div class="col-xs-3"><span class="visible-xs-block action-label">Details</span></div>
                            <div class="col-xs-3"><span class="visible-xs-block action-label">Documents</span></div>
                            <div class="col-xs-2"><span class="visible-xs-block action-label">Notes</span></div>
                            <div class="col-xs-4">
                                <span class="visible-xs-block action-label">Update</span>
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
