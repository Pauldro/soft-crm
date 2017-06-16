<?php

    class TaskPanel {
		public $type = 'cust';
		public $loadinto;
		public $focus;
		public $data;
		public $modal;
		public $collapse;
		public $completed = false;
		public $completechecked = '';

		public $custID;
		public $shipID;
		public $contactID;

        public $links = array('assignedto' => false, 'customerlink' => false, 'shiptolink' => false, 'contactlink' => false);

        public $count = 0;

		public function __construct($type, $loadinto, $focus, $modal, $throughajax) {
	   		$this->type = $type;
			$this->loadinto = $loadinto;
			$this->focus = $focus;
			$this->modal = $modal;
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


		function setupcompletetasks() {
			$this->completechecked = 'checked';
			$this->completed = true;
		}

		function getaddtasklink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->tasks."add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
					$link = wire('config')->pages->tasks."add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->tasks."add/new/";
					break;
			}
			return $link;
		}

		function getpanelrefreshlink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->tasks."load/list/cust/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
					$link = wire('config')->pages->tasks."load/list/contact/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->tasks."load/list/user/";
					break;
			}
			return $link;
		}

		function getpanelloadtaskschedulelink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->taskschedule."load/list/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
					$link = wire('config')->pages->taskschedule."load/list/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->taskschedule."load/list/";
					break;
			}
			return $link;
		}

		function getpanelnewtaskschedulelink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->taskschedule."add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'cust':
					$link = wire('config')->pages->taskschedule."add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'cust':
					$link = wire('config')->pages->taskschedule."add/new/";
					break;

			}
			return $link;
		}

		function getpaneladdtaskschedulelink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->taskschedule."add/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
				case 'contact':
					$link = wire('config')->pages->taskschedule."add/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					$link .= "&contactID=".urlencode($this->contactID);
					break;
                case 'user':
					$link = wire('config')->pages->taskschedule."add/";
					break;
			}
			return $link;
		}

		function getloadtasklink($noteid) {
			return wire('config')->pages->tasks."load/?id=".$noteid;
		}

		function getpaneltitle() {
			switch ($this->type) {
				case 'cust':
					return 'Customer Tasks';
					break;
				case 'contact':
					return 'Contact Tasks';
					break;
                case 'user':
					return 'Your Tasks';
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
			}
		}

        function buildarraylinks(array $links) {
            $this->links = array('assignedto' => false, 'customerlink' => false, 'shiptolink' => false, 'contactlink' => false);
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


 ?>
