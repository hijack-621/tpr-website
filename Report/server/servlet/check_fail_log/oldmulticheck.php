<?php
session_start();
$flag=$_POST['flag'];
$mysqli=null;
$tpr=$_SESSION['utpr'];
//echo $tpr;
include '../../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}
switch($flag){
    case 'gettpr':{
        $tpr = $_SESSION['utpr'];
        echo json_encode($tpr);
//        if($tpr=='CGS'){
//            echo '1';
//        }else{
//            echo '0';
//        }

    break;
    }
    case 'getfac':{
        if($tpr=='CGS'){

        }
        $table=$tpr.'_check_data';
        $vtime = $_POST['vtime'];
        $vmodel = $_POST['vmodel'];
        $vfail = $_POST['vfail'];
        $sql = "select distinct TPR_FA,Action,update_time from $table where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail' order by update_time desc limit 1";
        //die($sql);
        $result = $mysqli->query($sql);
        $afrows = $mysqli->affected_rows;
        $taarr = array();
        if($afrows==1){
            while(($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) !== false && $row>0 ){
                $taarr[] = $row;
            }
            echo json_encode($taarr);
        }else{
            echo json_encode('null');
        }
        include '../../db/close_db.php';
        break;
    }

    case 'showselect':
        if($tpr=='CGS'){
            $stpr=array("RLC_SH","CEP","CEB","IGS","CTS","TSI","CGS");
        }else{
            $stpr=array($tpr);
        }
        $sarr = array();
        for($i = 0;$i<count($stpr);$i++){
            $table = $stpr[$i].'_check_data';
            $sql = "select distinct Test_time,Model,Fail_Item from $table where isnull(Compal_check) or (isnull(Action) and isnull(TPR_FA)) ";
            $res = $mysqli->query($sql);
            $afnums = $mysqli->affected_rows;
           $mtarr = array();
           $mtarr[] = $stpr[$i];
            if($afnums){
                while(($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) !== false && $row>0 ){
                    $mtarr[] = $row;
                }
            }
            if(count($mtarr) >1){
                $sarr[] = $mtarr;
            }
        }
    //die($sql);

    echo json_encode($sarr);
    include '../../db/close_db.php';
    break;

    case 'update':{
        $vtime = $_POST['vtime'];
        $vmodel = $_POST['vmodel'];
        $vfail = $_POST['vfail'];
        $vfa = $_POST['vfa'];
        $vaction = $_POST['vaction'];
        $vck = $_POST['vck'];
        if($tpr=='CGS'){
            $tpr = array("RLC_SH","CEP","CEB","IGS","CTS","TSI","CGS");
            //echo '?';
            for($i=0;$i<count($tpr);$i++){
                //echo $i;
                $table = $tpr[$i].'_check_data';
                $sql = "update $table set Compal_check='$vck' where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'";
                $result = $mysqli->query($sql);

                //die($sql);
            }
            //$afrows = $mysqli->affected_rows;
            //if($afrows){
                echo json_encode('success') ;
            //}
        }else{
            //echo '?';
            $table = $tpr.'_check_data';
            $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'";
            //die($sql);
            $result = $mysqli->query($sql);
            //update  不返回结果集！！！！
            $afrows = $mysqli->affected_rows;
            if($afrows){
                echo json_encode('success') ;
            }

        }
        //die($sql);

        include '../../db/close_db.php';
        break;
    }
}