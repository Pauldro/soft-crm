<?php 
    if ($input->get->ordn) {
        $page->body = $config->paths->content."warehouse/picking/sales-order/item-pick-screen.php";
    } else {
        $url = new Purl\Url($page->fullURL->getUrl());
        $url->path = $config->pages->salesorderpicking."redir/";
        $url->query->set('action', 'initiate-pick')->set('sessionID', session_id());
        curl_redir($url->getUrl());
        $page->body = $config->paths->content."warehouse/picking/sales-order/choose-sales-order-form.php";
    }
    
    $toolbar = false;

    include $config->paths->content."common/include-toolbar-page.php";
