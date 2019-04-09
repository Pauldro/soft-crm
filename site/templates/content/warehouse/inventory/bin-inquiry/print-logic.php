<?php
	use Dplus\FileServices\PDFMaker;
	$sessionID = $input->get->referenceID ? $input->get->text('referenceID') : session_id();


	if ($input->get->binID) {
		$binID = $input->get->text('binID');
		// GETS CUSTOMER CONFIGS FOR THIS FUNCTION / MENU AREA
		$functionconfig = $pages->get('/config/warehouse/inventory/');
		$resultscount = InventorySearchItem::count_distinct_itemid($sessionID);
		$items = InventorySearchItem::get_all_distinct_itemid($sessionID);
		$page->title = "Bin Inquiry for $binID";
		$page->body = __DIR__."/inventory-results.php";
	}


	if ($input->get->text('view') != 'pdf') {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('referenceID', $sessionID);
		$url->query->set('view', 'pdf');
		$url->query->set('print', 'pdf');
		$pdfmaker = new PDFMaker($sessionID, $page->parent->name, $url->getUrl());
		$result = $pdfmaker->process();
	}
	$page->body = __DIR__."/inventory-results-print.php";
	include $config->paths->content."common/include-print-page.php";
