<?php 
	$config->scripts->append($config->urls->templates.'scripts/edit/edit-pricing.js');
    if (getcartheadcount(session_id(), false) > 0) {
        $carthead = getcarthead(session_id(), false);
        $custID = $carthead['custid'];
        $shipID = $carthead['shiptoid'];
        $page->title = "Cart for ".get_customer_name($carthead['custid']);
    }
?>
   <?php include('./_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <?php include $config->paths->content.'cart/cart-outline.php'; ?>
    </div>
    <button class="btn btn-primary" onclick="opencustindexmodal('', '<?= $config->pages->cart; ?>')">Choose Cust</button> 
<?php include('./_foot.php'); // include footer markup ?>