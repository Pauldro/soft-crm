<?php 
    if ($input->get->text('action') == 'denied') {
        include $config->paths->content."common/permission-denied-page.php";
    } else {
        $page->body = $config->paths->content."warehouse/picking/picking-menu.php";
        include $config->paths->content.'common/include-page.php';
    }
