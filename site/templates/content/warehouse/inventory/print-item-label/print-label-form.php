<div class="form-group">
	<a href="<?= $page->url; ?>" class="btn btn-primary not-round">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> Return to Item Form
	</a>
</div>
<div class="col-sm-6">
	<?php include __DIR__."/item-details.php"; ?>

	<form action="<?= $page->parent->child('name=redir')->url; ?>" id="print-label-form" method="post">
		<input type="hidden" name="action" value="print-thermal-label">
		<input type="hidden" name="itemID" value="<?= $item->itemid; ?>">
		<input type="hidden" name="bin" value="<?= $item->bin; ?>">
		<input type="hidden" name="lotserial" value="<?= $item->lotserial; ?>">
		<input type="hidden" name="whseID" value="<?= $whsesession->whseid; ?>">
		<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">

		<div class="results">

		</div>
		<table class="table table-striped">
			<tr>
				<td colspan="2" class="bg-info text-center"><b>Product Label</b></td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Product Label</td>
				<td>
					<div class="label-input">
						<div class="input-group">
							<input type="text" class="form-control input-sm required" name="box-label" value="<?= $labelsession->label_box; ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#labelformats-modal" data-input="box-label">
									<span class="fa fa-search"></span>
								</button>
							</span>
						</div>
						<br>
						<p class="label-desc">
							<?= !empty($labelsession->label_box) ? ThermalLabelFormat::load_desc($labelsession->label_box) : '';  ?>
						</p>
					</div>
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Printer</td>
				<td>
					<div class="printer-input">
						<div class="input-group">
							<input type="text" class="form-control input-sm required" name="box-printer" value="<?= $labelsession->printer_box; ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#labelprinters-modal" data-input="box-printer">
									<span class="fa fa-search"></span>
								</button>
							</span>
						</div><br>
						<p class="printer-desc">
							<?= !empty($labelsession->printer_box) ? WhsePrinter::load_desc($whsesession->whseid, $labelsession->printer_box) : '';  ?>
						</p>
					</div>
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Box Qty</td>
				<td>
					<input class="form-control input-sm qty required" type="number" name="box-qty" value="0">
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Nbr of Labels</td>
				<td>
					<input class="form-control input-sm qty required" type="number" name="box-label-count" value="1">
				</td>
			</tr>
			<tr>
				<td colspan="2" class="bg-info text-center"><b>Master Pack</b></td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Master Pack Label</td>
				<td>
					<div class="label-input">
						<div class="input-group">
							<input type="text" class="form-control input-sm" name="masterpack-label" value="<?= $labelsession->label_master; ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#labelformats-modal" data-input="masterpack-label">
									<span class="fa fa-search"></span>
								</button>
							</span>
						</div><br>
						<p class="label-desc">
							<?= !empty($labelsession->label_master) ? ThermalLabelFormat::load_desc($labelsession->label_master) : '';  ?>
						</p>
					</div>
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Printer</td>
				<td>
					<div class="printer-input">
						<div class="input-group">
							<input type="text" class="form-control input-sm" name="masterpack-printer" value="<?= $labelsession->printer_master; ?>">
							<span class="input-group-btn">
								<button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#labelprinters-modal" data-input="masterpack-printer">
									<span class="fa fa-search"></span>
								</button>
							</span>
						</div><br>
						<p class="printer-desc">
							<?= !empty($labelsession->printer_master) ? WhsePrinter::load_desc($whsesession->whseid, $labelsession->printer_master) : '';  ?>
						</p>
					</div>
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Box Qty</td>
				<td>
					<input class="form-control input-sm qty" type="number" name="masterpack-qty">
				</td>
			</tr>
			<tr class="input-row">
				<td class="control-label">Nbr of Labels</td>
				<td>
					<input class="form-control input-sm qty" type="number" name="masterpack-label-count" value="0">
				</td>
			</tr>
		</table>
		<button type="submit" class="btn btn-sm btn-emerald not-round">Print Labels</button>
	</form>
</div>

<?php
	include __DIR__."/labels-modal.php";
	include __DIR__."/printers-modal.php";
?>
