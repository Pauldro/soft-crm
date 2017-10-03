<?php 

    class SalesOrderPanel {
        public $type = 'cust';
        public $modal;
        public $focus;
        public $loadinto;
        public $pageurl;
        public $throughajax;
        public $sessionID;
        public $collapse = 'collapse';
        public $orderbystring;
        public $sortrule;
        public $nextorder;
        public $orderby;
        public $active;
        public $custID;
        public $shipID;
        public $count;
        public $orders = array();
        private $debugorders;
        
        public function __construct($type, $orderbystring, $modal, $loadinto, $throughajax, $sessionID) {
        	$this->type = $type;
            $this->orderbystring = $orderbystring;
        	
        	if ($throughajax) {
        		$this->collapse = '';
        	} else {
        		$this->collapse = 'collapse';
        	}
        	
        	$this->loadinto = $this->focus = $loadinto;
            $this->sessionID = $sessionID;
        	
        	$this->data = 'data-loadinto="'.$this->loadinto.'" data-focus="'.$this->focus.'"';
        }

        public function setup_customerpanel($custID, $shipID) {
        	$this->custID = $custID;
        	$this->shipID = $shipID;
        }
        
        public function setup_orderby() {
            if (!empty($this->orderbystring)) {
        		$orderby_array = explode('-', $this->orderbystring);
        		$this->orderby = $orderby_array[0];
        		if ($orderby_array[0] != '') {
        			$this->sortrule = $orderby_array[1];
        			$this->nextorder = get_sorting_rule($orderby, $this->sortrule, $this->orderby);
        		} else {
        			$this->sortrule = "ASC";
        			$this->nextorder = "DESC";
        		}
                // TODO: add logic for adding orderby to url
        		// $sortlinkaddon = "&orderby=".$this->orderbystring;
        	} else {
        		$this->orderby = false;
        		$this->sortrule = false;
        		$this->nextorder = "ASC";
                // TODO: add logic for adding orderby to url
        		// $sortlinkaddon = '';
        	}
        }
        
        public function get_orders() {
            if ($this->type == 'cust') {
                $this->orders = $this->get_customerorders();
                $this->debugorders = $this->get_customerorders(true);
            } else {
                $this->orders = $this->get_salesreporders();
            }
        }
        
        protected function get_customerorders($debug = false) {
            if ($this->orderby) {
                if ($this->orderby == 'orderdate') {
                    return customerordersorderdate($this->sessionID, $this->custID, wire('config')->showonpage, wire('input')->pageNum(), $this->sortrule, $debug);
                } else {
                    return get_cust_orders_orderby($this->sessionID, $this->custID, wire('config')->showonpage, wire('input')->pageNum(), $this->sortrule, $this->orderby, $debug);
                }
            } else {
                $this->sortrule = 'DESC'; $this->orderby = 'orderno';
				return get_cust_orders_orderby($this->sessionID, $this->custID, wire('config')->showonpage, wire('input')->pageNum(), $this->sortrule, $this->orderby, $debug);
            }
        }
        
        protected function get_salesreporders() {
            if ($this->orderby) {
                
            } else {
                
            }
        }
        
        public function generate_salesordericonlegend() {
            $legendcontent = "<span class='glyphicon glyphicon-shopping-cart' title='re-order'></span> = Re-order whole order <br>";
        	$legendcontent .= "<span class='glyphicon glyphicon-folder-open' title='Click to view Documents'></span> &nbsp; = Documents <br>";
        	$legendcontent .= "<span class='glyphicon glyphicon-plane hover' title='Click to view Tracking'></span> = Tracking <br>";
        	$legendcontent .= "<span class='glyphicon glyphicon-list-alt' title='View notes'></span> = Notes <br>";
        	$legendcontent .= "<span class='glyphicon glyphicon-pencil' title='Edit this Order'></span> = Edit Order<br>";
        	$legendiconcontent = 'class="btn btn-sm btn-info" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="Icon Definition"';
            
            // TODO: look at legend content
            return $legendcontent;
        }
        
        public function generate_sortsymbol($pageorderby, $column, $pagesort) {
    		$symbol = "";
    		if ($pageorderby == $column) {
    			if ($pagesort == "ASC") {
    				$symbol = "<span class='glyphicon glyphicon-arrow-up'></span>";
    			} else {
    				$symbol = "<span class='glyphicon glyphicon-arrow-down'></span>";
    			}
    		}
    		return $symbol;
    	}
        
        // TODO: look at function
        public function generate_columnsortingrule($orderingby, $sort, $orderby) {
    		if ($orderingby != $orderby || $sort == false) {
    			$sortrule = "ASC";
    		} else {
    			switch ($sort) {
    				case 'ASC':
    					$sortrule = 'DESC';
    					break;
    				case 'DESC':
    					$sortrule = 'ASC';
    					break;
    			}
    		}
    		return $sortrule;
    	}
    }
