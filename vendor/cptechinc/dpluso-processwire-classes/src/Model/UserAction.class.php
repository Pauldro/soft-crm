<?php
	
	class UserAction {
		public $id;
		public $datecreated;
		public $actiontype;
		public $actionsubtype;
		public $duedate;
		public $createdby;
		public $assignedto;
		public $assignedby;
		public $title;
		public $textbody;
		public $reflectnote;
		public $completed;
		public $datecompleted;
		public $dateupdated;
		public $customerlink;
		public $shiptolink;
		public $contactlink;
		public $salesorderlink;
		public $quotelink;
		public $vendorlink;
		public $vendorshipfromlink;
		public $purchaseorderlink;
		public $actionlink;
		public $rescheduledlink;
		
		public $actionlineage = array();
		
		public $structure = array(
			'id' => array(),
			'datecreated' => array(),
			'actiontype' => array(),
			'actionsubtype'  => array(),
			'duedate' => array(),
			'createdby' => array(),
			'assignedto' => array(),
			'assignedby' => array(),
			'title' => array(),
			'textbody' => array(),
			'reflectnote' => array(),
			'completed' => array(),
			'datecompleted' => array(),
			'dateupdated' => array(),
			'customerlink' => array(),
			'shiptolink' => array(),
			'contactlink' => array(),
			'salesorderlink' => array(),
			'quotelink' => array(),
			'vendorlink' => array(),
			'vendorshipfromlink' => array(),
			'purchaseorderlink' => array(),
			'actionlink' => array(),
			'rescheduledlink' => array(),
		);
	
		public function __construct() {
			
		}
		
		public function has_customerlink() {
			return (!empty($this->customerlink)) ? true : false;
		}
		
		public function has_shiptolink() {
			return (!empty($this->shiptolink)) ? true : false;
		}
		
		public function has_contactlink() {
			return (!empty($this->contactlink)) ? true : false;
		}
		
		public function has_salesorderlink() {
			return (!empty($this->salesorderlink)) ? true : false;
		}
		
		public function has_quotelink() {
			return (!empty($this->quotelink)) ? true : false;
		}
		
		public function has_actionlink() {
			return (!empty($this->actionlink)) ? true : false;
		}
		
		public function is_completed() {
			return ($this->completed == 'Y') ? true : false;
		}
		
		public function is_rescheduled() {
			return ($this->completed == 'R') ? true : false;
		}
		
		public function is_overdue() {
			if ($this->actiontype == 'tasks') {
				return (strtotime($this->duedate) < strtotime("now") && (!$this->is_completed())) ? true : false;
			} else {
				return false;
			}
		}
		
		public function generate_regardingdescription() {
			$desc = '';
			if (!empty($this->title)) {
				return $this->title;
			}
			$desc = $this->has_customerlink() ? 'CustID: '. get_customername($this->customerlink) : '';
			$desc .=  $this->has_shiptolink() ? ' ShipID: '. get_shiptoname($this->customerlink, $this->shiptolink, false) : '';
			$desc .=  $this->has_contactlink() ? ' Contact: '. $this->contactlink : '';
			$desc .=  $this->has_salesorderlink() ? ' Sales Order #' . $this->salesorderlink : '';
			$desc .=  $this->has_quotelink() ? ' Quote #' . $this->quotelink : '';
			$desc .=  $this->has_actionlink() ? ' ActionID: ' . $this->actionlink: '';
			return $desc;
		}
		
		public function generate_message($message) {
			$regex = '/({replace})/i';
			$replace = "";

			$replace = $this->has_customerlink() ? get_customername($this->customerlink)." ($this->customerlink)" : '';
			$replace .= $this->has_shiptolink() ? " Shipto: " . get_shiptoname($this->customerlink, $this->shiptolink, false)." ($this->shiptolink)" : '';
			$replace .= $this->has_contactlink() ? " Contact: " . $this->contactlink : '';
			$replace .= $this->has_salesorderlink() ? " Sales Order #" . $this->salesorderlink : '';
			$replace .= $this->has_quotelink() ? " Quote #" . $this->quotelink : '';
			$replace .= $this->has_actionlink() ? " Action #" . $this->actionlink : '';
			
			$replace = trim($replace);

			if (empty($replace)) {
				if (empty($this->assignedto)) {
					$replace = 'Yourself ';
				} else {
					if ($this->assignedto != wire('user')->loginid) {
						$replace = 'User: ' . wire('user')->loginid;
					} else {
						$replace = 'Yourself ';
					}
				}
			}
			return preg_replace($regex, $replace, $message);
		}

		public function generate_duedatedisplay($format) {
			switch ($this->actiontype) {
				case 'tasks':
					return date($format, strtotime($this->duedate));
					break;
				default:
					return 'N/A';
					break;
			}
		}

		public function generate_taskstatusdescription() {
			switch (trim($this->completed)) {
				case 'R':
					return 'rescheduled';
				case 'Y':
					return 'completed';
				default:
					return 'incomplete';
			}
		}

		public function generate_actionsubtypedescription() {
			switch ($this->actiontype) {
				case 'tasks':
					$subpage = wire('pages')->get("/activity/$this->actiontype/$this->actionsubtype/");
					return $subpage->subtypeicon.' '.$subpage->actionsubtypelabel;
					break;
				case 'notes':
					$subpage = wire('pages')->get("/activity/$this->actiontype/$this->actionsubtype/");
					return $subpage->subtypeicon.' '.$subpage->actionsubtypelabel;
					break;
				case 'actions':
					$subpage = wire('pages')->get("/activity/$this->actiontype/$this->actionsubtype/");
					return $subpage->subtypeicon.' '.$subpage->actionsubtypelabel;
					break;
				default:
					return '';
					break;
			}
		}

		public function get_actionlineage() {
			if ($this->has_actionlink()) {
				$parentid = getparentaction($this->id, false);
				while ($parentid != '') {
					$this->actionlineage[] = $parentid;
					$parentid = getparentaction($parentid, false);
				}
			}
			return $this->actionlineage;
		}
		
		/* =============================================================
			OTHER CONSTRUCTOR FUNCTIONS 
		============================================================ */
		public static function create_fromarray(array $array) {
		   $myClass = get_class();
		   $object  = new $myClass(); 

		   foreach ($array as $key => $val) {
			   $object->$key = $val;
		   }
		   return $object;
		}
		
		/* =============================================================
 		   GENERATE ARRAY FUNCTIONS 
 	   ============================================================ */
 		public static function generate_classarray() {
 			return UserAction::remove_nondbkeys(get_class_vars('UserAction'));
 		}
 		
 		public static function remove_nondbkeys($array) {
			unset($array['actionlineage']);
			unset($array['structure']);
 			return $array;
 		}
 		
 		public function toArray() {
 			return (array) $this;
 		}

	}
