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
        $ptpr = $_POST['tpr'];
        $table=$ptpr.'_check_data';
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
        $mtarr = array();
        if($tpr=='CGS'){
            $sql = "(select distinct cep_check_data.tpr TPR, cep_check_data.Model as model,cep_check_data.Fail_Item as fail,cep_check_data.Test_time as ttime from cep_check_data where cep_check_data.Compal_check is null or (isnull(Action) and isnull(TPR_FA)) order by ttime DESC) UNION all (select distinct cgs_check_data.tpr, cgs_check_data.Model ,cgs_check_data.Fail_Item,cgs_check_data.Test_time from cgs_check_data where cgs_check_data.Compal_check is null or (isnull(Action) and isnull(TPR_FA)))  UNION all (select distinct ceb_check_data.tpr, ceb_check_data.Model ,ceb_check_data.Fail_Item,ceb_check_data.Test_time from ceb_check_data where ceb_check_data.Compal_check is null or (isnull(Action) and isnull(TPR_FA)))   UNION all (select distinct igs_check_data.tpr, igs_check_data.Model ,igs_check_data.Fail_Item,igs_check_data.Test_time from igs_check_data where igs_check_data.Compal_check is null  or (isnull(Action) and isnull(TPR_FA)) )  UNION all (select distinct rlc_sh_check_data.tpr, rlc_sh_check_data.Model ,rlc_sh_check_data.Fail_Item,rlc_sh_check_data.Test_time from rlc_sh_check_data where rlc_sh_check_data.Compal_check is null) UNION all (select distinct tsi_check_data.tpr, tsi_check_data.Model, tsi_check_data.Fail_Item,tsi_check_data.Test_time from tsi_check_data where tsi_check_data.Compal_check is null or (isnull(Action) and isnull(TPR_FA))  order by tsi_check_data.Test_time DESC)";

           // die($sql);
            $res = $mysqli->query($sql);
            $afnums = $mysqli->affected_rows;
            if($afnums){
                while(($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) !== false && $row>0 ){
                    $mtarr[] = $row;
                }
            }

        }else{
            $stpr= $_SESSION['utpr'];
            $table = $stpr.'_check_data';
            $sql = "select TPR, model,fail_item fail,test_time ttime from $table where (Compal_check is null or Compal_check='' ) or (isnull(Action) and isnull(TPR_FA)) ";
            $res = $mysqli->query($sql);

            $afnums = $mysqli->affected_rows;
            if($afnums){
                while(($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) !== false && $row>0 ){
                    $mtarr[] = $row;
                }
            }

        }

    //die($sql);

    echo json_encode($mtarr);
    include '../../db/close_db.php';
    break;

    case 'update':{
        $vtime = $_POST['vtime'];
        $vmodel = $_POST['vmodel'];
        $vfail = $_POST['vfail'];
        $vfa = $_POST['fa'];
        $vaction = $_POST['action'];
        $vcheck = $_POST['check'];
        $vtpr = $_POST['tpr'];
		
		 $time = date('Y-m-d H:i:s');
        $strpos = strpos($vfail,'MfgModel');
       // echo strpos('MfgModel:SMMM  Service Me','MfgModel').'aaaa';
        $table = $vtpr.'_check_data';
        if($vcheck==null){
            if($strpos === false){
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",update_time=\"$time\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'";
            }else{
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",update_time=\"$time\" where TPR_FA is null and Action is null and Fail_Item like 'MfgModel%'";
                // die($sql);
            }
        }else{
            if($strpos === false){
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",Compal_check=\"$vcheck\",update_time=\"$time\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'";
                //die($sql);
            }else{
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",Compal_check=\"$vcheck\",update_time=\"$time\" where TPR_FA is null and Action is null and Fail_Item like 'MfgModel%'";
                // die($sql);
            }
        }
            $result = $mysqli->query($sql);
            //update  不返回结果集！！！！
            $afrows = $mysqli->affected_rows;
            if($afrows){
                echo json_encode('success') ;


        }
        //die($sql);

        include '../../db/close_db.php';
        break;
    }
}