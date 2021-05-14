<?php
/**
 * Created by PhpStorm.
 * User: Iori
 * Date: 2020/5/4
 * Time: 16:05
 */

function getBGtime(){
    date_default_timezone_set('PRC');
    $date = date('Y-m-d H:i:s');

    return $date;

}
function ispolandDst()

{
    $timezone = date('e');
//获取当前使用的时区

 //$timezone = date('I');
  //$timezone.'a';

//强制设置时区US/Pacific-New
   // $dst = date('I');
 date_default_timezone_set('Europe/Warsaw');

//判断是否夏令时
$dst = date('I');

    date_default_timezone_set($timezone);
 //还原时区

//($timezone);

return $dst ;

}
function isusaDst(){
    $timezone = date('e');
    date_default_timezone_set('America/New_York');
    $dst = date('I');

    date_default_timezone_set($timezone);
    return $dst;
}
function isindiaDst(){
    $timezone = date('e');
    date_default_timezone_set('	Indian/Cocos');
    $dst = date('I');

    date_default_timezone_set($timezone);
    return $dst;
}
function isMEXDst(){
    $timezone = date('e');
    date_default_timezone_set('America/Mexico_City');
    $dst = date('I');

    date_default_timezone_set($timezone);
    return $dst;
}

//ispolandDst();

