<?php
    if (!WhseSession::does_sessionexist(session_id())) {
        WhseSession::start_session(session_id(), $page->fullURL);
        $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
    } else {
        $whsesession = WhseSession::load(session_id());
        
        if ($input->get->ordn) {
            if (empty($whsesession->binnbr)) {
                $page->title = 'Choose Starting Bin';
                $page->body = $config->paths->content."warehouse/picking/sales-order/choose-bin-form.php";
            } else {
                $page->body = $config->paths->content."warehouse/picking/sales-order/item-pick-screen.php";
            }
        }
    }
    
    $toolbar = false;

    include $config->paths->content."common/include-toolbar-page.php";
