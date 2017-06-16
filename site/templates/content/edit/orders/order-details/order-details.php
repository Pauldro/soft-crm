<div id="no-more-tables">
    <table class="table-condensed cf order-details table-bordered">
        <thead class="cf">
            <tr>
                <th>Item ID</th> <th width="300">Description</th> <th class="numeric" width="90">Price</th> <th class="numeric">Ordered</th> <th class="numeric" width="90">Total</th>
                <th class="numeric">Shipped</th> <th>Rqstd Ship Date</th> <th>Whse</th>
                <th>
                	<div class="row">
                    	<div class="col-xs-3">Details</div><div class="col-xs-3">Documents</div> <div class="col-xs-3">Notes</div> <div class="col-xs-3">Item Info</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
       		<?php $order_details = getorderdetails(session_id(), $ordn, false); ?>
            <?php foreach ($order_details as $detail) : ?>
            	<?php
					$detailnoteurl = $config->pages->notes.'redir/?action=get-order-notes&ordn='.$ordn.'&linenbr='.$detail['linenbr'];

					if ($detail['havenote'] != 'Y') {
						$detnoteicon = '<a class="load-notes text-muted" href="'.$detailnoteurl.'" data-modal="#ajax-modal"><i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
					} else {
						$detnoteicon = '<a class="load-notes" href="'.$detailnoteurl.'" data-modal="#ajax-modal"> <i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
					}

                    if ($detail['haveitemdoc'] != 'Y') {
                        $detailnoteicon = '<a href="#" class="text-muted"><i class="material-icons md-36">&#xE873;</i></a> ';
                    } else {
                        $detailnoteicon = '<a href="'.$detailnoteurl.'"><i class="material-icons md-36">&#xE873;</i></a> ';
                    }

				?>
            <tr>
                <td data-title="ItemID"><?= $detail['itemid']; ?> </td>
                <td data-title="Description"><?= $detail['desc1']; ?></td>
                <td data-title="Price" class="text-right">$ <?= formatMoney($detail['price']); ?></td>
                <td data-title="Ordered" class="text-right"><?= $detail['qtyordered'] + 0; ?></td>
                <td data-title="Total" class="text-right">$ <?= formatMoney($detail['extamt']); ?></td>
                <td data-title="Shipped" class="text-right"><?= $detail['qtyshipped'] + 0; ?></td>
                <td data-title="Requested Ship Date" class="text-right"><?= $detail['rshipdate']; ?></td>
                <td data-title="Warehouse">MN</td>
                <td class="action">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="visible-xs-block action-label">Details</span>
                            <a href="<?= $config->pages->ajax."load/view-detail/order/?ordn=".$detail['orderno']."&line=".$detail['linenbr']; ?>" class="btn btn-xs btn-primary view-item-details" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"> <i class="material-icons">&#xE8DE;</i><a>
                        </div>
                        <div class="col-xs-3"> <span class="visible-xs-block action-label">Documents</span> <?= $detailnoteicon; ?></div>
                        <div class="col-xs-3"> <span class="visible-xs-block action-label">Notes</span> <?= $detnoteicon; ?></div>
                        <div class="col-xs-3"> <span class="visible-xs-block action-label">Update</span>
                            <?php if ($editorder['canedit']) : ?>
                                <a href="<?= $config->pages->ajax."load/edit-detail/order/?ordn=".$detail['orderno']."&line=".$detail['linenbr']; ?>" class="btn btn-xs btn-warning update-line" data-line="<?= $detail['recno']; ?>" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"  data-custid="<?= $order['custid']; ?>">
                                    <i class="material-icons">&#xE3C9;</i>
                                </a>
                            <?php else : ?>
                                <a href="<?= $config->pages->ajax."load/edit-detail/order/?ordn=".$detail['orderno']."&line=".$detail['linenbr']; ?>" class="btn btn-xs btn-warning update-line" data-line="<?= $detail['recno']; ?>" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"  data-custid="<?= $order['custid']; ?>">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
			<?php endforeach; ?>
        </tbody>
    </table>
</div>
