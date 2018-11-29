<?php
	// NOTE THE FOLLOWING IS FOR NORMAL ITEMS ONLY
	
	if ($input->get->scan) {
		$page->fullURL->query->remove('scan');
		
		$scan = $input->get->text('scan');
		$resultscount = count_invsearch(session_id());
		
		if ($resultscount == 0) {
			$page->body = $config->paths->content."{$page->path}item-form.php";
		} elseif ($resultscount == 1) {
			$item = get_firstinvsearchitem(session_id());
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = get_invsearchitems(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} elseif ($input->get->serialnbr) {
		
	} elseif ($input->get->lotnbr) {
		
	} elseif ($input->get->itemid) {
		$itemID = $input->get->text('itemid');
		$resultscount = count_invsearchbyitemid(session_id(), $itemID);
		
		if ($resultscount == 1) {
			$item = get_firstinvsearchitem(session_id());
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = get_invsearchitems(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} else {
		$page->body = $config->paths->content."{$page->path}item-form.php";
	}
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
