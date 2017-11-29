<?php 
    class FormMaker extends Contento {
        use AttributeParser;
        private $formstring = '';
        private static $count = 0;
        private $openform;
        
        function __construct($attr = '', $openform = true) {
            self::$count++;
            $this->formstring = $this->indent() . $openform ? $this->open('form', $attr) : '';
            $this->openform = $openform;
        }
        
        public function input($attr = '') {
            $this->formstring .= $this->indent() . $this->open('input', $attr);
        }
        
        public function select($attr = '', array $keyvalues, $selectvalue = null) {
            $this->formstring .= $this->indent() . $this->open('select', $attr);
            
            foreach ($keyvalues as $key => $value) {
                $optionattr = "value=$key";
                $optionattr .= ($key == $selectvalue) ? "|selected=noparam" : '';
                $this->formstring .= $this->indent() . $this->openandclose('option', $optionattr, $value);
            }
            
            $this->formstring .= $this->close('select');
        }
        
        public function button($attr = '', $content) {
            $this->formstring .= $this->indent() . $this->openandclose('button', $attr, $content);
        }
        
        public function add($str) {
            $this->formstring .= $str;
        }
        
        public function finish() {
            if (self::$count < 0) {
                self::$count--;
                if ($this->openform) {
                    $this->formstring .= $this->close('form');
                }
            }
            return $this->formstring;
        }
        
        public function _toString() {
            return $this->finish();
        }
        
        
        /** 
    	 * Makes a new line and adds four spaces to format a string in html
    	 * @return string new line and four spaces
    	 */
    	protected function indent() {
    		$indent = "\n";
    		for ($i = 0; $i < self::$count; $i++) {
    			$indent .= '  ';
    		}
    		return $indent;
    	}
    }
