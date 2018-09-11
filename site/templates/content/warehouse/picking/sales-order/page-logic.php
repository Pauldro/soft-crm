<?php
    if (!WhseSession::does_sessionexist(session_id())) {
        WhseSession::start_session(session_id(), $page->fullURL);
        $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
    } else {
        $whsesession = WhseSession::load(session_id());
        
        if ($input->get->ordn) {
            // CHECK IF BIN IS DEFINED AND THAT tHE ORDER IS NOT IN FINISHED STATUS
            if ($whsesession->is_orderinvalid()) {
                $page->body = $config->paths->content."warehouse/picking/sales-order/invalid-order.php";
            } else if (!$whsesession->has_bin() && !$whsesession->is_orderfinished()) {
                if ($whsesession->is_orderonhold() || $whsesession->is_orderverified() || $whsesession->is_orderinvoiced()) {
                    $page->body = $config->paths->content."warehouse/picking/sales-order/order-on-hold.php";
                } else {
                    $page->title = 'Choose Starting Bin';
                    $page->title = var_dump($whsesession->is_orderinvalid());
                    $page->body = $config->paths->content."warehouse/picking/sales-order/choose-bin-form.php";
                }
            } else {
                if (Pick_SalesOrderDetail::has_detailstopick(session_id())) { // ARE THERE ITEMS ASSIGNED TO USER TO PICK?
                    $pickitem = Pick_SalesOrderDetail::load(session_id());
                    $pickitem->init();
                    $config->scripts->append(hashtemplatefile('scripts/warehouse/pick-order.js'));
                    $page->body = $config->paths->content."warehouse/picking/sales-order/item-pick-screen.php";
                } elseif ($whsesession->is_orderfinished()) { // IS THE USER DONE WITH THE ASSIGNED ORDER?
                    $order = Pick_SalesOrder::load(session_id(), $input->get->text('ordn'));
                    Pick_SalesOrder::load(session_id(), $input->get->text('ordn'));
                    $config->scripts->append(hashtemplatefile('scripts/warehouse/pick-order.js'));
                    $page->body = $config->paths->content."warehouse/picking/sales-order/finished-order-screen.php";
                } else {
                    if ($whsesession->is_orderfinished() || $whsesession->is_orderexited()) {
                        $whsesession->delete_orderpickeditems();
                    }
                    $config->scripts->append(hashtemplatefile('scripts/warehouse/pick-order.js'));
                    $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
                }
            }
        } else {
            if ($whsesession->is_orderfinished() || $whsesession->is_orderexited()) {
                $whsesession->delete_orderpickeditems();
            }
            $config->scripts->append(hashtemplatefile('scripts/warehouse/pick-order.js'));
            $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
        }
    }
    
    $toolbar = false;
    include $config->paths->content."common/include-toolbar-page.php";
    
