<?php
$host="127.0.0.1";
$user="temp_write";
$word="qaz12345";
$dbname="temp_monitor";
$connID=mysqli_connect($host,$user,$word);
mysqli_select_db($connID, $dbname);
?>