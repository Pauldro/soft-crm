<?php
    class ScreenFormatterFactory {
        protected $sessionID;
        protected $formatters = array(
            'ii-sales-history' => 'SalesHistoryFormatter',
            'ii-sales-orders' => 'SalesOrderFormatter',
        );
        
        public function __construct($sessionID) {
            $this->sessionID = $sessionID;
        }
        
        public function generate_screenformatter($type) {
            if (in_array($type, array_keys($this->formatters))) {
                return new $this->formatters[$type]($this->sessionID);
            } else {
                $this->error("Screen Formatter $type does not exist");
                return false;
            }
        }
        
        protected function error($error, $level = E_USER_ERROR) {
			$error = (strpos($error, 'DPLUSO[SCREEN-FORMATTER]: ') !== 0 ? 'DPLUSO[SCREEN-FORMATTER]: ' . $error : $error);
			trigger_error($error, $level);
			return;
		}
    } 
 ?>
