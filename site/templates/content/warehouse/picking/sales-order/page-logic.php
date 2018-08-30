<?php
    if (!WhseSession::does_sessionexist(session_id())) {
        WhseSession::start_session(session_id(), $page->fullURL);
        $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
    } else {
        $whsesession = WhseSession::load(session_id());
        
        if ($input->get->ordn) {
            if (!$whsesession->has_bin()) {
                $page->title = 'Choose Starting Bin';
                $page->body = $config->paths->content."warehouse/picking/sales-order/choose-bin-form.php";
            } else {
                if (Pick_SalesOrderDetail::has_detailstopick(session_id())) { // ARE THERE ITEMS ASSIGNED TO USER TO PICK?
                    $pickitem = Pick_SalesOrderDetail::load(session_id());
                    $pickitem->init();
                    $config->scripts->append(hashtemplatefile('scripts/warehouse/pick-order.js'));
                    $page->body = $config->paths->content."warehouse/picking/sales-order/item-pick-screen.php";
                } elseif ($whsesession->is_orderfinished()) { // IS THE USER DONE WITH THE ASSIGNED ORDER?
                    $order = Pick_SalesOrder::load(session_id(), $input->get->text('ordn'));
                    Pick_SalesOrder::load(session_id(), $input->get->text('ordn'));
                    $page->body = $config->paths->content."warehouse/picking/sales-order/finished-order-screen.php";
                } else {
                    $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
                }
            }
            
        } else {
            $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
        }
    }
    
    $toolbar = false;
    include $config->paths->content."common/include-toolbar-page.php";
    
