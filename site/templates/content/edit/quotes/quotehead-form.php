<?php $quote = get_quotehead(session_id(), $qnbr, false); $hidden_domestic = '';  ?>
<form id="quotehead-form" action="<?php echo $config->pages->quotes."redir/";  ?>" class="form-group" method="post">
	<input type="hidden" name="action" value="save-quotehead">
	<input type="hidden" name="qnbr" id="qnbr" value="<?php echo $qnbr; ?>">
    <input type="hidden" name="custid" id="custID" value="<?php echo $quote['custid']; ?>">
    <div class="row"> <div class="col-xs-10 col-xs-offset-1"> <div class="response"></div> </div> </div>

    <div class="row">
    	<div class="col-sm-6">
        	<?php include $config->paths->content.'edit/quotes/quotehead/bill-to.php'; ?>
            <?php include $config->paths->content.'edit/quotes/quotehead/ship-to.php'; ?>
        </div>
        <div class="col-sm-6">
        	<?php include $config->paths->content.'edit/quotes/quotehead/quote-info.php'; ?>
			<div class="text-right form-group">
				<?php if ($editquote['canedit']) : ?>
	        		<button type="button" class="btn btn-success text-center" onclick="$('#quotedetail-link').click()"><span class="glyphicon glyphicon-triangle-right"></span> Details Page</button>
				<?php endif; ?>
	        </div>
        </div>
    </div>
	<div class="text-center form-group">
		<button type="submit" class="btn btn-success btn-block save-quotehead"><i class="glyphicon glyphicon-floppy-disk"></i> Save Changes</button>
	</div>
	<div class="row">
		<div class="col-sm-6 form-group">
			<div class="text-center">
				<button type="button" class="btn btn-success btn-block save-unlock-quotehead"><i class="fa fa-unlock" aria-hidden="true"></i> Save and Unlock Quote</button>
			</div>
		</div>
		<div class="col-sm-6 form-group">
			<div class="text-center">
				<button type="button" class="btn btn-success btn-block save-unlock-quotehead"><i class="fa fa-unlock" aria-hidden="true"></i> Save and Unlock Quote</button>
			</div>
		</div>
	</div>
</form>
