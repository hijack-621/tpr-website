<?php 
session_start();
$flag=$_POST['flag'];
if (empty($_SESSION["uname"])){
    echo "10000";
    return;
}
$flag=$_POST['flag'];
$mysqli=null;
include '../../server/db/new_link_db.php';
if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}

switch ($flag){
    case 'sh_model':
        //select model
    	$sql="SELECT Model,Oldver,Old_sysver FROM (SELECT Model,Oldver,Old_sysver FROM model ORDER BY Oldver DESC) a GROUP BY a.model";
    	$result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $model=array();
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            	$model[]=$row['Model'].'-'.$row['Oldver'].'-'.$row['Old_sysver'];
            }
        }
        echo json_encode($model);
        break;
    case 'sh_all':
        if($_SESSION["utpr"]=='CGS'){
            $sql="select * from eco_system ";
            $result=$mysqli->query($sql);
        }else{
            $tpr=$_SESSION["utpr"];
            $sql="select * from eco_system where TPR='$tpr' ";
            $result=$mysqli->query($sql);
        }
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
            }
        }
        echo json_encode($arr);
        break;
    case 'step':
        $dataid=$_POST['dataid'];
        $sql="select * from eco_system where Id='$dataid' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        break;
    case 'path_edit':
        $id=$_POST['dataid'][0];
        $step=$_POST['dataid'][1];
        $file_id=$step."_file";
        $sql="select file_name from npi_file where npi_id in (select $file_id from eco_system where Id='$id')";
        //$sql="select ";
        $arr=getSqlData($sql);
        $msg=array();
        if($arr[0]!=null){
            for($i=0;$i<count($arr);$i++){
                if($arr[$i][0]!=null){
                    $path="../../ECO_System_file/".$arr[$i][0];
                    if(is_dir($path)){
                        $p = scandir($path);
                        foreach($p as $val){
                            if($val !="." && $val !=".."){
                                //$file[]=$path."/".$val;
                                $file_path=array();
                                $file_path[]=$arr[$i][0];
                                $file_path[]=$path."/".$val;
                                $file_path[]=$val;
                                $msg[]=$file_path;
                            }
                        }
                    }
                }
            }
        }
        //echo json_encode($file);
        //$path_id=$arr[0][$step.'_file'];
        echo json_encode($msg);
        break;
    case 'add_file':
        $file=$_FILES['file'];
        $id=$_POST['id'];
        $step=$_POST['step'];
        $file_field=$step."_file";
        $sql="select $file_field from eco_system where id='$id' ";
        $arr=getSqlData($sql);
        if($arr[0][0]==null){
            $npi_id = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
            $sql="update eco_system set $file_field='$npi_id' where Id='$id' ";
            $nums=getSqlRow($sql);
            if ($nums<=0){
                echo 10103;
                return;
            }
        }else{
            $npi_id =$arr[0][0];
        }

        $file_name = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
        $path="../../ECO_System_file/".$file_name."/";

        if(!mkdir($path)){
            echo '1140';
            return;
        }
        if(move_uploaded_file($file['tmp_name'],$path.$file['name'])){
            $sql="insert into npi_file (file_name,npi_id) values ('$file_name','$npi_id')";
            $result=$mysqli->query($sql);
            $nums=$mysqli->affected_rows;
            if ($nums>0){
                echo 1111;
            }else{
                del_1_file($file_name);
                echo 10101;
            }
        }else{
            echo 10102;
        }
        //echo json_encode($file);
        break;
    case 'del_file':
        $file_name=$_POST['dataid'];
        $sql="delete from npi_file where file_name='$file_name' ";
        $result=$mysqli->query($sql);
        $nums=$mysqli->affected_rows;
        if($nums>0){
            del_1_file($file_name);
            echo 1111;
        }else{
            echo 1010;
        }
        break;
    case 'sh_data':
        //$result=mysqli_query($connID,"select Sort,Model,Station,Old_ver,New_ver,Reason,TPR,1_Bgingtime,5_endtime from eco_system ");
        if($_SESSION["utpr"]=='CGS'){
            $sql="select * from eco_system where 5_Status<>1 or 5_Status is NULL ";
            $result=$mysqli->query($sql);
        }else{
            $tpr=$_SESSION["utpr"];
            $sql="select * from eco_system where 5_Status<>1 or 5_Status is NULL and TPR='$tpr' ";
            $result=$mysqli->query($sql);
        }
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
            }
        }
        echo json_encode($arr);
        break;
    case 'del_data':
        $Id=$_POST['id'];
        if($_SESSION["uname"]!='rock'){
            echo '1020';
            return;
        }
        //$mysqli->autocommit(false);
        $sql="select 1_file,4_file from eco_system where Id='$Id' ";
        $arr=getSqlData($sql);
        $file_arr=array();
        if($arr[0]['1_file']!=null){
            $sop_file=$arr[0]['1_file'];
            $sql="select Id from eco_system where 1_file='$sop_file' and Id<>'$Id' ";
            $nums=getSqlRow($sql);
            if($nums==0){
                //del file and file_data
                $sql="select file_name from npi_file where npi_id='$sop_file' ";
                $file_name[]=getSqlData($sql);
                for ($x=0;$x<count($file_name[0]);$x++){
                    del_1_file($file_name[0][$x][0]);
                }
                $sql="delete from npi_file where npi_id='$sop_file'";
                $nums=getSqlRow($sql);
                if ($nums<=0){
                    echo 'del error';
                    return;
                }
            }

            if($arr[0]['4_file']!=null){
                $file_arr[]=$arr[0]['4_file'];
                del_1_file($arr[0]['4_file']);
            }
            
        }

        $sql="delete from npi_filepath where id='$Id' ";
        $mysqli->query($sql);

        $sql="delete from eco_system where Id='$Id' ";
        $nums=getSqlRow($sql);
        if($nums>0){
            echo 1;
        }else{
            echo 0;
        }
        //$mysqli->rollback();
        @$result->free();
        $mysqli->close();
        break;
    case 'Edit':
        $val=$_POST['dataid'];
        $Owner=$val[1].'_Owner';
        $Checker=$val[1].'_Checker';
        $ck_date=$val[1].'_ck_date';
        $score=$val[1].'_score';
        $ck_mark=$val[1].'_ck_mark';
        $day=$val[1].'_ck_day';
        $Remark=$val[1].'_remark';
        $sql="select $Owner,$Checker,Sort,TPR,Station,Old_ver,New_ver,$Remark,$ck_date,$score,$ck_mark,$day from eco_system where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        break;
    case 'Edit_Owner':
        function check_finish($status_field,$val){
            global $mysqli;
            $sql="select  $status_field from eco_system where Id='$val[0]' ";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                $status_arr=array();
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $status_arr[]=$row;
                }
            }
                return $status_arr[0][$status_field];
        }

        function Status($nowtime,$this_bgtime_field,$Id){
            global $mysqli;
            $sql="select $this_bgtime_field from eco_system where Id='$Id' ";
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            
            $arr=array();
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            $date_day=floor((strtotime($nowtime)-strtotime($arr[0][0]))/3600);
            if($date_day>5){
                return 5;
            }else{
                return 1;
            }
        }
        
        $val=$_POST['dataid'];
        $remark=$_POST['remark'];
        $now_date=date('Y-m-d H:i:s');
        $status=$_POST['status'];
        if($val[1]!=6){
        $next_step=$val[1]+1;

        $sql="select Owner,Checker from npi_owner where steps='$next_step' and  tpr='$val[2]' ";
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
            return ;
        }
        }
        $this_owner_field=$val[1].'_Owner';
        $this_checker_field=$val[1].'_Checker';
        $remark_field=$val[1].'_remark';
        $status_field=$val[1].'_Status';
        $edtime_field=$val[1].'_Endtime';
        $this_bgtime_field=$val[1].'_Begingtime';
        
        $file_field=$val[1].'_file';
        
        //echo json_encode($remark_field.'++'.$status_field.'++'.$edtime_field.'++'.$bgtime_field.'++'.$next_owner_field.'++'.$next_checker_field);
        $sql="select TPR,$this_owner_field,$this_checker_field,$this_bgtime_field,$file_field from eco_system where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $hand_arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $hand_arr[]=$row;
            }
        }
        $tpr=$hand_arr[0]['TPR'];
        $this_Owner=$hand_arr[0][$this_owner_field];
        $this_Checker=$hand_arr[0][$this_checker_field];
        $this_bgtime=$hand_arr[0][$this_bgtime_field];
        $this_file=$hand_arr[0][$file_field];
        //is checker and owner
        if($_SESSION["uname"]!=$this_Owner&&$_SESSION["utpr"]!="CGS"){
            $time[]='is not Owner';
            $msg[]=$time;
            echo json_encode($msg);
            return ;
        }
        //is finish
        $m=check_finish($status_field,$val);
        if($m == 1){
            $time[]='already finish';
            $msg[]=$time;
            echo json_encode($msg);
            return ;
        }
        //continue;
        if($status==0){
            $sql="update eco_system set $remark_field='$remark' where Id='$val[0]' ";
            $result=$mysqli->query($sql);
            if($result==1){
                $time[]='111';
                $send_mail[]=$tpr;
                
            }else{
                $time[]='fail change';
                $send_mail[]=$tpr;
            }
            $send_mail[]=$tpr;
            $msg[]=$time;
            $msg[]=$send_mail;
            $msg[]=$next_Owner;
            echo json_encode($msg);
            return;
        }
        
        switch ($val[1]){
            
            case 2:
                    $this_status=Status($now_date,$this_bgtime_field,$val[0]);
                    $sql="update eco_system set $remark_field='$remark',$status_field=$this_status,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0 where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    if($result==1){
                        $time[]='1111';
                        $send_mail[]=$tpr;
                    }else{
                      
                        $time[]='fail finish';
                        $send_mail[]=$tpr;
                    }
                
                $msg[]=$time;
                $msg[]=$send_mail;
                $msg[]=$next_Owner;
                echo json_encode($msg);
                break;
            case 3:
                    $this_status=Status($now_date,$this_bgtime_field,$val[0]);
                    $sql="update eco_system set $remark_field='$remark',$status_field=$this_status,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0 where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    //$result=mysqli_query($connID,"update eco_system set $remark_field='$remark',$status_field=1,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0  where Id='$val[0]' ");
                    if($result==1){
                        
                        $time[]='1111';
                        $send_mail[]=$tpr;
                    }else{
                        
                        $time[]='fail finish';
                        $send_mail[]=$tpr;
                    }
                
                $msg[]=$time;
                $msg[]=$send_mail;
                $msg[]=$next_Owner;
                echo json_encode($msg);
                break;
            case 4:
                    if ($this_file==null||$this_file==""){
                        $time[]='no file upload';
                        $msg[]=$time;
                        echo json_encode($msg);
                        return;
                    }
                    $this_status=Status($now_date,$this_bgtime_field,$val[0]);
                    $sql="update eco_system set $remark_field='$remark',$status_field=$this_status,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0 where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    //$result=mysqli_query($connID,"update eco_system set $remark_field='$remark',$status_field=1,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0  where Id='$val[0]' ");
                    if($result==1){
                        $time[]='1111';
                        $send_mail[]=$tpr;
                    }else{
                        $time[]='fail finish';
                        $send_mail[]=$tpr;
                    }
                $msg[]=$time;
                $msg[]=$send_mail;
                $msg[]=$next_Owner;
                echo json_encode($msg);
                break;
            case 5:
                $this_status=Status($now_date,$this_bgtime_field,$val[0]);
                $sql="update eco_system set $remark_field='$remark',$status_field=$this_status,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0 where Id='$val[0]' ";
                $result=$mysqli->query($sql);
                if($result==1){
                    $time[]='1111';
                    $send_mail[]=$tpr;
                }else{
                    $time[]='fail finish';
                    $send_mail[]=$tpr;
                }
                $msg[]=$time;
                $msg[]=$send_mail;
                $msg[]=$next_Owner;
                echo json_encode($msg);
                break;
            case 6:
                    $this_status=Status($now_date,$this_bgtime_field,$val[0]);
                    //$mysqli->autocommit(false);
                    $sql="update eco_system set $remark_field='$remark',$status_field=$this_status,$edtime_field='$now_date',Status=1 where Id='$val[0]' ";
                    $result=$mysqli->query($sql);
                    //$result=mysqli_query($connID,"update eco_system set $remark_field='$remark',$status_field=1,$edtime_field='$now_date',$bgtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$next_status_field=0  where Id='$val[0]' ");
                    if($result==1){
                        $sql="select Old_ver,New_ver from eco_system where Id='$val[0]' ";
                        $result=$mysqli->query($sql);
                        $nums=mysqli_num_rows($result);
                        if ($nums!=0){
                        	$arr=array();
                        	while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        		$arr[]=$row;
                        	}
                        }
                        $old_char=$arr[0]['Old_ver'];
                        $new_char=$arr[0]['New_ver'];
                        if($old_char!=$new_char){
                        	$model_arr=explode(',',$new_char);
                        	for($i=0;$i<count($model_arr);$i++){
                        		$up_model=explode('-',$model_arr[$i])[0];
                        		$up_ver=explode('-',$model_arr[$i])[1];
                        		$up_sys=explode('-',$model_arr[$i])[2];
                        		$sql="insert into model (Model,Oldver,Oldsysver) values ('$up_model','$up_ver','$up_sys')";
                        		$mysqli->query($sql);
                        	}
                        }
                        //$mysqli->rollback();
                        $time[]='1111';
                        $send_mail[]=$tpr;
                    }else{
                        
                        $time[]='fail finish';
                        $send_mail[]=$tpr;
                    }
                
                $msg[]=$time;
                $msg[]=$send_mail;
                $msg[]=$this_Owner;
                echo json_encode($msg);
                break;
        }
        break;
    case 'Edit_score':
        $dataid=$_POST['dataid'];
        $score=$_POST['score'];
        $remark=$_POST['days'];
        $date=date('Y-m-d H:i:s');
        
        echo json_encode($date);
        break;
    case 'send_mail':
        $step=$_POST['step'];
        switch ($step){
            case 'create':
                $tpr_arr=$_POST['tpr'];
                $owner=$_POST['owner'];
                for($i=0;$i<count($tpr_arr);$i++){
                    $sql="select  name,mail from _mail where tpr='$tpr_arr[$i]' ";
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
                        if ($arr[$x]['name']==$owner){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //send mail
                    $title="this is test mail title (create)";
                    $text="this is test text";
                    //$msg[]=sendmail($arr,$title,$text);
                    //echo json_encode($arr);
                }
                
                $msg=sendmail($arr_to,$title,$text);
                echo json_encode($msg);
                break;
            case 'continue':
                $tpr_arr=$_POST['tpr'];
                $owner=$_POST['owner'];
                for($i=0;$i<count($tpr_arr);$i++){
                    $sql="select  name,mail from _mail where tpr='$tpr_arr[$i]' ";
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
                        if ($arr[$x]['name']==$owner){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //send mail
                    $title="this is test mail title";
                    $text="this is test text";
                }
                
                $msg=sendmail($arr_to,$title,$text);
                echo json_encode($msg);
                break;
            case 'finish':
                $tpr_arr=$_POST['tpr'];
                $owner=$_POST['owner'];
                for($i=0;$i<count($tpr_arr);$i++){
                    $sql="select  name,mail from _mail where tpr='$tpr_arr[$i]' ";
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
                        if ($arr[$x]['name']==$owner){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //send mail
                    $title="this is test mail title";
                    $text="this is test text";
                }
                
                $msg=sendmail($arr_to,$title,$text);
                echo json_encode($msg);
                break;
        }
        break;
    case 'create':
    	$model_json=$_POST['model_json'];
    	//$model_arr = get_object_vars($model_obj);
    	
    	//foreach ($model_arr as $num=>$name){
    	//	echo json_encode($num.'--'.$name);
    	//}
    	$model_obj=json_decode($model_json);
    	$model_arr=$model_obj->AAE00;
    	foreach ($model_obj as $key=>$value){
    		
    	}
    	//echo json_encode($model_arr);
    	//echo json_decode($model_obj[]);
    	return;
        $now_time=@date('Y-m-d H:i:s');
        $up=$_POST['up'];
        $station=$_POST['station'];
        $old_ver=$_POST['old_ver'];
        $reason=$_POST['reason'];
        $path=$_POST['path'];
        $npi_path=$_POST['npipath'];
        $new_ver=$_POST['new_ver'];
        $st_arr=$_POST['st_group'];

        $st_group=explode(",",$st_arr);
        //echo json_encode($st_group);
        $npi_id= strtoupper ( md5 ( uniqid ( rand (), true ) ) );
        
        $checkdata=$_POST['checkdata'];
        $tpr_arr=explode(',',$checkdata);
        $k=array();
        $upfile=0;
        for ($x=0;$x<count($tpr_arr);$x++){

            $sql="select Owner,Checker from npi_owner where tpr='$up' and steps=1";
            $arr=array();
            $arr=getSqlData($sql);
            $this_Owner=$arr[0]['Owner'];
            $this_Checker=$arr[0]['Checker'];

            $tpr=$tpr_arr[$x];
            $sql="select Owner,Checker from npi_owner where tpr='$tpr' and steps=2 ";
            $arr=array();
            $arr=getSqlData($sql);
            $next_Owner=$arr[0]['Owner'];
            $next_Checker=$arr[0]['Checker'];

            $charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
            $k[]=$charid;
            $sql="insert into eco_system (Id,Sort,Station,npi_path,Ftp_path,TPR,1_file,Old_ver,Reason,New_ver,1_Begingtime,1_Owner,1_Checker,1_Status,1_Endtime,2_Begingtime,2_Owner,2_Checker,2_Status)
            values ('$charid','$up','$station','$npi_path','$path','$tpr','$npi_id','$old_ver','$reason','$new_ver','$now_time','$this_Owner','$this_Checker',1,'$now_time','$now_time','$next_Owner','$next_Checker',0) ";
            $result=$mysqli->query($sql);
            if ($result==1){
            	for($z=0;$z<count($st_group);$z++){
            		$sa=explode("_",$st_group[$z])[0];
            		$path=explode("_",$st_group[$z])[1];
            		$sql="insert into npi_filepath (id,station,path) values ('$charid','$sa','$path')";
            		echo $sql;
            		$result=$mysqli->query($sql);
            	}
            	for ($c=0;$c<count($_FILES);$c++){
                    $sopfolder = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
                    $path="../../ECO_System_file/".$sopfolder."/";
                    if(mkdir($path)){
                        if(move_uploaded_file($_FILES['file'.$c]['tmp_name'],$path.$_FILES['file'.$c]['name'])){
                            $sql="insert into npi_file (file_name,npi_id) values ('$sopfolder','$npi_id')";
                            $result=$mysqli->query($sql);
                            $upfile=1;
                        }
                    }
                }
                $time[]=1;
                $send_mail[]=$tpr;
            }else{
                $time[]=0;
            }
        }
        $msg[]=$time;
        $msg[]=$send_mail;
        $msg[]=$upfile;
        $msg[]=$next_Owner;
        
        echo json_encode($msg);
        break;
    case 'sop_load':
    	$Id=$_POST['dataid'];
    	$sql="select * from npi_filepath where id='$Id' ";
    	$result=$mysqli->query($sql);
    	$arr=array();
    	$nums=mysqli_num_rows($result);
    	if ($nums!=0){
    		while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
    			$arr[]=$row;
    		}
    	}
    	echo json_encode($arr);
    	break;
    case 'sure_add':
    	$Id=$_POST['dataid'];
    	$arr=$_POST['arr'];
    	$sql="insert into npi_filepath (id,station,path) values ('$Id','$arr[1]','$arr[2]')";
    	if ($mysqli->query($sql)){
    		echo "ok";
    	}else{
    		echo "fail";
    	}
    	break;
    case 'edit_npi':
    	$Id=$_POST['dataid'];
    	$arr=$_POST['arr'];
    	$sql="update npi_filepath set station='$arr[0]',path='$arr[1]' where id='$Id' and station='$arr[0]' ";
    	if ($mysqli->query($sql)){
    		echo json_encode("ok");
    	}else{
    		echo json_encode("fail");
    	}
    	break;
    case 'delete_npi':
    	$Id=$_POST['dataid'];
    	$station=$_POST['station'];
    	$sql="delete from npi_filepath where id='$Id' and station='$station' ";
    	if ($mysqli->query($sql)){
    		echo json_encode("ok");
    	}else{
    		echo json_encode("fail");
    	}
    	break;
    case 'show_upload':
        $checkarr=$_POST['checkarr'];
        $Id_arr=explode(",",$checkarr);
        $file=$_FILES['file'];
        $sopfolder = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
        $path="../../ECO_System_file/".$sopfolder."/";
        $stage=$_POST['stage'];
        if($stage==1){
            $sopfields="1_file";
        }else{
            $sopfields=$stage."_file";
        }
        if(mkdir($path)){
            if(!move_uploaded_file($_FILES['file']['tmp_name'],$path.$_FILES['file']['name'])){
                echo '1009';
                return false;
            }
        }
        for ($i=0;$i<count($Id_arr);$i++){
        $sql="select $sopfields from eco_system where Id='$Id_arr[$i]' and LENGTH($sopfields)>25 ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        //1_file is null
        if($nums==0){
             $sql="update eco_system set $sopfields='$sopfolder' where Id='$Id_arr[$i]' ";
             //$ps_file=$mysqli->query($sql);
             if($mysqli->query($sql)){
                 $msg[]=1;
             }else{
                 $msg[]=0;
                 del_1_file($sopfolder);
             }
         }else{
             //$nums=mysqli_num_rows($result);
                 while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                     $sop=$row[$sopfields];
                 }
             $sql="select * from eco_system where Id<>'$Id_arr[$i]' and $sopfields='$sop' ";
             $result=$mysqli->query($sql);
             $nums=mysqli_num_rows($result);
             //1_file is only one
             if($nums==0){
                 //delete $sop file
                 del_1_file($sop);
                 $sql="update eco_system set $sopfields='$sopfolder' where Id='$Id_arr[$i]' ";
                 $result=$mysqli->query($sql);
                 if($result==1){
                     $msg[]=1;
                 }else{
                     $msg[]=0;
                 }
             }else{
                 //1_file 
                 $sql="update eco_system set $sopfields='$sopfolder' where Id='$Id_arr[$i]' ";
                 $result=$mysqli->query($sql);
                 if($result==1){
                     $msg[]=1;
                 }else{
                     $msg[]=0;
                 }
             }
         }
        }
         
         echo json_encode($msg);
        break;
}
function del_1_file($sop){
    $path="../../ECO_System_file/".$sop."/";
    if(is_dir($path)){
    $p = scandir($path);
    foreach($p as $val){
        if($val !="." && $val !=".."){
            unlink($path.$val);
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
    $mail->Host = "smtp.163.com";
    $mail->SMTPAuth = true;

    $mail->Username = "13771992334@163.com";
    $mail->Password = "qaz123456";

    $mail->Port = 25;
    $mail->From = "13771992334@163.com";


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
        return '0000';
        exit;
    }else{
        return '1111';
    }
}
function getSqlData($sql){
    global $mysqli;
    $result=$mysqli->query($sql);
    $arr=array();
    $nums=mysqli_num_rows($result);
    if ($nums!=0){
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $arr[]=$row;
        }
        return $arr;
    }else{
        return 0;
    }
}
function getSqlRow($sql){
    global $mysqli;
    $mysqli->query($sql);
    $nums=$mysqli->affected_rows;
    return $nums;
}
?>