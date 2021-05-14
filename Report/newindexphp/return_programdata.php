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
$tpr = $_POST['tpr'];
if(isset($flag)){
    $mysqli = DAOMySQLi::getSingleton($linkinfo);
    if($tpr=='CGS'){
        $sql = "select  tpr,count(*) count from npi_primary where  Status=0 group by tpr";
    }else{
        $sql = "select count(*) from npi_primary where tpr='$tpr' and Status=0 ";
    }

    //die($sql);
    $res = $mysqli->fetchAll($sql);
    //var_dump($res);
    echo json_encode($res);
}