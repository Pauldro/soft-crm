<?php 
    use Dplus\ProcessWire\DplusWire as DplusWire;
    
    /**
     * Class to interact with the wmpickhed table which
     * is the SalesOrder Head to pick
     */
    class Pick_SalesOrder {
        use Dplus\Base\ThrowErrorTrait;
		use Dplus\Base\MagicMethodTraits;
		use Dplus\Base\CreateFromObjectArrayTraits;
		use Dplus\Base\CreateClassArrayTraits;
        
        
        /**
         * Date
         * @var int
         */
        protected $date;
        
        /**
         * Time
         * @var int
         */
        protected $time;
        
        /**
         * Sales Order Number
         * @var string
         */
        protected $ordernbr;
        
        /**
         * Customer Identifier
         * @var string
         */
        protected $customerid;
        
        /**
         * Customer Name
         * @var string
         */
        protected $customername;
        
        /**
         * Status Message from Dplus
         * @var string
         */
        protected $statusmsg;
        
        /**
         * How many Items have been picked so far
         * @var int
         */
        protected $itemspicked;
        
        /**
         * Last Pallet Number for this Order
         * @var int
         */
        protected $lastpalletnbr;
        
        protected $sessionID;
        
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'ordn' => 'ordernbr',
            'custID' => 'customerid'
        );
        
        public function init($sessionID) {
            $this->sessionID = $sessionID;
            $whsesession = WhseSession::load($this->sessionID);
            
            DplusWire::wire('config')->js('pickorder', [
                'order' => [
                    'ordn' => $this->ordernbr,
                    'pallet' => [
                        'current' => $whsesession->palletnbr,
                        'last' => $this->lastpalletnbr
                    ]
                ]
            ]);
        }
            
        /* =============================================================
			CRUD FUNCTIONS
		============================================================ */
        /**
         * Returns an instance of this class with data from the database
         * @param  string          $ordn      Order Number
         * @param  bool            $debug     Run in debug? If so, return SQL Query
         * @return Pick_SalesOrder            Sales Order Header to Pick
         */
        public static function load($ordn, $debug = false) {
            return get_picksalesorderheader($ordn, $debug);
        }
    }
