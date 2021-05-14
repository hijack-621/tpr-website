<?php
require_once '../class.php/DAOMySQLi.class.php';
$linkinfo = [

        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'dbname' => 'compaluser',
        'port' => 3306,

];
$mid = $_POST['rsid'];
$username = $_POST['user'];
$mysqli = DAOMySQLi::getSingleton($linkinfo);
$sql = "select mid from user where username='$username' and mid = '$mid'";
//die($sql);
$res = $mysqli->fetchAll($sql);
echo json_encode($res);