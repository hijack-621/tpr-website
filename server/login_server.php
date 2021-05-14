<?php
session_start();//寮�惎Session 鍐欏湪php閲�蹇呴』鍐欏湪鏈�笂闈�
$un = $_POST['uname'];
$pw = $_POST['pword'];
$connID="";
include 'link_db.php';
$result=mysqli_query($connID,"select username,password from user where username='$un' and password='$pw' ");
$r=mysqli_num_rows($result);
if ($r==1){
    $result=mysqli_query($connID, "select username,level,usertpr from user where username='$un' ");
    while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
        //session鍙互瀛樿串涓�釜鏁扮粍
        //鍥犱负鐧诲綍,鐢ㄦ埛鍙兘鐧婚檰涓�釜,鎵�互涓嶇敤鎷呭績浼氫骇鐢熷缁存暟缁�
        $uname=$row[0];
        $uflag=$row[1];
        $utpr=$row[2];
        $_SESSION['uname']=$uname;
        $_SESSION['uflag']=$uflag;
        $_SESSION['utpr']=$utpr;
    }
    echo $r;
}else {
    echo $r;
}
include 'close_db.php';
