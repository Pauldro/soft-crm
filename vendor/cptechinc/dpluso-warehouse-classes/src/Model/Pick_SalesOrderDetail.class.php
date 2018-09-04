<?php
    /**
     * Class for the Pick Sales Order Detail Item
     */
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
         * Status Message from Dplus
         * @var string
         */
        protected $statusmsg;
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'ordn' => 'ordernbr',
            'bin' => 'binnbr',
            'itemid' => 'itemnbr',
            'itemID' => 'itemnbr'
        );
        
        public function init() {
            DplusWire::wire('config')->js('pickitem', [
                'item' => [
                    'itemid' => $this->itemnbr,
                    'qty' => [
                        'ordered' => $this->qtyordered,
                        'pulled' => $this->get_pickedtotal(),
                        'remaining' => $this->get_qtyremaining()
                    ]
                ]
            ]);
        }
        
        /**
         * Get the Picked Quantity Total
         * @param  bool   $debug Run in debug? If so, return SQL Query
         * @return int           Picked Quantity Total
         */
        public function get_pickedtotal($debug = false) {
            return get_orderpickeditemqtytotal($this->sessionid, $this->ordernbr, $this->itemnbr, $debug);
        }
        
        /**
         * Returns if there's still quantity remaining to pick
         * @return bool Is there quantity left to pick?
         */
        public function has_qtyremaining() {
            return $this->get_qtyremaining() > 0 ? true : false;
        }
        
        /**
         * Returns the Quantity remaining to pull
         * @return int
         */
        public function get_qtyremaining() {
            return $this->qtyordered - $this->get_pickedtotal();
        }
        
        /**
         * Returns if Qty picked is more than needed
         * @return bool Have user picked too much?
         */
        public function has_pickedtoomuch() {
            return $this->get_pickedtotal() > $this->qtyordered ? true : false;
        }
        
        /**
         * Returns the Picked Order Item record number
         * @param  bool   $debug Run in debug? If so, return SQL Query
         * @return int           Max record number for this Order Item
         */
        public function get_pickedmaxrecordnumber($debug = false) {
            return get_orderpickeditemmaxrecordnumber($this->sessionid, $this->ordernbr, $this->itemnbr, $debug);
        }
        
        /**
         * Returns the Picked Order Item record number for a barcode
         * @param  bool   $debug Run in debug? If so, return SQL Query
         * @return int           Max record number for this Order Item barcode
         */
        public function get_pickedmaxrecordnumberforbarcode($barcode, $debug = false) {
            return get_orderpickedbarcodemaxrecordnumber($this->sessionid, $this->ordernbr, $this->itemnbr, $barcode, $debug);
        }
        
        /**
         * Adds a barcode to the itemwhsepick table
         * @param string $barcode Item Barcode
         * @param bool   $debug   Run in debug? If so, return SQL Query
         */
        public function add_barcode($barcode, $debug = false) {
            if (BarcodedItem::find_barcodeitemid($barcode) == $this->itemnbr) {
                return insert_orderpickedbarcode($this->sessionid, $this->ordernbr, $barcode, $debug);
            } else {
                DplusWire::wire('session')->error("$barcode is not a barcode for Item $this->itemnbr", Processwire\Notice::log);
                return false;
            }
        }
        
        /**
         * Removes an instance of barcode in the itemwhsepick table
         * @param string $barcode Item Barcode
         * @param bool   $debug   Run in debug? If so, return SQL Query
         */
        public function remove_barcode($barcode, $debug = false) {
            return remove_orderpickedbarcode($this->sessionid, $this->ordernbr, $barcode, $debug);
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
        
        public static function has_detailstopick($sessionID, $debug = false) {
            return has_whsesessiondetail($sessionID, $debug);
        }
    }
