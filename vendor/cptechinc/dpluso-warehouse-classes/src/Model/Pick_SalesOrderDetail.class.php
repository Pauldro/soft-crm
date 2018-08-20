<?php 
    class Pick_SalesOrderDetail {
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
         * Record Number
         * @var int
         */
        protected $recno;
        
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
         * Line Number
         * @var int
         */
        protected $linenbr;
        
        /**
         * Item ID
         * @var string
         */
        protected $itemnbr;
        
        /**
         * Item Description 1
         * @var string
         */
        protected $itemdesc1;
        
        /**
         * Item Description 2
         * @var string
         */
        protected $itemdesc2;
        
        /**
         * Order Qty
         * @var int
         */
        protected $qtyordered;
        
        /**
         * Qty Pulled
         * @var int
         */
        protected $qtypulled;
        
        /**
         * Qty Remaining
         * @var int
         */
        protected $qtyremaining;
        
        /**
         * Bin ID / Location
         * @var string
         */
        protected $binnbr;
        
        /**
         * Qty in Case
         * @var int
         */
        protected $caseqty;
        
        /**
         * Qty in an inner pack
         * @var int
         */
        protected $innerpack;
        
        /**
         * Error Message
         * @var string
         */
        protected $errormsg;
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'ordn' => 'ordernbr',
            'bin' => 'binnbr',
            'itemid' => 'itemnbr',
            'itemiID' => 'itemnbr'
        );
        
        public function init() {
            DplusWire::wire('config')->js('pickitem', [
                'item' => [
                    'itemid' => $this->itemnbr,
                    'qty' => [
                        'ordered' => $this->qtyordered,
                        'pulled' => $this->qtypulled,
                        'remaining' => $this->qtyremaining
                    ]
                ]
            ]);
        }
        
        /**
         * Returns an Instance of Pick_SalesOrderDetail
         * @param  string                $sessionID Session Identifier
         * @param  bool                  $debug     Run in debug? If so, return SQL Query
         * @return Pick_SalesOrderDetail
         */
        public static function load($sessionID, $debug = false) {
            return get_whsesessiondetail($sessionID, $debug);
        }
    }
