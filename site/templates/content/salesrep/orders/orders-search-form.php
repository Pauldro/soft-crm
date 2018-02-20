
<?php include('./_head.php'); // include header markup ?>
<?php
	$orderpanel = new CustomerSalesOrderPanel(session_id(), $page->fullURL, '#ajax-modal', '#orders-panel', $config->ajax);
	$orderpanel->set_customer('JAMES', '0001');
	$orderpanel->pagenbr = $input->pageNum;
	$orderpanel->activeID = !empty($input->get->ordn) ? $input->get->text('ordn') : false;
	$orderpanel->get_ordercount();
	
	$paginator = new Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
?>
<div class="page container">
    
    <!-- TODO: needs a CSS class to move down in line with the first cell -->
    </br></br> 
    <div class="row">
        <div class="col-sm-2">
            <form action="<?php echo $config->pages->orders."redir/"; ?>" method="post" id="order-search-form" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="fuelux">
                <input type="hidden" name="custID" value="<?php echo $custID; ?>">  
                <input type="hidden" name="action" value="search-cust-orders">
                <input type="hidden" name="shipID" value="<?php echo $shipID; ?>">
                
                <!-- TODO: needs a CSS class to move down in line with the first cell -->
                </br></br> 
                <h4>Order Status :</h4>
                <label for="">New</label>
                <input class="pull-right" type="checkbox" name="status[]" value="New"></br>
                <label for="">Invoice</label>
                <input class="pull-right" type="checkbox" name="status[]" value="Invoice"></br>
                <label for="">Pick</label>
                <input class="pull-right" type="checkbox" name="status[]" value="Pick"></br>
                <label for="">Verify</label>
                <input class="pull-right" type="checkbox" name="status[]" value="Verify">
                
                <h4>Cust PO :</h4>
                <input class="form-control inline input-sm" type="text" name="custpo" value="" placeholder="Cust PO">
                
                <h4>Cust ID :</h4>
                <input class="form-control form-group inline input-sm" type="text" name="custid-low" value="" placeholder="From CustID">
                <input class="form-control form-group inline input-sm" type="text" name="custid-high" value="" placeholder="Through CustID">
                
                <h4>Order # :</h4>
                <input class="form-control form-group inline input-sm" type="text" name="orderno-low" value="" placeholder="From Order #">
                <input class="form-control form-group inline input-sm" type="text" name="orderno-high" value="" placeholder="Through Order #">
            
                <h4>Order Date :</h4>
                <label class="control-label">From Date </label>
                <?php $name = 'date-from'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="control-label">Through Date </label>
                <?php $name = 'date-through'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?></br>
                
                <div class="form-group">
                	<button class="btn btn-success btn-block" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-sm-10">
            <table class="table table-striped table-bordered table-condensed" id="orders-table">
            	<thead>
                   <?php include $config->paths->content.'customer/cust-page/orders/orders-thead-rows.php'; ?>
                </thead>
                <tbody>
                	<?php if ($input->get->ordn) : ?>
            			<?php if ($orderpanel->count == 0 && $input->get->text('ordn') == '') : ?>
                            <tr> <td colspan="12" class="text-center">No Orders found! Try using a date range to find the order(s) you are looking for.</td> </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php $orderpanel->get_orders(); ?>
                    <?php foreach ($orderpanel->orders as $order) : ?>
                        <tr class="<?= $orderpanel->generate_rowclass($order); ?>" id="<?= $order->orderno; ?>">
                        	<td class="text-center"><?= $orderpanel->generate_expandorcollapselink($order);?></td>
                            <td> <?= $order->orderno; ?></td>
                            <td><?= $order->custpo; ?></td>
                            <td>
                                <a href="<?= $orderpanel->generate_customershiptourl($order); ?>"><?= $order->shiptoid; ?></a>
                                <?= $orderpanel->generate_shiptopopover($order); ?>
                            </td>
                            <td align="right">$ <?= formatmoney($order->odrtotal); ?></td> <td align="right" ><?= $order->orderdate; ?></td>
                            <td align="right"><?=  $order->status; ?></td>
                            <td colspan="4">
                                <span class="col-xs-3"><?= $orderpanel->generate_loaddocumentslink($order); ?></span>
                                <span class="col-xs-3"><?= $orderpanel->generate_loadtrackinglink($order); ?></span>
                                <span class="col-xs-3"><?= $orderpanel->generate_loaddplusnoteslink($order, '0'); ?></span>
                                <span class="col-xs-3"><?= $orderpanel->generate_editlink($order); ?></span>
                            </td>
                        </tr>

                        <?php if ($order->orderno == $input->get->text('ordn')) : ?>
                        	<?php if ($input->get->show == 'documents' && (!$input->get('item-documents'))) : ?>
                            	<?php include $config->paths->content.'customer/cust-page/orders/order-documents-rows.php'; ?>
                            <?php endif; ?>

                           <?php include $config->paths->content.'customer/cust-page/orders/order-detail-rows.php'; ?>

                           <?php include $config->paths->content.'customer/cust-page/orders/order-totals.php'; ?>

                           <?php if ($input->get->text('show') == 'tracking') : ?>
            					<?php include $config->paths->content.'customer/cust-page/orders/order-tracking-rows.php'; ?>
                           <?php endif; ?>

                    	<?php if ($order->has_error()) : ?>
                            <tr class="detail bg-danger" >
                                <td colspan="2" class="text-center"><b class="text-danger">Error:</b></td>
                                <td colspan="2"><?= $order->errormsg; ?></td> <td></td> <td></td>
                                <td colspan="2"> </td> <td></td> <td></td> <td></td>
                            </tr>
                        <?php endif; ?>

                         <tr class="detail last-detail">
                         	<td colspan="2">
            					<?= $orderpanel->generate_viewprintlink($order); ?>
            				</td>
            				<td colspan="3">
            					<?= $orderpanel->generate_viewlinkeduseractionslink($order); ?>
            				</td>
                            <td>
                            	<a class="btn btn-primary btn-sm" onClick="reorder('<?= $order->orderno; ?>')">
                                	<span class="glyphicon glyphicon-shopping-cart" title="re-order"></span> Reorder Order
                                </a>
                            </td>
                            <td></td>  <td></td>
                            <td colspan="2">
                                <div class="pull-right"> <a class="btn btn-danger btn-sm load-link" href="<?= $orderpanel->generate_closedetailsurl($order); ?>" <?php echo $orderpanel->ajaxdata; ?>>Close</a> </div>
                            </td>
                         	<td></td>
                         </tr>
                    	<?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>      
    
<?php include('./_foot.php'); // include footer markup ?>
