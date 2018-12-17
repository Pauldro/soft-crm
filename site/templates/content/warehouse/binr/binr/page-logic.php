<?php
	// NOTE THE FOLLOWING IS FOR NORMAL ITEMS ONLY
	$config->scripts->append(hashtemplatefile('scripts/warehouse/binr.js'));
	$binID = '';
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	
	if ($input->get->scan) {
		$page->fullURL->query->remove('scan');
		
		$scan = $input->get->text('scan');
		$resultscount = InventorySearchItem::count_all(session_id());
		
		if ($resultscount == 0) {
			$page->body = $config->paths->content."{$page->path}item-form.php";
		} elseif ($resultscount == 1) {
			$item = InventorySearchItem::load_first(session_id());
			$pageurl = $page->fullURL->getUrl();
			header("Location: {$config->pages->menu_binr}redir/?action=search-item-bins&itemID=$item->itemid&page=$pageurl");
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} elseif ($input->get->serialnbr) {
		$serialnbr = $input->get->text('serialnbr');
		$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $serialnbr);
		
		if ($resultscount == 1) {
			$item = InventorySearchItem::load_from_lotserial(session_id(), $serialnbr);
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} elseif ($input->get->lotnbr) {
		$lotnbr = $input->get->text('lotnbr');
		$binID  = $input->get->text('binID');
		
		$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $lotnbr, $binID);
		
		if ($resultscount == 1) {
			$item = InventorySearchItem::load_from_lotserial(session_id(), $lotnbr, $binID);
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} elseif ($input->get->itemID) {
		$itemID = $input->get->text('itemID');
		$binID  = $input->get->text('binID');
		
		$resultscount = InventorySearchItem::count_from_itemid(session_id(), $itemID, $binID);
		
		if ($resultscount == 1) {
			$item = InventorySearchItem::load_from_itemid(session_id(), $itemID, $binID);
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} else {
		$page->body = $config->paths->content."{$page->path}item-form.php";
	}
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
