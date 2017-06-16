<form action="<?php echo $config->pages->ajax."load/ii/search-results/modal/"; ?>" method="POST" id="ii-item-lookup">
    <input type="hidden" name="action" value="ii-item-lookup">
    <input type="hidden" name="custID" class="custid" value="<?php echo $custID; ?>">
    <input type="hidden" name="shipID" class="shipid" value="<?php echo $shipID; ?>">
    <div class="form-group">
        <div class="input-group custom-search-form">
            <input type="text" class="form-control not-round itemid" name="itemid" placeholder="Search ItemID, X-ref" value="<?php echo $input->get->text('itemid'); ?>">
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search"></span> </button>
            </span>
        </div>
    </div>
    <input type="hidden" class="prev-itemid" value="<?php echo getitembyrecno(getnextrecno($input->get->text('itemid'), "prev", false), false); ?>">
	<input type="hidden" class="next-itemid" value="<?php echo getitembyrecno(getnextrecno($input->get->text('itemid'), "next", false), false); ?>">
</form>

