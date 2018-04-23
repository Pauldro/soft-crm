<?php
	class ActionsPanel extends UserActionDisplay {
		use Filterable;
		use AttributeParser;
		
		/**
		* Session Identifier
		* @var string
		*/
		protected $sessionID;
		/**
		* Partial ID for $this->focus and $this->loadinto
		* @var string
		*/
		protected $partialid = 'actions';
		
		/**
		* Modal to load some Ajax content into
		* @var string
		*/
		protected $modal = '#ajax-modal';
		/**
		* What Action Type to filter 
		* // TODO work into filters
		* @var string
		*/
		protected $actiontype = '';
		
		/**
		* ID of element to focus on
		* @var string
		*/
		protected $focus = '';
		/**
		* ID of element to load ajax content into
		* @var string
		*/
		protected $loadinto = '';
		
		/**
		* Page URL
		* @var Purl\Url
		*/
		protected $pageurl = false;
		
		/**
		* String of data attributes
		* @var string e.g. data-loadinto='$this->loadinto' data-focus='$this->focus'
		*/
		protected $ajaxdata;
		
		/**
		* Load into Modal
		* @var bool
		*/
		protected $loadintomodal = false;
		
		/**
		* Whether or not the panel div shows opened or collapse
		* @var string
		*/
		protected $collapse = 'collapse';
		// TODO $tablesorter
		
		/**
		* Page Number
		* @var int
		*/
		protected $pagenbr = 0;
		
		/**
		* Number of Actions that match
		* @var int
		*/
		protected $count = 0;
		
		protected $completed = false;
		protected $rescheduled = false;
		/**
		* Task Status
		* TODO work into filter
		* @var [type]
		*/
		protected $taskstatus = 'N';
		/**
		 * Array of filters that will apply to the orders
		 * @var array
		 */
		protected $filters = false;
		protected $filterable = array(
			'actiontype' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Action Type'
			),
			'completed' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Completed'
			),
			'assignedto' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Assigned To'
			),
			'datecreated' => array(
				'querytype' => 'between',
				'datatype' => 'mysql-date',
				'label' => 'Date Created',
				'date-format' => "Y-m-d H:i:s"
			),
			'datecompleted' => array(
				'querytype' => 'between',
				'datatype' => 'mysql-date',
				'label' => 'Date Completed',
				'date-format' => "Y-m-d H:i:s"
			)
		);
		protected $taskstatuses = array('Y' => 'Completed', 'N' => 'Not Completed', 'R' => 'Rescheduled');
		
		public $panelid = '';
        public $panelbody = '';
		
		/* =============================================================
			CONSTRUCTOR FUNCTIONS 
		============================================================ */
		public function __construct($sessionID, \Purl\Url $pageurl, ProcessWire\WireInput $input, $throughajax = false, $loadinmodal = false) {
			$this->sessionID = $sessionID;
			$this->pageurl = new \Purl\Url($pageurl->getUrl());
			$this->pagenbr = Paginator::generate_pagenbr($pageurl);
			$this->partialid = ($loadinmodal) ? 'actions-modal' : $this->partialid;
			$this->loadinto = '#'.$this->partialid.'-panel';
			$this->focus = '#'.$this->partialid.'-panel';
			$this->panelid = $this->partialid.'-panel';
			$this->panelbody = $this->partialid.'-div';
			$this->loadintomodal = $loadinmodal;
			$this->ajaxdata = 'data-loadinto="'.$this->loadinto.'" data-focus="'.$this->focus.'"';
			$this->collapse = $throughajax ? '' : 'collapse';
			
			$this->generate_filter($input);
			$this->count_actions();
		}
		
		/* =============================================================
			SETTER FUNCTIONS 
		============================================================ */
		
		public function setup_completedtasks() {
			$this->taskstatus = 'Y';
			$this->completed = true;
		}
		
		public function setup_rescheduledtasks() {
			$this->taskstatus = 'R';
			$this->rescheduled = true;
		}
		
		public function setup_tasks($status) {
			switch ($status) {
				case 'Y':
					$this->setup_completedtasks();
					break;
				case 'R':
					$this->setup_rescheduledtasks();
					break;
			}
		}
		
		/* GENERATE URLS - URLS ARE THE HREF VALUE */
		public function generate_refreshurl() { 
			$url = new \Purl\Url($this->pageurl->getUrl());
			$url->path = DplusWire::wire('config')->pages->activity."user-actions/";
			if ($this->loadintomodal) { $url->query->set('modal', 'modal'); }
			return $url->getUrl();
		}
		
		function generate_addactionurl($keepactiontype = false) {
			if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
				$actionpath = ($this->actiontype == 'all') ? 'tasks' : $this->actiontype;
			} else {
				$actionpath = ($keepactiontype) ? $this->actiontype : '{replace}';
			}
			$url = new \Purl\Url($this->generate_refreshurl(true));
			$url->path = DplusWire::wire('config')->pages->actions.$actionpath."/add/";
			return $url->getUrl();
		}
		
		public function generate_removeassigneduserIDurl() {
			$url = new \Purl\Url($this->generate_refreshurl(true));
			$url->query->remove('assignedto');
			return $url->getUrl();
		}
		
		/* =============================================================
			CLASS FUNCTIONS 
		============================================================ */
		/* = GENERATE LINKS - LINKS ARE THE HTML MARKUP FOR LINKS */
		public function generate_refreshlink() {
			$bootstrap = new Contento();
			$href = $this->generate_refreshurl(true);
			$icon = $bootstrap->createicon('material-icons md-18', '&#xE86A;');
			$ajaxdata = $this->generate_ajaxdataforcontento();
			return $bootstrap->openandclose('a', "href=$href|class=btn btn-info btn-xs load-link actions-refresh pull-right hidden-print|title=button|title=Refresh Actions|aria-label=Refresh Actions|$ajaxdata", $icon);
		}
		
		public function generate_printlink() {
			$bootstrap = new Contento();
			$href = $this->generate_refreshurl(true);
			$icon = $bootstrap->createicon('glyphicon glyphicon-print');
			return $bootstrap->openandclose('a', "href=$href|class=h3|target=_blank", $icon." View Printable");
		}
		
		function generate_addlink() {
			if (get_class($this) == 'UserActionsPanel') return '';
			$bootstrap = new Contento();
			$href = $this->generate_addactionurl();
			$icon = $bootstrap->createicon('material-icons md-18', '&#xE146;');
			if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
				return $bootstrap->openandclose('a', "href=$href|class=btn btn-info btn-xs load-into-modal pull-right hidden-print|data-modal=$this->modal|role=button|title=Add Action", $icon);
			}
			return $bootstrap->openandclose('a', "href=$href|class=btn btn-info btn-xs add-action pull-right hidden-print|data-modal=$this->modal|role=button|title=Add Action", $icon);
		}
		
		public function generate_removeassigneduserIDlink() {
			$bootstrap = new Contento();
			$href = $this->generate_removeassigneduserIDurl();
			$icon = $bootstrap->createicon('fa fa-user-times');
			$ajaxdata = $this->generate_ajaxdataforcontento();
			return $bootstrap->openandclose('a', "href=$href|class=btn btn-warning btn-xs load-link pull-right hidden-print|title=button|title=Return to Your Actions|aria-label=Return to Your Actions|$ajaxdata", $icon.' Remove User lookup');
		}
		
		/* CONTENT FUNCTIONS  */
		public function generate_rowclass($action) {
			if ($action->actiontype == 'tasks') {
				if ($action->is_rescheduled()) {
					return 'bg-info';
				}
				if ($action->is_overdue()) {
					return 'bg-warning';	
				}
				if ($action->is_completed()) {
					return 'bg-success';
				}
			}
			return '';
		}
		
		public function generate_actionstable() {
			$actions = $this->get_actions();
			$table = false;
			switch ($this->actiontype) {
				case 'actions':
					$table = $this->draw_actionstable($actions);
					break;
				case 'notes':
					$table = $this->draw_notestable($actions);
					break;
				case 'tasks':
					$table = $this->draw_taskstable($actions);
					break;
				default:
					$table = $this->draw_allactionstable($actions);
					break;
			}
			return $table;
		}
		
		public function draw_allactionstable($actions) {
			$tb = new Table('class=table table-bordered table-condensed table-striped');
			$tb->tablesection('thead');
				$tb->tr();
				$tb->th('', 'Due')->th('', 'Type')->th('', 'Subtype')->th('', 'Customer')->th('', 'Regarding / Title')->th('', 'View');
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
				if (!sizeof($this->count)) {
					$tb->tr();
					$tb->td('colspan=6|class=text-center h4', 'No related actions found');
				}
				
				foreach ($actions as $action) {
					$class = $this->generate_rowclass($action);
					$tb->tr("class=$class");
					$tb->td('', $action->generate_duedatedisplay('m/d/Y'));
					$tb->td('', $action->actiontype);
					$tb->td('', $action->generate_actionsubtypedescription());
					$tb->td('', $action->customerlink.' - '.Customer::get_customernamefromid($action->customerlink, '', false));
					$tb->td('', $action->generate_regardingdescription());
					$tb->td('', $this->generate_viewactionlink($action));
				}
			$tb->closetablesection('tbody');
			return $tb->close();
		}
		
		public function draw_actionstable($actions) { // DEPRECATED 02/21/2018
			$tb = new Table('class=table table-bordered table-condensed table-striped');
			$tb->tablesection('thead');
				$tb->tr();
				$tb->th('', 'Date / Time')->th('', 'Subtype')->th('', 'CustID')->th('', 'Regarding / Title')->th('', 'View action');
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
				if (!sizeof($this->count)) {
					$tb->tr();
					$tb->td('colspan=5|class=text-center h4', 'No related actions found');
				}
				
				foreach ($actions as $action) {
					$class = $this->generate_rowclass($action);
					
					$tb->tr("class=$class");
					$tb->td('', date('m/d/Y g:i A', strtotime($action->datecreated)));
					$tb->td('', ucfirst($action->generate_actionsubtypedescription()));
					$tb->td('', $action->customerlink.' - '.Customer::get_customernamefromid($action->customerlink, '', false));
					$tb->td('', $action->generate_regardingdescription());
					$tb->td('', $this->generate_viewactionlink($action));
				}
			$tb->closetablesection('tbody');
			return $tb->close();
		}
		
		public function draw_notestable($notes) {
			$tb = new Table('class=table table-bordered table-condensed table-striped');
			$tb->tablesection('thead');
				$tb->tr();
				$tb->th('', 'Subtype')->th('', 'CustID')->th('', 'Regarding / Title')->th('', 'View action');
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
				if (!sizeof($this->count)) {
					$tb->td('colspan=4|class=text-center h4', 'No related actions found');
				}
				
				foreach ($notes as $note) {
					$class = $this->generate_rowclass($note);
					
					$tb->tr("class=$class");
					$tb->td('', ucfirst($note->generate_actionsubtypedescription()));
					$tb->td('', $note->customerlink.' - '.Customer::get_customernamefromid($note->customerlink, '', false));
					$tb->td('', $note->generate_regardingdescription());
					$tb->td('', $this->generate_viewactionlink($note));
				}
			$tb->closetablesection('tbody');
			return $tb->close();
		}
		
		public function draw_taskstable($tasks) {
			$form = $this->generate_changetaskstatusview();
			$tb = new Table('class=table table-bordered table-condensed table-striped');
			$tb->tablesection('thead');
				$tb->tr();
				$tb->th('', 'Due')->th('', 'Subtype')->th('', 'CustID')->th('', 'Regarding / Title')->th('', 'View action')->th('', 'Complete action');
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
				if (!sizeof($this->count)) {
					$tb->td('colspan=6|class=text-center h4', 'No related actions found');
				}
				
				foreach ($tasks as $task) {
					$class = $this->generate_rowclass($task);
					$tb->tr("class=$class");
					$tb->td('', $task->generate_duedatedisplay('m/d/Y'));
					$tb->td('', $task->generate_actionsubtypedescription());
					$tb->td('', $task->customerlink.' - '.Customer::get_customernamefromid($task->customerlink, '', false));
					$tb->td('', $task->generate_regardingdescription());
					$tb->td('', $this->generate_viewactionlink($task));
					$complete = ($task->is_completed()) ? '' : $this->generate_completetasklink($task);
					$tb->td('', $complete);
				}
			$tb->closetablesection('tbody');
			return $form . $tb->close();
		}
		
		public function generate_changetaskstatusview() {
			$bootstrap = new Contento();
			$ajaxdata = $this->generate_ajaxdataforcontento();
			$href = $this->generate_refreshurl(true);
			$form = new FormMaker('', false);
			$form->add($form->bootstrap->open('div', 'class=panel-body'));
				$form->add($form->bootstrap->open('div', 'class=row'));
					$form->add($form->bootstrap->open('div', 'class=col-xs-4'));
						$form->add($form->bootstrap->openandclose('label', 'for=view-action-completion-status', 'View Completed Tasks'));
						$form->select("id=view-action-completion-status|class=form-control input-sm|$ajaxdata|data-url=$href", $this->taskstatuses, $this->taskstatus);
					$form->add($form->bootstrap->close('div'));
				$form->add($form->bootstrap->close('div'));
			$form->add($form->bootstrap->close('div'));
			return $form->finish();
		}
		
		public function generate_legend() {
 			$bootstrap = new Contento();
 			$tb = new Table('class=table table-bordered table-condensed table-striped');
			$tb->tr('class=bg-warning')->td('', 'Task Overdue');
			$tb->tr('class=bg-info')->td('', 'Task Rescheduled');
			$tb->tr('class=bg-success')->td('', 'Task Completed');
 			$content = str_replace('"', "'", $tb->close());
 			$attr = "tabindex=0|role=button|class=btn btn-sm btn-info|data-toggle=popover|data-placement=bottom|data-trigger=focus";
 			$attr .= "|data-html=true|title=Icons Definition|data-content=$content";
 			return $bootstrap->openandclose('a', $attr, 'Icon Definitions');
 		}
		
		public function generate_completetasklink(UserAction $task) {
			$bootstrap = new Contento();
			$href = $this->generate_viewactionjsonurl($task);
			$icon = $bootstrap->createicon('fa fa-check-circle');
			$icon .= ' <span class="sr-only">Mark as Complete</span>';
			return $bootstrap->openandclose('a', "href=$href|role=button|class=btn btn-xs btn-primary complete-action|title=Mark Task as Complete", $icon);
		}
			
		/** 
		* Generates insertafter string for Paginator object to put the pagination string after
		* @return string 
		*/
		public function generate_insertafter() { 
			return "actions/";
		}
		
		/**
		* Checks if USER and the and $this->assigneduserID are equal
		* and if not return true
		* @return bool
		*/
		public function should_haveremoveuserIDlink() {
			return ($this->userID != $this->assigneduserID) ? true : false;
		}
		
		/** 
		* Generates title for Panel
		* Will be overwritten by children
		* @return string 
		*/
		public function generate_title() {
			return 'Your Actions';
		}
		
		/**
		* Returns if the panel should have the add link
		* Will be overwritten by children
		* @return bool
		*/
		public function should_haveaddlink() {
			return true;
		}
		
		public function count_actions($debug = false) {
			return $debug ? count_actions($this->filters, $this->filterable, $debug) : $this->count = count_actions($this->filters, $this->filterable, $debug);
		}
		
		public function get_actions($debug = false) {
			return get_actions($this->filters, $this->filterable, DplusWire::wire('session')->display, $this->pagenbr, $debug);
		}
		
		public function generate_pagenumberdescription() {
			return ($this->pagenbr > 1) ? "Page $this->pagenbr" : '';
		}
		
		public function generate_filter(ProcessWire\WireInput $input) {
			$this->generate_defaultfilter($input);
			
			if (!isset($this->filters['completed'])) {
				$this->filters['completed'] = array('');
			}
			
			if (isset($this->filters['datecreated'])) {
				if (empty($this->filters['datecreated'][1])) {
					$this->filters['datecreated'][1] = date('m/d/Y');
				}
				
				if (empty($this->filters['datecreated'][0])) {
					unset($this->filters['datecreated']);
				}
			}
			
			if (isset($this->filters['datecompleted'])) {
				$this->filters['completed'] = array('Y');
				if (empty($this->filters['datecompleted'][1])) {
					$this->filters['datecompleted'][1] = date('m/d/Y');
				}
			}
			
			if (isset($this->filters['actiontype'])) {
				if (sizeof($this->filters['actiontype']) > 1) {
					$this->actiontype = 'all';
				} else {
					$this->actiontype = $this->filters['actiontype'][0];
				}
			} else {
				$this->actiontype = 'all';
			}
		}
	}
