<?php 
    class ContactActionsPanel extends CustomerActionsPanel {
    
        /**
		* Contact Identifier
		* @var string
		*/
        protected $contactID;
        
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
			),
            'customerlink' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Customer Link'
			),
            'shiptolink' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Ship-to Link'
			),
            'contactlink' => array(
				'querytype' => 'in',
				'datatype' => 'text',
				'label' => 'Contact Link'
			)
		);
        
        /**
		* Type Identifier
		* @var string
		*/
        protected $paneltype = 'contact';
        
        
        /* =============================================================
            SETTER FUNCTIONS
        ============================================================ */
        /**
		 * Manipulates $this->pageurl path and query data as needed
		 * then sets $this->paginateafter value
		 * @return void
		 */
		public function setup_pageurl() {
			parent::setup_pageurl();
            $this->pageurl->query->set('contactID', $this->contactID);
		}
        
        public function set_contact($custID, $shiptoID = '', $contactID) {
            $this->set_customer($custID, $shiptoID);
            $this->contactID = $contactID;
            $this->generate_filter($this->input);
            $this->setup_pageurl();
        }
        
        public function generate_filter(ProcessWire\WireInput $input) {
            parent::generate_filter($input);
            $this->filters['contactlink'] = array($this->contactID);
        }
        
        /**
		* Generates title for Panel
		* @return string
		*/
		public function generate_title() {
			return 'Contact Actions';
		}
    }
