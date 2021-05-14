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
        if ($tpr=='CSAT'){
           $tpr='CTS';
        }
        $table=$tpr.'_check_data';
        $fail=urldecode($fail);
        $connID="";
        include '../../db/link_db.php';
        $result=mysqli_query($connID,"select distinct TPR_FA,Action,Compal_check,update_Time from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
        //die("select distinct TPR_FA,Action,Compal_check,update_Time from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
		$arr=array();
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $arr[]=$row;
        }
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
    case 3://提交
        $stpr=$_SESSION['utpr'];
        $tpr=$_POST['tpr'];
        $ppid=$_POST['ppid'];
        //echo $ppid;
        $station=$_POST['station'];
        $c_ck=$_POST['c_check'];
        $fa=$_POST['fa'];
		//$fasrp = str_replace($fa,'\'','\'\'');
        $action=$_POST['action'];
		//$actionsrp = str_replace($action,'\'','\'\'');
        $fail=$_POST['fail'];
        if ($tpr=="CSAT"){
            $tpr="cts";
        }
        $table=$tpr.'_check_data';
        $now_time=date("Y-m-d H-i-s");
        $tpr_cg_time=date("Y-m-d H-i-s");
        $connID="";
        include '../../db/link_db.php';
        //�ж�����Ƿ����
        $fail=urldecode($fail);
        $mssql = "select multippid from mppid order by  Numb desc limit 1";
        //die($mssql);
        $res = $mysqli->query($mssql);
        $nums = $mysqli->affected_rows;
        $sparr = Array();
        if($nums){
            while(($rows = mysqli_fetch_array($res,MYSQLI_ASSOC))!= false && $rows >0){
                $sparr[] = $rows;
            }
        }
        //echo count($sparr);
        //echo $sparr[0]['multippid'];
    if(count($sparr) >0){
        $ppidarr = explode(',',$sparr[0]['multippid']);
        for($i=0;$i<count($ppidarr);$i++){
            if($ppidarr[$i] == $ppid){
                $ppid = $ppidarr;
            }
        }
    }else{
        $ppid=$_POST['ppid'];
    }
       // echo gettype($ppidarr);

       //var_dump($ppid);
    //echo gettype($ppid);
        if($stpr=='CGS'){
            $owner=$_SESSION["uname"];
            if(gettype($ppid) == 'string'){
                $result=mysqli_query($connID,"update $table set Compal_owner='$owner',TPR_FA=\"$fa\",Action=\"$action\",Compal_check='$c_ck' where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
                if($result){
                    //echo 1;
                    echo json_encode('1111');
                }else{
                   // echo 2;
                    echo json_encode('0000');
                }
            }else{
                    //echo gettype($ppid);
                for($i=0;$i<count($ppid);$i++) {
					$sql = "update $table set Compal_owner='$owner',TPR_FA=\"$fa\",Action=\"$action\",Compal_check='$c_ck' where PPID='$ppid[$i]' and Station='$station' and Fail_Item='$fail'";
                    //die($sql);
					$result = mysqli_query($connID, $sql);
                }
				
                    if($result){
                        echo json_encode('1111');
                    }else{
                        echo json_encode('0000');
                    }

            }
            //$nums=mysqli_num_rows($result);
        }
        else {
            //TPR
            if(gettype($ppid) == 'string'){
                //echo 3;
                $result=mysqli_query($connID,"select * from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and isnull(Compal_check) ");
                $nums=mysqli_num_rows($result);
                if($nums){
                    $result=mysqli_query($connID,"select PPID from $table where PPID='$ppid' and Station='$station' and Fail_Item='$fail' and isnull(update_time) ");
                    $nums=mysqli_num_rows($result);
                    //echo 4;
                    if($nums){
                        //echo 5;
                        $result=mysqli_query($connID,"update $table set TPR_FA=\"$fa\",Action=\"$action\",update_time='$now_time' where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");
                            if($result){
                                echo json_encode('1111');
                            }else{
                                echo json_encode('0000');
                                }

                        //$nums=mysqli_num_rows($result);

                        }
                 }
            } else{
                for($i=0;$i<count($ppid);$i++){
                    $result=mysqli_query($connID,"select * from $table where PPID='$ppid[$i]' and Station='$station' and Fail_Item='$fail' and isnull(Compal_check) ");
                }

                $nums=mysqli_num_rows($result);
                if($nums){
                    for($i=0;$i<count($ppid);$i++){
                        $result=mysqli_query($connID,"select PPID from $table where PPID='$ppid[$i]' and Station='$station' and Fail_Item='$fail' and isnull(update_time) ");

                    }
                    $nums=mysqli_num_rows($result);
                    if($nums){
                        for($i=0;$i<count($ppid);$i++) {
                            $result = mysqli_query($connID, "update $table set TPR_FA=\"$fa\",Action=\"$action\",update_time='$now_time' where PPID='$ppid[$i]' and Station='$station' and Fail_Item='$fail' ");

                        }
                        if($result){
                                echo json_encode('1111');
                            }else{
                                echo json_encode('0000');
                            }

                        //$nums=mysqli_num_rows($result);

                    }else{
                        for($i=0;$i<count($ppid);$i++){
                            $result=mysqli_query($connID,"update $table set TPR_FA=\"$fa\",Action=\"$action\" where PPID='$ppid' and Station='$station' and Fail_Item='$fail' ");

                        }
                        if($result){
                                echo json_encode('1111');
                            }else{
                                echo json_encode('0000');
                            }

                    }

                }
                else{
                    echo json_encode('0450');//is close
                }
            }
        }

        include '../../db/close_db.php';
        break;
        default:
            break;
}

