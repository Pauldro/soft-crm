<?php
    class PickSalesOrderDisplay {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
        protected $url;
        protected $ordn;
        protected $order;
        protected $sessionID;
        
        
        public function __construct($sessionID, $ordn, Purl\Url $pageurl) {
            $this->url = new Purl\Url($pageurl->getUrl());
            $this->ordn = $ordn;
            $this->sessionID = $sessionID;
            
            $this->order = Pick_SalesOrder::load($ordn);
            $this->order->init($this->sessionID);
        }
        
        /**
         * Returns URL to send the add pallet Request
         * @return string                      Add Pallet URL
         */
        public function generate_addpalleturl() {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'add-pallet');
            $url->query->set('ordn', $this->ordn);
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns URL to send the Finished with Item Request
         * @param  Pick_SalesOrderDetail $item Item that is being picked
         * @return string                      Finish Item URL
         */
        public function generate_finishitemurl(Pick_SalesOrderDetail $item) {
            $whsesession = WhseSession::load($this->sessionID);
            $action = strtolower($whsesession->function) == 'picking' ? 'finish-item' : 'finish-item-pick-pack'; 
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', $action);
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns URL to send the skip Item Request
         * @param  Pick_SalesOrderDetail $item Item that is being picked
         * @return string                      Skip Item URL
         */
        public function generate_skipitemurl(Pick_SalesOrderDetail $item) {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'skip-item');
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns URL to send the Finish Sales Order Request
         * @return string                      Finish Order URL
         */
        public function generate_finishorderurl() {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'finish-order');
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns URL to send the exit Sales Order Request
         * @return string                      Exit Order URL
         */
        public function generate_exitorderurl() {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'exit-order');
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns the add barcode URL
         * @param  Pick_SalesOrderDetail $item    Item that is being picked
         * @param  string                $barcode Item Barcode
         * @return string                         Add barcode URL
         */
        public function generate_addbarcodeurl(Pick_SalesOrderDetail $item, $barcode) {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'add-barcode');
            $url->query->set('barcode', $barcode);
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        
        /**
         * Returns the remove barcode URL
         * @param  Pick_SalesOrderDetail $item      Item that is being picked
         * @param  string                $barcode   Item Barcode
         * @param  string                $palletnbr Pallet Number to remove item from
         * @return string                           Remove barcode URL
         */
        public function generate_removebarcodeurl(Pick_SalesOrderDetail $item, $barcode, $palletnbr) {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'remove-barcode');
            $url->query->set('barcode', $barcode);
            $url->query->set('palletnbr', $palletnbr);
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        /**
         * Returns URL to send the change pallet Request
         * @return string                      Change Pallet URL
         */
        public function generate_changepalleturl() {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'set-pallet');
            $url->query->set('ordn', $this->ordn);
            $url->query->set('page', $this->url->getUrl());
            return $url->getUrl();
        }
        
        public function get_redirURL() {
            $url = new Purl\Url(DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            return $url->getUrl();
        }
    }
