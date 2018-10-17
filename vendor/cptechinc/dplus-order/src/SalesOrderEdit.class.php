<?php
    use Dplus\ProcessWire\DplusWire;
    
	/**
	 * Class for editing Sales Orders from ordrhed
	 */
	class SalesOrderEdit extends Order implements OrderInterface {
		protected $type;
		
		/**
		 * Customer Name
		 * @var string
		 */
		protected $custname;
		
		/**
		 * Sales Order Number
		 * @var string
		 */
		protected $orderno;
		
		/**
		 * Date Order was Made
		 * @var string 
		 * Format: MM/DD/YYYY
		 */
		protected $orderdate;
		
		/** 
		 * Person to Ship to
		 * @var string
		 */
		protected $careof;
		
		/**
		 * Invoice Date
		 * @var string
		 * Format: MM/DD/YYYY
		 */
		protected $invdate;
		
		/**
		 * Shipped Date
		 * @var string
		 * Format: MM/DD/YYYY
		 */
		protected $shipdate;
		
		/**
		 * Review Date
		 * @var string
		 * Format: MM/DD/YYYY
		 */
		protected $revdate;
		
		/**
		 * Expire Date
		 * @var string
		 * Format: MM/DD/YYYY
		 */
		protected $expdate;
		
		/**
		 * Does Order have documents?
		 * @var bool
		 */
		protected $hasdocuments;
		
		/**
		 * Does Order have Tracking info?
		 * @var bool
		 */
		protected $hastracking;
		
		/**
		 * Is order editable?
		 * @var bool
		 */
		protected $editord;
		protected $sconame;
		protected $phintl;
		protected $extension;
		protected $releasenbr;
		protected $pricedisp;
		protected $taxcodedisp;
		protected $termtype;
		protected $rqstdate;
		protected $shipcom;
		protected $fob;
		protected $deliverydesc;
		protected $cardnumber;
		protected $cardexpire;
		protected $cardcode;
		protected $cardapproval;
		protected $totalcost;
		protected $totaldiscount;
		protected $paymenttype;
		protected $srcdatefrom;
		protected $srcdatethru;
		protected $prntfmt;
		protected $prntfmtdisp;

		// Properties needed by MYSQL to sort
		protected $dateoforder;

		protected $fieldaliases = array(
			'ordernumber' => 'orderno'
		);
		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Returns if Sales Order has Documents
		 * @return bool
		 */
		public function has_documents() {
			return $this->hasdocuments == 'Y' ? true : false;
		}

		/**
		 * Returns if Sales Order has tracking
		 * @return bool
		 */
		public function has_tracking() {
			return $this->hastracking == 'Y' ? true : false;
		}

		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : false;
		}
		
		/**
		 * Returns if the user can edit this order
		 * // NOTE if $userID is not supplied it will validate against current User
		 * @param  string $userID User ID
		 * @return bool           Can Order Be edited by user?
		 * @uses SalesOrder::load(), SalesOrder::can_edit()
		 */
		public function can_edit($userID = '') {
			$order = SalesOrder::load($this->orderno);
			return $order->can_edit($userID);
		}

		public function is_phoneintl() {
			return $this->phintl == 'Y' ? true : false;
		}

		/* =============================================================
			GENERATE ARRAY FUNCTIONS
			The following are defined CreateClassArrayTraits
			public static function generate_classarray()
			public function _toArray()
		============================================================ */
		/**
		 * Mainly called by the _toArray() function which makes an array
		 * based of the properties of the class, but this function filters the array
		 * to remove keys that are not in the database
		 * This is used by database classes for update
		 * @param  array $array array of the class properties
		 * @return array        with certain keys removed
		 */
		public static function remove_nondbkeys($array) {
			return $array;
		}

		/* =============================================================
			CRUD FUNCTIONS
		============================================================ */
		
		public static function exists($sessionID, $ordn, $debug = false) {
			return does_salesordereditexist($sessionID, $ordn, $debug);
		}
		/**
		 * Returns SalesOrder from ordrhed
		 * @param  string          $sessionID Session ID
		 * @param  string          $ordn      Sales Order #
		 * @param  bool            $debug     Run in debug? If so, will return SQL Query
		 * @return SalesOrderEdit             Editable Sales Order
		 * @uses Read (CRUD)
		 */
		public static function load($sessionID, $ordn, $debug = false) {
			return get_salesorderforedit($sessionID, $ordn, $debug);
		}
		
		/**
		 * Updates the Sales Order in the ordrhed table
		 * @param  bool   $debug Whether or not SQL Query is Executed
		 * @return string SQL QUERY
		 * @uses Update (CRUD)
		 */
		public function update($debug = false) {
			return edit_orderhead($this->sessionid, $this->orderno, $this, $debug);
		}

		/**
		 * Updates the Payment Information Sales Order in the ordrhed table
		 * @param  bool   $debug Whether or not SQL Query is Executed
		 * @return string SQL QUERY
		 * @uses UPDATE (CRUD)
		 */
		public function update_payment($debug = false) {
			return edit_orderhead_credit($sessionID, $this->orderno, $this->paymenttype, $this->cardnumber, $this->cardexpire, $this->cardcode, $debug) ;
		}

		/**
		 * Checks for changes by comparing it to original
		 * @return bool Changes Made Or Not
		 * @uses SalesOrder::load()
		 */
		public function has_changes() {
			$properties = array_keys(get_object_vars($this));
			$order = SalesOrderEdit::load($this->sessionid, $this->orderno);

			foreach ($properties as $property) {
				if ($this->$property != $order->$property) {
					return true;
				}
			}
			return false;
		}
	}
