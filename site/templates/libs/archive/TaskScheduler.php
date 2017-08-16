<?php
    class TaskScheduler {
        public $today;

		public $activetasks = "'Y','N'";
        public function __construct() {
          	$this->today = new DateTime('today');
        }

		public function getnextscheduledtaskdate($scheduledtask) {
			$nextdate = '';
			$this->today = new DateTime('today');
			$interval = $scheduledtask['interval'];
			$today = $this->today;
			$closestdate = '2044-12-06';
			switch ($scheduledtask['repeats']) {
				case 'day':
					if (intval($interval) > 1) {
						$today = $this->today;
						
						while (subtract_days($today->format('Y-m-d'), date('Y-m-d', strtotime($scheduledtask['startdate']))) % intval($interval) !== 0) {
							$today->modify('+1 day');
						}
						$nextdate = $today->format('Y-m-d');
					} else {
						$nextdate = $this->today->format('Y-m-d');
					}
					break;
				case 'monthday':
					$monthdiff = get_month_difference($scheduledtask['startdate'], $today->format('Y-m-d'), false);
					if (strpos($scheduledtask['fallson'],',') !== false) {
						$fallsonarray = explode(',', $scheduledtask['fallson']);
						foreach ($fallsonarray as $fallson) {
							$nextfallson = date('Y-m-d', strtotime(date('Y-m', strtotime($scheduledtask['startdate'])).'-'.$fallson));
							if (strtotime($nextfallson) < strtotime($scheduledtask['startdate'])) {
								$nextfallson = add_month_to_date($nextfallson, 1, false);
							}
							$closestfallson = add_month_to_date(date('Y-m-d', strtotime($nextfallson)), $monthdiff, false);
							if (strtotime("now") > strtotime($closestfallson)) {
								$closestfallson = add_month_to_date($closestfallson, 1, false);
							}
							if (strtotime($closestfallson) > strtotime("now")) {
								if (intval(str_replace('-', '', $closestfallson)) < intval(str_replace('-', '', $closestdate))) {
									$closestdate = $closestfallson;
								}
							}
						}
						$nextdate = $closestdate;
					} else {
						$nextfallson = date('Y-m-d', strtotime(date('Y-m', strtotime($scheduledtask['startdate'])).'-'.$scheduledtask['fallson']));
						if (strtotime($nextfallson) < strtotime($scheduledtask['startdate'])) {
							$nextfallson = add_month_to_date($nextfallson, 1, false);
						}
						$closestfallson = add_month_to_date(date('Y-m-d', strtotime($nextfallson)), $monthdiff, false);
						if (strtotime("now") > strtotime($closestfallson)) {
							$closestfallson = add_month_to_date($closestfallson, 1, false);
						}
						$nextdate = $closestfallson;
					}
					break;
				case 'monthweek':
					$startmonth = date('m', strtotime($scheduledtask['startdate'])); $startyear = date('Y', strtotime($scheduledtask['startdate']));
					$intervaldesc = ordinalword($interval);
					if (strpos($scheduledtask['fallson'],',') !== false) {
						$nextdate = 'not complete';
						if (strpos($scheduledtask['fallson'],',') !== false) {
							$monthdays = explode(',', $scheduledtask['fallson']);
							foreach ($monthdays as $day) {
								if ($interval > 1) {
									$firstmatching = date('Y-m-d', strtotime("{$intervaldesc} {$day}", mktime(0,0,0,$startmonth,1,$startyear) ) );
									$closestfallson = date('Y-m-d', strtotime("{$intervaldesc} {$day}", mktime(0,0,0,date('m'),1,date('Y')) ) );
									$monthdiff = get_month_difference($firstmatching, $closestfallson, false);
									if (strtotime($closestfallson) < strtotime("now")) {
										$closestfallson = add_month_to_date($closestfallson, 1, false);
										if (intval(str_replace('-', '',$closestfallson)) < intval(str_replace('-', '',$closestdate))) {
											$closestdate = $closestfallson;
										}
									}
								} else {
									$closestfallson = date('Y-m-d',strtotime("next ".$day));
									if (intval(str_replace('-', '',$closestfallson)) < intval(str_replace('-', '',$closestdate)))  {
										$closestdate = $closestfallson;
									}
								}
								
							}
							$nextdate = $closestdate;
						}
					} else {
						$day = $scheduledtask['fallson'];
						if ($interval > 1) {
							$firstmatching = date('Y-m-d', strtotime("{$intervaldesc} {$day}", mktime(0,0,0,$startmonth,1,$startyear) ) );
							$closestfallson = date('Y-m-d', strtotime("{$intervaldesc} {$day}", mktime(0,0,0,date('m'),1,date('Y')) ) );
							$monthdiff = get_month_difference($firstmatching, $closestfallson, false);
							if (strtotime($closestfallson) < strtotime("now")) {
								$closestfallson = add_month_to_date($closestfallson, 1, false);
							}
						} else {
							$closestfallson = date('Y-m-d',strtotime("next ".$day));
							if (strtotime($closestfallson) < strtotime($closestdate)) {
								$closestdate = $closestfallson;
							}
						}
						
						
						$nextdate = $closestfallson;
					}
					break;
				default:
					$nextdate = 'not complete';
					break;
			}
			return $nextdate;
		}
		
		public function writetaskfrequencydescription($repeats, $repeatsevery, $fallson) {
			$description = '';
			switch ($repeats) {
				case 'day':
					if ($repeatsevery == 1) { $description = 'Daily'; } elseif( $repeatsevery > 1) {$description = "Every " . $repeatsevery . " days";}
					break;
				case 'monthweek':
					if ($repeatsevery == 1) { $description = 'Every week'; } elseif( $repeatsevery > 1) {$description = "Every " . ordinal($repeatsevery) . " week of the month";}
					$description .= " on " . $fallson;
					break;
				case 'monthday':
					if ($repeatsevery == 1) { $description = 'Monthly'; } elseif( $repeatsevery > 1) {$description = "Every " . $repeatsevery . " months";}
					if (strpos($fallson,',') !== false) {
						$fallsonarray = explode(',', $fallson); $fallsondesc = '';
						foreach ($fallsonarray as $fallingon) {
							$fallsondesc .= ordinal($fallingon).", ";
						}
						$description .= " on the " . rtrim($fallsondesc, ', ') ;
					} else {
						$description .= " on the ".ordinal($fallson);
					}

					break;
			}
			return $description;
		}

	}


 ?>
