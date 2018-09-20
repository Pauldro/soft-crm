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
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'ordn' => 'ordernbr',
            'custID' => 'customerid'
        );
            
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
