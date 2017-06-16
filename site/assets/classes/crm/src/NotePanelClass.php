<?php

    class NotePanel {
		public $type = 'cust';
		public $loadinto;
		public $focus;
		public $data;
		public $modal;
		public $collapse;

		public $custID;
		public $shipID;
        public $contactID;


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

        function hascustomer() {
            ($this->custID) ? false : true;
        }

        function hasshipto() {
            ($this->shipID) ? false : true;
        }

        function hascontact() {
            ($this->contactID) ? false : true;
        }

		function getaddnotelink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->notes."add/new/?custID=".urlencode($this->custID);
					if ($this->shipID != '') {$link .= "&shipID=".urlencode($this->shipID);}
					break;
			}
			return $link;
		}

		function getpanelrefreshlink() {
			$link = '';
			switch ($this->type) {
				case 'cust':
					$link = wire('config')->pages->notes."load/list/cust/?custID=".urlencode($this->custID);
					if ($this->hasshipto()) {$link .= "&shipID=".urlencode($this->shipID);}
					break;
                case 'user':
                    $link = wire('config')->pages->notes."load/list/user/";
                    break;
			}
			return $link;
		}

		function getinsertafter() {
			switch ($this->type) {
				case 'cust':
                    return 'cust/';
					break;
                case 'user':
					return 'user/';
					break;
			}
		}

		function getloadnotelink($noteid) {
			return wire('config')->pages->notes."load/?id=".$noteid;
		}

		function getpaneltitle() {
			switch ($this->type) {
				case 'cust':
					return 'Customer Notes';
					break;
                case 'user':
                    return 'Your Notes';
                    break;
			}
		}

        function buildarraylinks() {
            $this->links = array('writtenby' => false, 'customerlink' => false, 'shiptolink' => false, 'contactlink' => false);
            $this->links['writtenby'] = wire('user')->loginid;
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
