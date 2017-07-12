<?php

	if ($input->urlSegment1) {
		if ($input->urlSegment1 == 'load-index') {

		} else {
			$custID = $sanitizer->text($input->urlSegment1);
			$shipID = '';
			$customer = get_customer_name($input->urlSegment1);
			$page->title = $input->urlSegment1 . ' - ' . $customer;
			$user->hascustomeraccess = has_access_to_customer($user->loginid, $user->hascontactrestrictions, $custID, false);
			$config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
			$config->scripts->append($config->urls->templates.'scripts/pages/customer-page.js');
			$config->scripts->append($config->urls->templates.'scripts/dplusnotes/order-notes.js');
		    $config->scripts->append($config->urls->templates.'scripts/dplusnotes/quote-notes.js');
		}

	} else {
		if ($input->get->q) {
			$page->title = "Searching for '".$input->get->q."'";
		} else {
			$page->title = "Customer Index";
		}
	}

	if ($input->urlSegment2) {
		if ($input->urlSegment1 == 'load-index') {

		} else {
			if (strpos($input->urlSegment2, 'contacts') !== FALSE) {
				$contactID = $sanitizer->text($input->get->id);
				$page->title = $contactID .", " . $customer;
				$shipID = "";
			} elseif (strpos($input->urlSegment2, 'shipto-') !== FALSE) {
				$shipID = urldecode(str_replace('shipto-', '', $input->urlSegment2));
			} elseif (strpos($input->urlSegment2, 'orders') !== FALSE) {

			}

			if (strpos($input->urlSegment3, 'contacts') !== FALSE) {
				$contactID = $sanitizer->text($input->get->id);
				$page->title = $contactID .", " . $customer;
				$shipID = urldecode(str_replace('shipto-', '', $input->urlSegment2));
			}


			if (strlen($shipID) > 0) {
				$user->hasshiptoaccess = has_access_to_customer_shipto($user->loginid, $user->hascontactrestrictions, $custID, $shipID, false);
			} else {
				$user->hasshiptoaccess = false;
			}
		}

	}



?>
<?php if (!$config->ajax) : ?>
<?php include('./_head.php'); // include header markup ?>
	<div class="jumbotron pagetitle">
		<div class="container">
			<h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
		</div>
	</div>
    <div class="container page">
    <?php endif; ?>
    	<?php
			if ($input->urlSegment1) {
				if ($input->urlSegment1 == 'load-index') {
					include $config->paths->content.'customer/ajax/load/index/outline.php';
				} else {
					if ($input->urlSegment2) {
						if (strpos($input->urlSegment2, 'contacts') !== FALSE || strpos($input->urlSegment3, 'contacts') !== FALSE) {
							include $config->paths->content.'customer/contact/contact-page.php';
							//<div class="row"><div class="col-xs-12"></div></div>
						} else {
							if ($user->hasshiptoaccess) {
								include $config->paths->content.'customer/cust-page/customer-page-outline.php';
							} else {
								include $config->paths->content.'customer/cust-page/customer-access-denied.php';
							}

						}
					} else {
						if ($user->hascustomeraccess) {
							include $config->paths->content.'customer/cust-page/customer-page-outline.php';
						} else {
							include $config->paths->content.'customer/cust-page/customer-access-denied.php';
						}

					}
				}


			} else {
				include $config->paths->content.'customer/cust-index/customer-index.php';
			}
		?>
  <?php if (!$config->ajax) : ?>

    </div>
	<?php include('./_foot.php'); // include footer markup ?>
<?php endif; ?>
