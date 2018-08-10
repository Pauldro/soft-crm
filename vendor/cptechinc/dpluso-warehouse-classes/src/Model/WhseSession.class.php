<?php
    /**
     * Class to Interact with the Whse Session Record for one session
     */
    class WhseSession {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
        /**
         * Session Identifier
         * @var string
         */
        protected $sessionid;
        
        /**
         * Date of Last Update
         * @var int
         */
        protected $date;
        
        /**
         * Time Session Record Update
         * @var int
         */
        protected $time;
        
        /**
         * User Login ID
         * @var string
         */
        protected $loginid;
        
        /**
         * Warehouse ID
         * @var string
         */
        protected $whseid;
        
        /**
         * Order Number
         * @var string
         */
        protected $ordernbr;
        
        /**
         * Bin Location
         * @var string
         */
        protected $binnbr;
        
        /**
         * Pallet Number
         * @var string
         */
        protected $palletnbr;
        
        /**
         * Carton Number
         * @var string
         */
        protected $cartonnbr;
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'sessionID' => 'sessionid',
            'loginID' => 'loginid',
            'whseID' => 'whseid',
            'ordn' => 'ordernbr',
            'bin' => 'binnbr',
            'pallet' => 'palletnbr',
            'carton' => 'cartonnbr'
        );
        
        /* =============================================================
			CLASS FUNCTIONS
		============================================================ */
        /**
         * Returns if the Whse Session has a bin defined
         * @return bool Is the bin defined?
         */
        public function has_bin() {
            return !empty($this->binnbr);
        }
        
        /* =============================================================
			CRUD FUNCTIONS
		============================================================ */
        /**
         * Loads a WhseSession record and loads the data into an Instance of this class
         * @param  string      $sessionID Session Identifier
         * @param  bool        $debug     Run in debug? If so, return SQL Query
         * @return WhseSession            Loaded from database
         */
        public static function load($sessionID, $debug = false) {
            return get_whsesession($sessionID, $debug);
        }
        
        /**
         * Returns if Whse Session Record exists for Session
         * @param  string $sessionID Session Identifier
         * @param  bool   $debug     Run in debug? If so, return SQL Query
         * @return bool              Does Whse Session Record exist?
         */
        public static function does_sessionexist($sessionID, $debug = false) {
            return does_whsesessionexist($sessionID, $debug);
        }
        
        public static function start_session($sessionID, Purl\Url $pageurl, $debug = false) {
            $url = new Purl\Url($pageurl->getUrl());
            $url->path = DplusWire::wire('config')->pages->salesorderpicking."redir/";
            $url->query->set('action', 'initiate-pick')->set('sessionID', $sessionID);
            curl_redir($url->getUrl());
        }
    }
