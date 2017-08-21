<?php
    class UserActionPanel {
        public $type = 'cust';
        public $actiontype;
		public $partialid;
		public $loadinto;
		public $panelid;
		public $panelbody;
		public $focus;
		public $data;
		public $modal;
		public $collapse;
		public $completed = false;
        public $rescheduled = false;
		public $loadmodal = false;

        public $taskstatus = 'N';
		public $custID;
		public $shipID;
		public $contactID;
        public $qnbr;
        public $querylinks = array();
        public $taskstatuses = array('Y' => 'Completed', 'N' => 'Not Completed', 'R' => 'Rescheduled');

        public $count = 0;

		public function __construct($type, $actiontype, $partialid, $modal, $throughajax, $modalTF) {
	   		$this->type = $type;
			$this->actiontype = $actiontype;
			$this->partialid = $partialid;
			$this->loadinto = '#'.$this->partialid.'-panel';
			$this->focus = '#'.$this->partialid.'-panel';
			$this->panelid = $this->partialid.'-panel';
			$this->panelbody = $this->partialid.'-div';
			$this->modal = $modal;
			$this->loadmodal = $modalTF;
			$this->data = 'data-loadinto="'.$this->loadinto.'" data-focus="'.$this->focus.'"';
			if ($throughajax) {
				$this->collapse = '';
			} else {
				$this->collapse = 'collapse';
			}
        }

		function setupcustomerpanel($custID, $shipID) {
			$this->custID = $custID;
			$this->shipID = $shipID;
		}

		function setupcontactpanel($custID, $shipID, $contactID) {
			$this->setupcustomerpanel($custID, $shipID);
			$this->contactID = $contactID;
		}

        function setupquotepanel($qnbr) {
            $this->qnbr = $qnbr;
        }

        function setuporderpanel($ordn) {
            $this->ordn = $ordn;
        }

		function setupcompletetasks() {
            $this->taskstatus = 'Y';
			$this->completed = true;
		}

        function setuprescheduledtasks() {
            $this->taskstatus = 'R';
			$this->rescheduled = true;
		}

        function setuptasks($status) {
            switch ($status) {
        		case 'Y':
        			$this->setupcompletetasks();
        			break;
        		case 'R':
        			$this->setuprescheduledtasks();
        			break;
        	}
        }

        function databasetaskstatus() {
            if ($this->actiontype == 'task') {
                switch ($this->taskstatus) {
                    case 'N':
                        return ' ';
                        break;
                    default:
                        return $this->taskstatus;
                }
            } else {
                return ' ';
            }

        }

        function hascustomer() {
            return ($this->custID) ? true : false;
        }

        function hasshipto() {
            return ($this->shipID) ? true : false;
        }

        function hascontact() {
            return ($this->contactID) ? true : false;
        }

        function hasquote() {
            return ($this->qnbr) ? true : false;
        }

        function getactiontypepage() {
            if ($this->actiontype == 'all') {
                return $this->actiontype;
            } else {
                return $this->actiontype.'s';
            }
        }

		function getaddactionlink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
                    $link = wire('config')->pages->actions.$this->actiontype."/add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
                    $link = wire('config')->pages->actions.$this->actiontype."/add/new/?custID=".urlencode($this->custID);
                    if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->actions.$this->actiontype."/add/new/";
					break;
                case 'quote':
                    $link = wire('config')->pages->actions.$this->actiontype."/add/new/?qnbr=".$this->qnbr;
                    break;
			}
			return $link;
		}

        function getactiontyperefreshlink() {
            $refreshlink = $this->getpanelrefreshlink();
            return str_replace($this->getactiontypepage(), '{replace}', $refreshlink);
        }

        function getaddactiontypelink() {
            $addlink = $this->getaddactionlink();
            return str_replace($this->getactiontypepage(), '{replace}', $addlink);
        }

		function getpanelrefreshlink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->actions.$this->getactiontypepage()."/load/list/cust/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
					$link = wire('config')->pages->actions.$this->getactiontypepage()."/load/list/contact/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->actions.$this->getactiontypepage()."/load/list/user/";
					break;
                case 'order':
					$link = wire('config')->pages->actions.$this->getactiontypepage()."/load/list/order/?ordn=".$this->ordn;
					break;
                case 'quote':
					$link = wire('config')->pages->actions.$this->getactiontypepage()."/load/list/quote/?qnbr=".$this->qnbr;
					break;
			}
			if ($this->loadmodal) {$link .= "&modal=modal";}
			return $link;
		}

        function needsaddactionlink() {
            $needsadd = false;
            switch ($this->type) {
				case 'cust':
					$needsadd = true;
					break;
				case 'contact':
					$needsadd = true;
					break;
                case 'user':
					$needsadd = true;
					break;
                case 'order':
                    $needsadd = true;
                    break;
                case 'quote':
                    $needsadd = true;
                    break;
			}
            return $needsadd;
        }

		function getloadtasklink($noteid) {
			return wire('config')->pages->tasks."load/?id=".$noteid;
		}

		function getpaneltitle() {
			switch ($this->type) {
				case 'cust':
                    if ($this->actiontype != 'all') {return 'Customer Actions';}
                    return 'Customer Actions';
					break;
				case 'contact':
					return 'Contact Actions';
					break;
                case 'user':
                    if ($this->actiontype != 'all') {return 'Your Actions';}
					return 'Your Actions';
					break;
                case 'order':
					return 'Order #'.$this->ordn.' Actions';;
					break;
                case 'quote':
					return 'Quote '.$this->qnbr.' Actions';;
					break;
			}
		}

		function getinsertafter() {
			switch ($this->type) {
				case 'cust':
					return 'cust/';
					break;
				case 'contact':
					return 'contact/';
					break;
                case 'user':
					return 'user/';
					break;
                case 'order':
                    return 'order/';
                    break;
                case 'quote':
                    return 'quote/';
                    break;
			}
		}

        function buildarraylinks(array $links) {
            $this->links['assignedto'] = wire('user')->loginid;
            if ($this->hascustomer()) { $this->links['customerlink'] = $this->custID; }
            if ($this->hasshipto()) { $this->links['shiptolink'] = $this->shipID; }
            if ($this->hascontact()){  $this->links['contactlink'] = $this->contactID; }
        }

        function getarraylinks() {
            $this->buildarraylinks();
            return $this->links;
        }

    }
