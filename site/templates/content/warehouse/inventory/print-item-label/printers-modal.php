<?php
	$printers = WhsePrinter::find_printers($whsesession->whseid);
?>
<div class="modal fade" id="labelprinters-modal" tabindex="-1" role="dialog" aria-labelledby="labelprinters-modal-label"  data-input="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="labelprinters-modal-label">Choose Printer</h4>
			</div>
			<div class="modal-body">
				<div>
					<div class="list-group">
						<?php foreach ($printers as $printer) : ?>
							<a href="#" class="list-group-item select-labelprinter">
								<div class="row">
									<div class="col-xs-6">
										<h5 class="list-group-item-heading printer-id"><?= $printer->id; ?></h5>
									</div>
									<div class="col-xs-6">
										<h5 class="list-group-item-heading printer-desc"><?= $printer->desc; ?></h5>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
