<?php
    $config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
    $config->scripts->append($config->urls->templates.'scripts/pages/dashboard.js');
?>
<?php include('./_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <?php include $config->paths->content.'dashboard/dashboard-page-outline.php'; ?>
    </div>
<?php include('./_foot.php'); // include footer markup ?>
