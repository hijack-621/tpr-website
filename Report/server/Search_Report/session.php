<?php
session_start();
$flag=$_POST['flag'];
require_once '../../../class.php/DAOMySQLi.class.php';
$linkinfo = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'QSCqZuGCU9Z',
    'dbname' => 'compaluser',
    'port' => 3306,
];
$nowdata = date('Y-m-d');
switch ($flag){
    case 1:
        if (empty($_SESSION["uname"])){
            echo "0";
        }else {
            echo "1";
        }
        break;
    case 2:{
        $mysqli = DAOMySQLi::getSingleton($linkinfo);
        $sql = "select Id from weekdate where date='$nowdata' " ;
        $res = $mysqli->fetchAll($sql);
        $gid = $res[0]['Id']-7;

        if($gid){
            $sqlg = "select FY,DellWeek from weekdate where Id='$gid' ";
            $resg = $mysqli->fetchAll($sqlg);

        }
       echo json_encode($resg);
       break;
    }
}
