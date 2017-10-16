<?php 
    class SalesOrderDisplay extends OrderDisplay implements OrderDisplayInterface, SalesOrderDisplayInterface {
        protected $ordn;
        use SalesOrderDisplayTraits;
        
        public function __construct($sessionID, \Purl\Url $pageurl, $ordn) {
            parent::__construct();
            $this->ordn = $ordn;
        }
        
        public function generate_editlink(Order $order) {
            // TODO    
        }
        
        
    }
