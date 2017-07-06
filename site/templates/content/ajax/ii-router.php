<?php
    $modal = false;
	$modalbody = false;
    switch ($input->urlSegment(3)) { //Parts of order to load
        case 'search-results':
            if ($input->get->q) {$q = $input->get->text('q'); $title = "Searching for '$q'";}
			switch ($input->urlSegment(4)) {
				case 'modal':
					$modal = true;
					$modalcontent = $config->paths->content."item-information/forms/item-search-form.php";
					break;
				default:
					$modalbody = $config->paths->content."item-information/item-search-results.php";
					break;
			}
            break;
		case 'ii-pricing':
            $itemid = $input->get->text('itemid');
			$custID = $input->get->text('custID');
            $title = $itemid. ' Price Inquiry for ' . $custID;
            $modalcontent = $config->paths->content."item-information/item-pricing.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
        case 'ii-costing':
            $itemid = $input->get->text('itemid');
            $title = $itemid .' Cost Inquiry';
            $modalcontent = $config->paths->content."item-information/item-costing.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
        case 'ii-purchase-order':
            $itemid = $input->get->text('itemid');
            $title = $itemid. ' Purchase Order Inquiry';
            $modalcontent = $config->paths->content."item-information/item-purchase-orders.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-quotes':
            $itemid = $input->get->text('itemid');
            $title = 'Viewing ' .$itemid . ' Quotes';
            $modalcontent = $config->paths->content."item-information/item-quotes.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		 case 'ii-purchase-history':
            $itemid = $input->get->text('itemid');
            $title = $itemid.'Purchase History Inquiry';
            $modalcontent = $config->paths->content."item-information/item-purchase-history.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-where-used':
            $itemid = $input->get->text('itemid');
            $title = $itemid.' Where Used Inquiry';
            $modalcontent = $config->paths->content."item-information/item-where-used.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-kit-components':
            $itemid = $input->get->text('itemid');
            $title = $itemid.' Kit Component Inquiry ';
            $modalcontent = $config->paths->content."item-information/item-kit-components.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-bom':
            $itemid = $input->get->text('itemid');
			$bom = $input->get->text('bom');
            $title = $itemid.' BOM Item Inquiry ';
            $modalcontent = $config->paths->content."item-information/item-bom-".$bom.".php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-general':
            $itemid = $input->get->text('itemid');
            $title = $itemid . ' General Item Inquiry';
            $modalcontent = $config->paths->content."item-information/item-general.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-activity':
            $itemid = $input->get->text('itemid');
			if ($input->urlSegment4 == 'form') {
				$title = 'Enter the Starting Report Date ';
				$modalbody = $config->paths->content."item-information/forms/item-activity-form.php";
			} else {
				$title = $itemid.' Activity Inquiry';
				$modalcontent = $config->paths->content."item-information/item-activity.php";
			}
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-requirements':
            $itemid = $input->get->text('itemid');
            $title = $itemid. ' Requirements Inquiry';
            $modalcontent = $config->paths->content."item-information/item-requirements.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-lot-serial':
            $itemid = $input->get->text('itemid');
            $title = 'Viewing ' .$itemid. ' Lot/Serial Inquiry';
            $modalcontent = $config->paths->content."item-information/item-lot-serial.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-sales-orders':
            $itemid = $input->get->text('itemid');
            $title = $itemid . ' Sales Order Inquiry';
            $modalcontent = $config->paths->content."item-information/item-sales-orders.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-sales-history':
			$itemid = $input->get->text('itemid');

			if ($input->urlSegment4 == 'form') {
				if ($input->get->custID) { $custID = $input->get->text('custID'); } else { $custID = ''; }
				$title = 'Search Item History';
				$modalbody = $config->paths->content."item-information/forms/item-history-form.php";
			} else {
				if ($input->get->custID) { $custID = $input->get->text('custID'); } else { $custID = ''; }
				$title = $itemid. ' Sales History Inquiry';
				$modalcontent = $config->paths->content."item-information/item-history.php";
			}
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
			break;
		case 'ii-stock':
            $itemid = $input->get->text('itemid');
            $title = $itemid. ' Stock by Warehouse Inquiry';
            $modalcontent = $config->paths->content."item-information/item-stock-by-whse.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-substitutes':
            $itemid = $input->get->text('itemid');
            $title = 'Viewing Item Substitutes for ' .$itemid;
            $modalcontent = $config->paths->content."item-information/item-substitutes.php";
			if ($config->ajax) { $modal = true; } else {$modalbody = $modalcontent;}
            break;
		case 'ii-documents':
            $itemid = $input->get->text('itemid');
            $title = 'Viewing Item Documents for ' .$itemid;
            $modal = true;
            $modalcontent = $config->paths->content."item-information/item-documents.php";
            break;
        default:
            $title = 'Search for an item';
            if ($input->get->q) {$q = $input->get->text('q');}
            $modal = true;
            $modalbody = $config->paths->content."item-information/forms/item-search-form.php";
            break;

    }

    if ($modal) {
        $modaltitle = $title;
		if (!$modalbody) {
			$modalbody = $config->paths->content."item-information/modal-result.php";
		}
        include $config->paths->content."common/modals/include-ajax-modal.php";
    } else {
		if ($config->ajax) {
			include $modalbody;
		} else {
			$page->title = $title;
			$config->styles->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
			$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
			$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
			$config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
			$config->scripts->append($config->urls->templates.'scripts/ii/item-functions.js');
			$config->scripts->append($config->urls->templates.'scripts/ii/item-info.js');
			include $config->paths->content."common/include-blank-page.php";
		}

    }


 ?>
