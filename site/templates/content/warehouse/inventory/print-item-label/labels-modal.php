<?php
	$labelformats = ThermalLabelFormat::find_formats();
?>
<div class="modal fade" id="labelformats-modal" tabindex="-1" role="dialog" aria-labelledby="labelformats-modal-label"  data-input="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="labelformats-modal-label">Choose Label format for <?= strtoupper($item->get_itemtypepropertydesc()) . ': '. $item->get_itemidentifier(); ?></h4>
			</div>
			<div class="modal-body">
				<div>
					<div class="list-group">
						<?php foreach ($labelformats as $labelformat) : ?>
							<a href="#" class="list-group-item select-labelformat">
								<div class="row">
									<div class="col-xs-6">
										<h5 class="list-group-item-heading format-id"><?= $labelformat->id; ?></h5>
										<h5 class="list-group-item-heading format-desc"><?= $labelformat->desc; ?></h5>
									</div>
									<div class="col-xs-6">
										L <?= $labelformat->length; ?> x W <?= $labelformat->width; ?>
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
