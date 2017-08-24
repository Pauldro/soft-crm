<?php


function renderNavTree($items, $maxDepth = 3) {

	// if we've been given just one item, convert it to an array of items
	if($items instanceof Page) $items = array($items);

	// if there aren't any items to output, exit now
	if(!count($items)) return;

	// $out is where we store the markup we are creating in this function
	// start our <ul> markup
	echo "<div class='list-group'>";

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class to it


		// markup for the link
		if($item->id == wire('page')->id) {
			echo "<a href='$item->url' class='list-group-item bg-primary'>$item->title</a>";
		} else {
			echo "<a href='$item->url' class='list-group-item'>$item->title</a>";
		}


		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children
		if($item->hasChildren() && $maxDepth) {
			renderNavTree($item->children, $maxDepth-1);
		}

		// close the list item
		//echo "</li>";
	}

	// end our <ul> markup
	echo "</div>";
}


/* =============================================================
   URL FUNCTIONS
 ============================================================ */

function paginate($url, $page, $insertafter, $hash) {
	if (strpos($url, 'page') !== false) {
		$regex = "((page)\d{1,3})";
		if ($page > 1) { $replace = "page".$page; } else {$replace = ""; }
		$newurl = preg_replace($regex, $replace, $url);
	} else {
		$insertafter = str_replace('/', '', $insertafter)."/";
		$regex = "(($insertafter))";
		if ($page > 1) { $replace = $insertafter."page".$page."/";} else {$replace = $insertafter; }
		$newurl = preg_replace($regex, $replace, $url);
	}

	return $newurl . $hash;
 }

function querystring_replace($querystring, $replacing, $values) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
	$querystring = str_replace("?", "&", $querystring);
	for ($i = 0; $i < sizeof($replacing); $i++) {
		$regex = getregex($replacing[$i]);
		if (preg_match($regex, $querystring)) {
			$replace = querystringreplacevalue($replacing[$i], $values[$i]);
			$querystring = preg_replace($regex, $replace, $querystring);
		} else { // IF DOESN'T MATCH ADD IT TO STRING MANUALLY
			if ($values[$i]) { //IF VALUE NOT FALSE
				$querystring = $querystring . "&".$replacing[$i]."=".$values[$i]; //MAKE IT AMPERSAND, AT THE END THE FIRST QUERY DELIMITER WILL BE REPLACED WITH ?
			} else {
				//$querystring = $querystring;
			}
		}
	}

	if (strlen(ltrim($querystring, "&")) > 0) {
		$querystring = 	"?".ltrim($querystring, "&");
	} else {
		$querystring = ltrim($querystring, "&");
	}

	return $querystring;

}

function buildlink($url, $replacing, $values, $hash) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
	if (strpos($url, '?') !== false) {
		$url_arr = explode("?", $url);
		$querystring = $url_arr[1];
		return $url_arr[0] . querystring_replace($querystring, $replacing, $values) . $hash;
	} else {
	   return $url;
	}
}


	function getregex($replacing) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
		 $regex = '';
		 switch ($replacing) {
			case 'orderby':
				$regex = "/[\?\&]\borderby+=\w+-(DESC|ASC)\b/";
				break;
			default:
				$regex = "/[\?\&]($replacing=\w+)/";
                $regex = "/[\?&]$replacing*?=[^&?]*/";
				break;
		 }
		 return $regex;
	 }

	 function querystringreplacevalue($replacing, $value) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
		 if ($value == 'remove-me' || (!$value)) {
			 return '';
		 } else {
			 return "&".$replacing."=".$value;
		 }
	 }

	function buildajaxpath($baseurl, $destinationsegments, $pagesegments) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
		if (strpos($pagesegments, $destinationsegments) !== false) { // IF PAGE SEGMENTS IS IN SEGMENTS
			$pagesegments = str_replace($destinationsegments, '', $pagesegments); //GET RID OF SAME SEGMENTS FROM PAGE SEGMENTS
		}
		return rtrim($baseurl . $destinationsegments . $pagesegments, "/") ."/"; //CONCATENATE ALL SEGMENTS
	}

	function buildpath($url, $replacing, $replacements) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
		for ($i = 0; $i < sizeof($replacements); $i++) {
			$regex = "/$replacing[$i]\//";
			if (preg_match($regex, $url)) {
				$replace = getpathreplacevalue($replacements[$i]);
				$url = preg_replace($regex, $replace, $url);
			} else {
				$url .= "$replacements[$i]/";
			}
		}
		return $url;
	}

	function getpathreplacevalue($replacement) { // DEPRECATED 8/8/2017 DELETE BY 9/1/2017
		if ($replacement== 'remove-me' || (!$replacement)) {
			return '';
		} else {
			return $replacement . "/";
		}
	}



/* =============================================================
   ORDERS FUNCTIONS
 ============================================================ */

function get_symbols($orderby, $match, $page_orderby) {
	$symbol = "";
	if ($orderby == $match) {
		if ($page_orderby == "ASC") {
			$symbol = "&#x25B2;";
			$symbol = "<span class='glyphicon glyphicon-arrow-up'></span>";
		} else {
			$symbol = "&#x25BC;";
			$symbol = "<span class='glyphicon glyphicon-arrow-down'></span>";
		}
	}
	return $symbol;
}

function get_sorting_rule($orderingby, $sort, $orderby) {
	if ($orderingby != $orderby || $sort == false) {
		$sortrule = "ASC";
	} else {
		switch ($sort) {
			case 'ASC':
				$sortrule = 'DESC';
				break;
			case 'DESC':
				$sortrule = 'ASC';
				break;
		}
	}
	return $sortrule;
}

function formatmoney($amt) {
	return number_format($amt, 2, '.', ',');
}

function formatnumber($number, $beforedecimal, $afterdecimal) {
	$array = explode('.', $number);
	return str_pad($array[0], $beforedecimal, '0', STR_PAD_LEFT) . '.' . str_pad($array[1], $afterdecimal, '0', STR_PAD_RIGHT);
}

function returntracklink($carrier, $tracknbr, $on) {
	$link = '';
	if (strpos(strtolower($carrier), 'fed') !== false) {
		$link = "https://www.fedex.com/fedextrack/WTRK/index.html?action=track&trackingnumber=".$tracknbr."&cntry_code=us&fdx=1490";
	} else if (strpos(strtolower($carrier), 'ups') !== false) {
		$link = "http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=".$tracknbr."&loc=en_us";
	} else if (strpos(strtolower($carrier), 'gro') !== false) {
		$link = "http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=".$tracknbr."&loc=en_us";
	} else if ((strpos(strtolower($carrier), 'will') !== false)) {
		$link = "#$on";
	} else {
		$link = "#$on";
	}
	return $link;
}

function doesitcontain($container, $needle) {
	if (is_array($container)) {
		if (in_array($needle, $container) !== false) {
			return true;
		} else {
			return false;
		}
	} else {
		if (strpos($needle, $container) !== false) {
			return true;
		} else {
			return false;
		}
	}
}


function show_requirements($field) {
	if (doesitcontain(wire('config')->required_billing_fields, $field)) {
		echo 'required';
	}
}

/* =============================================================
   DISPLAY FUNCTIONS
 ============================================================ */
	function highlight($haystack, $needle, $element) { //\b(\w*".$needle."\w*)\b
		$regex = "/(".$needle.")/i";
		$contains = preg_match($regex, $haystack, $matches);
		if ($contains) {
			$replace =  str_replace('{ele}', $matches[0], $element);
			return preg_replace($regex, $replace, $haystack);
		} else {
			return $haystack;
		}
	}

/* =============================================================
   MISC FUNCTIONS
 ============================================================ */

 function latin_to_utf($string) {
	$encode = array("â€¢" => '&bull;', "â„¢" => '&trade;', "â€" => '&prime;');
	foreach ($encode as $key => $value) {
		if (strpos($string, $key) !== false) {
			$string = str_replace($key, $value, $string);
		}
	}
	return $string;
 }

 function returnsqlquery($sql, $oldtonew, $havequotes) {
	$i = 0;
	foreach ($oldtonew as $old => $new) {
		if ($havequotes[$i]) {
			$sql = str_replace($old, "'".$new."'", $sql);
		} else {
			$sql = str_replace($old, $new, $sql);
		}
		$i++;
	}
	return $sql;
}
 /* =============================================================
   DB FUNCTIONS
 ============================================================ */
	function returnlimitstatement($limit, $page) {
		if ($limit) {
			if ($page > 1 ) {$start_point = ($page * $limit) - $limit; } else { $start_point = 0; }
			return "LIMIT ".$start_point.",".$limit;
		} else {
			return "";
		}
	}
	/**
	 * [returnpreppedquery description]
	 * @param  [array] $originalarray [Key-Valued array with original record column values]
	 * @param  [type] $changedarray  [Key-Valued array with changed record column values]
	 * @return [array]                [Array that has the Set statement with prepped values, columns changed, how many need quotes, AND
	 * 								   The count of how many values changed between the original and changed.]
	 */
	function returnpreppedquery($originalarray, $changedarray) {
		$withquotes = $switching = array();
		$setstmt = '';
		$columns = array_keys($originalarray);
		foreach ($columns as $column) {
			if (strlen($changedarray[$column])) {
				if ($originalarray[$column] != $changedarray[$column]) {
					$prepped = ':'.$column;
					$setstmt .= $column." = ".$prepped.", ";
					$switching[$prepped] = $changedarray[$column];
					$withquotes[] = true;
				}
			}
		}
		$setstmt = rtrim($setstmt, ', ');
		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'setstatement' => $setstmt,
			'changecount' => sizeof($switching)
		);
	}

	function returnwherelinks($linkarray) {
		$withquotes = $switching = array();
		$wherestmt = '';
		$columns = array_keys($linkarray);
		foreach ($linkarray as $key => $val) {
			if (strlen($val)) {
				$prepped = ':'.$key;
				$wherestmt .= $key." = ".$prepped." AND ";
				$switching[$prepped] = $val;
				$withquotes[] = true;
			}
		}
		$wherestmt = rtrim($wherestmt, ' AND ');
		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'wherestatement' => $wherestmt,
			'changecount' => sizeof($switching)
		);
	}

	function returninsertlinks($linkarray) {
		$withquotes = $switching = array();
		$columnlist = $valueslist = '';
		$columns = array_keys($linkarray);
		foreach ($linkarray as $key => $val) {
			if (strlen($val)) {
				$prepped = ':'.$key;
				$columnlist .= $key.", ";
				$valueslist .= $prepped.", ";
				$switching[$prepped] = $val;
				$withquotes[] = true;
			}
		}
		$columnlist = rtrim($columnlist, ', ');
		$valueslist = rtrim($valueslist, ', ');

		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'valuelist' => $valueslist,
			'columnlist' => $columnlist,
			'changecount' => sizeof($switching)
		);
	}

	function returncustindextable($distincton) {
		if ($distincton) {
			if ($distincton == 'shipto') {
				$table = 'view_distinct_cust_records';
			} elseif ($distincton == 'custshipto') {
				$table = 'view_distinct_cust_shiptos';
			} else {
				$table = 'view_distinct_customers';
			}
		} else {
			$table = 'custindex';
		}
		return $table;
	}

	function returntaskstable($status) {
		switch ($status) {
			case 'Y':
				$table = 'view_completed_tasks';
				break;
			case 'N':
				$table = 'view_incomplete_tasks';
				break;
			case 'R':
				$table = 'view_rescheduled_tasks';
				break;
			default:
				$table = 'view_incomplete_tasks';
				break;
		}
		return $table;
	}

 /* =============================================================
   DATE FUNCTIONS
 ============================================================ */



	function get_time($timeString) {
		$partofDay = ""; $colon = ":";
		$timeAsString = substr($timeString, 0, 2) . $colon . substr($timeString, 2, 2);
		$time = explode($colon, $timeAsString, 2);
		$hour = $time[0];

		$hr = (int)$hour;

		if ($hr == 00) {
			$hr = 12;
			$partofDay = "AM";
		} else if ($hr > 12) {
			$hr = $hr - 12;
			$partofDay = "PM";
		} else {
			$partofDay = "AM";
		}

		$time = strval($hr) . $colon . $time[1].' '.$partofDay;
		return $time;
	}

	function dplusdate($date) { // DEPRECATED 8/23/2017 DELETE IN A MONTH
		if (date('m/d/Y', strtotime($date)) == "12/31/1969") {
			return '';
		} else {
			return date('m/d/Y', strtotime($date));
		}
	}


/* =============================================================
  TASK FUNCTIONS
============================================================ */


	function ordinal($number) {
	    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
	    if ((($number % 100) >= 11) && (($number%100) <= 13))
	        return $number. 'th';
	    else
	        return $number. $ends[$number % 10];
	}

	function ordinalword($number) {
		switch ($number) {
			case '1':
				return 'first';
				break;
			case '2':
				return 'second';
				break;
			case '3':
				return 'third';
				break;
			case '4':
				return 'fourth';
				break;
		}
	}

	function createmessage($message, $custID, $shipID, $contactID, $taskID, $noteID, $ordn, $qnbr) {
		$regex = '/({replace})/i';
		$replace = "";

		if ($custID != '') {
			$replace = get_customer_name($custID)." ($custID)";
		}

		if ($shipID != '') {
			$replace .= " Shipto: " . get_shipto_name($custID, $shipID, false)." ($shipID)";
		}

		if ($contactID != '') {
			$replace .= " Contact: " . $contactID;
		}

		if ($ordn != '') {
			$replace .= " Sales Order #" . $ordn;
		} elseif ($qnbr != '') {
			$replace .= " Quote #" . $qnbr;
		}

		if ($taskID != '') {
			$replace .= " Task #" . $taskID;
		} elseif ($noteID != '') {
			$replace .= " CRM Note #" . $noteID;
		}

		return preg_replace($regex, $replace, $message);
	}

	function curl_redir($url) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_FOLLOWLOCATION => true
		));
		sleep(2);
		return curl_exec($curl);
	}

	function writedplusfile($data, $filename) {
		$file = '';
		foreach ($data as $key => $value) {
			if (is_string($key)) {
				if (is_string($value)) {
					$file .= $key . "=" . $value . "\n";
				} else {
					$file .= $key . "\n";
				}
			} else {
				$file .= $value . "\n";
			}

		}
		$vard = "/usr/capsys/ecomm/" . $filename;
		$handle = fopen($vard, "w") or die("cant open file");
		fwrite($handle, $file);
		fclose($handle);
	}

	function writedataformultitems($data, $items, $qtys) {
		for ($i = 0; $i < sizeof($items); $i++) {
			$itemID = str_pad(wire('sanitizer')->text($items[$i]), 30, ' ');
			$qty = wire('sanitizer')->text($qtys[$i]);
			if (empty($qty)) {$qty = "1"; }
			$data[] = "ITEMID=".$itemID."QTY=".$qty;
		}
		return $data;
	}

	/**
	 * [convertfiletojson description]
	 * @param  [string] $file [String that contains file location]
	 * @return [string]       [Returns json-encode string]
	 */
	function convertfiletojson($file) {
		$json = file_get_contents($file);
		$json = preg_replace('~[\r\n]+~', '', $json);
		$json = utf8_clean($json);
		return $json;
	}

	function cleanforjs($str) {
		return urlencode(str_replace(' ', '-', str_replace('#', '', $str)));
	}

 /* =============================================================
   PROCESSWIRE USER FUNCTIONS
 ============================================================ */
	function setupuser($sessionid) {
		$loginrecord = get_login_record($sessionid);
		wire('user')->fullname = $loginrecord['loginname'];
		wire('user')->loginid = $loginrecord['loginid'];
		wire('user')->hascontactrestrictions = $loginrecord['restrictedaccess'];
		wire('user')->hasorderlocked = hasanorderlocked(session_id());
		if (wire('user')->hasorderlocked) {
			wire('user')->lockedordn = getlockedordn(session_id());
		}
		wire('user')->hasquotelocked = hasaquotelocked(session_id());
		if (wire('user')->hasquotelocked) {
			$user->lockedquote = getlockedquotenbr(session_id());
		}
	}

	function createshopasform($custID, $shipID) {
		$form = '<form action="'.wire(config)->pages->customer.'redir/" method="post">';
		$form .= '<input type="hidden" name="action" value="shop-as-customer">';
		$form .= '<input type="hidden" name="page" value="'.wire(config)->filename.'">';
		$form .= '<input type="hidden" name="custID" value="'.$custID.'">';
		if ($shipID) {
			$form .= '<input type="hidden" name="shipID" value="'.$shipID.'">';
			$form .= '<button type="submit" class="btn btn-sm btn-primary">Shop as '.get_customer_name($custID).' - '. $shipID.'</button>';
		} else {
			$form .= '<button type="submit" class="btn btn-sm btn-primary">Shop as '.get_customer_name($custID).'</button>';
		}
		$form .= '</form>';
		return $form;
	}

	function strToHex($string){
		$hex = '';
		for ($i=0; $i<strlen($string); $i++){
			$ord = ord($string[$i]);
			$hexCode = dechex($ord);
			$hex .= substr('0'.$hexCode, -2);
		}
		return strToUpper($hex);
	}

	function hexToStr($hex){
		$string='';
		for ($i=0; $i < strlen($hex)-1; $i+=2){
			$string .= chr(hexdec($hex[$i].$hex[$i+1]));
		}
		return $string;
	}


	function createalert($alerttype, $msg) {
		return '<div class="alert alert-'.$alerttype.'" role="alert">' . $msg . '</div>';
	}

	function makeprintlink($link, $msg) {
		return '<a href="'.$link.'" class="h4" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> '.$msg.'.</a>';
	}

?>
