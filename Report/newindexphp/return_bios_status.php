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
    $sql = 'select * from bios_system where Status=0 or status=3';
    //die($sql);
    $res = $mysqli->fetchAll($sql);
    //var_dump($res);
    echo json_encode($res);
}