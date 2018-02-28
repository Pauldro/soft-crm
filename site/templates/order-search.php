<?php 
    switch ($page->name) { //$page->name is what we are editing
            case 'order':
                $ordn = $input->get->text('ordn');
                $page->body = $config->paths->content.'search/sales-orders/search-orders.php';
                break;
            case 'quote':
                $qnbr = $input->get->text('qnbr');
                $page->body = $config->paths->content.'search/quotes/search-quotes.php';
                break;
        }

    include $config->paths->content."common/include-page.php";
