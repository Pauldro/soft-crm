<?php if (does_user_have_access_contact($user->loginid, $user->hasrestrictions, $custID, $shipID, $contactID, false)) : ?>
	<?php $contact = getcustcontact($custID, $shipID, $contactID, false); ?>
	<h3 class="text-muted"><?php echo $contact['contact']; ?></h3>
	<?php include $config->paths->content.'customer/contact/contact-address.php'; ?>
	<div class="row">
		<div class="col-sm-6"> <?php include $config->paths->content.'customer/contact/contact-card.php'; ?> </div>
		<div class="col-sm-6">
			<?php include $config->paths->content."customer/contact/tasks-panel.php"; ?>
		</div>
	</div>
<?php endif; ?>
