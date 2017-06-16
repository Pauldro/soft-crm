<?php 

    class Note {
        public $id;
        public $type;
        public $datecreated;
        public $writtenby;
        public $textbody;
        public $customerlink;
        public $shiptolink;
        public $contactlink;
        public $salesorderlink;
        public $quotelink;
        public $tasklink;

        public $hasshiptolink = false;
        public $hascontactlink = false;
        public $hasorderlink = false;
        public $hasquotelink = false;
        public $hastasklink = false;


        public function __construct() {
            $this->update();
        }

		public function update() {
			if ($this->shiptolink != '') { $this->hasshiptolink = true; }
            if ($this->contactlink != '') { $this->hascontactlink = true; }
            if ($this->salesorderlink != '') { $this->hasorderlink = true; }
            if ($this->quotelink != '') { $this->hasquotelink = true; }
            if ($this->tasklink != '') { $this->hastasklink = true; }
		}

        public function generatecustomerurl() {
            return wire('config')->pages->customer.urlencode($this->customerlink)."/";
        }

        public function generateshiptourl() {
            return $this->generatecustomerurl() . "shipto-".urlencode($this->shiptolink)."/";
        }

        public function generatecontacturl() {
            if ($this->hasshiptolink) {
                return $this->generatecustomerurl() . "shipto-".urlencode($this->shiptolink)."/contacts/?id=".urlencode($this->contactlink);
            } else {
                return generatecustomerurl()."contacts/?id=".urlencode($this->contactlink);
            }
        }


    }


 ?>
