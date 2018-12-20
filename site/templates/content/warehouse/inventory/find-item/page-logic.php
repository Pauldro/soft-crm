<?php
	$resultscount = InventorySearchItem::count_all(session_id());
	$items = InventorySearchItem::get_all(session_id());
	$page->body = __DIR__."/inventory-results.php";
	
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
