<?php
$host="127.0.0.1";
$user="temp_write";
$word="Hijack";
$dbname="temp_monitor_fcg";
$connID=mysqli_connect($host,$user,$word);
mysqli_select_db($connID, $dbname);
?>