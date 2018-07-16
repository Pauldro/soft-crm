<?php
    class SigninLog {

        /**
		 * Array of logins
		 * @var array
		 */
		public $logs = array();
        public $sessionid;
        public $user;
        public $date;

        protected $filter;
        protected $filterable = array();

        /**
		 * Returns the number of signins that will be found with the filters applied
		 * @param  bool   $debug Whether or Not the Count will be returned
		 * @return int           Number of Signins | SQL Query
		 */
        public function count_day_signins($day, $debug = false) {
            $count = count_daysignins($day, $debug);
			return $debug ? $count : $this->count = $count;
        }

        /**
		 * Returns the Signins into the property $logs
		 * @param  bool   $debug Whether to run query to return quotes
		 * @return array         Signins | SQL Query
		 * @uses
		 */
        public function get_daysignins($day, $debug = false) {
			$logs = get_daysignins($day, $debug);
			return $debug ? $logs : $this->logs = $logs;
        }
    }
