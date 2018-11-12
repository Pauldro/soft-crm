<?php
    use Dplus\Base\Curl;
    
    if ($input->get->scan) {
        $scan = $input->get->text('scan');
        $is_barcode = BarcodedItem::find_barcodeitemid($scan);
        
        if (!empty($is_barcode)) {
            $itemID = $is_barcode;
            $barcodeditem = BarcodedItem::load($scan);
        } else {
            $xrefitem = XRefItem::load($scan);
            
            if (!empty($xrefitem)) {
                $itemID = $xrefitem->itemid;
            } else {
                $itemID = $scan;
            }
            
            $url = new Purl\Url($page->fullURL->getUrl());
            $url->path = "{$config->pages->products}redir/";
            $url->query->set('action', 'item-search');
            $url->query->set('q', $itemID);
            $url->query->set('sessionID', session_id());
            $curl = new Curl();
            $curl->get($url->getUrl());
            
            $pricingitem = PricingItem::load(session_id(), $itemID);
            
            if (!empty($pricingitem)) {
                $itemtype = $pricingitem->itemtype;
                
            } else {
                $page->body = $config->paths->content."{$page->path}item-form.php";
            }
        }
    } else {
        $page->body = $config->paths->content."{$page->path}item-form.php";
    }
    $toolbar = false;
    include $config->paths->content."common/include-toolbar-page.php";
