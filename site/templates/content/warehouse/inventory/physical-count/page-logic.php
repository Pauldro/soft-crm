<?php
    use Dplus\Warehouse\PhysicalCount;
    
    $toolbar = false;
    $config->scripts->append(hashtemplatefile('scripts/warehouse/physical-count.js'));
    $whsesession = WhseSession::load(session_id());
	$whsesession->init();
    $whseconfig = WhseConfig::load($whsesession->whseid);
    
    
    if ($input->get->binID) {
            $binID = $input->get->text('binID');
            if ($whseconfig->validate_bin($binID)) {
                $physicalcounter = new PhysicalCount(session_id(), $page->fullURL);
                $physicalcounter->set_bin($binID);
                
                if ($input->get->scan) {
                    $itemquery = $input->get->text('scan');
                    // $resultscount = InventorySearchItem::count_distinct_xorigin(session_id());
                    $resultscount = InventorySearchItem::count_all(session_id());
                    
                    if ($resultscount == 1) {
                        $item = InventorySearchItem::load_first(session_id());
                        $page->body = __DIR__."/physical-count-form.php";
                    } else {
                        $items = InventorySearchItem::get_all(session_id());
                        $page->body = __DIR__."/inventory-results.php";
                    }
                } elseif (!empty($input->get->serialnbr) | !empty($input->get->lotnbr) | !empty($input->get->itemID)) {
                    if ($input->get->serialnbr) {
                        $serialnbr = $input->get->text('serialnbr');
                		$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $serialnbr);
                        $item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $serialnbr) : false;
                    } elseif ($input->get->lotnbr) {
                        $lotnbr = $input->get->text('lotnbr');
                		$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $lotnbr);
                        $item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $lotnbr) : false;
                    } elseif ($input->get->itemID){
                        $itemID = $input->get->text('itemID');
                		$resultscount = InventorySearchItem::count_from_itemid(session_id(), $itemID);
                        $item = $resultscount == 1 ? InventorySearchItem::load_from_itemid(session_id(), $itemID) : false;
                    }
                    
                    if ($resultscount == 1) {
            			$page->body = __DIR__."/physical-count-form.php";
            		} else {
            			$items = InventorySearchItem::get_all(session_id());
            			$page->body = __DIR__."/inventory-results.php";
            		}
                } else {
                    $page->body = __DIR__."/item-form.php";
                }
            } else {
                $page->body = __DIR__."/invalid-bin.php";
            }
    } else {
        $page->body = __DIR__."/select-bin-form.php";
    }
    
    
    include $config->paths->content."common/include-toolbar-page.php";
