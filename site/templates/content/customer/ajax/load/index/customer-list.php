<?php include $config->paths->content."customer/ajax/load/index/search-index-form.php"; ?>
<?php if ($function == 'ii' || $function == 'ii-item-hist') : ?>
	<button type="button" class="btn btn-primary btn-sm" onclick="ii_customer('')">
		 Remove Customer ID
	</button>		
<?php endif; ?>
<div class="list-group customer-list">
	<?php if ($input->urlSegment2) : ?>
		<div class="list-group-item" id="<?= $customer['custid']."-row"; ?>">
			<div class="row">
				<div class="col-sm-5"><?php echo $customer['custid']." - ".$customer['name']; ?>
				 <a href="<?= $config->pages->customer."redir/?action=load-customer&custID=".$customer['custid']; ?>">
				 	<i class="glyphicon glyphicon-share"></i> View Page
				 </a>
				</div>
				<div class="col-sm-7">
					<button type="button" class="btn btn-primary btn-sm" onclick="pickcustomer('<?= $customer['custid']; ?>','<?= $count; ?>')">
						<span class="glyphicon glyphicon-th-list"></span> Load Ship-tos
					</button>
					&nbsp;
					
					&nbsp;
					<form action="<?php echo $config->pages->customer."redir/"; ?>" method="post" class="inline-block">
						<div class="form-group">
							<input type="hidden" name="action" value="shop-as-customer">
							<input type="hidden" name="page" value="<?= $source; ?>">
							<input type="hidden" name="custID" value="<?= $customer['custid']; ?>">
							<button type="submit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Shop as <?php echo $customer['custid']; ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php foreach ($customer_records as $customer) : ?>
			<div class="list-group-item" id="<?= $customer['custid']."-row"; ?>">
				<div class="row">
					<div class="col-sm-5"><?php echo $customer['custid']." - ".$customer['name']; ?></div>
					<div class="col-sm-7">
						<?php if ($function == 'ii') : ?>
							<button type="button" class="btn btn-primary btn-sm" onclick="ii_customer('<?= $customer['custid']; ?>')">
								 Pick Customer
							</button>
						<?php elseif ($function == 'ii-pricing') : ?>
							<button type="button" class="btn btn-primary btn-sm" onclick="chooseiipricingcust('<?= $customer['custid']; ?>', '')">
								 Pick Customer
							</button>
						<?php elseif($function == 'ii-item-hist') : ?>
							<button type="button" class="btn btn-primary btn-sm" onclick="chooseiihistorycust('<?= $customer['custid']; ?>', '')">
								 Pick Customer
							</button>
						<?php else : ?>
							<button type="button" class="btn btn-primary btn-sm" onclick="pickcustomer('<?= $customer['custid']; ?>','<?= $count; ?>', '<?= $source; ?>')">
								 <span class="glyphicon glyphicon-th-list"></span> Load Ship-tos
							</button>
							&nbsp;
							<a href="<?= $config->pages->customer."redir/?action=load-customer&custID=".$customer['custid']; ?>" class="btn btn-primary btn-sm"><i class="material-icons md-18">&#xE2C9;</i> Go To Customer Page</a>
							&nbsp;
							<form action="<?php echo $config->pages->customer."redir/"; ?>" method="post" class="inline-block">
								<div class="form-group">
									<input type="hidden" name="action" value="shop-as-customer">
									<input type="hidden" name="page" value="<?= $source; ?>">
									<input type="hidden" name="custID" value="<?= $customer['custid']; ?>">
									<button type="submit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Shop as <?php echo $customer['custid']; ?></button>
								</div>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php $count++; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php if ($input->urlSegment2) : ?>
		<h5>Ship-tos</h5>
		<table class="table table-condensed table-bordered">
			<thead>
				<tr> <th>Choose</th> <th>Ship-to ID</th> <th>Name</th> <th>Address</th> <th>Phone</th> </tr>
			</thead>
			<tbody>
				<?php foreach ($shiptos as $shipto) : ?>
					<tr>
						<?php $location = $shipto['addr1'] . ' ' . $shipto['addr2'] .' ' . $shipto['ccity'] . ', ' . $shipto['cst'] . ' ' . $shipto['czip']; ?>
						<td>
							<form action="<?php echo $config->pages->customer."redir/"; ?>" method="post">
								<input type="hidden" name="action" value="shop-as-customer">
								<input type="hidden" name="page" value="<?= $source; ?>">
								<input type="hidden" name="custID" value="<?= $customer['custid']; ?>">
								<input type="hidden" name="shipID" value="<?= $shipto['shiptoid']; ?>">
								<button type="submit" class="btn btn-sm btn-primary">Shop as <?php echo $shipto['name']; ?></button>
							</form>
						</td>
						<td><?php echo $shipto['shiptoid']; ?></td>
						<td><?php echo $shipto['name']; ?></td>
						<td><?php echo $location; ?></td>
						<td><?php echo $shipto['cphone']; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
