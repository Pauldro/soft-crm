<?php
	/**
	 * Customer Class
	 * Used to generate data and provides functions
	 * that allow data extraction about that customer
	 */
    class Customer extends Contact {
        use CreateFromObjectArrayTraits;
        /* =============================================================
			GETTER FUNCTIONS 
		============================================================ */
		/**
		 * Returns Customer Name or custID if blank
		 * @return string
		 */
        public function get_name() {
            return (!empty($this->name)) ? $this->name : $this->custid;
        }
        
		/**
		 * Returns the number of Shiptos this customer has
		 * @return int
		 */
        public function get_shiptocount() {
            return count_shiptos($this->custid, Processwire\wire('user')->loginid, Processwire\wire('user')->hascontactrestrictions);
        }
        
		/**
		 * Returns the next sequential shiptoid 
		 * or the first one
		 * @return string shiptoid
		 */
        public function get_nextshiptoid() {
            $shiptos = get_customershiptos($this->custid, Processwire\wire('user')->loginid, Processwire\wire('user')->hascontactrestrictions);
            if (sizeof($shiptos) < 1) {
                return false;
            } else {
                if ($this->has_shipto()) {
                    for ($i = 0; $i < sizeof($shiptos); $i++) {
                        if ($shiptos[$i]->shiptoid == $this->shiptoid) {
                            break;
                        }
                    }
                    $i++; // Get the next 
                    
                    if ($i > sizeof($shiptos)) {
                        return $shiptos[0]->shiptoid;
                    } elseif ($i == sizeof($shiptos)) {
                        return $shiptos[$i - 1]->shiptoid;
                    } else {
                        $shiptos[$i]->shiptoid;
                    }
                } else {
                    return $shiptos[0]->shiptoid;
                }
            }
        }
        
        /* =============================================================
			CLASS FUNCTIONS 
		============================================================ */
		/**
		 * Returns Customer name and shiptoid for page title
		 * @return string
		 */
        public function generate_title() {
            return $this->get_name() . (($this->has_shipto()) ? ' Ship-to: ' . $this->shiptoid : '');
        }
		
		/**
		 * Returns array of data that is the label, value provided, this custid, this shiptoid
		 * and this will be used in a Morris.js pie chart
		 * @param  string $value usually amount sold value
		 * @return array
		 */
		public function generate_piesalesdata($value) {
			return array(
				'label' => $this->get_name(),
				'value' => $value,
				'custid' => $this->custid,
				'shiptoid' => $this->shiptoid
			);
		}
        
        /* =============================================================
			OTHER CONSTRUCTOR FUNCTIONS 
            Inherits some from CreateFromObjectArrayTraits
		============================================================ */
		/**
		 * Loads an object with this class using the parameters as provided
		 * @param  string $custID    CustomerID
		 * @param  string $shiptoID  Shipto ID (can be blank)
		 * @param  string $contactID Contact ID (can be blank)
		 * @return Customer
		 */
        public static function load($custID, $shiptoID = '', $contactID = '') {
            return self::create_fromobject(get_customercontact($custID, $shiptoID, $contactID));
        } 
        
    }
