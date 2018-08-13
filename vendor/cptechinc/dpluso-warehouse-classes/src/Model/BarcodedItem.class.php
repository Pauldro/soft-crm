<?php 
    class BarcodedItem {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
        /**
         * Barcode Number
         * @var string
         */
        protected $barcodenbr;
        
        /**
         * Item ID
         * @var string
         */
        protected $itemid;
        
        /**
         * Is this the Primary Item
         * @var string Y | N
         */
        protected $primary;
        
        /**
         * Qty For Barcode
         * @var int
         */
        protected $unitqty;
        
        /**
         * Unit of Measurement
         * @var string
         */
        protected $uom;
        
        /**
         * Aliases for Class Properties
         * @var array
         */
        protected $fieldaliases = array(
            'qty' => 'unitqty',
            'itemid' => 'itemnbr',
            'itemiID' => 'itemnbr'
        );
        
        /**
         * Returns if Item is Primary / base Item
         * @return bool Is Item Primary / base Item ?
         */
        public function is_primary() {
            return $this->primary == 'Y' ? true : false;
        }
        
        public function load($barcode, $debug = false) {
            return get_barcodeditem($barcode, $debug);
        }
    }
