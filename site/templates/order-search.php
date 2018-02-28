<?php 
    switch ($page->name) { //$page->name is what we are editing
            case 'sales-orders':
                $ordn = $input->get->text('ordn');
                $page->body = $config->paths->content.'search/sales-order/search-orders.php';
                break;
            case 'quotes':
                $qnbr = $input->get->text('qnbr');
                $page->body = $config->paths->content.'search/quotes/search-quotes.php';
                break;
        }

    include $config->paths->content."common/include-page.php";
