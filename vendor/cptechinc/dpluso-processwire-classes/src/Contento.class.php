<?php 
    class Contento {
        public function open($element, $attributes) {
            $attr = $this->attributes($attributes);
            return "<$element $this->values($attributes)>";
        }
        
        public function close($element) {
            return "</$element>";
        }
        
        public function openandclose($element, $attributes, $content) {
            return $this->open($element, $attributes) . $content . $this->close($element);
        }
        
        
        
        /**
    	 * Takes a string of attributes and parses it out by a delimiter (|)
    	 * @param  [type] $vars string of attributes separated by | 
    	 * @return [type]       string of atrributes and values like class=""
    	 */
    	private function attributes($vars) {
    		$put = array();
    		if (!empty($vars)) {
    			$values = explode('|', $vars);
    			foreach ($values as $value) {
    				$pieces = explode('=', $value);
    				$put[array_shift($pieces)] = implode('=', $pieces);
    			}
    		}
    		$attributes = '';
    		if (!empty($put)) {
    			foreach ($put as $key => $value) {
    				$attributes .= ' ' . $key . '="' . $value . '"';
    			}
    		}
    		return $attributes;
    	}
    	
    	/** 
    	 * Makes a new line and adds four spaces to format a string in html
    	 * @return string new line and four spaces
    	 */
    	private function indent() {
    		$indent = "\n";
    		for ($i = 0; $i < self::$count; $i++) {
    			$indent .= '  ';
    		}
    		return $indent;
    	}
    }
?>
