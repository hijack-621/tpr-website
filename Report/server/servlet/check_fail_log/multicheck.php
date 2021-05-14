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
        if($vfail=='MfgModelFail'){
            $sql = "select distinct TPR_FA,Action,update_time from $table where Test_time='$vtime' and Model='$vmodel' and Fail_Item like 'MfgModel%' order by update_time desc limit 1";
        }else{
            $sql = "select distinct TPR_FA,Action,update_time from $table where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail' order by update_time desc limit 1";

        }
        //die($sql);
        $result = $mysqli->query($sql);
        $afrows = $mysqli->affected_rows;
        $taarr = array();
       if($afrows==1){
		while(($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) !== false && $row>0 ){
        $taarr[] = $row;
    }
    if($vfail=='MfgModelFail'){
        $nsql="select Model,Fail_Item,test_time,count(*) as count from $table where compal_check is null and Model='$vmodel' and Test_time='$vtime' and Fail_item like 'MfgModel%' group by model,Fail_Item,test_time having count >=1";
      //  die($nsql);

    }else{
        $nsql="select Model,Fail_Item,test_time,count(*) as count from $table where compal_check is null and Model='$vmodel' and Test_time='$vtime' and Fail_Item='$vfail'  group by model,Fail_Item,test_time having count >=1";

        //die($nsql);
    }
    // die($nsql);
    $nresult = $mysqli->query($nsql);
    $nafrows = $mysqli->affected_rows;
    $narr = array();
    if($nafrows){
        while(($nrow = mysqli_fetch_array($nresult,MYSQLI_ASSOC)) !== false && $nrow>0 ){
            $narr[] = $nrow;
        }
    }
    $jarr = [
        "data"=>$taarr,//返回该条faca是否被tpr签核
        "data2"=> $narr//返回fail_item数目
    ];

    echo json_encode($jarr);
	}else{
    echo json_encode('null');
}
        include '../../db/close_db.php';
        break;
    }

    case 'showselect':
        $mtarr = array();
        if($tpr=='CGS'){
            $sql = "(select distinct cep_check_data.tpr TPR, cep_check_data.Model as model,cep_check_data.Fail_Item as fail,cep_check_data.Fail_Detail as dfail,cep_check_data.Test_time as ttime from cep_check_data where cep_check_data.Compal_check is null  order by ttime DESC) UNION all (select distinct cgs_check_data.tpr, cgs_check_data.Model ,cgs_check_data.Fail_Item,cgs_check_data.Fail_Detail as dfail,cgs_check_data.Test_time from cgs_check_data where cgs_check_data.Compal_check is null )  UNION all (select distinct ceb_check_data.tpr, ceb_check_data.Model ,ceb_check_data.Fail_Item,ceb_check_data.Fail_Detail as dfail,ceb_check_data.Test_time from ceb_check_data where ceb_check_data.Compal_check is null )   UNION all (select distinct igs_check_data.tpr, igs_check_data.Model ,igs_check_data.Fail_Item,igs_check_data.Fail_Detail as dfail,igs_check_data.Test_time from igs_check_data where igs_check_data.Compal_check is null   )  UNION all (select distinct rlc_sh_check_data.tpr, rlc_sh_check_data.Model ,rlc_sh_check_data.Fail_Item,rlc_sh_check_data.Fail_Detail as dfail,rlc_sh_check_data.Test_time from rlc_sh_check_data where rlc_sh_check_data.Compal_check is null) UNION all (select distinct tsi_check_data.tpr, tsi_check_data.Model, tsi_check_data.Fail_Item,tsi_check_data.Fail_Detail as dfail,tsi_check_data.Test_time from tsi_check_data where tsi_check_data.Compal_check is null   order by tsi_check_data.Test_time DESC)";

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
            $sql = "select TPR, model,fail_item fail,test_time ttime from $table where (Compal_check is null or Compal_check='' )  ";
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
        $table = $vtpr.'_check_data';
        if($vcheck==null){
            if($strpos === false){
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",update_time=\"$time\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'";
            }else{
                $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",update_time=\"$time\" where Model=\"$vmodel\"  TPR_FA is null and Action is null and Fail_Item like 'MfgModel%'";
            }
        }else{
            if( $vtime!='-1'&&$vmodel=='-1'&&$vfail=='-1'){
                $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Test_time='$vtime' and compal_check is null ";
            }
            else if($vtime=='-1'&&$vmodel!=='-1'&&$vfail=='-1') {
                $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Model='$vmodel' and compal_check is null ";
            }
            else if($vtime=='-1'&&$vmodel=='-1'&&$vfail!=='-1') {
                if($strpos === false){
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Fail_Item='$vfail' and compal_check is null ";
                }
                else{
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Fail_Item like 'MfgModel%' and compal_check is null ";
                }
                
            }
            else if($vtime!=='-1'&&$vmodel!=='-1'&&$vfail=='-1') {
                $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Test_time='$vtime' and Model='$vmodel'  and compal_check is null ";
            }
            else if($vtime!=='-1'&&$vmodel=='-1'&&$vfail!=='-1'){
                if($strpos === false){
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Test_time='$vtime' and Fail_Item='$vfail'  and compal_check is null ";
                }
                else{
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Test_time='$vtime' and Fail_Item like 'MfgModel%'  and compal_check is null ";
                }
            }
            else if($vtime=='-1'&&$vmodel!=='-1'&&$vfail!=='-1'){
                if($strpos === false){
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Model='$vmodel' and Fail_Item='$vfail'  and compal_check is null ";
                }
                else{
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and  Model='$vmodel' and Fail_Item like 'MfgModel%'  and compal_check is null ";
                }
            }

            else if($vtime=='-1'&&$vmodel=='-1'&&$vfail=='-1'){
                    $sql = "update $table set Compal_check=\"$vcheck\",update_time=\"$time\" where  TPR_FA is not null and compal_check is null ";
            }
            //Compal_check=\"$vcheck\" 这样转义 $vcheck会带引号
           else{
                if($vfa!==''&& $vaction!==''){
                    if($strpos === false){
                        $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",Compal_check=\"$vcheck\",update_time=\"$time\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item='$vfail'  ";
                    }
                    else{
                        $sql = "update $table set TPR_FA =\"$vfa\",Action=\"$vaction\",Compal_check=\"$vcheck\",update_time=\"$time\" where Test_time='$vtime' and Model='$vmodel' and Fail_Item like 'MfgModel%'";
                    }
                }
            }
        }
            //die($sql);
            $result = $mysqli->query($sql);
            //update  不返回结果集！！！！
            $afrows = $mysqli->affected_rows;
            if($afrows>0){
                echo  json_encode(['success',$afrows]) ;
            }else {
                echo json_encode(['0',0]);
            }  
        include '../../db/close_db.php';
        break;
    }
}