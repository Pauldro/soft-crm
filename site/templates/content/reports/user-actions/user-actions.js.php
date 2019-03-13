<script>
	$(function() {
		<?php if (!empty($actionpanel->filters['assignedto'])) : ?>
			$('.selectpicker[name="assignedto[]"]').selectpicker('val', <?= json_encode($actionpanel->filters['assignedto']); ?>);
		<?php endif; ?>

		$("body").on("click", "[name='actiontype[]']", function(e) {
			var checkbox = $(this);
			var form = checkbox.closest('form');

			if (checkbox.is(':checked')) {
				if (checkbox.val() == 'all') {
					form.find("[name='actiontype[]']").not("[value='all']").prop('checked', true);
				} else {
					form.find("[name='actiontype[]'][value='all']").prop('checked', false);
				}
			}
		});

		<?php if ($config->ajax) : ?>
			$('.selectpicker[name="assignedto"]').selectpicker();
		<?php endif; ?>

		$('body').on('changed.bs.select', '.selectpicker[name="assignedto[]"]', function (e) {
			console.log($(this).val());
		});
	});
</script>
