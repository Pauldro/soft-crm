<?php

    class Task {
        public $id;
        public $tasktype;
        public $datewritten;
        public $duedate;
        public $writtenby;
        public $assignedto;
        public $assignedby;
        public $textbody;
        public $customerlink;
        public $shiptolink;
        public $contactlink;
        public $salesorderlink;
        public $quotelink;
        public $notelink;
        public $completed;
        public $completedate;
        public $lastupdated;

        public $contactby;

        public $hasshiptolink = false;
        public $hascontactlink = false;
        public $hasorderlink = false;
        public $hasquotelink = false;
        public $hasnotelink = false;
        public $isoverdue = false;
        public $hascompleted = false;

        public static function buildfromPDO($data) {
            $task = new Task();
            $task->id = $data['id'];
            $task->tasktype = $data['tasktype'];
            $task->datewritten = $data['datewritten'];
            $task->duedate = $data['duedate'];
            $task->writtenby = $data['writtenby'];
            $task->assignedto = $data['assignedto'];
            $task->assignedby = $data['assignedby'];
            $task->textbody = $data['textbody'];

            $task->customerlink = $data['customerlink'];
            $task->shiptolink = $data['shiptolink'];
            $task->contactlink = $data['contactlink'];
            $task->salesorderlink = $data['salesorderlink'];
            $task->quotelink = $data['quotelink'];
            $task->notelink = $data['notelink'];
            $task->completed = $data['completed'];
            $task->completedate = $data['completedate'];
            $task->lastupdated = $data['updatedate'];

            if ($task->shiptolink != '') { $task->hasshiptolink = true; }
            if ($task->contactlink != '') { $task->hascontactlink = true; }
            if ($task->salesorderlink != '') { $task->hasorderlink = true; }
            if ($task->quotelink != '') { $task->hasquotelink = true; }
            if ($task->notelink != '') { $task->hasnotelink = true; }
            if ($task->completed == 'Y') { $task->hascompleted = true; }
            if (strtotime($task->duedate) < strtotime("now") ) { $task->isoverdue = true;}
            return $task;
        }

		public static function blanktask($customerlink, $shiptolink, $contactlink, $salesorderlink, $quotelink, $notelink) {
			$task = new Task();
			$task->customerlink = $customerlink;
            $task->shiptolink = $shiptolink;
            $task->contactlink = $contactlink;
            $task->salesorderlink = $salesorderlink;
            $task->quotelink = $quotelink;
            $task->notelink = $notelink;
			if ($task->shiptolink != '') { $task->hasshiptolink = true; }
            if ($task->contactlink != '') { $task->hascontactlink = true; }
            if ($task->salesorderlink != '') { $task->hasorderlink = true; }
            if ($task->quotelink != '') { $task->hasquotelink = true; }
            if ($task->notelink != '') { $task->hasnotelink = true; }
			return $task;
		}

        public function __construct() {
            if ($this->shiptolink != '') { $this->hasshiptolink = true; }
            if ($this->contactlink != '') { $this->hascontactlink = true; }
            if ($this->salesorderlink != '') { $this->hasorderlink = true; }
            if ($this->quotelink != '') { $this->hasquotelink = true; }
            if ($this->notelink != '') { $this->hasnotelink = true; }
            if ($this->completed == 'Y') { $this->hascompleted = true; }
            if (strtotime($this->duedate) < strtotime("now") && (!$this->hascompleted) ) { $this->isoverdue = true;}
            $contact = getcustcontact($this->customerlink, $this->shiptolink, $this->contactlink, false);
            switch ($this->tasktype) {
                case 'email':
                    $this->contactby = $contact['email'];
                    break;
                case 'phone':
                    $this->contactby = $contact['cphone'];
                    break;
                default:
                    $this->contactby = $contact['cphone'];
                    break;
            }
        }



        public function generatecustomerurl() {
            return wire('config')->pages->customer."/redir/?action=load-customer&custID=".urlencode($this->customerlink);
        }

        public function generateshiptourl() {
            return $this->generatecustomerurl() . "&shipID=".urlencode($this->shiptolink);
        }

        public function generatecontacturl() {
            if ($this->hasshiptolink) {
                return wire('config')->pages->customer.urlencode($this->customerlink) . "/shipto-".urlencode($this->shiptolink)."/contacts/?id=".urlencode($this->contactlink);
            } else {
                return wire('config')->pages->customer.urlencode($this->customerlink)."/contacts/?id=".urlencode($this->contactlink);
            }
        }

        public function generatecompletionurl($complete) {
            return wire('config')->pages->tasks."update/completion/?id=".$this->id."&complete=".$complete; //true or false
        }

        public function generateviewtaskurl() {
            return wire('config')->pages->tasks."load/?id=".$this->id;
        }

        public function generatecontactbylink() {
            $href = '';
            $contact = getcustcontact($this->customerlink, $this->shiptolink, $this->contactlink, false);
            switch ($this->tasktype) {
                case 'email':
                    $href = "mailto:".$contact['email'];
                    break;
                case 'phone':
                    $href = "tel:".$contact['cphone'];
                    break;
                default:
                    $href = "tel:".$contact['cphone'];
                    break;
            }
            return $href;
        }




    }


 ?>
