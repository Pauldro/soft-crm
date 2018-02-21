<?php
    $cartdisplay = new CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();
    $custID = $cart->custid;
    $shipID = $cart->shiptoid;
    $itemlookup->set_customer($custID, $shipID);
    $page->pagetitle = "Quote for ".get_customername($custID);
    $noteurl = $config->pages->notes.'redir/?action=get-cart-notes';
    
    $config->scripts->append(hashtemplatefile('scripts/pages/cart.js'));
	$config->scripts->append(hashtemplatefile('scripts/edit/edit-pricing.js'));
	$page->body = $config->paths->content.'cart/cart-outline.php';
	include $config->paths->content."common/include-page.php";
?>
