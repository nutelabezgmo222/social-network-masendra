<?php

function debug($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}

function dateHandler($str){
	$newStr = '';
	$currentDay = date('d');
	$currentMonth = date('m');
	$month = ['Cічня','Лютого','Березня','Квітня','Травня','Червня','Липня','Серпня','Вересня','Жовтня','Листопада','Грудня'];
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	$hourMinuteSecond = explode(':', $arr[1]);
	if($yearMonthDay[1] != $currentMonth ) {
		$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
	} else {
		if($currentDay == $yearMonthDay[2]) {
			$newStr = $hourMinuteSecond[0] .':'. $hourMinuteSecond[1];
		}
		elseif(intval($currentDay)-1 == intval($yearMonthDay[2])) {
			$newStr = 'Вчора';
		} else {
			$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
		}
	}
	return $newStr;
}
function onlineWard($str) {
	$newStr = '';
	$currentDay = date('d');
	$currentMonth = date('m');
	$month = ['Cічня','Лютого','Березня','Квітня','Травня','Червня','Липня','Серпня','Вересня','Жовтня','Листопада','Грудня'];
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	$hourMinuteSecond = explode(':', $arr[1]);
	if($yearMonthDay[1] != $currentMonth ) {
		$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
	} else {
		if($currentDay != $yearMonthDay[2]) {
			if(intval($currentDay)-1 == intval($yearMonthDay[2])) {
				$newStr = 'Вчора';
			} else {
				$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
			}
		}
	}
	$newStr .= ' о ' .$hourMinuteSecond[0].':'.$hourMinuteSecond[1];
	return $newStr;
}

function dateWithYear($str) {
	$newStr = '';
	$currentDay = date('d');
	$currentMonth = date('m');
	$month = ['Cічня','Лютого','Березня','Квітня','Травня','Червня','Липня','Серпня','Вересня','Жовтня','Листопада','Грудня'];
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	$hourMinuteSecond = explode(':', $arr[1]);
	if($yearMonthDay[1] != $currentMonth ) {
		$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
	} else {
		if($currentDay == $yearMonthDay[2]) {
			$newStr = $hourMinuteSecond[0] .':'. $hourMinuteSecond[1];
		}
		elseif(intval($currentDay)-1 == intval($yearMonthDay[2])) {
			$newStr = 'Вчора';
		} else {
			$newStr = intval($yearMonthDay[2]) .' '. $month[intval($yearMonthDay[1]) - 1];
		}
	}
	return $newStr . ' '. $yearMonthDay[0] . ' року';
}

function makeDate($day, $month, $year) {
	 if(intval($day) < 10) {
		 $day = '0'.$day;
	 }
	 if(intval($month) < 10) {
		 $month = '0'.$month;
	 }
	 return $year . '-' . $month . '-' . $day;
}
function getDay($str) {
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	return $yearMonthDay[2];
}
function getMonth($str) {
	$month = ['Cічня','Лютого','Березня','Квітня','Травня','Червня','Липня','Серпня','Вересня','Жовтня','Листопада','Грудня'];
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	return $month[$yearMonthDay[1] - 1] ;
}
function getYear($str) {
	$arr = explode(' ', $str);
	$yearMonthDay = explode('-', $arr[0]);
	return $yearMonthDay[0];
}
function getTime($str) {
	$arr = explode(' ', $str);
	$hourMinuteSecond = explode(':', $arr[1]);
	return $hourMinuteSecond[0] . ':' . $hourMinuteSecond[1];
}
