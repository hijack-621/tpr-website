<?php
$now_date = date("Y-m-d H:i:s ");
if(1){
    $weekarray = array('日','一','二','三','四','五','六');
    $week = $weekarray[date('w',strtotime($now_date))];
    echo $week;
    echo $now_date;
    if($week == '二'){
        echo  1;
    }
}
function qgmdate($dateformat, $timestamp , $timeoffset ,$dtpr,$dtime) {
   /* if(empty($timestamp)) {
        $timestamp = time();
    }*/
    if(empty($timestamp)&&$dtpr != 'IGS') {
        $timestamp = time();
    }else if(empty($timestamp)&&$dtpr = 'IGS'){
        $timestamp = strtotime($dtime);
    }
    $result = gmdate($dateformat, $timestamp + $timeoffset * 3600);
    return $result;
}
   echo qgmdate('Y-m-d H:i:s', '', -5,'IGS',$now_date).'<br/>';
   echo  time();
   echo  strtotime(date("Y-m-d H:i:s "));