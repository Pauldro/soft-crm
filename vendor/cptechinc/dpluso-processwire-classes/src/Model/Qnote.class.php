<?php
	class QNote {
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
		use ThrowErrorTrait;
		
		protected $sessionid;
		protected $recno;
		protected $date;
		protected $time;
		protected $rectype; // SORD|QUOT|CART
		protected $key1; // ORDER # | QUOTE # | SESSIONID
		protected $key2; // LINE #
		protected $key3;
		protected $key4;
		protected $key5;
		protected $form1;
		protected $form2;
		protected $form3;
		protected $form4;
		protected $form5;
		protected $form6;
		protected $form7;
		protected $form8;
		protected $colwidth;
		protected $notefld = '35';
		protected $dummy;
		
		/* =============================================================
			SETTER FUNCTIONS 
		============================================================ */
		public function __set($property, $value) {
			return $this->set($property, $value);
		}
		
		public function set($property, $value) {
			if (property_exists($this, $property) !== true) {
				$this->error("This property ($property) does not exist ");
				return false;
			}
			$this->$property = $value;
		}
		
		/* =============================================================
			GETTER FUNCTIONS 
		============================================================ */
		public function __get($property) {
			if (property_exists($this, $property) !== true) {
				$this->error("This property ($property) does not exist");
				return false;
			}
			
			$method = "get_{$property}";
			if (method_exists($this, $method)) {
				return $this->$method();
			} elseif (property_exists($this, $property)) {
				return $this->$property;
			} else {
				$this->error("This property ($property) is not accessible");
				return false;
			}
		}
		
		/* =============================================================
			CLASS FUNCTIONS 
		============================================================ */
		public function generate_jsonurl() {
			$url = new Purl\Url(wire('config')->pages->ajax."json/dplus-notes/");
			$url->query->setData(array(
				'key1' => $this->key1,
				'key2' => $this->key2,
				'recnbr' => $this->recno,
				'type' => $this->rectype
			));
			return $url->getUrl();
		}
		 
		/* =============================================================
			CRUD FUNCTIONS 
		============================================================ */
		public static function can_write($sessionID, $type, $key1, $key2) {
			switch ($type) {
				case 'CART' :
					return true;
					break;
				case 'SORD':
					$order = SalesOrder::load($sessionID, $key1);
					return $order->can_edit();
					break;
				case 'QUOT':
					$quote = Quote::load($sessionID, $key1);
					return $quote->can_edit();
					break;
				default: 
					return false;
					break;
			}
		}
		
		public static function get_qnotetype($type) {
			return Processwire\wire('config')->dplusnotes[strtolower($type)]['type'];
		}
		
		public static function load($sessionID, $key1, $key2, $rectype, $recnbr, $debug = false) {
			return get_qnote($sessionID, $key1, $key2, $rectype, $recnbr, true, $debug); 
		}
		
		public function update($debug = false) {
			return update_note($this->sessionid, $this, $debug);
		}
		
		public function add($debug = false) {
			return add_qnote($this->sessionid, $this, $debug);
		}
		
		/* =============================================================
			GENERATE ARRAY FUNCTIONS 
			The following are defined CreateClassArrayTraits
			public static function generate_classarray()
			public function _toArray()
		============================================================ */
		public static function remove_nondbkeys($array) {
			return $array;
		}
	}
