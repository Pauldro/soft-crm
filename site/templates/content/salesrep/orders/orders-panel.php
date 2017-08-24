<?php
	//SETUP AJAX
	$ajax = new stdClass();
	$ajax->loadinto = "#orders-panel"; //WHERE TO LOAD AJAX LOADED DATA
	$ajax->focus = "#orders-panel"; //WHERE TO FOCUS AFTER LOADED DATA IS LOADED
	$ajax->searchlink = $config->pages->ajax.'load/order-search/';  //LINK TO THE SEARCH PAGE FOR THIS OBJECT
	$ajax->data = 'data-loadinto="'.$ajax->loadinto.'" data-focus="'.$ajax->focus.'"'; //DATA FIELDS FOR JAVASCRIPT

	$ajax->url = $page->fullURL;
	$ajax->url->path->setDplusPath("load/orders/salesrep/", $input->urlSegmentsStr."/");
	$ajax->url->query->setData(array("display" => false, "ajax" => false));

	$ajax->path = $ajax->url->path; //MODAL TO LOAD INTO IF NEED BE
	$ajax->querystring = $ajax->url->query;//BASE QUERYSTRING NEEDED FOR AJAX
	$ajax->link = $ajax->url; //LINK TO THE AJAX FILE


	$ajax->insertafter = 'salesrep';

    if ($config->ajax) {$collapse = '';} else {$collapse = 'collapse'; }


	include $config->paths->content.'recent-orders/setup.php';
	$ordercount =  get_salesrep_order_count(session_id(), false);
	$totalcount = $ordercount;

?>
<div class="panel panel-primary not-round" id="orders-panel">
    <div class="panel-heading not-round" id="order-panel-heading">
    	<?php if (isset($_SESSION['order-search'])) : ?>
        	<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Searching for <?php echo $_SESSION['order-search']; ?> <span class="caret"></span> <span class="badge"><?php echo $ordercount; ?></span>
            </a>
    	<?php elseif ($ordercount > 0) : ?>
            <a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">Your Orders <span class="caret"></span></a> &nbsp; <span class="badge"> <?php echo $ordercount; ?></span> &nbsp; | &nbsp;
            <a href="<?php echo $config->pages->orders."redir/?action=load-orders"; ?>" class="generate-load-link" id="load-cust-orders" <?php echo $ajax->data; ?>>
                <i class="fa fa-refresh" aria-hidden="true"></i> Refresh Orders
            </a>
        <?php else : ?>
        	<a href="<?php echo $config->pages->orders."redir/?action=load-orders"; ?>" class="generate-load-link" id="load-cust-orders"  <?php echo $ajax->data; ?>>
                Customer Orders
            </a>
        <?php endif; ?>
		&nbsp; &nbsp;
		<?php
			if (isset($_SESSION['orders-loaded-for'])) {
				if ($_SESSION['orders-loaded-for'] == $user->loginid) {
					echo 'Last Updated : ' . $_SESSION['orders-updated'];
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
                	<a href="<?php echo $ajax->searchlink; ?>" class="btn btn-default bordered search-orders" data-modal="#order-search-modal">Search Orders</a>
                    &nbsp; &nbsp; &nbsp;
                    <?php if (isset($_SESSION['order-search'])) : ?>
                    <a href="<?php echo $config->pages->customer."redir/?custID=".$custID;?>" class="btn-warning btn" id="load-cust-orders" <?php echo $ajax->data; ?>>
                        Clear Search
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <?php include $config->paths->content.'salesrep/orders/orders-table.php'; ?>
            <?php $totalpages = ceil($totalcount / $config->showonpage); ?>
            <?php include $config->paths->content.'pagination/ajax/pagination-links.php'; ?>
        </div>
    </div>
</div>
