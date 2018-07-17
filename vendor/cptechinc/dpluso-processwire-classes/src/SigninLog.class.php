<?php
    class SigninLog {

        /**
		 * Array of logins
		 * @var array
		 */
		public $logs = array();
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

        /**
         * Logs the Session Sign in, if not already created
         * @param  string $sessionID User Session ID
         * @param  string $userID    User ID
         * @return void
         */
        public static function log_signin($sessionID, $userID) {
            if (!self::has_loggedsignin($sessionID)) {
                self::insert_logsignin($sessionID, $userID);
            }
        }

        /**
         * Inserts a signin record into the log_signin table
         * @param  string $sessionID User Session ID
         * @param  string $userID    User ID
         * @param  bool   $debug     Run in debug? If so return SQL Query
         * @return string            SQL Query after Execution
         */
        public static function insert_logsignin($sessionID, $userID, $debug = false) {
            return insert_logsignin($sessionID, $userID, $debug);
        }

        /**
         * Returns if this session has a log_signin record attached
         * @param  string $sessionID User Session ID
         * @param  bool   $debug     Run in debug? If so return SQL Query
         * @return bool              Does sessionID have log_signin record?
         */
        public static function has_loggedsignin($sessionID, $debug = false) {
            return has_loggedsignin($sessionID, $debug);
        }
    }
