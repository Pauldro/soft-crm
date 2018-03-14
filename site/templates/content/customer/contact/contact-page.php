<a href="<?= $contact->generate_customerurl(); ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go To <?= $contact->get_customername()."'s"; ?> Page </a>

<div class="row">
	</br>
	<div class="col-sm-12"> <?php include $config->paths->content.'customer/contact/contact-card.php'; ?> </div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content."customer/contact/actions/actions-panel.php"; ?>
	</div>
</div>
