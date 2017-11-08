<?php 
    class UserActionDisplay {
        public $modal = '#ajax-modal';
        public $pageurl = false;
        
        public function __construct(\Purl\Url $pageurl) {
            $this->pageurl = new \Purl\Url($pageurl->getUrl());;
        }
        
        public function generate_viewactionurl($action) {
			return wire('config')->pages->actions."$action->actiontype/load/?id=".$action->id;
		}

		public function generate_completionurl($action, $complete) {
			return wire('config')->pages->actions."$action->actiontype/update/completion/?id=".$action->id."&complete=".$complete; //true or false
		}

		public function generate_rescheduleurl($action) {
			return wire('config')->pages->actions."$action->actiontype/update/reschedule/?id=".$action->id;
		}

		public function generate_viewactionjsonurl($action) {
			return wire('config')->pages->ajax."json/load-action/?id=".$action->id;
		}

		public function generate_customerurl($action) {
			return wire('config')->pages->customer."redir/?action=load-customer&custID=".urlencode($action->customerlink);
		}

		public function generate_shiptourl($action) {
			return $action->generate_customerurl($action) . "&shipID=".urlencode($action->shiptolink);
		}

		public function generate_contacturl($action) {
			if ($this->has_shiptolink()) {
				return wire('config')->pages->customer.urlencode($action->customerlink) . "/shipto-".urlencode($action->shiptolink)."/contacts/?id=".urlencode($action->contactlink);
			} else {
				return wire('config')->pages->customer.urlencode($action->customerlink)."/contacts/?id=".urlencode($actions->contactlink);
			}
		}
        
        public function generate_viewactionlink($action) {
            $bootstrap = new Contento();
            $href = $this->generate_viewactionurl($action);
            $icon = $bootstrap->createicon('material-icons md-18', '&#xE02F;');
            return $bootstrap->openandclose('a', "href=$href|role=button|class=btn btn-xs btn-primary load-action|data-modal=$this->modal|title=View Task", $icon);
        }
        
        public function generate_completetasklink($task) {
            $bootstrap = new Contento();
            $href = $this->generate_rescheduleurl($task);
            $icon = $bootstrap->createicon('fa fa-check-circle');
            $icon .= ' <span class="sr-only">Mark as Complete</span>';
            return $bootstrap->openandclose('a', "href=$href|role=button|class=btn btn-primary complete-action|title=Mark Task as Complete", $icon. " Complete Task");
        }
        
        public function generate_rescheduletasklink($task) {
            $bootstrap = new Contento();
            $href = $this->generate_viewactionjsonurl($task);
            $icon = $bootstrap->createicon('fa fa-calendar');
            return $bootstrap->openandclose('a', "href=$href|role=button|class=btn btn-default reschedule-task", $icon. " Reschedule Task");
        }
        
        public function generate_customerpagelink($action) {
            $bootstrap = new Contento();
            $href = $this->generate_customerurl($action);
            $icon = $bootstrap->createicon('glyphicon glyphicon-share');
            return $bootstrap->openandclose('a', "href=$href", $icon." Go to Customer Page");
        }
        
        public function generate_shiptopagelink($action) {
            $bootstrap = new Contento();
            $href = $this->generate_customerurl($action);
            $icon = $bootstrap->createicon('glyphicon glyphicon-share');
            return $bootstrap->openandclose('a', "href=$href", $icon." Go to Shipto Page");
        }
        
        public function generate_contactpagelink($action) {
            $bootstrap = new Contento();
            $href = $this->generate_contacturl($action);
            $icon = $bootstrap->createicon('glyphicon glyphicon-share');
            return $bootstrap->openandclose('a', "href=$href", $icon." Go to Contact Page");
        }
    }
