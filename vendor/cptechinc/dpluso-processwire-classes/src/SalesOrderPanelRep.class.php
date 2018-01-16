<?php 
    class RepSalesOrderPanel extends SalesOrderPanel {
        
        public function setup_pageurl(\Purl\Url $pageurl) {
			$url = $pageurl;
			$url->path = Processwire\wire('config')->pages->ajax."load/orders/salesrep/";
			$url->query->remove('display');
			$url->query->remove('ajax');
            $this->paginationinsertafter = 'salesrep';
			return $url;
		}
        
        public function get_ordercount($debug = false) {
            $this->count = count_salesreporders($this->sessionID, $debug);
        }
        
        public function get_orders($debug = false) {
            $useclass = true;
            if ($this->tablesorter->orderby) {
                if ($this->tablesorter->orderby == 'orderdate') {
                    $orders = get_salesrepordersorderdate($this->sessionID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $useclass, $debug);
                } else {
                    $orders = get_salesrepordersorderby($this->sessionID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->tablesorter->orderby, $useclass, $debug);
                }
            } else {
                // DEFAULT BY ORDER DATE SINCE SALES ORDER # CAN BE ROLLED OVER
                $this->tablesorter->sortrule = 'DESC'; 
                //$this->tablesorter->orderby = 'orderno';
                //$orders = get_salesrepordersorderby($this->sessionID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $this->tablesorter->orderby, $useclass, $debug);
                $orders = get_salesrepordersorderdate($this->sessionID, Processwire\wire('session')->display, $this->pagenbr, $this->tablesorter->sortrule, $useclass, $debug);
            }
            return $debug ? $orders : $this->orders = $orders;
        }
    }
?>
