<?php
    /**
     * Class to Interact with the Whse Session Record for one session
     */
    class WhseSession {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
        /**
         * Session Identifier
         * @var string
         */
        protected $sessionid;
        
        /**
         * Date of Last Update
         * @var int
         */
        protected $date;
        
        /**
         * Time Session Record Update
         * @var int
         */
        protected $time;
        
        /**
         * User Login ID
         * @var string
         */
        protected $loginid;
        
        /**
         * Warehouse ID
         * @var string
         */
        protected $whseid;
        
        /**
         * Order Number
         * @var string
         */
        protected $ordernbr;
        
        /**
         * Bin Location
         * @var string
         */
        protected $binnbr;
        
        /**
         * Pallet Number
         * @var string
         */
        protected $palletnbr;
        
        /**
         * Carton Number
         * @var string
         */
        protected $cartonnbr;
        
        /**
         * Status Message
         * @var string
         */
        protected $status;
        
        /**
         * Current Warehouse Function
         * @var string
         */
        protected $function;
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'loginID' => 'loginid',
            'whseID' => 'whseid',
            'ordn' => 'ordernbr',
            'bin' => 'binnbr',
            'pallet' => 'palletnbr',
            'carton' => 'cartonnbr'
        );
        
        /* =============================================================
			CLASS FUNCTIONS
		============================================================ */
        /**
         * Returns if the Whse Session has a bin defined
         * @return bool Is the bin defined?
         */
        public function has_bin() {
            return !empty($this->binnbr);
        }
        
        /**
         * Returns if the Whse Session has a pallet defined
         * @return bool Is the pallet defined?
         */
        public function has_pallet() {
            return !empty($this->palletnbr);
        }
        
        /**
         * Returns if the Sales Order is finished
         * @return bool        Is Order finished?
         */
        public function is_orderfinished() {
            return strtolower($this->status) == 'end of order' ? true : false;
        }
        
        /**
         * Returns if the Sales Order has been Exited
         * @return bool Is Order exited?
         */
        public function is_orderexited() {
            return strtolower($this->status) == 'order exited' ? true : false;
        }
        
        /**
         * Returns if the Sales Order is on hold
         * @return bool        Is Order on Hold?
         */
        public function is_orderonhold() {
            return strtolower($this->status) == 'order on hold' ? true : false;
        }
        
        /**
         * Returns if the Sales Order has been verified, has been picked
         * @return bool        Has Order been verified?
         */
        public function is_orderverified() {
            return strtolower($this->status) == 'order is verified' ? true : false;
        }
        
        /**
         * Returns if the Sales Order has been invoiced
         * @return bool        Has Order been invoiced?
         */
        public function is_orderinvoiced() {
            return strtolower($this->status) == 'order is invoiced' ? true : false;
        }
        
        /**
         * Returns if the Sales Order Number is invalid
         * @return bool        Has Order been Sales Order Number is invalid
         */
        public function is_orderinvalid() {
            return strtolower($this->status) == 'bad order nbr' ? true : false;
        }
        
        /**
         * Returns a message about the Status of the Order
         * @return string Order Status
         */
        public function generate_statusmessage() {
            $msg = '';
            
            if ($this->is_orderonhold()) {
                $msg = "Order $this->ordernbr is on hold";
            } elseif($this->is_orderverified()) {
                $msg = "Order $this->ordernbr has been verified";
            } elseif($this->is_orderinvoiced()) {
                $msg = "Order $this->ordernbr has been invoiced";
            }
            return $msg;
        }
        
        /**
         * Return the barcodes that have been
         * @param  string $itemID Item ID
         * @param  bool   $debug  Run in debug? If so return SQL Query
         * @return array          Array of Arrays that are the items picked
         */
        public function get_orderpickeditems($itemID, $debug = false) {
            return get_orderpickeditems($this->sessionid, $this->ordernbr, $itemID, $debug);
        }
        
        /**
         * Get a total quantity picked for that Item for this Order
         * @param  string $itemID Item ID
         * @param  bool   $debug  Run in debug? If so return SQL Query
         * @return int            Total Quantity
         */
        public function get_orderpickeditemqtytotal($itemID, $debug = false) {
            return get_orderpickeditemqtytotal($this->sessionid, $this->ordernbr, $itemID, $debug);
        }
        
        /**
         * Deletes all the Items Picked so far 
         * @param  bool   $debug Run in debug? If so return SQL Query
         * @return int           Number of items deleted
         */
        public function delete_orderpickeditems($debug = false) {
            return delete_orderpickeditems($this->sessionid, $debug);
        }
        
        
        /**
         * Returns URL to send the logout Request
         * @return string                      logout URL
         */
        public function end_session() {
            $url = new Purl\Url("127.0.0.1".DplusWire::wire('config')->pages->salesorderpicking);
            $url->path->add('redir');
            $url->query->set('action', 'logout')->set('sessionID', $this->sessionid);
            echo $url->getUrl();
            curl_redir($url->getUrl());
        }
        
        /**
         * Sends a Request to the COBOL to initiate PICKING
         * @return void
         */
        public function start_pickingsession() {
            $url = new Purl\Url("127.0.0.1".DplusWire::wire('config')->pages->salesorderpicking);
            $url->path = DplusWire::wire('config')->pages->salesorderpicking."redir/";
            $url->query->set('action', 'start-pick')->set('sessionID', $this->sessionid);
            curl_redir($url->getUrl());
        }
        
        /**
         * Sends a Request to the COBOL to initiate PICK PACK
         * @return void
         */
        public function start_pickpackingsession() {
            $url = new Purl\Url("127.0.0.1".DplusWire::wire('config')->pages->salesorderpicking);
            $url->path = DplusWire::wire('config')->pages->salesorderpicking."redir/";
            $url->query->set('action', 'start-pick-pack')->set('sessionID', $this->sessionid);
            curl_redir($url->getUrl());
        }
        
        /* =============================================================
			CRUD FUNCTIONS
		============================================================ */
        /**
         * Loads a WhseSession record and loads the data into an Instance of this class
         * @param  string      $sessionID Session Identifier
         * @param  bool        $debug     Run in debug? If so, return SQL Query
         * @return WhseSession            Loaded from database
         */
        public static function load($sessionID, $debug = false) {
            return get_whsesession($sessionID, $debug);
        }
        
        /**
         * Returns if Whse Session Record exists for Session
         * @param  string $sessionID Session Identifier
         * @param  bool   $debug     Run in debug? If so, return SQL Query
         * @return bool              Does Whse Session Record exist?
         */
        public static function does_sessionexist($sessionID, $debug = false) {
            return does_whsesessionexist($sessionID, $debug);
        }
        
        /**
         * Sends the Start Session Request using cURL
         * @param  string   $sessionID Session Identifier
         * @param  Purl\Url $pageurl   URL for Current Page
         * @param  bool     $debug     Run in debug? If so, return SQL Query
         * @return void
         */
        public static function start_session($sessionID, Purl\Url $pageurl, $debug = false) {
            $url = new Purl\Url($pageurl->getUrl());
            $url->path = DplusWire::wire('config')->pages->salesorderpicking."redir/";
            $url->query->set('action', 'initiate-whse')->set('sessionID', $sessionID);
            curl_redir($url->getUrl());
        }
    }
