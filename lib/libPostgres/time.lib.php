<?php
class time
{
	function howlong($time)
	{
		$difference_s = time() - $time;
		$difference_m = intval($difference_s / 60);
		$difference_h = intval($difference_m / 60);
		$difference_d = intval($difference_h / 24);
		$difference_w = intval($difference_d / 7);
		$difference_o = intval($difference_d / 30);
		$difference_y = intval($difference_d / 365);
		if ($difference_s < 60)
			return $difference_s == 1 ? "$difference_s second" : "$difference_s seconds";
		elseif($difference_m < 60)
			return $difference_m == 1 ? "$difference_m minute" : "$difference_m minutes";
		elseif($difference_h < 24)
			return $difference_h == 1 ? "$difference_h hour" : "$difference_h hours";
		elseif($difference_w < 5)
			return $difference_w == 1 ? "$difference_w week" : "$difference_w weeks";
		elseif($difference_o < 12)
			return $difference_o == 1 ? "$difference_o month" : "$difference_o months";
		else
			return $difference_y == 1 ? "$difference_y year" : "$difference_y years";
	}
	
	function convert_datetime($str)
	{
		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		return $timestamp;
	}
	
	function returnDifference($time1,$time2)
	{
		if ($time2 < $time1)
			$dif = $time1 - $time2;
		else
			$dif = $time2 - $time1;
		$hours = intval($dif / (60*60));
		$minutes = intval(($dif / (60)) - ($hours * 60));
		$seconds = intval($dif - ($hours * (60 *60) + $minutes * 60));
		return "".($hours == 0 ? "" : $hours . ":" ).$minutes.":".$seconds;
	}
	
}
?>