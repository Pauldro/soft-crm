<?php 
    /**
     * Class to interact with the wmpickhed table which
     * is the SalesOrder Head to pick
     */
    class Pick_SalesOrder {
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
        
        /* =============================================================
			CRUD FUNCTIONS
		============================================================ */
        /**
         * Returns an instance of this class with data from the database
         * @param  string          $sessionID Session Identifier
         * @param  string          $ordn      Order Number
         * @param  bool            $debug     Run in debug? If so, return SQL Query
         * @return Pick_SalesOrder            Sales Order Header to Pick
         */
        public static function load($sessionID, $ordn, $debug = false) {
            return get_picksalesorderheader($sessionID, $ordn);
        }
    }
