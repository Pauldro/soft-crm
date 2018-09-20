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
         * Bin Qty
         * @var int
         */
        protected $binqty;
        
        
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
         * Over Bin 1 ID / Location
         * @var string
         */
        protected $overbin1;
        
        /**
         * Over Bin 1 Qty
         * @var int
         */
        protected $overbinqty1;
        
        /**
         * Over Bin 2 ID / Location
         * @var string
         */
        protected $overbin2;
        
        /**
         * Over Bin 2 Qty
         * @var int
         */
        protected $overbinqty2;
        
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
                        'picked' => $this->get_userpickedtotal(),
                        'pulled' => $this->qtypulled,
                        'total_picked' => $this->get_orderpickedtotal(),
                        'remaining' => $this->get_qtyremaining()
                    ]
                ]
            ]);
        }
        
        /**
         * Returns the Picked Quantity Total from the database
         * @param  bool  $debug Run in debug? If so, return SQL Query
         * @return int          Picked Quantity Total
         */
        public function get_userpickedtotal($debug = false) {
            return get_orderpickeditemqtytotal($this->sessionid, $this->ordernbr, $this->itemnbr, $debug);
        }
        
        /**
         * Returns the Picked Qty + already pulled qty for the Order, not just user
         * // NOTE this Total is total picked for the order, not just what the user has picked
         * @return int total Picked for this item on the order
         */
        public function get_orderpickedtotal() {
            return $this->qtypulled + $this->get_userpickedtotal();
        }
        
        /**
         * Returns if there has been Qty pulled for this Item / Order
         * @return bool Does Order Item have previous pick quantity?
         */
        public function has_qtypulled() {
            return $this->qtypulled > 0 ? true : false;
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
            return $this->qtyordered - ($this->get_orderpickedtotal());
        }
        
        /**
         * Returns if Qty picked is more than needed
         * @return bool Have user picked too much?
         */
        public function has_pickedtoomuch() {
            return ($this->get_orderpickedtotal()) > $this->qtyordered ? true : false;
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
         * @param  string $barcode   Item Barcode
         * @param  bool   $debug     Run in debug? If so, return SQL Query
         * @param  int    $palletnbr Pallet Number
         * @return int               Max record number for this Order Item barcode
         */
        public function get_pickedmaxrecordnumberforbarcode($barcode, $palletnbr = 0, $debug = false) {
            return get_orderpickedbarcodemaxrecordnumber($this->sessionid, $this->ordernbr, $this->itemnbr, $barcode, $palletnbr, $debug);
        }
        
        /**
         * Adds a barcode to the itemwhsepick table
         * @param string $barcode   Item Barcode
         * @param int    $palletnbr Pallet Number
         * @param bool   $debug     Run in debug? If so, return SQL Query
         */
        public function add_barcode($barcode, $palletnbr = 0, $debug = false) {
            if (BarcodedItem::find_barcodeitemid($barcode) == $this->itemnbr) {
                return insert_orderpickedbarcode($this->sessionid, $this->ordernbr, $barcode, $debug);
            } else {
                DplusWire::wire('session')->error("$barcode is not a barcode for Item $this->itemnbr", ProcessWire\Notice::log);
                return false;
            }
        }
        
        /**
         * Removes an instance of barcode in the itemwhsepick table
         * @param string $barcode   Item Barcode
         * @param int    $palletnbr Pallet Number
         * @param bool   $debug     Run in debug? If so, return SQL Query
         */
        public function remove_barcode($barcode, $palletnbr = 0, $debug = false) {
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
