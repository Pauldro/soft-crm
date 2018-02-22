<?php 
	class SalesOrderDetail extends OrderDetail implements OrderDetailInterface {
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
		
		protected $type;
		protected $orderno;
		protected $price;
		protected $qty;
		protected $qtyshipped;
		protected $qtybackord;
		protected $hasdocuments;
		protected $qtyavail;
		protected $cost;
		protected $promocode;
		protected $taxcodeperc;
		protected $uomconv;
		protected $mfgid;
		protected $mfgitemid;
		protected $leaddays;
		protected $costuom;
		protected $quotind;
		protected $quotunit;
		protected $quotprice;
		protected $quotcost;
		protected $quotmkupmarg;
		protected $quotdiscpct;
		protected $ponbr;
		protected $poref;
		
		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		public function has_error() {
			return !empty($this->errormsg);
		}
		
		public function is_kititem() {
			return $this->kitemflag == 'Y' ? true : false;
		}
		
		public function has_documents() {
			return $this->hasdocuments == 'Y' ? true : false;
		}
		
		public function can_edit() {
			$order = SalesOrder::load($this->sessionid, $this->orderno);
			return $order->can_edit();
		}
		
		/* =============================================================
			CRUD FUNCTIONS
		============================================================ */
		public static function load($sessionID, $ordn, $linenbr, $debug = false) {
			return get_orderdetail($sessionID, $ordn, $linenbr, $debug);
		}
		public function update($debug = false) {
			return update_orderdetail($this->sessionid, $this, $debug);
		}
		
		public function has_changes() {
			$properties = array_keys(get_object_vars($this));
			$detail = self::load($sessionID, $linenbr, $debug);
			
			foreach ($properties as $property) {
				if ($this->$property != $detail->$property) {
					return true;
				}
			}
			return false;
		}
	}
