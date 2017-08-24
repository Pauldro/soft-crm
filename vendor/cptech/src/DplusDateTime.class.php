<?php
    class DplusDateTime {
        static $defaultdate = 'm-d-Y';
        static $defaulttime = 'h:i A';

        public static function formatdplustime($time, $formatstring = null) {
            $formatstring ? $formatstring = $formatstring : $formatstring = self::$defaulttime;
            $formatted = DateTime::createFromFormat('YmdHisu', $time);
            return $formatted->format($formatstring);
        }

        public static function formatdate($date, $formatstring = null) {
            $formatstring ? $formatstring = $formatstring : $formatstring = self::$defaultdate;
            if (date($formatstring, strtotime($date)) == "12/31/1969") {
    			return '';
    		} else {
    			return date($formatstring, strtotime($date));
    		}
        }
    }
 ?>
