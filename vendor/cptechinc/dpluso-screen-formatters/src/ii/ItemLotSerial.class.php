<?php 
     class II_ItemLotSerialScreen extends TableScreenMaker {
		protected $tabletype = 'normal'; // grid or normal
		protected $type = 'ii-lot-serial'; 
		protected $title = 'Item Lot Serial';
		protected $datafilename = 'iilotser'; 
		protected $testprefix = 'iilot';
		protected $datasections = array();
        
        /* =============================================================
          PUBLIC FUNCTIONS
       	============================================================ */
        public function generate_screen() {
            $bootstrap = new Contento();
            $content = '';
            // NEW CODE HERE
            return $content;
        }
        
        public function generate_javascript() {
			$bootstrap = new Contento();
			$content = $bootstrap->open('script', '');
				$content .= "\n";
                // TODO
				$content .= "\n";
			$content .= $bootstrap->close('script');
			return $content;
		}
        

    }
