<?php
require_once '../../class.php/DAOMySQLi.class.php';
$linkinfo = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'dbname' => 'compaluser',
    'port' => 3306,
];
$flag = $_POST['flag'];
if(isset($flag)){
    $mysqli = DAOMySQLi::getSingleton($linkinfo);
    $sql = 'select * from eco_system where Status=0';
    $res = $mysqli->fetchAll($sql);
    echo json_encode($res);
}