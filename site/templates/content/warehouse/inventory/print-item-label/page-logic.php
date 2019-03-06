<?php
	use Dplus\Warehouse\LabelPrinting;

	$toolbar = false;
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);
	$labelprinting = new LabelPrinting();
	$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/print-labels.js'));

	if ($input->get->scan) {
		$scan = $input->get->text('scan');
		$page->title = "Find Item Inquiry for $scan";
		$resultscount = InventorySearchItem::count_distinct_itemid(session_id());
		$items = InventorySearchItem::get_all_distinct_itemid(session_id());
		$page->body = __DIR__."/inventory-results.php";

	} elseif (!empty($input->get->serialnbr) | !empty($input->get->lotnbr) | !empty($input->get->itemID)) {
		$binID = $input->get->text('binID');

		if ($input->get->serialnbr) {
			$serialnbr = $input->get->text('serialnbr');
			$input->get->scan = $serialnbr;
			$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $serialnbr);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $serialnbr) : false;
		} elseif ($input->get->lotnbr) {
			$lotnbr = $input->get->text('lotnbr');
			$input->get->scan = $lotnbr;
			$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $lotnbr, $binID);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $lotnbr, $binID) : false;
		} elseif ($input->get->itemID) {
			$itemID = $input->get->text('itemID');
			$input->get->scan = $itemID;
			$resultscount = InventorySearchItem::count_from_itemid(session_id(), $itemID, $binID);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_itemid(session_id(), $itemID, $binID) : false;
		}

		if ($resultscount == 1) {
			if (LabelPrintSession::exists(session_id())) {
				$labelsession = LabelPrintSession::load(session_id());
			} else {
				$labelsession = new LabelPrintSession();
				$labelsession->set('sessionid', session_id());
				$labelsession->set('itemid', $item->itemid);
				$labelsession->set('bin', $item->bin);
				$labelsession->set('lotserial', $item->lotserial);
				$labelsession->set('whse', $whsesession->whseid);
			}

			$page->body = __DIR__."/print-label-form.php";
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = __DIR__."/inventory-results.php";
		}
	} else {
		$page->body = __DIR__."/inventory-results.php";
	}

	include $config->paths->content."common/include-toolbar-page.php";
