<?php
	// $costfile = $config->jsonfilepath.session_id()."-vicost.json";
	$costfile = $config->jsonfilepath."vicst-vicost.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->openandclose('p', '', $page->bootstrap->makeprintlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($costfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$costjson = json_decode(file_get_contents($costfile), true);
		$costjson = $costjson ? $costjson : array('error' => true, 'errormsg' => 'The Item Cost JSON contains errors. JSON ERROR: ' . json_last_error());
		
		if ($costjson['error']) {
			echo $page->bootstrap->createalert('warning', $costjson['errormsg']);
		} else {
			$standardpricecolumns = array_keys($costjson['columns']['standard pricing']);
			$customerpricecolumns = array_keys($costjson['columns']['customer pricing']);
			$derivedpricecolumns = array_keys($costjson['columns']['pricing derived from']);
			include $config->paths->content."cust-information/tables/item-pricing-tables.php";
			
			echo $itemtable;
			echo '<div class="row">';
				echo '<div class="col-sm-4">';
					echo '<h3>Standard Pricing</h3>';
					echo $standardpricingtable;
				echo '</div>';
				echo '<div class="col-sm-4">';
					echo '<h3>Customer Pricing</h3>';
					echo $customerpricingtable;
				echo '</div>';
				echo '<div class="col-sm-4">';
					echo '<h3>Pricing Derived From</h3>';
					echo $derivedpricingtable;
				echo '</div>';
			echo '</div>';
		}
	} else {
		echo $page->bootstrap->createalert('warning', 'Information Not Available');
	}
 ?>
