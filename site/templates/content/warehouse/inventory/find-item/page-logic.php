<?php
	// GETS CUSTOMER CONFIGS FOR THIS FUNCTION / MENU AREA
	$functionconfig = $pages->get('/config/warehouse/inventory/');

	/////////////////////////////////////////////////////////////////////////////////////////////
	// Inventory Results Grouping
	//
	// If they have lotted or serialized Items then we have to show all the results, do not group
	// If they don't then we pull the inventory grouping config
	// They might only want to see 
	//                             1. Distinct Items 
	//                             2. Different Results based on X-ref (standard 1/09/2018)
	//                             3. All results
	///////////////////////////////////////////////////////////////////////////////////////////////
	$inventory_results_grouping = $functionconfig->inventory_haslotserial ? 'all' : $functionconfig->inventory_results_grouping->value;
	
	// HOW TO GROUP ITEM RESULTS CAN BE CHANGED IN PROCESSWIRE /config/warehouse/inventory/
	switch ($inventory_results_grouping) {
		case 'distinct-item':
			$resultscount = InventorySearchItem::count_distinct_itemid(session_id());
			$items = InventorySearchItem::get_all_distinct_itemid(session_id());
			break;
		case 'x-ref':
			$resultscount = InventorySearchItem::count_distinct_xorigin(session_id());
			$items = InventorySearchItem::get_all_distinct_xorigin(session_id());
			break;
		case 'all':
			$resultscount = InventorySearchItem::count_all(session_id());
			$items = InventorySearchItem::get_all(session_id());
			break;
		default:
			$resultscount = InventorySearchItem::count_distinct_xorigin(session_id());
			$items = InventorySearchItem::get_all_distinct_xorigin(session_id());
			break;
	}
	
	$page->body = __DIR__."/inventory-results.php";
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
