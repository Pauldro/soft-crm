<?php 
	/**
	 * Base Class for Orders and Quotes to share similar properties
	 * and define functions they will extend.
	 */
	abstract class Order {
		use ThrowErrorTrait;
		
		protected $sessionid;
		protected $recno;
		protected $date;
		protected $time;
		protected $custid;
		protected $shiptoid;
		protected $quotdate;
		protected $billname;
		protected $billaddress;
		protected $billaddress2;
		protected $billaddress3;
		protected $billcountry;
		protected $billcity;
		protected $billstate;
		protected $billzip;
		protected $shipname;
		protected $shipaddress;
		protected $shipaddress2;
		protected $shipaddress3;
		protected $shipcountry;
		protected $shipcity;
		protected $shipstate;
		protected $shipzip;
		protected $contact; 
		protected $sp1;
		protected $sp1name;
		protected $sp2;
		protected $sp2name;
		protected $sp2disp;
		protected $sp3;
		protected $sp3name;
		protected $sp3disp;
		protected $hasnotes;
		protected $shipviacd;
		protected $shipviadesc;
		protected $custpo;
		protected $custref;
		protected $status;
		protected $phone;
		protected $faxnbr;
		protected $email;
		protected $subtotal;
		protected $salestax;
		protected $freight;
		protected $misccost;
		protected $ordertotal;
		protected $whse;
		protected $taxcode;
		protected $taxcodedesc;
		protected $termcode;
		protected $termcodedesc; 
		protected $pricecode;
		protected $pricecodedesc;
		protected $error;
		protected $errormsg;
		protected $dummy;
		
		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Looks and returns property value, also looks through
		 * $this->aliases
		 * @param  string $property Property name to get value from
		 * @return mixed           Value of Property
		 */
		public function __get($property) {
			$method = "get_{$property}";
			if (method_exists($this, $method)) {
				return $this->$method();
			} elseif (property_exists($this, $property)) {
				return $this->$property;
			} else {
				$this->error("This property ($property) does not exist");
				return false;
			}
		}
		
		/**
		 * Checks if property is isset, used for if outside of this class if empty() is called on protected property
		 * @param  string  $property property to check 
		 * @return bool           if $this->$property isset()
		 */
		public function __isset($property){
			return isset($this->$property);
		} 
		
		/**
		 * Returns if Order has notes attached
		 * @return bool Y = true | N = false
		 */
		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : false;
		}
		
		/**
		 * Returns if Order has error
		 * @return bool Y = true | N = false
		 */
		public function has_error() {
			return $this->error == 'Y' ? true : false;
		}
		
		/**
		 * Returns if Order has shiptoid defined
		 * @return bool 
		 */
		public function has_shipto() {
			return (!empty($this->shiptoid));
		}
		
		/* =============================================================
			SETTER FUNCTIONS
		============================================================ */
		/**
		 * Set the value for a property
		 * @param string $property property to assign the value to
		 * @param mixed $value    value to assign to property
		 */
		public function set($property, $value) {
			if (property_exists($this, $property) !== true) {
				$this->error("This property ($property) does not exist ");
				return false;
			}
			$this->$property = $value;
		}
		
	}
