<form action="<?php echo $config->pages->customer."load-index/"; ?>" method="POST" id="cust-index-search" data-modal="#ajax-modal">
    <div class="form-group">
        <div class="input-group custom-search-form">
            <input type="hidden" name="sourcepage" class="sourcepage" value="<?php echo $source; ?>">
            <?php if ($input->get->function) : ?>
                
            	<input type="hidden" name="function" class="function" value="<?php echo $function; ?>">
                
            <?php endif; ?>

            <input type="text" class="form-control query" name="q" placeholder="Type customer phone, name, ID, contact">
            <span class="input-group-btn"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span> </button> </span>
        </div>
    </div>
</form>
