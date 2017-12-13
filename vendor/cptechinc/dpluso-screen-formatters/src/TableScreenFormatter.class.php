<?php
	abstract class TableScreenFormatter {
		protected $sessionID;
		protected $userID;
		protected $debug = false;
        protected $tabletype = 'normal'; // grid or normal
		protected $type = ''; 
		protected $title = '';
		protected $datafilename = ''; 
		protected $fullfilepath = false;
		protected $testprefix = ''; 
		protected $json = false; // WILL BE JSON DECODED ARRAY
		protected $formatterfieldsfile = ''; 
		protected $formatter = false; // WILL BE JSON DECODED ARRAY
		protected $fields = false; // WILL BE JSON DECODED ARRAY
		protected $tableblueprint = false; // WILL BE ARRAY
		protected $datasections = array();
		protected $jsfile; //
		
		public static $filedir = false;
		public static $testfiledir = false;
		public static $fieldfiledir = false;
		
		/* =============================================================
           CONSTRUCTOR AND SETTER FUNCTIONS
       ============================================================ */
		public function __construct($sessionID) {
			$this->sessionID = $sessionID;
			$this->userID = wire('user')->loginid;
			$this->load_fields();
			$this->load_formatter();
			$this->generate_tableblueprint();
			$this->load_filepath();
		}
		
		public function set_debug($debug) {
			$this->debug = $debug;
			$this->load_filepath();
		}
		
		public function set_userid($userID) {
			$this->userID = $userID;
		}
		
		/* =============================================================
          GETTER FUNCTIONS
       ============================================================ */
		public function __get($property) {
			if (property_exists($this, $property) !== true) {
				$this->error("This property ($property) does not exist");
				return false;
			}
			$method = "get_{$property}";
			if (method_exists($this, $method)) {
				return $this->$method();
			} else {
				return $this->$property;
			}
		}
		
		public function get_fields() {
			if (!$this->fields) {
                $this->load_fields();
            }
            return $this->fields;
		}
		
		public function get_formatter() {
			if (!$this->formatter) {
                $this->load_formatter();
            }
            return $this->formatter;
		}
		
		/* =============================================================
          PUBLIC FUNCTIONS
       	============================================================ */
			public function load_filepath() {
				$this->fullfilepath = ($this->debug) ? self::$testfiledir.$this->datafilename.".json" : self::$filedir.$this->sessionID."-".$this->datafilename.".json";
			}
			
			public function process_json() {
				$this->load_filepath();
				$json = json_decode(file_get_contents($this->fullfilepath), true); 
				$this->json = (!empty($json)) ? $json : array('error' => true, 'errormsg' => "The $this->title JSON contains errors. JSON ERROR: ".json_last_error());
			}
	        
	        public function get_tableblueprint() {
	            if (!$this->tableblueprint) {
	                $this->generate_tableblueprint();
	            }
	            return $this->tableblueprint;
	        }
			
			public function generate_formatterfrominput(WireInput $input) {
				$this->formatter = false;
				$postarray = $table = array('cols' => 0);
				$tablesections = array_keys($this->fields['data']);
				
				foreach ($tablesections as $tablesection) {
					$postarray[$tablesection] = array('rows' => 0, 'columns' => array());
					$table[$tablesection] = array('maxrows' => 0, 'rows' => array());
					
					foreach (array_keys($this->fields['data'][$tablesection]) as $column) {
						$postcolumn = str_replace(' ', '', $column);
						$linenumber = $input->post->int($postcolumn.'-line');
						$length = $input->post->int($postcolumn.'-length');
						$colnumber = $input->post->int($postcolumn.'-column');
						$label = $input->post->text($postcolumn.'-label');
						$dateformat = $beforedecimal = $afterdecimal = false;
						
						if ($this->fields['data'][$tablesection][$column]['type'] == 'D') {
							$dateformat = $input->post->text($postcolumn.'-date-format');
						} elseif ($this->fields['data'][$tablesection][$column]['type'] == 'N') {
							$beforedecimal = $input->post->int($postcolumn.'-before-decimal');
							$afterdecimal = $input->post->int($postcolumn.'-after-decimal');
						}
						
						$postarray[$tablesection]['columns'][$column] = array(
							'line' => $linenumber, 
							'column' => $colnumber, 
							'col-length' => $length, 
							'label' => $label, 
							'before-decimal' => $beforedecimal, 
							'after-decimal' => $afterdecimal, 
							'date-format' => $dateformat
						);
					}
					
					foreach ($postarray[$tablesection]['columns'] as $column) {
						if ($column['line'] > $postarray[$tablesection]['rows']) {
							$postarray[$tablesection]['rows'] = $column['line'];
						}
					}
					
					for ($i = 1; $i < ($postarray[$tablesection]['rows'] + 1); $i++) {
						$table[$tablesection]['rows'][$i] = array('columns' => array());
						
						foreach ($postarray[$tablesection]['columns'] as $column) {
							if ($column['line'] == $i) {
								$table[$tablesection]['rows'][$i]['columns'][$column['column']] = $column;
							}
						}
					}
					
					foreach ($table[$tablesection]['rows'] as $row) {
						$columncount = 0;
						foreach ($row['columns'] as $column) {
							$columncount += $column['col-length'];
						}
						$postarray['cols'] = ($columncount > $postarray['cols']) ? $columncount : $postarray['cols'];
					}
				}
				$this->formatter = $postarray;
				$this->generate_tableblueprint();
			}
			
			public function change_userID($userID) {
				$this->userID = $userID;
			}
			
			public function save($debug = false) {
				$userID = wire('user')->loginid;
				$userpermission = wire('pages')->get('/config/')->allow_userscreenformatter;
				$userpermission = (!empty($userpermission)) ? $userpermission : wire('users')->get("name=$userID")->hasPermission('setup-screen-formatter');
				
				if ($this->has_savedformatter()) {
					return $this->update($debug);
				} else {
					return $this->create($debug);
				}
			}
			
			public function save_andrespond() {
				$response = $this->save();
				
				if ($response['success']) {
					$json = array (
						'response' => array (
							'error' => false,
							'notifytype' => 'success',
							'action' => $response['querytype'],
							'message' => "Your table ($this->type) configuration has been saved",
							'icon' => 'glyphicon glyphicon-floppy-disk',
						)
					);
				} else {
					$json = array (
						'response' => array (
							'error' => true,
							'notifytype' => 'danger',
							'action' => $response['querytype'],
							'message' => "Your configuration ($this->type) was not able to be saved, you may have not made any discernable changes.",
							'icon' => 'glyphicon glyphicon-warning-sign',
						)
					);
				}
				return $json;
			}
		
		/* =============================================================
          INTERNAL FUNCTIONS
       	============================================================ */
		protected function load_fields() {
			$this->fields = json_decode(file_get_contents(self::$fieldfiledir."$this->formatterfieldsfile.json"), true);
		}
	   
		protected function load_formatter() {
			if ($this->does_userhaveformatter()) {
				$this->formatter = getformatter(wire('user')->loginid, $this->type, false);
			} else {
				$this->formatter = file_get_contents(wire('config')->paths->vendor."cptechinc/dpluso-screen-formatters/src/default/$this->type.json");
			}
			$this->formatter = json_decode($this->formatter, true);
		}
		
		protected function does_userhaveformatter() {
			return checkformatterifexists(wire('user')->loginid, $this->type, false);
		}
		
        protected function generate_tableblueprint() {
            $tablesections = array_keys($this->fields['data']);
            $table = array('cols' => $this->formatter['cols']);
			
            foreach ($tablesections as $section) {
                $columns = array_keys($this->formatter[$section]['columns']);
                $table[$section] = array(
					'maxrows' => $this->formatter[$section]['rows'], 
					'rows' => array()
				);
                
                for ($i = 1; $i < $this->formatter[$section]['rows'] + 1; $i++) {
            		$table[$section]['rows'][$i] = array('columns' => array());
            		foreach($columns as $column) {
            			if ($this->formatter[$section]['columns'][$column]['line'] == $i) {
            				$col = array(
            					'id' => $column, 
            					'label' => $this->formatter[$section]['columns'][$column]['label'], 
            					'column' => $this->formatter[$section]['columns'][$column]['column'], 
            					'col-length' => $this->formatter[$section]['columns'][$column]['col-length'], 
            					'before-decimal' => $this->formatter[$section]['columns'][$column]['before-decimal'],
            					'after-decimal' => $this->formatter[$section]['columns'][$column]['after-decimal'], 
            					'date-format' => $this->formatter[$section]['columns'][$column]['date-format']
            				 );
            				$table[$section]['rows'][$i]['columns'][$this->formatter[$section]['columns'][$column]['column']] = $col;
            			}
            		}
            	}
            }
            $this->tableblueprint = $table;
        }
		/* =============================================================
			DATABASE FUNCTIONS
		============================================================ */
			public function has_savedformatter() {
				return does_tableformatterexist($this->userID, $this->type);
			}
			
			protected function update($debug = false) {
				return update_formatter($this->userID, $this->type, json_encode($this->formatter), $debug);
			}
			
			protected function create($debug = false) {
				return create_formatter($this->userID, $this->type, json_encode($this->formatter), $debug);
			}
			
		/* =============================================================
			CLASS FUNCTIONS
		============================================================ */
		protected function error($error, $level = E_USER_ERROR) {
			$error = (strpos($error, 'DPLUSO[SCREEN-FORMATTER]: ') !== 0 ? 'DPLUSO[SCREEN-FORMATTER]: ' . $error : $error);
			trigger_error($error, $level);
			return;
		}
		
		public static function set_filedirectory($dir) {
			self::$filedir = $dir;
		}
		
		public static function set_testfiledirectory($dir) {
			self::$testfiledir = $dir;
		}
		
		public static function set_fieldfiledirectory($dir) {
			self::$fieldfiledir = $dir;
		}
}
