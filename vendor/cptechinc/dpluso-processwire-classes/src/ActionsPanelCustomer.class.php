<?php 
    class CustomerActionsPanel extends ActionsPanel {
    
        /**
		* Customer Identifier
		* @var string
		*/
        protected $custID;
        
        /**
		* Ship-to Identifier
		* @var string
		*/
        protected $shiptoID;
        
        /**
		 * Array of filterable columns and their attributes
		 * @var array
		 */
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
				'date-format' => "m/d/Y H:i:s"
			),
			'datecompleted' => array(
				'querytype' => 'between',
				'datatype' => 'mysql-date',
				'label' => 'Date Completed',
				'date-format' => "m/d/Y H:i:s"
			),
			'dateupdated' => array(
				'querytype' => 'between',
				'datatype' => 'mysql-date',
				'label' => 'Date Updated',
				'date-format' => "m/d/Y H:i:s"
			),
			'duedate' => array(
				'querytype' => 'between',
				'datatype' => 'mysql-date',
				'label' => 'Due Date',
				'date-format' => "m/d/Y H:i:s"
			)
		);
        
        /**
		* Type Identifier
		* @var string
		*/
        protected $type = 'customer';
        protected $input; 
        
        /* =============================================================
			CONSTRUCTOR FUNCTIONS
		============================================================ */
		/**
		 * Constructor
		 * @param string                $sessionID   Session Identifier
		 * @param Purl\Url              $pageurl     Object that contains URL to Page
		 * @param ProcessWire\WireInput $input       Input such as the $_GET array to run generate_filter
		 * @param bool                  $throughajax If panel was loaded through ajax
		 * @param string                $panelID     Panel element ID
		 */
		public function __construct($sessionID, \Purl\Url $pageurl, ProcessWire\WireInput $input, $throughajax = false, $panelID = '') {
            parent::__construct($sessionID, $pageurl, $input, $throughajax, $panelID);
            $this->input = $input;
		}
        
        /* =============================================================
			SETTER FUNCTIONS
		============================================================ */
        public function set_customer($custID, $shiptiID = '') {
            $this->custID = $custID;
            $this->shiptoID = $shiptoID;
            $this->generate_filter($this->input);
        }
        
        public function generate_filter(ProcessWire\WireInput $input) {
			parent::generate_filter($input);
			$this->filters['customerlink'] = array($this->custID);
            if (!empty($this->shiptoID)) {
                $this->filters['shiptolink'] = array($this->shiptoID);
            }
		}
