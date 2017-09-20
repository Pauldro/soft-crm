<form action="<?php echo $config->pages->ajax."load/vend-index/"; ?>" method="POST" id="vend-index-search-form">
    <div class="form-group">
        <?php if ($input->get->function) : ?>
        	<input type="hidden" name="function" class="function" value="<?= $input->get->function; ?>">
        <?php endif; ?>
        <input type="text" class="form-control vend-index-search" name="q" placeholder="Type vendor phone, name, ID, contact">
    </div>
    <div>
        <?php
            if ($input->get->q) {
                switch ($dplusfunction) {
                    case 'ci':
                        include $config->paths->content."customer/ajax/load/cust-index/ci-cust-list.php";
                        break;
                    case 'ii':
                        include $config->paths->content."customer/ajax/load/cust-index/ii-cust-list.php";
                        break;
                }
            } else {
                echo '<div id="vend-results"></div>';
            }
        ?>
    </div>
</form>
