<form action="<?php echo $config->pages->ajax."load/vendors/vend-index/"; ?>" method="POST" id="vi-vend-lookup">
    <div class="form-group">
        <div class="input-group custom-search-form">
            <input type="text" class="form-control input-sm not-round vendorID" name="vendorID" placeholder="Search vendorID" value="<?= $vendorID; ?>">
            <input type="hidden" class="vendorshipfromID" name="vendorshipfromID" value="<?= $vendorshipfromID; ?>"> 
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-sm btn-default not-round"> <span class="glyphicon glyphicon-search"></span> </button>
            </span>
        </div>
    </div>
</form>
