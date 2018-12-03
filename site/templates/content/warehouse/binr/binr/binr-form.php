<div class="row">
	<div class="col-sm-6">
		<?php include __DIR__."/scanned-item-details.php"; ?>
		<div>
			<h3>Select From Bin</h3>
			<div class="list-group">
				<div class="list-group-item">
	                <div class="row">
	                    <div class="col-xs-6">
	                        <h4 class="list-group-item-heading">Bin</h4>
	                    </div>
	                    <div class="col-xs-6">
	                        <h4 class="list-group-item-heading">On Hand</h4>
	                    </div>
	                </div>
	            </div>
				<a href="#" class="list-group-item">
	                <div class="row">
	                    <div class="col-xs-6">
	                        <p class="list-group-item-text">Pack</p>
	                    </div>
	                    <div class="col-xs-6">
	                        <p class="list-group-item-text text-right">26</p>
	                    </div>
	                </div>
	            </a>
			</div>
		</div>
		<div>
			<h3>From</h3>
			<div class="row">
				<div class="col-sm-6 form-group">
					<label for="from-bin">Bin</label>
					<input type="text" class="form-control input-sm" name="from-bin">
				</div>
				<div class="col-sm-6 form-group">
					<label for="bin-qty">Qty</label>
					<div class="input-group">
						<input type="text" class="form-control input-sm text-right" name="bin-qty" disabled>
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary btn-sm not-round">Use Bin Qty</button>
						</span>
					</div>
					
				</div>
			</div>
		</div>
		
		<div>
			<h3>To</h3>
			<div class="row">
				<div class="col-sm-6 form-group">
					<label for="to-bin">Bin</label>
					<input type="text" class="form-control input-sm" name="to-bin">
				</div>
				<div class="col-sm-6 form-group">
					<label for="move-qty">Qty</label>
					<input type="text" class="form-control input-sm text-right" name="move-qty">
				</div>
			</div>
		</div>
	</div>
</div>
