<?php
require_once '../../class.php/DAOMySQLi.class.php';
$linkinfo = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'Hijack',
    'dbname' => 'compaluser',
    'port' => 3306,
];
$flag= $_POST['flag'];
$mflag= $_POST['mflag'];
$tpr = $_POST['tpr'];
$username= $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$dept = $_POST['dept'];
$checker = $_POST['checker'];
switch ($flag){
    case 'up':
        {
            $mysqli = DAOMySQLi::getSingleton($linkinfo);

            $sql="insert into user (username,password,email,level,usertpr,dept) values ('$username','$password','$email',2,'$tpr','$dept')";

            //die($sql);
            $res = $mysqli->query($sql);//增删改用
            echo json_encode($res);
        }
        break;
    case 'mr':
    {
        $mysqli = DAOMySQLi::getSingleton($linkinfo);

        $sql = "insert into mail (name,mail,tpr,spmaflag) values ('$username','$email','$tpr','$mflag')";
        //die($sql);
        $res = $mysqli->query($sql);//增删改用
        echo json_encode($res);
        break;
    }
    case 'ad':
        {
            $mysqli = DAOMySQLi::getSingleton($linkinfo);

            $sql = "update h4_aduit set username='$username',Owner='$username',Checker='$username',mail='$email',dept='$dept'  where tpr = '$tpr' and Checker='$checker' ";
            //die($sql);
            $res = $mysqli->query($sql);//增删改用
            echo json_encode($res);
            break;
        }
    case 'ac':
        {
            $mysqli = DAOMySQLi::getSingleton($linkinfo);

            $sql = "select distinct username,dept,mail from h4_aduit where tpr = '$tpr' ";
            //die($sql);
            $res = $mysqli->fetchAll($sql);//查
            echo json_encode($res);
            break;
        }
    case 'ao':
        {
            $mysqli = DAOMySQLi::getSingleton($linkinfo);

            $sql = "select distinct no,name from mail where tpr = '$tpr' ";
            //die($sql);
            $res = $mysqli->fetchAll($sql);//查
            echo json_encode($res);
            break;
        }
    case 'amr':
        {
            $mysqli = DAOMySQLi::getSingleton($linkinfo);

            $sql = "update mail set name='$username',mail='$email',spmaflag='$mflag' where name='$checker'";
            //die($sql);
            $res = $mysqli->query($sql);//查
            echo json_encode($res);
            break;
        }
}
