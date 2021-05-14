<?php
$un=$_POST['uname'];
$pw=$_POST['pword'];
$em=$_POST['email'];
$connID="";
include 'link_db.php';
$result=mysqli_query($connID,"insert into register (username,password,email) values ('$un','$pw','$em')");//insert
echo $result;
include 'close_db.php';
?>