<?php
$host="127.0.0.1";
$user="root";
$word="QSCqZuGCU9Z";
$dbname="matrix";
$connID=mysqli_connect($host,$user,$word);
mysqli_select_db($connID, $dbname);
?>