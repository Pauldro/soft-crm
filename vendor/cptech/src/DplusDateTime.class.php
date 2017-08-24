<?php
    class DplusDateTime {
        private $defaultdate = 'm-d-Y';
        private $defaulttime = 'h:i A';

        function formatdplustime($time, $formatstring = null) {
            $formatstring ? $formatstring = $formatstring : $formatstring = $this->defaulttime;
            $formatted = DateTime::createFromFormat('YmdHisu', $time);
            return $formatted->format($formatstring);
        }

        function formatdate($date, $formatstring = null) {
            $formatstring ? $formatstring = $formatstring : $formatstring = $this->defaultdate;
            if (date($formatstring, strtotime($date)) == "12/31/1969") {
    			return '';
    		} else {
    			return date($formatstring, strtotime($date));
    		}
        }
    }
 ?>
