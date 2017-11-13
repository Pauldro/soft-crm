<?php
	// $uninvoicedfile = $config->jsonfilepath.session_id()."-viuninvoiced.json";
	$uninvoicedfile = $config->jsonfilepath."viuni-viuninvoiced.json";
	
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
					$pocolumnmax = (count($uninvoicedjson['columns']['header'])) - 1;
					$detailcolumnmax = count($uninvoicedjson['columns']['details']);
					$maxrows = count($uninvoicedjson['data']['purchaseorders']);
					$row = 0;
					foreach ($uninvoicedjson['data']['purchaseorders'] as $order) {
						$row++;
						$tb->tr();
						for ($x = 1; $x < $pocolumnmax + 1; $x++) {
							$tb->td('');
						}
						$tb->tr('');
						for ($x = 1; $x < $detailcolumnmax + 1; $x++) {
							$tb->td('');
						}
						$tb->tr('');
						foreach ($uninvoicedjson['data']['purchaseorders'][$row]['totals'] as $total) {
							$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details'][$column]['headingjustify']], $uninvoicedjson['data']['purchaseorders'][$row]['totals'][$total]);
						}
						$tb->tr('class=last-section-row');
					}
					$tb->tr('class=bg-primary');
					foreach ($uninvoicedjson['data']['vendortotals'] as $totals) {
						$tb->td('class='.$config->textjustify[$uninvoicedjson['columns']['details'][$column]['headingjustify']], $uninvoicedjson['data']['vendortotals'][$totals]);
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
			} else {
				echo $page->bootstrap->createalert('warning', 'Information not available.');
			}
		}
	} else {
		echo $page->bootstrap->createalert('warning', 'Vendor has no Uninvoiced Purchase Orders'); 
	}
?>
