<?php
//  $un=$_POST['uname'];
//  $pw=$_POST['pword'];
//  $em=$_POST['email'];
//  $uf=$_POST['uflag'];
//  $tp=$_POST['tpr'];

$un="compalsod";
$pw="compalsod";
$em="123456789@qq.com";
$uf="1";
$tp="ALL";

$connID="";

include 'link_db.php';
$result=mysqli_query($connID,"insert into user (username,password,email,level,usertpr) values ('$un','$pw','$em','$uf','$tp')");//insert

echo $result;
include 'close_db.php';
?>