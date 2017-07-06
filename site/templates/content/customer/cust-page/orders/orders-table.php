<table class="table table-striped table-bordered table-condensed" id="orders-table">
	<thead>
       <?php include $config->paths->content.'customer/cust-page/orders/orders-thead-rows.php'; ?>
    </thead>
    <tbody>
    	<?php if ($input->get->ordn) : ?>
			<?php if ($ordercount == 0 && $sanitizer->text($input->get->ordn) == '') : ?>
                <tr> <td colspan="12" class="text-center">No Orders found! Try using a date range to find the order(s) you are looking for.</td> </tr>
            <?php endif; ?>
        <?php endif; ?>

         <?php
			if ($orderby != "") {
				if ($orderby == "orderdate") {
					$orders = get_cust_orders_orderdate(session_id(), $custID, $config->showonpage, $input->pageNum(), $sortrule, false);
					$sql = get_cust_orders_orderdate(session_id(), $custID, $config->showonpage, $input->pageNum(), $sortrule, true);
				} else {
					$orders = get_cust_orders_orderby(session_id(), $custID, $config->showonpage, $input->pageNum(), $sortrule, $orderby, false);
					$sql = get_cust_orders_orderby(session_id(), $custID, $config->showonpage, $input->pageNum(), $sortrule, $orderby, true);
				}
			} else {
				$orders = get_cust_orders(session_id(), $custID, $config->showonpage, $input->pageNum(), false);
				$sql = get_cust_orders(session_id(), $custID, $config->showonpage, $input->pageNum(), true);
			}
		?>

        <?php foreach($orders as $order) :
				$on = $order['orderno'];
				$editlink = $config->pages->customer."redir/?action=get-order-details&ordn=".$on."&lock=lock";
				//$customer_link = $config->pages->customer.$custID."/";
				//$customer_ship = $customer_link . "shipto-" . urlencode($order['shiptoid'])."/";


				//CLICK TO EXPAND ICON
				$sorting = false;
				if ($on == $input->get->text('ordn')) {
					$oni = ""; $rowclass = 'selected';
					$orderlink = new \Purl\Url($page->httpUrl);
					$orderlink->path = $ajax->path;
					$orderlink->query->setData(array('ordn' => false, 'show' => false, 'orderby' => false));
					$ordnjsdata = $ajax->data;
				} else {
					$oni = $on; $rowclass = ''; $title = "View Order Details";
					if ($input->get->orderby) { $sorting = 	$orderby."-".$sortrule; } // just to set up the orderlink querystring replace
					$orderlink = new \Purl\Url($page->httpUrl);
					$orderlink->path = $config->pages->customer."redir/";
					$orderlink->query->setData(array('action' => 'get-order-details', 'ordn' => $on, 'custID' => urlencode($custID), 'page' => $input->pageNum, 'orderby' => $sorting));
					$ordnjsdata = 'data-loadinto="'.$ajax->loadinto.'"  data-focus="#'.$on.'"';
				}

				//DOCUMENTS ICON
				$docsurl = new \Purl\Url($page->httpUrl);
				$docsurl->path = $config->pages->customer."redir/";
				$docsurl->query->setData(array('action' => 'get-order-documents', 'ordn' => $on, 'linenbr' => '0', 'page' => $input->pageNum, 'orderby' => $sorting));

				if ($order['havedoc'] == 'Y') {
					$documentlink = '
								<a class="h3 generate-load-link" href="'.$docsurl.'" '.$ajax->data.'>
									<span class="sr-only">View Documents</span>
									<i class="material-icons md-36" title="Click to View Documents">&#xE873;</i>
								</a>';
				} else {
					$documentlink = '<a class="h3 text-muted">
										<span class="sr-only">View Documents</span>
										<i class="material-icons md-36" title="There are no documents for this order">&#xE873;</i>
									</a>';
				}


				//TRACKING ICON
				$trackhref = new \Purl\Url($page->httpUrl);
				$trackhref->path = $config->pages->customer."redir/";
				$trackhref->query->setData(array('action' => 'get-order-tracking','ordn' => $on,'page' => $input->pageNum,'orderby' => $sorting));


				if ($order['havetrk'] == 'Y') {
					$tracklink = '
								<a href="'.$trackhref.'" class="h3 generate-load-link" '.$ajax->data.'>
										<span class="sr-only">View Tracking</span><span class="glyphicon glyphicon-plane hover" title="Click to view Tracking"></span>
									</a>';
				} else {
					$tracklink = '<a class="text-muted h3">
										<span class="sr-only">View Tracking</span>
										<span class="glyphicon glyphicon-plane hover" title="There are no tracking numbers for this order"></span>
								  </a>';

				}

				//ORDER NOTES
				$noteurl = $config->pages->notes.'redir/?action=get-order-notes&ordn='.$on.'&linenbr=0';
				if ($order['havenote'] != 'Y') {
					$headnoteicon = '<a class="load-notes text-muted" href="'.$noteurl.'" data-modal="#ajax-modal"><i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
				} else {
					$headnoteicon = '<a class="load-notes" href="'.$noteurl.'" data-modal="#ajax-modal"> <i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
				}


				//ORDER LOCKS
				include ($config->paths->content."recent-orders/order-lock-logic.php");

				$shiptoaddress = $order['saddress']."<br>";
				if ($order['saddress2'] != '' ) { $shiptoaddress .= $order['saddress2']."<br>"; }
				$shiptoaddress .= $order['scity'].", ". $order['sst'].' ' . $order['szip'];

				$shiptopopover = 'data-toggle="popover" role="button" data-placement="top" data-trigger="focus" data-html="true" title="Ship-To Address"';

		?>

            <tr class="<?php echo $rowclass; ?>" id="<?php echo $on; ?>">
            	<?php if ($on == $input->get->text('ordn')) : ?>
                	 <td class="text-center">
                     	<a href="<?php echo $orderlink; ?>" class="btn btn-sm btn-primary load-link" <?php echo $ordnjsdata; ?>>-</a>
                     </td>
                <?php else : ?>
                	 <td class="text-center">
                     	<a href="<?php echo $orderlink; ?>" class="btn btn-sm btn-primary generate-load-link" <?php echo $ordnjsdata; ?>>+</a>
                     </td>
                <?php endif; ?>

                <td> <?php echo $order['orderno'];?> </td>
                <td><?php echo $order['custpo']; ?></td>
                <td>
                    <a href="<?php echo $customer_ship; ?>"><?php echo $shipID = $order['shiptoid']; ?></a>
                    <a tabindex="0" class="btn btn-default bordered btn-sm" <?php echo $shiptopopover; ?> data-content="<?php echo $shiptoaddress; ?>"><b>?</b></a>
                </td>
                <td align="right">$ <?php echo formatmoney($order['odrtotal']); ?></td> <td align="right" ><?php echo $order['orderdate']; ?></td>
                <td align="right"><?php echo $order['status']; ?></td>
                <td colspan="4">
                    <span class="col-xs-3"><?php echo $documentlink; ?></span>
                    <span class="col-xs-3"><?php echo $tracklink; ?></span>
                    <span class="col-xs-3"><?php echo $headnoteicon; ?> </span>
                    <span class="col-xs-3"><?php echo $editordericon; ?> </span>
                </td>
            </tr>

            <?php if ($on == $input->get->text('ordn')) : ?>
            	<?php if ($input->get->show == 'documents' && (!$input->get('item-documents'))) : ?>
                	<?php include $config->paths->content.'customer/cust-page/orders/order-documents-rows.php'; ?>
                <?php endif; ?>

               <?php include $config->paths->content.'customer/cust-page/orders/order-detail-rows.php'; ?>

               <?php include $config->paths->content.'customer/cust-page/orders/order-totals.php'; ?>

               <?php if ($input->get->text('show') == 'tracking') : ?>
					<?php include $config->paths->content.'customer/cust-page/orders/order-tracking-rows.php'; ?>
               <?php endif; ?>

        	<?php if ($order['error'] == 'Y') : ?>
                <tr class="detail bg-danger" >
                    <td colspan="2" class="text-center"><b class="text-danger">Error:</b></td>
                    <td colspan="2"><?php echo $order['errormsg']; ?></td> <td></td> <td></td>
                    <td colspan="2"> </td> <td></td> <td></td> <td></td>
                </tr>
            <?php endif; ?>

             <tr class="detail last-detail">
             	<td colspan="2">
					<a href="<?= $config->pages->notes."load/modal/order/?ordn=".$on; ?>" class="h3 load-into-modal" data-loadinto="#ajax-modal" data-modal="#ajax-modal"><i class="fa fa-sticky-note" aria-hidden="true"></i></a> &nbsp; &nbsp;
					<a href="<?= $config->pages->orders."redir/?action=get-order-details-print&ordn=".$on; ?>" class="h3" target="_blank">
						<i class="glyphicon glyphicon-print" aria-hidden="true"></i> <span class="sr-only">View Printable Order</span>
					</a>
				</td>
				<td colspan="3"><?php // TODO get_current_linked_tasks_count($user->loginid, $order['custid'], 'salesorderlink', $on, false); ?></td>
                <td>
                	<a class="btn btn-primary btn-sm" onClick="reorder()">
                    	<span class="glyphicon glyphicon-shopping-cart" title="re-order"></span> Reorder Order
                    </a>
                </td>
                <td></td>  <td></td>
                <td colspan="2">
                    <div class="pull-right"> <a class="btn btn-danger btn-sm load-link" href="<?php echo $orderlink; ?>" <?php echo $ordnjsdata; ?>>Close</a> </div>
                </td>
             	<td></td>
             </tr>
        	<?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
