<?php
	$uninvoicedfile = $config->jsonfilepath.session_id()."-viuninvoiced.json";
	// $uninvoicedfile = $config->jsonfilepath."viuni-viuninvoiced.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->openandclose('p', '', $page->bootstrap->makeprintlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($uninvoicedfile)) {
		// JSON FILE will be false if an error occured during file get or json decode
		$uninvoicedjson = json_decode(convertfiletojson($uninvoicedfile), true);
		$uninvoicedjson ? $uninvoicedjson : array('error' => true, 'errormsg' => 'The VI Uninvoiced Purchase Orders JSON contains errors. JSON ERROR: ' . json_last_error());
		
		if ($uninvoicedjson['error']) {
			echo $page->bootstrap->createalert('warning', $uninvoicedjson['errormsg']);
		} else {
			$headercolumns = array_keys($uninvoicedjson['columns']['header']);
		    $detailcolumns = array_keys($uninvoicedjson['columns']['details']);
			
			if (sizeof($uninvoicedjson['data']) > 0) {
				
				$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id=uninvoiced');
				$tb->tablesection('thead');
					$tb->tr();
					$count = (count($uninvoicedjson['columns']['header'])) - 1;
					foreach ($headercolumns as $column) {
						$tb->th('class='.$config->textjustify[$uninvoicedjson['columns']['header'][$column]['headingjustify']], $uninvoicedjson['columns']['header'][$column]['heading']);
						// needs this because errors were coming up for detail
						$count--;
						if ($count == 0){
							break;
						}
					}
					$tb->tr();
					foreach ($detailcolumns as $column) {
						$tb->th('class='.$config->textjustify[$uninvoicedjson['columns']['details'][$column]['headingjustify']], $uninvoicedjson['columns']['details'][$column]['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					$maxrows = count($uninvoicedjson['data']['purchaseorders']);
					for ($row = 1; $row < $maxrows; $row++) {
						$tb->tr('');
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['header']['Purchase Order Number']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['Purchase Order Number']);
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['header']['Receipt Date']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['Receipt Date']);
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['header']['Item ID']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['Item ID']);
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['header']['Item Description 1']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['Item Description 1']);
						$count = 0;
						foreach ($uninvoicedjson['data']['purchaseorders'][$row]['details'] as $details) {
							$count++;
							$tb->tr('');
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Unit of Measure']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Unit of Measure']);
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Quantity Received']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Quantity Received']);
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Quantity Invoiced']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Quantity Invoiced']);
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Quantity Uninvoiced']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Quantity Uninvoiced']);
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Unit Cost']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Unit Cost']);
								$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Total Amount']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['details'][$count]['Total Amount']);
						}
						$tb->tr('');
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Unit of Measure']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['totals']['Unit of Measure']);
							$tb->td('');
							$tb->td('');
							$tb->td('');
							$tb->td('');
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Total Amount']['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['totals']['Total Amount']);
						$tb->tr('class=last-section-row');
						}
					$tb->tr('class=bg-primary');
						$tb->td('');
						$tb->td('');
						$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Unit of Measure']['headingjustify']], $uninvoicedjson['data']['vendortotals']['Unit of Measure']);
						$tb->td('');
						$tb->td('');
						$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details']['Total Amount']['headingjustify']], $uninvoicedjson['data']['vendortotals']['Total Amount']);
				$tb->closetablesection('tbody');
				echo $tb->close();
			}
			}
			
		} else {
			echo $page->bootstrap->createalert('warning', 'Information not available.');
		}
?>
