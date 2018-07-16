<?php
    /**
     * Class for dealing with Items that are Barcoded
     */
    class BarcodedItem {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
        /**
         * Decoded Barcode
         * @var string
         */
        protected $barcode;
        
        /**
         * Item's Item ID / Number
         * @var string
         */
        protected $itemid;
        
        /**
         * Is this Item the Primary item?
         * Y | N
         * @var string
         */
        protected $primary;
        
        /**
         * Unit of Measure Code
         * @var string
         */
        protected $uom;
        
        /**
         * Qty Per Unit
         * @var int
         */
        protected $unitqty;
        
        /**
         * Returns if Item is the Primary / Base Item
         * @return bool
         */
        public function is_primary() {
            return $this->primary == 'Y' ? true : false;
        }
        
        public function load_barcode()
        
    }
