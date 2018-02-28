<?php 
    $orderpanel = new RepSalesOrderPanel(session_id(), $page->fullURL, '#ajax-modal', '#orders-panel', $config->ajax);
    $orderpanel->pagenbr = $input->pageNum;
    $orderpanel->activeID = !empty($input->get->ordn) ? $input->get->text('ordn') : false;
    $orderpanel->get_ordercount();
    $paginator = new Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
?>

<div class="row">
    <div class="col-sm-2">
        <form action="<?php echo $page->fullURL->getUrl(); ?>" method="get" id="order-search-form" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="fuelux">
            <input type="hidden" name="custID" value="<?php echo $custID; ?>">  
            <input type="hidden" name="action" value="search-cust-orders">
            <input type="hidden" name="shipID" value="<?php echo $shipID; ?>">
            
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
        <?php include $config->paths->content.'salesrep/orders/orders-table.php'; ?>
        <?= $paginator; ?>
    </div>
</div>
