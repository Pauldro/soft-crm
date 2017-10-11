<?php 

    class SalesOrderEdit extends SalesOrder {
        
        public function generate_loaddocumentslink(SalesOrderPanel $orderpanel, $linenbr = '0') {
            $bootstrap = new Contento();
            $href = $this->generate_documentsrequesturl($orderpanel);
            $icon = $bootstrap->createicon('material-icons md-36', '&#xE873;');
            $ajaxdata = "data-loadinto=.docs|data-focus=.docs|data-click=#documents-link";
            
            if ($this->has_documents()) {
                return $bootstrap->openandclose('a', "href=$href|class=btn btn-primary load-sales-docs|role=button|title=Click to view Documents|$ajaxdata", $icon. ' Show Documents');
            } else {
                return $bootstrap->openandclose('a', "href=#|class=btn btn-default|title=No Documents Available", $icon. ' 0 Documents Found');
            }
        }
        
        public function generate_documentsrequesturl(SalesOrderPanel $orderpanel) {
			$url = $this->generate_ordersredirurl();
			$url->query->setData(array('action' => 'get-order-documents', 'ordn' => $this->orderno, 'page' => 'edit'));
			return $url->getUrl();
		}
    }
