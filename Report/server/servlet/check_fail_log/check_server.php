<?php
session_start();
$flag=$_POST['flag'];
$mysqli=null;
include '../../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}
switch ($flag){
    case 1:
        $ppid=$_POST['ppid'];
        $tpr=$_POST['tpr'];
        $station=$_POST['station'];
        $fail=$_POST['fail'];
		$time=$_POST['time'];
        if ($tpr=='CSAT'){
           $tpr='CTS';
        }
        $table=$tpr.'_check_data';
        $fail=urldecode($fail);
        $connID="";
        include '../../db/link_db.php';
        $result=mysqli_query($connID,"select distinct TPR_FA,Action,Compal_check,update_Time from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and Test_time='$time' ");
        //die("select distinct TPR_FA,Action,Compal_check,update_Time from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and Test_time='$time' ");
		$arr=array();
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $arr[]=$row;
        }
		//var_dump($row);
        echo json_encode($arr);
        include '../../db/close_db.php';
        break;
    case 2:
        $ppid=$_POST['ppid'];
        $tpr=$_POST['tpr'];
        $station=$_POST['station'];
        if($_SESSION["utpr"]==$tpr){
            echo "1";
            return ;
        }elseif ($_SESSION["utpr"]=='CGS'){
            echo "2";
            return;
        }else{
            echo "0";
            return ;
        }
        break;
    case 3:
        $stpr=$_SESSION['utpr'];
        $tpr=$_POST['tpr'];
        $ppid=$_POST['ppid'];
        $station=$_POST['station'];
        $c_ck=$_POST['c_check'];
        $fa=$_POST['fa'];
        $action=$_POST['action'];
		$testtime=$_POST['ttime'];
        $fail=$_POST['fail'];
        if ($tpr=="CSAT"){
            $tpr="cts";
        }
        $table=$tpr.'_check_data';
        $now_time=date("Y-m-d H-i-s");
        $tpr_cg_time=date("Y-m-d H-i-s");
        $connID="";
        include '../../db/link_db.php';
        $fail=urldecode($fail);
        if($stpr=='CGS'){
            $owner=$_SESSION["uname"];
            $result=mysqli_query($connID,"update $table set Compal_owner='$owner',TPR_FA=\"$fa\",Action=\"$action\",Compal_check='$c_ck' where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
            //$nums=mysqli_num_rows($result);
            if($result==1){
                echo'1111';
            }else{
                echo json_encode('0000');
            }

        }else{
            //TPR
            $result=mysqli_query($connID,"select * from $table where PPID='$ppid' and Test_time='$testtime' and Station='$station' and Fail_Item='$fail' and Compal_check is null ");
			//die("select * from $table where PPID='$ppid' and Test_time='$testtime' and Station='$station' and Fail_Item='$fail' and Compal_check is null ");
            $nums=mysqli_num_rows($result);
			//die("select * from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and Compal_check is null ");
            if($nums>0){
                $result=mysqli_query($connID,"select PPID from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and Compal_check is null  ");
				//die("select PPID from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and Compal_check is null  ");
                $nums=mysqli_num_rows($result);
                if($nums==1){
                    $result=mysqli_query($connID,"update $table set TPR_FA=\"$fa\",Action=\"$action\",update_time='$now_time' where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
                    //$nums=mysqli_num_rows($result);
                    //die("update $table set TPR_FA=\"$fa\",Action=\"$action\",update_time='$now_time' where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
					if($result){
                        echo'1111';
                    }else{
                        echo '0000';
                    }
                }else{
                    $result=mysqli_query($connID,"update $table set TPR_FA=\"$fa\",Action=\"$action\" where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
                    //die("update $table set TPR_FA=\"$fa\",Action=\"$action\" where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
					if($result){
                        echo'1111';
                    }else{
                        echo '0000';
                    }
                }
            }else{
                echo json_encode('0450');//is close
            }
        }
        include '../../db/close_db.php';
        break;
        default:
            break;
}

