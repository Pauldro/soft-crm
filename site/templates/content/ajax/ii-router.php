<?php
    if (checkconfigifexists($user, 'iio', false)) {
        $iiconfig = json_decode(getconfiguration($user->loginid, $configtype, false), true);
    } else {
        $iiconfig = json_decode(file_get_contents($config->paths->content."salesrep/configs/defaults/item-info-options.json"), true);
    }

    switch ($input->urlSegment(3)) { //Parts of order to load
        case 'search-results':
            if ($input->get->q) {$q = $input->get->text('q'); $page->title = "Searching for '$q'";}
			switch ($input->urlSegment(4)) {
				case 'modal':
					$page->body = $config->paths->content."item-information/forms/item-search-form.php";
					break;
				default:
					$page->body = $config->paths->content."item-information/item-search-results.php";
					break;
			}
            break;
		case 'ii-pricing':
            $itemid = $input->get->text('itemid');
			$custID = $input->get->text('custID');
            $page->title = $itemid. ' Price Inquiry for ' . $custID;
            $page->body = $config->paths->content."item-information/item-pricing.php";
            break;
        case 'ii-costing':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid .' Cost Inquiry';
            $page->body = $config->paths->content."item-information/item-costing.php";
            break;
        case 'ii-purchase-order':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid. ' Purchase Order Inquiry';
            $page->body = $config->paths->content."item-information/item-purchase-orders.php";
            break;
		case 'ii-quotes':
            $itemid = $input->get->text('itemid');
            $page->title = 'Viewing ' .$itemid . ' Quotes';
            $page->body = $config->paths->content."item-information/item-quotes.php";
            break;
		 case 'ii-purchase-history':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid.'Purchase History Inquiry';
            $page->body = $config->paths->content."item-information/item-purchase-history.php";
            break;
		case 'ii-where-used':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid.' Where Used Inquiry';
            $page->body = $config->paths->content."item-information/item-where-used.php";
            break;
		case 'ii-kit-components':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid.' Kit Component Inquiry ';
            $page->body = $config->paths->content."item-information/item-kit-components.php";
            break;
		case 'ii-bom':
            $itemid = $input->get->text('itemid');
			$bom = $input->get->text('bom');
            $page->title = $itemid.' BOM Item Inquiry ';
            $page->body = $config->paths->content."item-information/item-bom-".$bom.".php";
            break;
		case 'ii-general':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid . ' General Item Inquiry';
            $page->body = $config->paths->content."item-information/item-general.php";
            break;
		case 'ii-activity':
            $itemid = $input->get->text('itemid');
			if ($input->urlSegment4 == 'form') {
				$page->title = 'Enter the Starting Report Date ';
				$page->body = $config->paths->content."item-information/forms/item-activity-form.php";
			} else {
				$page->title = $itemid.' Activity Inquiry';
				$page->body = $config->paths->content."item-information/item-activity.php";
			}
            break;
		case 'ii-requirements':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid. ' Requirements Inquiry';
            $page->body = $config->paths->content."item-information/item-requirements.php";
            break;
		case 'ii-lot-serial':
            $itemid = $input->get->text('itemid');
            $page->title = 'Viewing ' .$itemid. ' Lot/Serial Inquiry';
            $page->body = $config->paths->content."item-information/item-lot-serial.php";
            break;
		case 'ii-sales-orders':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid . ' Sales Order Inquiry';
            $page->body = $config->paths->content."item-information/item-sales-orders.php";
            break;
		case 'ii-sales-history':
			$itemid = $input->get->text('itemid');

			if ($input->urlSegment4 == 'form') {
				if ($input->get->custID) { $custID = $input->get->text('custID'); } else { $custID = ''; }
				$page->title = 'Search Item History';
				$page->body = $config->paths->content."item-information/forms/item-history-form.php";
			} else {
				if ($input->get->custID) { $custID = $input->get->text('custID'); } else { $custID = ''; }
				$page->title = $itemid. ' Sales History Inquiry';
				$page->body = $config->paths->content."item-information/item-history.php";
			}
			break;
		case 'ii-stock':
            $itemid = $input->get->text('itemid');
            $page->title = $itemid. ' Stock by Warehouse Inquiry';
            $page->body = $config->paths->content."item-information/item-stock-by-whse.php";
            break;
		case 'ii-substitutes':
            $itemid = $input->get->text('itemid');
            $page->title = 'Viewing Item Substitutes for ' .$itemid;
            $page->body = $config->paths->content."item-information/item-substitutes.php";
            break;
		case 'ii-documents':
            $itemid = $input->get->text('itemid');
            switch ($input->urlSegment(4)) {
                case 'order':
                    $page->title = "Order #" . $input->get->text('ordn'). ' Documents';
                    break;
                default:
                    $page->title = 'Viewing Item Documents for ' .$itemid;
                    break;
            }
            $page->body = $config->paths->content."item-information/item-documents.php";
            break;
        default:
            $page->title = 'Search for an item';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."item-information/forms/item-search-form.php";
            break;

    }

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		$config->styles->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
		$config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
		$config->scripts->append($config->urls->templates.'scripts/ii/item-functions.js');
		$config->scripts->append($config->urls->templates.'scripts/ii/item-info.js');
		include $config->paths->content."common/include-blank-page.php";
	}


 ?>
