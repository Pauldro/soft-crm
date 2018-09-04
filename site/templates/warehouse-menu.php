<?php 
    if (1 == 1) { // has_dpluspermission($user->loginid, 'ci')
        $page->body = $config->paths->content."warehouse/menu.php";
        include $config->paths->content."common/include-page.php";
    } else {
        include $config->paths->content."common/permission-denied-page.php";
    }
