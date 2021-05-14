<?php
$host="127.0.0.1";
$user="root";
$word="Hijack";
$dbname="compaluser";
$connID=mysqli_connect($host,$user,$word);
mysqli_select_db($connID, $dbname);
?>