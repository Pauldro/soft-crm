<?php
	//SETUP AJAX
	$ajax = new stdClass();
	$ajax->loadinto = "#orders-panel"; //WHERE TO LOAD AJAX LOADED DATA
	$ajax->focus = "#orders-panel"; //WHERE TO FOCUS AFTER LOADED DATA IS LOADED
	$ajax->searchlink = $config->pages->ajax.'load/orders/search/cust/?custID='.urlencode($custID);  //LINK TO THE SEARCH PAGE FOR THIS OBJECT
	$ajax->data = 'data-loadinto="'.$ajax->loadinto.'" data-focus="'.$ajax->focus.'"'; //DATA FIELDS FOR JAVASCRIPT
	$ajax->path = buildajaxpath($config->pages->ajax, "load/orders/cust/", $input->urlSegmentsStr); //MODAL TO LOAD INTO IF NEED BE
	$ajax->querystring = querystring_replace($querystring, array("display", "ajax"), array(false, false)); //BASE QUERYSTRING NEEDED FOR AJAX
	$ajax->link = $ajax->path.$ajax->querystring; //LINK TO THE AJAX FILE

	if ($shipID != '') {
		$ajax->insertafter = 'shipto-'.$shipID;
		$ajax->searchlink .=	"&shipID=".urlencode($shipID);
	} else {
		$ajax->insertafter = $custID;
	}

    if ($config->ajax) {$collapse = '';} else {$collapse = 'collapse'; }


	include $config->paths->content.'recent-orders/setup.php';
	$ordercount =  get_cust_order_count(session_id(), $custID, false);
	$totalcount = $ordercount;

?>
<?php
	if ($session)
?>
<div class="panel panel-primary not-round" id="orders-panel">
    <div class="panel-heading not-round" id="order-panel-heading">
    	<?php if ($session->ordersearch) : ?>
        	<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Searching for <?php echo $session->ordersearch; ?> <span class="caret"></span> <span class="badge"><?php echo $ordercount; ?></span>
            </a>
    	<?php elseif ($ordercount > 0) : ?>
            <a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">Customer Orders <span class="caret"></span></a> <span class="badge"><?php echo $ordercount; ?></span>  |
            <a href="<?php echo $config->pages->customer."redir/?custID=".urlencode($custID); ?>" class="load-cust-orders" data-custid="<?php echo $custID; ?>" <?php echo $ajax->data; ?>>
                Load Orders
            </a>
        <?php else : ?>
        	<a href="<?php echo $config->pages->customer."redir/?custID=".urlencode($custID); ?>" class="load-cust-orders" data-custid="<?php echo $custID; ?>" <?php echo $ajax->data; ?>>
                Customer Orders
            </a>
        <?php endif; ?>
		&nbsp; &nbsp;
		<?php
			if ($session->{'orders-loaded-for'}) {
				if ($session->{'orders-loaded-for'} == $custID) {
					echo 'Last Updated : ' . $session->{'orders-updated'};
				}
			}
		?>
        <span class="pull-right"><?php if ($input->pageNum > 1 ) {echo 'Page '.$input->pageNum;} ?></span>
    </div>
    <div id="orders-div" class="<?php echo $collapse; ?>">
        <div class="panel-body">
        	<div class="row">
                <div class="col-sm-6">
                    <?php include $config->paths->content.'pagination/ajax/pagination-start.php'; ?>
                </div>
                <div class="col-sm-4">
                	<a href="<?php echo $ajax->searchlink; ?>" class="btn btn-default bordered search-orders" data-modal="#ajax-modal">Search Orders</a>
                    &nbsp; &nbsp; &nbsp;
                    <?php if ($session->ordersearch) : ?>
						<a href="<?php echo $config->pages->customer."redir/?custID=".urlencode($custID); ?>" class="btn-warning btn load-cust-orders" data-custid="<?php echo $custID; ?>" <?php echo $ajax->data; ?>>
							Clear Search
						</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <?php include $config->paths->content.'customer/cust-page/orders/orders-table.php'; ?>
            <?php $totalpages = ceil($totalcount / $config->showonpage); ?>
            <?php include $config->paths->content.'pagination/ajax/pagination-links.php'; ?>
        </div>
    </div>
</div>
