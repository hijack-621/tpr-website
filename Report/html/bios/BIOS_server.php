<?php
session_start();
$flag=$_POST['flag'];
if (empty($_SESSION["uname"])){
    echo "10000";
    return;
}
$flag=$_POST['flag'];

$mysqli=null;
include '../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}

//@$result->free();
//$mysqli->close();
switch ($flag){
    case 'sh_model':
        $sql="select distinct Model from model";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $model=array();
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                $model[]=$row;
            }
        }
        @$result->free();
        $mysqli->close();
        echo json_encode($model);
        break;
    case 'sh_ver':
        $model=$_POST['model'];
        $sql="select Oldver,Old_sysver from model where Model='$model' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        @$result->free();
        $mysqli->close();
        echo json_encode($arr);
        break;
    case 'add_model':
        $model=$_POST['model'];
        $new_ver=$_POST['new_ver'];
        $new_sysver=$_POST['new_sysver'];
        $series = $_POST['series'];
        $sql="select * from model where Model='$model' and Oldver='$new_ver' and Old_sysver='$new_sysver' and DMname='$new_sysver' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            echo '102';//重复添加
        }else{
            $sql="insert into model (Model,Oldver,Old_sysver,DMname) values ('$model','$new_ver','$new_sysver','$series')";
            $result=$mysqli->query($sql);
            if($result==1){
                if(isset($series)){
                    $msql = "insert into matrix_rlc_sh (Compal_Name,DELL_Name) values ('$model','$series')";
                    $mresult=$mysqli->query($msql);
                }
                if($mresult==1){
                    echo '1';
                }else{
                    echo '11';//martix表插入错误
                }
                
            }else{
                echo '0';
            }
        }
       
        $mysqli->close();
        break;
    case 'Find_model':
        $model=$_POST['model'];

        $t=0;
         $table="matrix_rlc_sh";
//         $dbname="matrix";

//         mysqli_select_db($mysqli, $dbname);
        $tol_model=explode("&",$model);
        $model_arr=array();
        for($i=0;$i<count($tol_model);$i++){
            //$k[]=$tol_model[$i];
            $field_model=explode("_",$tol_model[$i]);
            $header=substr($field_model[0],0,3);
            for($x=0;$x<count($field_model);$x++){
                if($x==0){
                    $one_model=substr($field_model[0],3,2);
                    $final_model=$header.$one_model;
                }else{
                    $final_model=$header.$field_model[$x];
                }

                //$k[]=$final_model;
                $sql="select Compal_Name from $table where Compal_Name='$final_model' ";
                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                if($nums==0){
                    $model_arr[]=$final_model;
                }else{
                    $t=1;
                }
            }
        }

        if($t==0){
            $mrk=1041;
            $msg[]=$mrk;
            echo json_encode($msg);
            return;
        }
        $mrk=1111;
        $msg[]=$mrk;
        $msg[]=$model_arr;
        echo json_encode($msg);
        @$result->free();
        $mysqli->close();

        break;
    case 'Create':
        $data=$_POST['obj_pro'];
        $activity=$data['descript'];
        $model=$data['model'];
        $new_ver=$data['newver'];

        $lock=0;
        $sql="select distinct suo from bios_system where Model='$model' and New_ver='$new_ver' ";
        $result=$mysqli->query($sql);
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $lock=$row[0][0];
        }
        if ($lock==1){
            $mrk=1042;
            $msg[]=$mrk;
            echo json_encode($msg);
            return;
        }

        //echo json_encode($activity.$model.$new_ver);
        //return;
        $sql="select * from bios_system where Model='$model' and Activity='$activity' and New_ver='$new_ver' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if($nums!=0){
            $mrk=1043;
            $msg[]=$mrk;
            echo json_encode($msg);
            return;
        }
        $Id = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
        $tpr_arr=explode(',',$data['checkdata']);
        //select sql model is true
        $sql="select * from h4_aduit where (steps=1 or steps=2) and TPR='CGS' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                $arr[]=$row;
            }

        }

        $Owner_1=$arr[0]["Owner"];
        $Check_1=$arr[0]["Checker"];
        $Owner_2=$arr[1]["Owner"];
        $Check_2=$arr[1]["Checker"];

        $model=$data['model'];
        $Activity=$data['descript'];
        $TPRS=$data['checkdata'];
        $Eco=$data['econo'];
        $Old_ver=$data['oldver'];
        $Old_sysver=$data['oldsys'];
        $New_ver=$data['newver'];
        $New_sysver=$data['newsys'];
        $Now_time=date('Y-m-d H:i:s');
		//echo $Now_time;
        $sql="insert into bios_system (Id,Model,Activity,TPR,TPRS,Eco_no,Old_ver,Old_sysver,New_ver,New_sysver,1_Begingtime,1_Owner,1_Checker,1_Endtime,1_Remark,1_Status,2_Begingtime,2_Owner,2_Checker,2_Status,D_bgtime) values
        ('$Id','$model','$Activity','CGS','$TPRS','$Eco','$Old_ver','$Old_sysver','$New_ver','$New_sysver','$Now_time','$Owner_1','$Check_1','$Now_time','ok',1,'$Now_time','$Owner_2','$Check_2',0,'$Now_time')";
        $result=$mysqli->query($sql);
        if(!$mysqli->errno){
            $mrk=1111;
        }else{
            $mrk=1040;
        }
        $mail_msg[]=$Owner_2;
        $mail_msg[]=$model;
		$mail_msg[]=$new_ver;

        $msg[]=$mrk;
        $msg[]=$mail_msg;

        echo json_encode($msg);
        //@$result->free();
        $mysqli->close();
        break;
    case 'load_data':
		$ptpr = $_POST['ptpr'];
		$TPR=$_SESSION["utpr"];
		if($ptpr==''){
		 if($TPR=='CGS'){
            $sql="select * from bios_system where Status!=1 and Status!=5 and Status!=2 order by 1_Begingtime desc";
		}else{
            $sql="select * from bios_system where Status!=1 and Status!=5 and Status!=2 and TPR='$TPR' order by 1_Begingtime desc";
			}
		}else{
			if($ptpr == 'bm'){
				$ptpr='Bizcom';
			}
		$sql="select * from bios_system where Status!=1 and Status!=5 and Status!=2 and TPR='$ptpr' order by 1_Begingtime desc";

		}
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                if ($row['TPR']=='CGS'){
                    $arr['CGS'][]=$row;
                }else if($row['TPR']=='RLC_SH'){
                    $arr['RLC_SH'][]=$row;
                }else if($row['TPR']=='CEP'){
                    $arr['CEP'][]=$row;
                }else if($row['TPR']=='IGS'){
                    $arr['IGS'][]=$row;
                }else if($row['TPR']=='CEB'){
                    $arr['CEB'][]=$row;
                }else if($row['TPR']=='CSAT'){
                    $arr['CSAT'][]=$row;
                }else if($row['TPR']=='RLC_INDIA'){
                    $arr['RLC-INDIA'][]=$row;
                }else if($row['TPR']=='Regenersis_INDIA'){
                    $arr['Regenersis-INDIA'][]=$row;
                }else if($row['TPR']=='TSI'){
                    $arr['TSI'][]=$row;
               }
			   else if($row['TPR']=='Bizcom'){
                    $arr['Bizcom'][]=$row;
               }

            }
        }
        echo json_encode($arr);
        //@$result->free();
        $mysqli->close();
        break;
    case 'lock_model':
        $model=$_POST['model'];
        $new_ver=$_POST['new_ver'];
        $sql="select suo from bios_system where suo=1 and Model='$model' and New_ver='$new_ver' ";
        $result=$mysqli->query($sql);
        $arr=array();
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
         echo '1040';
         return;
        }
        $sql="update bios_system set suo=1 where Model='$model' and New_ver='$new_ver' ";
        $result=$mysqli->query($sql);
        if(!$mysqli->errno){
            echo '1111';
        }else{
            echo '1041';
        }
        //@$result->free();
        $mysqli->close();
        break;
    case 'unlock_model':
        ini_set('display_errors','on');
        error_reporting(E_ALL);
        $model=$_POST['model'];
        $new_ver=$_POST['new_ver'];
        $tpr=$_POST['tpr'];
        $sql="select suo from bios_system where suo=0 and Model='$model' and New_ver='$new_ver' AND TPR='$tpr' ";
        $result=$mysqli->query($sql);
        $arr=array();
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            echo '1040';
            return;
        }

        $sql="update bios_system set suo=0 where Model='$model' and New_ver='$new_ver' and TPR='$tpr' ";
        $result=$mysqli->query($sql);//remove delay
        $sqlstatus ="update bios_system set 2_status = if(2_status=5,1,2_status),3_status = if(3_status=5,1,3_status),4_status = if(4_status=5,1,4_status),5_status = if(5_status=5,1,5_status) where model='$model' and New_ver='$new_ver' and status!=1";
        //die($sqlstatus);
        $results=$mysqli->query($sqlstatus);
        if($result!=false&&$results!=false){
            echo '1111';

        }else{
            echo '1041';
        }
       // @@$result->free();
        $mysqli->close();
        break;

    case 'sh_select':
        $sql="select distinct TPR,model,New_ver from bios_system ";
        $result=$mysqli->query($sql);
        $arr=array();
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        //@$result->free();
        $mysqli->close();
        break;

        $tpr=$_POST['tpr'];
        $model=$_POST['model'];
        $sql="select distinct New_ver from bios_system where TPR='$tpr' and Model='$model' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $new_ver=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $new_ver[]=$row;
            }
        }
        echo json_encode($new_ver);
        @$result->free();
        $mysqli->close();
        break;
    case 'load_all':
		$ptpr = $_POST['ptpr'];
		if($ptpr==''){
		 if($_SESSION["utpr"]=='CGS'){
            $sql="select * from bios_system order by 1_Begingtime desc ";
        }else{
            $tpr=$_SESSION["utpr"];
            $sql="select * from bios_system where TPR='$tpr' order by 1_Begingtime desc ";
        }
		
		}else{
			$sql="select * from bios_system where TPR='$ptpr' order by 1_Begingtime desc ";

		}
       
        $result=$mysqli->query($sql);
        $arr=array();
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                if ($row['TPR']=='CGS'){
                    $arr['CGS'][]=$row;
                }else if($row['TPR']=='RLC_SH'){
                    $arr['RLC_SH'][]=$row;
                }else if($row['TPR']=='CEP'){
                    $arr['CEP'][]=$row;
                }else if($row['TPR']=='IGS'){
                    $arr['IGS'][]=$row;
                }else if($row['TPR']=='CEB'){
                    $arr['CEB'][]=$row;
                }else if($row['TPR']=='CSAT'){
                    $arr['CSAT'][]=$row;
                }else if($row['TPR']=='RLC-INDIA'){
                    $arr['RLC-INDIA'][]=$row;
                }else if($row['TPR']=='Regenersis-INDIA'){
                    $arr['Regenersis-INDIA'][]=$row;
                }
                else if($row['TPR']=='TSI'){
                	$arr['TSI'][] =$row;
               }
			   else if($row['TPR']=='Bizcom'){
                	$arr['Bizcom'][] =$row;
               } 
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
    case 'sh_data':
        $tpr=$_POST['tpr'];
        $model=$_POST['model'];
		$newver=$_POST['newver'];
        if($_SESSION["utpr"]=='CGS'||$_SESSION["utpr"]==$tpr){
           if($tpr!=''&&$model==''&&$newver==''){

                $sql="select * from bios_system where TPR='$tpr'  ";
                //die($sql);
            }else if($tpr==''&&$model!=''&&$newver==''){
                $sql="select * from bios_system where Model='$model'   ";
            }else if($tpr==''&&$model==''&&$newver!=''){
                $sql="select * from bios_system where New_ver='$newver'  ";
            }else if($tpr!=''&&$model!=''&&$newver==''){
                $sql="select * from bios_system where tpr='$tpr' and Model='$model'  ";
            }else if($tpr!=''&&$model==''&&$newver!=''){
                $sql="select * from bios_system where tpr='$tpr' and New_ver='$newver'  ";
            }else if($tpr==''&&$model!=''&&$newver!=''){
                $sql="select * from bios_system where New_ver='$newver' and model='$model'  ";
            }else if($tpr!=''&&$model!=''&&$newver!=''){
                $sql="select * from bios_system where New_ver='$newver' and tpr='$tpr' and model='$model'  ";
        }

            $result=$mysqli->query($sql);
            $arr=array();
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    if ($row['TPR']=='CGS'){
                        $arr['CGS'][]=$row;
                    }else if($row['TPR']=='RLC_SH'){
                        $arr['RLC_SH'][]=$row;
                    }else if($row['TPR']=='CEP'){
                        $arr['CEP'][]=$row;
                    }else if($row['TPR']=='IGS'){
                        $arr['IGS'][]=$row;
                    }else if($row['TPR']=='CEB'){
                        $arr['CEB'][]=$row;
                    }else if($row['TPR']=='CSAT'){
                        $arr['CSAT'][]=$row;
                    }else if($row['TPR']=='RLC_INDIA'){
                        $arr['RLC-INDIA'][]=$row;
                    }else if($row['TPR']=='Regenersis_INDIA'){
                        $arr['Regenersis-INDIA'][]=$row;
                    }else if($row['TPR']=='TSI'){
                        $arr['TSI'][]=$row;
                    }
					else if($row['TPR']=='Bizcom'){
                        $arr['Bizcom'][]=$row;
                    }
                }
            }
            echo json_encode($arr);
        }else{
            echo '1040';
        }
        @$result->free();
        $mysqli->close();
        break;
    case 'add_data':
        $data=$_POST['add_obj'];
        $Id=$data['data_id'];
        $tprs=$data['tpr'];

        $sql="select TPR,TPRS,Status,Model,New_ver from bios_system where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $Is_T=$row['TPR'];
                $T=$row['TPRS'];
                $S=$row['Status'];
                $M=$row['Model'];
                $N=$row['New_ver'];
            }
        }
        if($Is_T!="CGS"){
            echo '1090';
            return;
        }

        $lock=0;
        $sql="select distinct suo from bios_system where Model='$M' and New_ver='$N' ";
        $result=$mysqli->query($sql);
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $lock=$row[0][0];
        }
        if ($lock==1){
            echo '1042';
            return;
        }
        $now_date=date("Y-m-d H:i:s");

        if($S==0){
            for($i=0;$i<count($tprs);$i++){
                if(strpos($T,$tprs[$i])===false){
                    $T.=",".$tprs[$i];
                }else{
                    continue;
                }
            }
        }else if($S==1||$S==5){
            for($i=0;$i<count($tprs);$i++){
                if(!strpos($T,$tprs[$i])){
                    //select Owner
                    $sql="select Owner,Checker from h4_aduit where steps='3' and  tpr='$tprs[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);

                    $hand_arr=array();
                    if ($nums!=0){
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $hand_arr[]=$row;
                        }
                        $Owner=$hand_arr[0]['Owner'];
                        $Checker=$hand_arr[0]['Checker'];
                    }
                    $tpr_Id = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
                    $sql="insert into bios_system(Id,Model,Activity,TPR,TPRS,Eco_no,Old_ver,Old_sysver,New_ver,New_sysver,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,3_Begingtime,3_Owner,3_Checker,3_Status,3_file) select '$tpr_Id',Model,Activity,'$tprs[$i]','$tprs[$i]',Eco_no,Old_ver,Old_sysver,New_ver,New_sysver,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,'$now_date','$Owner','$Checker',0,3_file from bios_system where Id='$Id' ";
                    $result=$mysqli->query($sql);
                    if($result!=0){
                        $T.=",".$tprs[$i];
                    }
                }else{
                    continue;
                }
            }
        }
        $sql="update bios_system set TPRS='$T' where Id='$Id' ";
        $result=$mysqli->query($sql);
        if($result==1){
            echo '1111';
        }else{
            echo '1030';
        }
        @$result->free();
        $mysqli->close();
        break;
    case 'del_data':
        $Id=$_POST['id'];
      
        $sql="select TPR,TPRS,Model,Activity,New_ver,2_file,5_file from bios_system where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        $T=$arr[0]['TPR'];
        $model=$arr[0]['Model'];
        $activity=$arr[0]['Activity'];
        $new_ver=$arr[0]['New_ver'];
        $file_2=$arr[0]['2_file'];
        $file_5=$arr[0]['5_file'];
        $tag=1020;
        if($T=="CGS"){
            $sql="delete from bios_system where Id='$Id' ";
            $result=$mysqli->query($sql);
            if(!$mysqli->errno){
                if($file_2!=null){
                    del_sopfile($arr[0]['2_file']);
                }
                $tag=1111;
            }else{
                echo json_encode($tag);
                @$result->free();
                $mysqli->close();
                return ;
            }
            $TPR_arr=explode(',',$arr[0]['TPRS']);
            for($i=0;$i<count($TPR_arr);$i++){
                $tpr=$TPR_arr[$i];
                $sql="select 5_file from bios_system where Model='$model' and Activity='$activity' and TPR='$tpr' and New_ver='$new_ver' ";
                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                $arr=array();
                if ($nums!=0){
                    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                }
                $sql="delete from bios_system where Model='$model' and Activity='$activity' and TPR='$tpr' and New_ver='$new_ver' ";
                $result=$mysqli->query($sql);

                if(!$mysqli->errno){
                    if($arr!=null&&$arr!=""){
                        del_sopfile($arr[0]['5_file']);
                    }
                    $tag=1111;
                }
            }

        }else{
            $sql="select Id,TPRS from bios_system where TPR='CGS' and Model='$model' and Activity='$activity' and New_ver='$new_ver' ";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                $arr=array();
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            $tprs=str_replace(",".$T,"",$arr[0]['TPRS']);
            $CGS_Id=$arr[0]['Id'];
            $mysqli->autocommit(false);
            $sql="update bios_system set TPRS='$tprs' where Id='$CGS_Id' ";
            $result=$mysqli->query($sql);
            if(!$mysqli->errno){
                $sql="delete from bios_system where Id='$Id' ";
                $result=$mysqli->query($sql);
                if(!$mysqli->errno){
                    if($file_5!=null&&$file_5!=""){
                        del_sopfile($arr[0]['5_file']);
                    }
                    $tag=1111;
                    $mysqli->commit();
                }else{
                    $mysqli->rollback();
                }
            }else{
                $mysqli->rollback();
            }
        }
        echo json_encode($tag);
        //@$result->free();
        $mysqli->close();
        break;
    case 'step':
        $dataid=$_POST['dataid'];
        $sql="select * from bios_system where Id='$dataid' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
    case 'step_file':
        $rqdata=$_POST['dataid'];
        $sql="select 2_file,5_file from bios_system where id= '$rqdata'";
        //die($sql);
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $arr=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_NUM ))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        $file=array();
        if($arr[0]!=null){
            for($i=0;$i<count($arr[0]);$i++){
                if($arr[0][$i]!=null){
                    $path="../../BIOS_System_file/".$arr[0][$i];
                    if(is_dir($path)){
                        $p = scandir($path);
                        foreach($p as $val){
                           
                            if($val !="." && $val !=".."){
                                $file[]=$path."/".$val;
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($file);
        @$result->free();
        $mysqli->close();
        break;
        /*
    case 'close_data':
        $Id=$_POST['Id'];
        $tpr=$_POST['TPR'];
        $step=$_POST['step'];
        $ver=$_POST['ver'];
        $Owner=$_SESSION["uname"];
        $now_date=date("Y-m-d H:i:s");
        if($Owner!="compalsod"){
            echo '1044';
            @$result->free();
            $mysqli->close();
            return ;
        }
        $sql="select TPR,Model,New_ver,New_sysver from bios_system where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }

        if($ver==1){
            $bios_ver=$arr[0]['New_sysver'];
        }elseif ($ver==0){
            $bios_ver=$arr[0]['New_ver'];
        }
        if ($arr[0]['TPR']=="CGS"){
            echo '1041';
            @$result->free();
            $mysqli->close();
            return;
        }

        //for link sql
        $sql="update bios_system set ";
        for($i=$step;$i<7;$i++){
            $status_field=$i."_Status";
            $bgtime_field=$i."_Begingtime";
            $edtime_field=$i."_Endtime";
            $owner_field=$i."_Owner";
            $check_field=$i."_Checker";
            if($i==$step){
                $sql.=" $status_field=1,$edtime_field='$now_date',$owner_field='$Owner',$check_field='$Owner',";
            }else{
                $sql.=" $status_field=1,$bgtime_field='$now_date',$edtime_field='$now_date',$owner_field='$Owner',$check_field='$Owner',";
            }
        }
        $sql.="Status=1 where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=$mysqli->affected_rows;
        if ($nums==1){
            $model=$arr[0]['Model'];
            $new_ver=$arr[0]['New_ver'];
            $new_sysver=$arr[0]['New_sysver'];
            $sql="insert into model (Model,Oldver,Oldsysver) values ('$model','$new_ver','$new_sysver')";
            $result=$mysqli->query($sql);

            $tol_model=explode("&",$model);
            $tb_Matir="matrix_rlc_sh";

            for($i=0;$i<count($tol_model);$i++){
                $field_model=explode("_",$tol_model[$i]);
                $header=substr($field_model[0],0,3);


                for($x=0;$x<count($field_model);$x++){
                    if($x==0){
                        $one_model=substr($field_model[0],3,2);
                        $final_model=$header.$one_model;
                    }else{
                        $final_model=$header.$field_model[$x];
                    }
                    //$k[]=$field_model[$x];
                    $sqla="update $tb_Matir set Old_BIOS_Ver=BIOS_Ver,BIOS_Ver='$bios_ver',Last_Update_Date='$now_date',NewBios_Time='$now_date' where Compal_name='$final_model' ";
                    $sqlb="update matrix_example set Old_BIOS_Ver=BIOS_Ver,BIOS_Ver='$bios_ver',Last_Update_Date='$now_date',NewBios_Time='$now_date' where Compal_name='$final_model' ";
                    $result=$mysqli->query($sqla);
                    $numsa=$mysqli->affected_rows;
                    $mysqli->query($sqlb);
                    $result=$mysqli->query($sqlb);
                    $numsb=$mysqli->affected_rows;
                    if($numsa>0 && $numsb>0){
                        $mrk=1111;
                        //$mysqli->rollback();
                        $mysqli->commit();
                    }else{
                        $mrk="1010";
                        $mysqli->rollback();
                    }
                }
            }
        }else{
            $mrk="1010";
            $mysqli->rollback();
        }
            $mail_msg[]=$model;
            $mail_msg[]=$Owner;
            //$tpr=$arr[0]['TPR'];
            $msg[]=$mrk;
            $msg[]=$arr[0]['TPR'];
            $msg[]=$mail_msg;

        echo json_encode($msg);
        @$result->free();
        $mysqli->close();
        break;
        */
    case 'Edit_load':
        $val=$_POST['dataid'];
        $Owner=$val[1].'_Owner';
        $Bgtime=$val[1].'_Begingtime';
        $Acty='Activity';
        $Remark=$val[1].'_Remark';

        $Checker=$val[1].'_Checker';
        $score=$val[1].'_score';
        $ck_mark=$val[1].'_ck_mark';
        $day=$val[1].'_ck_date';

        $sql="select $Owner,$Checker,$Acty,Model,$Bgtime,$Remark from bios_system where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
    case 'Edit_Owner':
        function check_finish($status_field,$val){
            global $mysqli;
            $sql="select  $status_field from bios_system where Id='$val[0]' ";
            $result= $mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                $status_arr=array();
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $status_arr[]=$row;
                }
            }
            return $status_arr[0][$status_field];
        }

        function check_file($Id){
            if($Id==null||$Id==""){
                return '0';
            }
            $path="../../BIOS_System_file/".$Id."/";
            if(is_dir($path)){
                if(count(array_diff(scandir($path),array('..','.')))==0){
                    return '0';
                }else{
                    return '1';
                }
            }else{
                return '0';
            }
        }
			function qgmdate($dateformat = 'Y-m-d H:i:s', $timestamp = '', $timeoffset = 8,$dtpr,$dtime) {//yanshishiyan
            if(empty($timestamp)&&$dtpr != 'IGS') {
                $timestamp = time();
            }else if(empty($timestamp)&&$dtpr = 'IGS'){
                $timestamp = strtotime($dtime);
            }
            $result = gmdate($dateformat, $timestamp + $timeoffset * 3600);
            return $result;
        }
        function Status($nowtime,$this_bgtime_field,$Id,$stpr){//yanshishiyan
            global $mysqli;
            //$now_date = date("Y-m-d H:i:s ");
            $sql="select $this_bgtime_field from bios_system where Id='$Id' ";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            $arr=array();
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            $weekarray = array('日','一','二','三','四','五','六');
            if($stpr=='IGS'){
                $date_day=floor((strtotime(qgmdate('Y-m-d H:i:s', '', -5,$stpr,$nowtime))-strtotime(qgmdate('Y-m-d H:i:s', '', -5,$stpr,$arr[0][0])))/86400);//86400
                $week = $weekarray[date('w',strtotime(qgmdate('Y-m-d H:i:s', '', -5,$stpr,$arr[0][0])))];
                if ( $week == '六'){
                    $date_day -=1;
                }
                if($date_day >1){
                    return 5;
                }else{
                    return 1;
                }
            }else{
                $date_day=floor((strtotime($nowtime)-strtotime($arr[0][0]))/86400);
                $week = $weekarray[date('w',strtotime($arr[0][0]))];
                if($week =='六'){
                    $date_day -=1;
                }
                if($date_day>2){  //每一步超过两天就状态变为5，爆红
                    return 5;
                }else{
                    return 1;
                }
            }
        }
        function lock($model,$new_ver,$tpr){
            global $mysqli;
            $sql="select distinct suo from bios_system where Model='$model' and New_ver='$new_ver' and TPR='$tpr' ";
			//die($sql);
            $result=$mysqli->query($sql);
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                $lock=$row[0][0];
            }
            return $lock;
        }

        $val=$_POST['dataid'];
        $remark=$_POST['remark'];
        $now_date=date('Y-m-d H:i:s');
        $status=$_POST['status'];
		$mb = $_POST['mb'];
        $this_owner_field=$val[1].'_Owner';
        $this_checker_field=$val[1].'_Checker';
        $remark_field=$val[1].'_Remark';
        $status_field=$val[1].'_Status';
        $edtime_field=$val[1].'_Endtime';
        $this_bgtime_field=$val[1].'_Begingtime';
        $file_field=$val[1].'_file';

        if(check_finish($status_field,$val)==1||check_finish($status_field,$val)==5){
            $mrk=1040;
            $msg[]=$mrk;
            echo json_encode($msg);
            //@$result->free();
            $mysqli->close();
            return;
        }
        $ending=0;
        if(($val[2]=='CGS'&&$val[1]==3)||$val[1]==5){
            $ending=1;
        }
        if($ending==0){
            $next_step=$val[1]+1;

            $sql="select Owner,Checker from h4_aduit where steps='$next_step' and  tpr='$val[2]' ";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);

            $hand_arr=array();
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $hand_arr[]=$row;
                }

                $next_owner_field=$next_step.'_Owner';
                $next_checker_field=$next_step.'_Checker';
                $next_Owner=$hand_arr[0]['Owner'];
                $next_Checker=$hand_arr[0]['Checker'];
                $next_status_field=$next_step.'_Status';
                $bgtime_field=$next_step.'_Begingtime';
            }else{
                echo '0106';
                @$result->free();
                $mysqli->close();
                return ;
            }
        }

        $sql="select $this_owner_field,$this_checker_field,$this_bgtime_field,$file_field,Model,TPRS,New_ver,New_sysver from bios_system where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $hand_arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $hand_arr[]=$row;
            }
        }
        $tpr=$val[2];
        $this_Owner=$hand_arr[0][$this_owner_field];
        $this_Checker=$hand_arr[0][$this_checker_field];
        $this_bgtime=$hand_arr[0][$this_bgtime_field];
        $this_file=$hand_arr[0][$file_field];
        $model=$hand_arr[0]['Model'];
        $New_ver=$hand_arr[0]['New_ver'];
        $New_sysver=$hand_arr[0]['New_sysver'];
        $tprs=explode(',',$hand_arr[0]['TPRS']);


        if(lock($model,$New_ver,$tpr)==1){
            echo '1044';
            @$result->free();
            $mysqli->close();
            return ;
        }

        if($_SESSION["utpr"]!=$tpr&&$_SESSION["utpr"]!="CGS"){
            $time[]='is not Owner';
            $msg[]=$time;
            echo json_encode($msg);
            @$result->free();
            $mysqli->close();
            return ;
        }

        if($status==0){
            $sql="update bios_system set $remark_field='$remark' where Id='$val[0]' ";
            $result=$mysqli->query($sql);
            if($mysqli->errno){
                $mrk=1010;
                $tag[]=$tpr;
                $mail_msg[]=$next_Owner;
                $mail_msg[]=$model;
				$mail_msg[]=$New_ver;

                $msg[]=$mrk;
                $msg[]=$tag;
                $msg[]=$mail_msg;
                echo json_encode($msg);
                @$result->free();
                $mysqli->close();
                return;
            }else{
                $mrk=1051;
                $tag[]=$tpr;
                $mail_msg[]=$next_Owner;
                $mail_msg[]=$model;
				$mail_msg[]=$New_ver;


                $msg[]=$mrk;
                $msg[]=$tag;
                $msg[]=$mail_msg;
                echo json_encode($msg);
                @$result->free();
                $mysqli->close();
                return;
            }
        }

        if ($tpr=='CGS'){
            switch ($val[1]){
                case 2:
                    $m=check_file($this_file);
                    if($m==0){
                        $mrk=1041;
                        $msg[]=$mrk;
                        echo json_encode($msg);
                        @$result->free();
                        $mysqli->close();
                        return ;
                    }

                    $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);
                    $sql="update bios_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    if(!$mysqli->errno){
                        $mrk=1111;
                        $tag[]=$tpr;
                    }else{
                        $mrk=1010;
                        $tag[]=$tpr;
                    }
                    $mail_msg[]=$next_Owner;
                    $mail_msg[]=$model;
					$mail_msg[]=$New_ver;

                    $msg[]=$mrk;
                    $msg[]=$tag;
                    $msg[]=$mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                case 3:
                    $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);
                    $sql="update bios_system set $edtime_field='$now_date',$remark_field='$remark',$status_field='$this_status',Status=1,D_bgtime='$now_date' where Id='$val[0]' ";
                    $result=$mysqli->query($sql);

                    if(!$mysqli->errno){
                        for($i=0;$i<count($tprs);$i++){
                            $sql="select Owner,Checker from h4_aduit where steps='$val[1]' and  tpr='$tprs[$i]' ";
                            $result=$mysqli->query($sql);
                            $nums=mysqli_num_rows($result);
                            $hand_arr=array();
                            if ($nums!=0){
                                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                                    $hand_arr[]=$row;
                                }
                                $Owner=$hand_arr[0]['Owner'];
                                $Checker=$hand_arr[0]['Checker'];
                            }
                            $Id = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
                            $sql="insert into bios_system(Id,Model,Activity,TPR,TPRS,Eco_no,Old_ver,Old_sysver,New_ver,New_sysver,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,3_Begingtime,3_Owner,3_Checker,3_Status,3_file,D_bgtime) select '$Id',Model,Activity,'$tprs[$i]','$tprs[$i]',Eco_no,Old_ver,Old_sysver,New_ver,New_sysver,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,'$now_date','$Owner','$Checker',0,3_file,'$now_date' from bios_system where Id='$val[0]' ";
                            $result=$mysqli->query($sql);
                            if(!$mysqli->errno){
                                $tag[]=$tprs[$i];
                                $time[]=1;
                            }
                        }
                        if(in_array(1,$time)){
                            $mrk=1101;
                        }else{
                            $mrk=1010;
                        }
                    }else{
                        $mrk=1010;
                        $tag[]=null;
                    }
                    $mail_msg[]=$this_Owner;
                    $mail_msg[]=$model;
					$mail_msg[]=$New_ver;

                    $msg[]=$mrk;
                    $msg[]=$tag;
                    $msg[]=$mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
            }
        }else{
            switch ($val[1]){
                case 3:
                    $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);
                    $sql="update bios_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    if(!$mysqli->errno){
                        $mrk=1111;
                        $tag[]=$tpr;
                    }else{
                        $mrk=1010;
                        $tag[]=$tpr;
                    }
                    $mail_msg[]=$next_Owner;
                    $mail_msg[]=$model;
					$mail_msg[]=$New_ver;

                    $msg[]=$mrk;
                    $msg[]=$tag;
                    $msg[]=$mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
               case 4:
    if($mb==1){
        $m=check_file($this_file);
        if($m==0){
            $mrk=1041;
            $msg[]=$mrk;
            echo json_encode($msg);
            //    @$result->free();
            $mysqli->close();
            return ;
        }
        $info = 'No MB and Import New Program';
        $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);
        $sql="update bios_system set $edtime_field='$now_date',$remark_field='$remark',$status_field='$this_status',D_bgtime='$now_date',5_Remark='$info',6_Remark='$info',5_Status=1,5_Checker='System auto closed',6_checker='System auto closed',6_Status=1,Status=1 where Id='$val[0]' ";
        //die($sql);
        $result=$mysqli->query($sql);
        if(!$mysqli->errno){
            $mrk=1222;//mb auto close
            $tag[]=$tpr;
        }else{
            $mrk=1010;
            $tag[]=$tpr;
        }
        $mail_msg[]=$model;
        $mail_msg[]=$New_ver;
        $mail_msg[] = $info;
        $msg[]=$mrk;
        $msg[]=$tag;
        $msg[]=$mail_msg;

    }else{
        $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);
        $sql="update bios_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        if(!$mysqli->errno){
            $mrk=1111;
            $tag[]=$tpr;
        }else{
            $mrk=1010;
            $tag[]=$tpr;
        }
        $mail_msg[]=$next_Owner;
        $mail_msg[]=$model;
        $mail_msg[]=$New_ver;
        $msg[]=$mrk;
        $msg[]=$tag;
        $msg[]=$mail_msg;
    }

    echo json_encode($msg);
 //   @$result->free();
    $mysqli->close();
    break;
                case 5:
                    $m=check_file($this_file);
                     if($m==0){
                         $mrk=1041;
                         $msg[]=$mrk;
                         echo json_encode($msg);
                     return ;
                     }
                     $path="../../BIOS_System_file/".$this_file."/";
                     if(!file_exists($path)){
                         echo '1047';
                         return ;
                     }
                     $resdir=opendir($path);
                     while(false!=($file=readdir($resdir))){
                         $path_t=$path.$file;
                         if($file!='.' AND $file!='..'){
                             $log_file=$path_t;
                         }
                     }
                     $file=fopen($log_file,"r");
                     $user=array();
                     $i=0;
                    
                     while(! feof($file))
                     {
                         $user[]= fgets($file);
                         
                     }
                     fclose($file);
                     $user=array_filter($user);
                     $preg='/BIOS Ver|BIOS ver/';
                     $ver=preg_grep($preg,$user);
                     //$preg='/Version|Revision|version/';
                     //$ver=preg_grep($preg,$ver);
                     $preg='/\=|\:/';
                     $ver=preg_grep($preg,$ver);
                     $preg='/[0-9]/';
                     $ver=preg_grep($preg,$ver);
                     $ver=array_merge($ver);
						//var_dump($ver[0].'BBB');
                     if (strpos($ver[0],"=")!==false){
                        $new_ver1 = explode("=",$ver[0]);
                        //echo '<pre>';
                        //var_dump($new_ver1);
                        $new_ver2 = trim($new_ver1[1]);
                        //echo $new_ver2;
                        $pattern = '/(?<=").*?(?=")/';
                        preg_match_all($pattern,$new_ver2, $new_ver3);
                        //echo (count($new_ver3[0]));
                        if( count($new_ver3[0]) ){
                            //echo 'a';
                            $new_ver = substr($new_ver2,1,strlen($new_ver2)-2);
                        }else{
                            //echo 'b';
                            $new_ver = $new_ver2;
                        }
                        //$tmp = trim($new_ver1);
                        //echo '<pre>';
                        //var_dump($new_ver3[0]);
                        //echo $new_ver3;

                        //echo $new_ver;
                     }else{
                          //echo '2';
						 //echo '2';
                         $new_ver1 = explode(":",$ver[0]);
                         //echo '<pre>';
                         //var_dump($new_ver1);
						 //echo $ver[0];
                         //echo '<pre>';
						 //var_dump($new_ver1);
                         $new_ver = $new_ver1[1];
						//echo $new_ver;
						//echo $New_sysver;
						
                     }
                     if(trim($new_ver) != trim($New_sysver)){
                         
						 $mrk="4404";
                         $msg[]=$mrk;
                         echo json_encode($msg);
                         return;
                     }
                    $this_status=Status($now_date,$this_bgtime_field,$val[0],$tpr);//yanshishiyan

                     $sql="select 2_Endtime from bios_system where Id='$val[0]' ";
                     $result=$mysqli->query($sql);
                     $nums=mysqli_num_rows($result);
                     $arr=array();
                     if ($nums!=0){
                         while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                             $arr[]=$row;
                         }
                     }
                     //echo $val[2];
                    if($val[2]=='IGS'){
                        $date_day=floor((strtotime(qgmdate('Y-m-d H:i:s', '', -5,$val[2],$now_date))-strtotime(qgmdate('Y-m-d H:i:s', '', -5,$val[2],$arr[0][0])))/86400);//86400
                        $weekarray = array('日','一','二','三','四','五','六');
                        $week = $weekarray[date('w',strtotime(qgmdate('Y-m-d H:i:s', '', -5,$val[2],$arr[0][0])))];
                        if($week == '四'){
                            $date_day = $date_day -1;
                        }else if ($week == '五' || $week == '六'){
                            $date_day -=2;

                        }
                    }else{
                        $date_day=floor((strtotime($now_date)-strtotime($arr[0][0]))/86400);


                    }
                    if($val[2]=='IGS'){
                         if($date_day>3){
                             $all_stuatus = 5;
                         }else{
                             $all_stuatus = 1;
                         }
                     }else {
                     if($date_day>6){//延时判断
                         $all_stuatus=5;
                     }else{
                         $all_stuatus=1;
                        }
                     }
                     //open rollback
                     $mysqli->autocommit(false);
                     //$sql="update bios_system set 5_Endtime='$now_date' where Id='$val[0]' ";
                     $sql="update bios_system set 5_Endtime='$now_date',$remark_field='$remark',$status_field='$this_status',6_Begingtime='$now_date',6_Status=1,6_Owner='$this_Owner',6_Checker='$this_Checker',6_Remark='$remark',6_Endtime='$now_date',Status='$all_stuatus',D_bgtime='$now_date' where Id='$val[0]' ";
                     $result=$mysqli->query($sql);
                     $nums=$mysqli->affected_rows;
					 if ($nums==1){

                         $sql="insert into model (Model,Oldver,Old_sysver) values ('$model','$New_ver','$New_sysver')";
                         $result=$mysqli->query($sql);
                         $ssql = "select 3_Endtime from bios_system where Id='$val[0]' ";
                         $sresult = $mysqli->query($ssql);
                         $snums=mysqli_num_rows($sresult);
                         $sarr = array();
                         if ($snums!=0){
                             while (($row = mysqli_fetch_array($sresult))!==false&&$row>0) {
                                 $sarr[]=$row;
                             }

                         }
                         $s3time = $sarr[0][0];
                         $tb_Matir="matrix_rlc_sh";
						 $sql='';
                         $sqla = '';
                         //$entry = 0;
                         if(strpos($model,'&')){ //判断是否包含符号

                             if(strpos($model,'_')){
                               // $entry = 1;
                                 $tarr = array();
                                 $st_model=explode("&",$model);//以符号切割字符串
                                 $tarr[0] = $st_model[1];
                                 $marr = explode("_",$st_model[0]);//判断切割后生成的数组第一个值是否包含特定符号
                                 $str=$marr[0];
                                 preg_match_all("/[a-zA-Z]{1}/",$str,$arrAl);
                                 $numal = count($arrAl[0]);//model中字母位数
                                 $almodel = substr($str,0,$numal);
                                 for($i=1;$i<count($marr);$i++){
                                     $marr[$i] = $almodel.$marr[$i];
                                 }
                                $st_model =  array_merge($tarr,$marr);
								// $sqla="update $tb_Matir set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$s3time',NewBios_Time='$now_date',lflag = 1 where Compal_name='$st_model[$i]' ";
                             }else{
                                  //  $entry = 2;
                                  $st_model=explode("&",$model);//以符号切割字符串
								  //$sqla="update $tb_Matir set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$s3time',NewBios_Time='$now_date',lflag = 1 where Compal_name='$st_model[$i]' ";
                             }
                             $sql="select BIOS_Ver from $tb_Matir where Compal_Name='$st_model[0]' ";
                             $result=$mysqli->query($sql);
                             $nums=mysqli_num_rows($result);
                             $arr=array();
                             if ($nums!=0){
                                 while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                                     $arr[]=$row;
                                 }

                             }
                             $old_model=$arr[0][0];

                         }else{
                             if(strpos($model,'_')){
                                 $st_model = explode("_",$model);
                                 $str = $st_model[0];
                                preg_match_all("/[a-zA-Z]{1}/",$str,$arrAl);
                                $numal = count($arrAl[0]);//model中字母位数
                                //echo $numal;
                                 $almodel = substr($str,0,$numal);
                                 for($i=1;$i<count($st_model);$i++){
                                     $st_model[$i] = $almodel.$st_model[$i];
                                 }
                                 $sql="select BIOS_Ver from $tb_Matir where Compal_Name='$st_model[0]' ";
                                 $result=$mysqli->query($sql);
                                $nums=mysqli_num_rows($result);
                                $arr=array();
                                if ($nums!=0){
                                    while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                                        $arr[]=$row;
                                    }

                                }
                                $old_model=$arr[0][0];
                                // die($sql);
                                

                                 
                             }else{
                                    $st_model = array();
                                   $st_model[0] = $model;
                                   $sql="select BIOS_Ver from $tb_Matir where Compal_Name='$st_model[0]' ";
                                   $result=$mysqli->query($sql);
                                   $nums=mysqli_num_rows($result);
                                   $arr=array();
                                   if ($nums!=0){
                                       while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                                           $arr[]=$row;
                                       }
   
                                   }
                                   $old_model=$arr[0][0];
								  // $sqla="update $tb_Matir set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$s3time',NewBios_Time='$now_date',lflag = 1 where Compal_name='$st_model' ";
                             }
                         }
                       
						 //die($sql);
                         
                         if ($new_ver!=$old_model){
                             $change=0;
                             if (strpos($old_model,'A')!==false){
                                 if ($old_model<$New_ver){
                                     $change=1;
                                 }
                             }else{
                                 if ($old_model<$New_sysver){
                                     $change=1;
                                 }
                             }
                             if ($change==1){
                                 //var_dump($st_model);
                                // die($st_model);
                                // var_dump($st_model);
                                 for($i=0;$i<count($st_model);$i++){
                                         //$k[]=$field_model[$x];
								        $sqla="update $tb_Matir set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$s3time',NewBios_Time='$now_date',lflag = 1 where Compal_name='$st_model[$i]' ";

                                        //$sqla = "update test set test='testing1112' where id=1 ";
                                       //  $sqlb="update matrix_example set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$now_date',NewBios_Time='$now_date' where Compal_name='$final_model' ";
                                         //die($sqla);
                                         //die($sqla);
										 $result=$mysqli->query($sqla);
                                         $numsa=$mysqli->affected_rows;
                                         if($numsa>0){
                                             $t[]=1;
                                             $mrk="1011";
                                             $mysqli->commit();
                                         }else{
                                            
                                             $mrk="10101";
                                             $mysqli->rollback();
                                         }

                                 }
                         }else{
                             $t[]=1;
                             $mrk="1011";
                             $mysqli->commit();
                         }
                         }else{
                             $t[]=1;
                             $mrk="1011";
                             $mysqli->commit();
                         }
                     }else{
                         $mrk="10102";
                         $mysqli->rollback();
                     }
                    
                     $tag=$tpr;
                     $mail_msg[]=$this_Owner;
                     $mail_msg[]=$model;
					 $mail_msg[]=$New_ver;

                     $msg[]=$mrk;
                     $msg[]=$tag;
                     $msg[]=$mail_msg;
                     echo json_encode($msg);
                     //@$result->free();
                     $mysqli->close();
                     break;
            }
        }

        break;
    case 'Upload_file':
        $tpr=$_POST['tpr'];
        $step=$_POST['step'];
        $file=$_FILES['file'];
        $Id=$_POST['Id'];

        /*
        $status_field=$step."_Status";

        $sql="select $status_field from bios_system where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $status=$row[$status_field];
            }
        }

        if($status==1||$status==5){
            echo '1130';
            return;
        }
        */
        $bios_file = strtoupper ( md5 ( uniqid ( rand (), true ) ) );

        $path="../../BIOS_System_file/".$bios_file."/";
        if(!mkdir($path)){
            echo '1140';
            return;
        }
//        if(!(($tpr=="CGS"&&$step==2)||($tpr!="CGS"&&$step==5))){
//            echo '1020';
//            return ;
//        }
        $this_file_field=$step."_file";
        if(move_uploaded_file($file['tmp_name'],$path.$file['name'])){
            $sql="select $this_file_field from bios_system where Id='$Id' and LENGTH($this_file_field)>25";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            if ($nums==0){
                $sql="update bios_system set $this_file_field='$bios_file' where Id='$Id' ";
                $result=$mysqli->query($sql);
                if(!$mysqli->errno){
                    $msg=1;
                }else{
                    $msg=0;
                }
            }else{
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $del_file=$row[$this_file_field];
                }
                del_sopfile($del_file);
                $sql="update bios_system set $this_file_field='$bios_file' where Id='$Id' ";
                $result=$mysqli->query($sql);
                if(!$mysqli->errno){
                    $msg=1;
                }else{
                    $msg=0;
                }
            }

        }else{
            $msg=0;
        }
        echo json_encode($msg);
        //@$result->free();
        $mysqli->close();
        break;
    case 'Send_mail':
        $mrk=$_POST['mrk'];
        $tpr=$_POST['tpr'];
        $msg=$_POST['msg'];
        switch ($mrk){
            case 'cr':
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){
                        if ($arr[$x]['name']==$msg[0]){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //$title=" WWW Repair Center BIOS Control System";
                    $title=" WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." New_version:".$msg[2]." need you trail run and upload BIOS program <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                }
				//die($text);
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 'c':
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){
                        if ($arr[$x]['name']==$msg[0]){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    $title=" WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." New_version:".$msg[2]." need you pay more action<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                }
				//die($text);
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 'f':
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){
                        if ($arr[$x]['name']==$msg[0]){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    $title="  WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." New_version:".$msg[2]." need you trail run and upload BIOS program<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                }
				//die($text);
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 'cf'://cgs step 3 close
               // $tpr[]="CGS";
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr like '%$tpr[$i]' and spmaflag=1 ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $sql="select username from h4_aduit where steps=3 and tpr='$tpr[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    //$Owner=null;
                    if ($nums!=0){
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $Owner=$row['username'];
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){
                        if ($arr[$x]['name']==$Owner){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //$mailer[]=$arr_to;
                    $title=" WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi Repair Center:<br/>
	".$tpr[$i]." ".$msg[1]." New_version:".$msg[2]." need you infrom engineer team to do it<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                    $mg=sendmail($arr_to,$title,$text);
					
                }
				//die($text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 'tf':
                //$tpr_arr[]=$tpr;
                //$tpr[]="CGS";
               // for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $sql="select username from h4_aduit where steps=5 and tpr='$tpr' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    //$Owner=null;
                    if ($nums!=0){
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $Owner=$row['username'];
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){
                        if ($arr[$x]['name']==$Owner){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }

                    //$mailer[]=$arr_to;
                    $title=" WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'> Hi ALL:<br/>
	".$tpr." ".$msg[1]." New_version:".$msg[2]." update successful<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                    $mg=sendmail($arr_to,$title,$text);
                //}
				//die($text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
			case 'mb':
               //$tpr_arr[]=$tpr;
               //$tpr[]="CGS";
               // for($i=0;$i<count($tpr);$i++){
               $sql="select name,mail from mail where tpr='$tpr' and spmaflag=1 ";
               $result=$mysqli->query($sql);
               $nums=mysqli_num_rows($result);
               if ($nums!=0){
                   $arr=array();
                   while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                       $arr[]=$row;
                   }
               }
              
               $arr_to=array();
               for($x=0;$x<count($arr);$x++){
                  
                       $arr_to[]=$arr[$x];
               }

               //$mailer[]=$arr_to;
               $title="  WWW Repair Center BIOS Control System";
               //$title="WWW Repair Center BIOS Control System";
               $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
".$tpr[0]." ".$msg[0]." New_version:".$msg[1]." is closed by system automatically because of 【".$msg[2]."】.<br/>
*Please login TPR ManageMent System(https://www.compal.top/Report/web/BIOS_System/Show.php) for details.<br/>
*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
               $mg=sendmail($arr_to,$title,$text);
               //}
			  // die($text);
               echo json_encode($mg);
               //  @$result->free();
               $mysqli->close();
               break;
        }
        break;
}
function del_sopfile($eco_file){
    $path="../../BIOS_System_file/".$eco_file."/";
    if(is_dir($path)){
        $p = scandir($path);
        foreach($p as $val){
            //???賊???璊漆?迄嚚蝠?啣?璇粹?嚙賜?撖詨??扳?????瞉嗅?⊿璅潛??箏掃蝘寞縑?賣???掉蝝?雿豢憿蝎什???箏?????輻憪斗?憍????梢?抵‘???憭Ⅱ????瘞剜?憿?????舫瑽箏延?遴?憿典瑽摮玫?豢撘嗥??蝸?抒遙??怒?仿憭?蝏嗥?儮 憓唳中? ??瘣芸捶瞈?????祈???瞈???嚙賡?雿箇盔?釆鈭詨??剜??寞憪日?甈??湔?嚙賣嚙賣偏? .???賊???璊漆??瘞暹璆?菟?撊?憿鈭圈?雿孵祐蝏餃??憿?銝中?怠??????莎蕭?哨蕭瘞暹..
            if($val !="." && $val !=".."){
                unlink($path.$val);
                //???賊????????蝥曉?????拍?颯?蝞?撊換??瑹??雿孵?憿典?撘駁???潛硃嚙質???楔?瑕陸????寥???? 撏寥????蝶???????抒盔?文??噤????日璆??嚗??Ⅰ?典?憒湔童蝟?瞈∵?蝎?敶?????典蝻蕭???賊???璊漆??瘞暹璆?菟??餅????雿箇盔??撏?嚙賡?渡????菟?? 賊??〩????萄阮?梢??撉?撟童?唬滷??遙?舀???啣坐?儘靽???蛔?瑕祚?桀??租?寞??萄?憡槽粹??批?恭??箏??器??? 菜耨璈?摰?嚙賣挪?＃?賢憤?曄??蝣勗蝏勗?蝜??格??踵????～??鈭??啁蝏粹?撘冽?戭怎??寥?遝???儭賢??箏掛?舀縑?朵???菜縑?芸 迆敹????阡????蝜?菜?璊文???蝏??箝???拍?蝏?株?瘨?輻?? 
                @rmdir($path);
            }
        }
    }
}
function sendmail($arr,$title,$text){
    require_once '../../Tool/phpmail/PHPMailer.php';
    require_once '../../Tool/phpmail/SMTP.php';
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP();
    //$mail->Host = "smtp.ym.163.com";
    $mail->Host = "localhost";
    $mail->SMTPAuth = true;
    //閸欐垿锟戒線鍋栫粻杈閹达拷
    $mail->Username = "compaltpr@compal.top";
    $mail->Password = "XUDELIN8800275";
    $mail->Port = 25;
    $mail->setFrom('compaltpr@compal.top', 'compaltpr@compal.top');//send mailer
    //$mail->setFrom('compaltpr@compaltpr.com', 'compaltpr@compaltpr.com');//send mailer
    for ($i=0;$i<count($arr);$i++){
        $email=$arr[$i]['mail'];
        $ename=$arr[$i]['name'];
        if($i==0){
            $mail->AddAddress("$email", "$ename");
        }else{
            $mail->AddCC("$email", "$ename");
        }
    }
    $mail->IsHTML(true);
    $mail->Subject = $title;
    $mail->Body = $text;
    //include '../db/close_db.php';
    if (!$mail->Send()) {
        //return "440: " . $mail->ErrorInfo;
        return '0';
        exit;
    }else{
        return '1';
    }
}
?>