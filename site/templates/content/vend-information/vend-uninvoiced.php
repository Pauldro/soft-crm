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
			
			$headercount = count($headercolumns);
			$detailcount = count($detailcolumns);
			
			if ($headercount > $detailcount) {
				$maxcolumns = $headercount;
			} else {
				$maxcolumns = $detailcount;
			}
			
				if (sizeof($uninvoicedjson['data']) > 0) {
					
					$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id=uninvoiced');
					$tb->tablesection('thead');
						$tb->tr();
						foreach ($headercolumns as $column) {
							$class = $config->textjustify[$uninvoicedjson['columns']['header'][$column]['headingjustify']];
							$tb->th("class=$class", $uninvoicedjson['columns']['header'][$column]['heading']);
						}
						$tb->tr();
						foreach ($detailcolumns as $column) {
							$class = $config->textjustify[$uninvoicedjson['columns']['details'][$column]['headingjustify']];
							$tb->th("class=$class", $uninvoicedjson['columns']['details'][$column]['heading']);
						}
					$tb->closetablesection('thead');
					$tb->tablesection('tbody');
						$maxrows = count($uninvoicedjson['data']['purchaseorders']);
						for ($row = 1; $row < $maxrows; $row++) {
							$tb->tr('');
								foreach ($uninvoicedjson['data']['purchaseorders'][$row] as $order) {
									if (!is_array($order)) {
										$key = array_search($order, ($uninvoicedjson['data']['purchaseorders'][$row]));
										$class = $config->textjustify[$uninvoicedjson['columns']['header'][$key]['datajustify']];
										$tb->td("class=$class", $order);
									} else {
										$tb->td('');
										break;
									}
								}
							$detailmaxrows = count($uninvoicedjson['data']['purchaseorders'][$row]['details']);
							for ($i = 1; $i < $detailmaxrows + 1; $i++) {
								$tb->tr('');
								foreach ($uninvoicedjson['data']['purchaseorders'][$row]['details'][$i] as $detail) {
									$key = array_search($detail, ($uninvoicedjson['data']['purchaseorders'][$row]['details'][$i]));
									$class = $config->textjustify[$uninvoicedjson['columns']['details'][$key]['datajustify']];
									$tb->td("class=$class", $detail);
								}
							}
							$tb->tr('');
								foreach ($uninvoicedjson['data']['purchaseorders'][$row]['totals'] as $total) {
									$key = array_search($total, ($uninvoicedjson['data']['purchaseorders'][$row]['totals']));
									$class = $config->textjustify[$uninvoicedjson['columns']['details'][$key]['datajustify']];
									$tb->td("class=$class", $total);
								}
							$tb->tr('class=last-section-row');
								for ($x = 1; $x < $maxcolumns + 1; $x++) {
									$tb->td('');
								}
							}
						$tb->tr('class=bg-primary');
							foreach ($uninvoicedjson['data']['vendortotals'] as $total) {
								$key = array_search($total, ($uninvoicedjson['data']['vendortotals']));
								$class = $config->textjustify[$uninvoicedjson['columns']['details'][$key]['datajustify']];
								$tb->td("class=$class", $total);
							}
					$tb->closetablesection('tbody');
					echo $tb->close();
				}
			}
			
		} else {
			echo $page->bootstrap->createalert('warning', 'Information not available.');
		}
?>
