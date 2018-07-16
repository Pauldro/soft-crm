<?php 
    if ($input->get->ordn) {
        $page->body = $config->paths->content."warehouse/picking/sales-order/item-pick-screen.php";
    } else {
        $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
    }

    include $config->paths->content."common/include-toolbar-page.php";
