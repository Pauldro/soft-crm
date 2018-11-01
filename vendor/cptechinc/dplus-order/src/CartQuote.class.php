<?php
	/**
	 * Class to handle Quotes
	 */
	class CartQuote extends Order implements OrderInterface {
		protected $sessionid;
		protected $custname;
		protected $orderno;
		protected $orderdate;
		protected $invdate;
		protected $shipdate;
		protected $revdate;
		protected $expdate;
		protected $hasdocuments;
		protected $hastracking;
		protected $editord;
		protected $sconame;
		protected $phintl;
		protected $extension;
		protected $releasenbr;
		protected $pricedisp;
		protected $taxcodedisp;
		protected $termtype;
		protected $termdesc;
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


		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		public function has_documents() {
			return $this->hasdocuments == 'Y' ? true : false;
		}

		/**
		 * Does Cart have tracking
		 * // NOTE this is only here to comply with Orders Interface
		 * @return bool
		 */
		public function has_tracking() {
			return false;
		}

		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : false;
		}

		public function can_edit() {
			return true;
		}

		public function is_phoneintl() {
			return false;
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
			unset($array['revdate']);
			unset($array['expdate']);
			unset($array['editord']);
			unset($array['sconame']);
			unset($array['phintl']);
			unset($array['extension']);
			unset($array['releasenbr']);
			unset($array['pricedisp']);
			unset($array['taxcodedisp']);
			unset($array['termtype']);
			unset($array['rqstdate']);
			unset($array['shipcom']);
			unset($array['fob']);
			unset($array['deliverydesc']);
			unset($array['cardnumber']);
			unset($array['cardexpire']);
			unset($array['cardcode']);
			unset($array['cardapproval']);
			unset($array['totalcost']);
			unset($array['totaldiscount']);
			unset($array['paymenttype']);
			unset($array['srcdatefrom']);
			unset($array['srcdatethru']);
			unset($array['prntfmt']);
			unset($array['prntfmtdisp']);
			unset($array['dateoforder']);
			unset($array['recno']);
			unset($array['quotdate']);
			unset($array['billname']);
			unset($array['billaddress']);
			unset($array['billaddress2']);
			unset($array['billaddress3']);
			unset($array['billcountry']);
			unset($array['billcity']);
			unset($array['billstate']);
			unset($array['billzip']);
			unset($array['shipname']);
			unset($array['shipaddress']);
			unset($array['shipaddress2']);
			unset($array['shipaddress3']);
			unset($array['shipcountry']);
			unset($array['shipcity']);
			unset($array['shipstate']);
			unset($array['shipzip']);
			unset($array['contact']);
			unset($array['sp1name']);
			unset($array['sp2']);
			unset($array['sp2name']);
			unset($array['sp2disp']);
			unset($array['sp3']);
			unset($array['sp3name']);
			unset($array['sp3disp']);
			unset($array['shipviacd']);
			unset($array['shipviadesc']);
			unset($array['custpo']);
			unset($array['custref']);
			unset($array['status']);
			unset($array['phone']);
			unset($array['faxnbr']);
			unset($array['email']);
			unset($array['whse']);
			unset($array['taxcode']);
			unset($array['taxcodedesc']);
			unset($array['termcode']);
			unset($array['termcodedesc']);
			unset($array['pricecode']);
			unset($array['pricecodedesc']);
			unset($array['error']);
			unset($array['errormsg']);
			return $array;
		}

		/* =============================================================
			CRUD FUNCTIONS
		============================================================ */
		/**
		 * Returns if Cart Head Exists
		 * @param  string $sessionID Session ID
		 * @param  bool   $debug     Whether or not to Return Cart Quote or SQL QUERY
		 * @return bool              Is the carthed defined?
		 * @uses Read (CRUD)
		 * @source _dbfunc.php
		 */
		public static function cart_exists($sessionID, $debug = false) {
			return has_carthead($sessionID, $debug);
		}

		/**
		 * Returns CartQuote from carthed table
		 * @param  string $sessionID Session ID
		 * @param  bool   $debug     Run in debug? If so, return SQL Query
		 * @return CartQuote
		 * @uses Read (CRUD)
		 * @source _dbfunc.php
		 */
		public static function load($sessionID, $debug = false) {
			return get_carthead($sessionID, $debug);
		}

		/**
		 * Saves (Updates / Creates) Database for Cart head
		 * @param  bool   $debug Run in debug? If so, return SQL Query
		 * @return bool          Was it Saved?
		 * @source _dbfunc.php
		 */
		public function save($debug = false) {
			if (self::cart_exists($this->sessionid)) {
				return $this->update($debug);
			} else {
				return $this->create($debug);
			}
		}

		/**
		 * Inserts Cart Head Data into database
		 * @param  bool   $debug Run in debug? If so, return SQL Query
		 * @return bool          Was Cart Head record created?
		 */
		public function create($debug = false) {
			return insert_carthead($this->sessionid, $this, $debug);
		}

		/**
		 * Updates Cart Head Data into database
		 * @param  bool   $debug Run in debug? If so, return SQL Query
		 * @return bool          Was Cart Head record updated?
		 */
		public function update($debug = false) {
			return update_carthead($this->sessionid, $this, $debug);
		}

		/**
		 * Returns if Cart Header has any changes by comparing it to the original
		 * @return bool
		 * @uses CartQuote::load
		 */
		public function has_changes() {
			$properties = array_keys(get_object_vars($this));
			$cart = self::load($this->sessionid);

			foreach ($properties as $property) {
				if ($this->$property != $cart->$property) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Returns Call to db function for getting the Customer ID
		 * Off the cartheader
		 * @param  string $sessionID Session Identifier
		 * @param  bool   $debug     Run in debug? If so return SQL Query
		 * @return string            Customer ID
		 */
		public static function get_cartcustid($sessionID, $debug = false) {
			return get_custidfromcart($sessionID, $debug);
		}
	}
