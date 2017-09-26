<?php
	$contactfile = $config->jsonfilepath.session_id()."-cicontact.json";
	//$contactfile = $config->jsonfilepath."cicont-cicontact.json";

	if ($config->ajax) {
		echo '<p>' . makeprintlink($config->filename, 'View Printable Version') . '</p>';
	}

	if (file_exists($contactfile)) {
		$contactjson = json_decode(file_get_contents($contactfile), true);
		if (!$contactjson) { $contactjson = array('error' => true, 'errormsg' => 'The customer Contacts JSON contains errors'); }

		if ($contactjson['error']) {
			createalert('warning', $contactjson['errormsg']);
		} else {
			$customerleftcolumns = array_keys($contactjson['columns']['customer']['customerleft']);
			$customerrightcolumns = array_keys($contactjson['columns']['customer']['customerright']);
			$shiptoleftcolumns = array_keys($contactjson['columns']['shipto']['shiptoleft']);
			$shiptorightcolumns = array_keys($contactjson['columns']['shipto']['shiptoright']);
			$contactcolumns = array_keys($contactjson['columns']['contact']);
			
			if (isset($contactjson['columns']['forms']))  {
				$formscolumns = array_keys($contactjson['columns']['forms']);
			}

			if (sizeof($contactjson['data']) > 0) {
				echo '<div class="row">';
					echo '<div class="col-sm-6">';
						$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
						foreach ($customerleftcolumns as $column) {
							$tb->tr();
							$tb->td('class='.$config->textjustify[$contactjson['columns']['customer']['customerleft'][$column]['headingjustify']], $contactjson['columns']['customer']['customerleft'][$column]['heading']);
							$tb->td('class='.$config->textjustify[$contactjson['columns']['customer']['customerleft'][$column]['datajustify']], $contactjson['data']['customer']['customerleft'][$column]);
						}
						echo $tb->close();
					echo '</div>';

					echo '<div class="col-sm-6">';
						$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
						foreach ($customerrightcolumns as $column) {
							$tb->tr();
							$tb->td('class='.$config->textjustify[$contactjson['columns']['customer']['customerright'][$column]['headingjustify']], $contactjson['columns']['customer']['customerright'][$column]['heading']);
							$tb->td('class='.$config->textjustify[$contactjson['columns']['customer']['customerright'][$column]['headingjustify']], $contactjson['data']['customer']['customerright'][$column]);
						}
						echo $tb->close();
					echo '</div>';
				echo '</div>';
				echo '<hr>';

				echo '<h2>Ship-To Contact Info</h2>';
				foreach ($contactjson['data']['shipto'] as $shipto) {
					echo '<h3>'.$shipto['shiptoid'].' - '.$shipto['shiptoname'].'</h3>';
					foreach ($shipto['shiptocontacts'] as $contact) {
						echo '<div class="row">';
							echo '<div class="col-sm-6">';
								$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
								foreach ($shiptoleftcolumns as $column) {
									$class =
									$tb->tr();
									$tb->td('class='.$config->textjustify[$contactjson['columns']['shipto']['shiptoleft'][$column]['headingjustify']], $contactjson['columns']['shipto']['shiptoleft'][$column]['heading']);
									$tb->td('class='.$config->textjustify[$contactjson['columns']['shipto']['shiptoleft'][$column]['datajustify']], $contact['shiptoleft'][$column]);
								}
								echo $tb->close();
							echo '</div>';

							echo '<div class="col-sm-6">';
								$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
								foreach ($shiptorightcolumns as $column) {
									$tb->tr();
									$tb->td('class='.$config->textjustify[$contactjson['columns']['shipto']['shiptoright'][$column]['headingjustify']], $contactjson['columns']['shipto']['shiptoright'][$column]['heading']);
									$tb->td('class='.$config->textjustify[$contactjson['columns']['shipto']['shiptoright'][$column]['datajustify']], $contact['shiptoright'][$column]);
								}
								echo $tb->close();
							echo '</div>';
						echo '</div>';
					}
				}

				echo '<h2>Customer Contact Info</h2>';
				$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
					$tb->tablesection('thead');
					$tb->tr();
						foreach ($contactcolumns as $column) {
							$tb->th('class='.$config->textjustify[$contactjson['columns']['contact'][$column]['headingjustify']], $contactjson['columns']['contact'][$column]['heading']);
						}
					$tb->closetablesection('thead');
					$tb->tablesection('tbody');
						foreach ($contactjson['data']['contact'] as $contact) {
							$tb->tr();
							$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactname']['datajustify']], $contact['contactname']);
							$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactemail']['datajustify']], $contact['contactemail']);
							if (isset($contact['contactnumbers']["1"]['contactnbr'])) {
								$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']], $contact['contactnumbers']["1"]['contactnbr']);
							} else {
								$tb->td();
							}
							for ($i = 1; $i < sizeof($contact['contactnumbers']) + 1; $i++) {
								if ($i != 1) {
									$tb->tr();
									$tb->td();
									$tb->td();
									$tb->td('class='.$config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']], $contact['contactnumbers']["$i"]['contactnbr']);
								}
							}
						}
					$tb->closetablesection('tbody');
				echo $tb->close();
				
				if (isset($contactjson['columns']['forms'])) : 
					echo '<h2>Forms Information</h2>';
					$tb = new Table('class=table table-striped table-bordered table-condensed table-excel');
						$tb->tablesection('thead');
							$tb->tr();
							foreach ($formscolumns as $column) {
								$tb->th('class='.$config->textjustify[$contactjson['columns']['forms'][$column]['headingjustify']], $contactjson['columns']['forms'][$column]['heading']);
							}
						$tb->closetablesection('thead');
						$tb->tablesection('tbody');
							foreach ($contactjson['data']['forms'] as $form) {
								$tb->tr();
								foreach ($formscolumns as $column) {
									$tb->th('class='.$config->textjustify[$contactjson['columns']['forms'][$column]['datajustify']], $form[$column]);
								}
							}
						$tb->closetablesection('tbody');
					echo $tb->close();
				endif;
			} else {
				createalert('warning', 'Information Not Available');
			}
		}
	} else {
		createalert('warning', 'Customer has no Contacts');
	}
?>
