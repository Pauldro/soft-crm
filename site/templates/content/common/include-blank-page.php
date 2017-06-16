<?php include($config->paths->templates.'_head-blank.php'); // include header markup ?>
    <div class="container page">
       <h2 class="text-center"><?php echo $title; ?></h2>
        <?php include $modalbody; ?>
    </div>
<?php include($config->paths->templates.'_foot-blank.php'); // include footer markup ?>