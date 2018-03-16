<?php 
    class Customer extends Contact {
        use CreateFromObjectArrayTraits;
		
        /* =============================================================
			GETTER FUNCTIONS 
		============================================================ */
        public function get_name() {
            return (!empty($this->name)) ? $this->name : $this->custid;
        }
        
        public function get_shiptocount() {
            return count_shiptos($this->custid, Processwire\wire('user')->loginid, Processwire\wire('user')->hascontactrestrictions);
        }
        
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
        public function generate_title() {
            return $this->get_name() . (($this->has_shipto()) ? ' Ship-to: ' . $this->shiptoid : '');
        }
		
		/** 
		 * Generates an array for the Sales Data for this Customer
		 * so it can be used in Morris.js to draw up a pie chart
		 * @param  float $value Amount
		 * @return array        has the Name, value, custid and shiptoid in an array
		 */
		public function generate_piesalesdata($value) {
			return array(
				'label' => $this->get_name(),
				'value' => $value,
				'custid' => $this->custid,
				'shiptoid' => $this->shiptoid
			);
		}
		
		/**
		 * Return URL to the add Contact form
		 * @return string  Add Contact URL
		 */
		public function generate_addcontacturl() {
			$url = new \Purl\Url(Processwire\wire('config')->pages->contact.'add/');
            $url->query->set('custID', $this->custid);
            
            if ($this->has_shipto()) {
                $url->query->set('shipID', $this->shiptoid);
            } 
            return $url->getUrl();
		}
        
        /* =============================================================
			OTHER CONSTRUCTOR FUNCTIONS 
            Inherits some from CreateFromObjectArrayTraits
		============================================================ */
        public static function load($custID, $shiptoID = '', $contactID = '', $debug = false) {
            return get_customer($custID, $shiptoID, $contactID, $debug);
        }
		
		/* =============================================================
			STATIC FUNCTIONS
		============================================================ */
		public static function get_customernamefromid($custID, $shiptoID = '') {
			$customer = self::load($custID, $shiptoID);
			return $customer ? $customer->get_customername() : '';
		}
    }
