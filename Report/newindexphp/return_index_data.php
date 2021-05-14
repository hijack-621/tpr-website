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

//echo $tpr;
if(isset($flag)){

        $mysqli = DAOMySQLi::getSingleton($linkinfo);
        //die($sql);
        $sql = 'select * from facaecobios';
        $res = $mysqli->fetchAll($sql);
        echo json_encode($res);

   /* case 'judgedelay';
        $mysqli = DAOMySQLi::getSingleton($linkinfo);
        $sql = 'select * from bios_system';
        $res = $mysqli->fetchAll($sql);*/

}






