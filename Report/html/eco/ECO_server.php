<?php
session_start();
$flag=$_POST['flag'];
//global $tpr_arr;//定义全局变量
//$tpr_arr = array();
//$GLOBALS['tpr_arr'];
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
    case 'sh_eco':
        $model=$_POST['contmodel'];
        $cmodel = array();
        
        $arr=array();
        for($i=0;$i<count($model);$i++){
            $sql="select Model ,eco,itime from sneco where Model='$model[$i]' order by itime desc limit 1 ";
            //die($sql);
            //die($sql);
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);

            if ($nums!=0){

                while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            array_push($cmodel,$model[$i]);

        }
        //var_dump($cmodel);
        @$result->free();
        $mysqli->close();
        echo json_encode($arr);
        break;
    case 'sh_dmname':
        $model=$_POST['contmodel'];
        //var_dump($model);
        $carr=array();
        for($i = 0;$i< count($model);$i++){
            $sql="select distinct DMname from model where Model='$model[$i]' ";
            //die($sql);
            $arr = array();
            $result=$mysqli->query($sql);
            $nums=mysqli_num_rows($result);

            if ($nums!=0){

                while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            array_push($carr,$arr[0][0]);
        }
        //echo $arr;
        @$result->free();
        $mysqli->close();
        echo json_encode($carr);

        break;

    case 'Create':
        $data=$_POST['obj_pro'];
        $activity=$data['descript'];
        $model=$data['model'];
        $smodel = implode(',',$model);
        //echo $smodel;
        $new_comp=$data['newcomp'];//以上是前台传过来的数据
		$flag = $data['fhw'];
		$tpm = $_POST['tpm'];
        //echo $new_comp;
        //$addtpr = $data['checkdata'];
        //echo $addtpr;
        //$tpr_arr=explode(',',$data['checkdata']);//hijack
        //$GLOBALS['tprst'] = $GLOBALS['tpr_arr'];
        //创建之前先判断数据库是否存在相同的eco事件
        //echo json_encode($activity.$model.$new_ver);
        //return;
        $sql="select * from eco_system where Model='$smodel' and Activity='$activity' and New_comp='$new_comp' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if($nums!=0){
            $mrk=1043;
            $msg[]=$mrk;
            echo json_encode($msg);
            return;
                }
        $Id = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
        $tpr_arr=explode(',',$data['checkdata']);//hijack
        //echo count($tpr_arr);
        //        //select sql model is true
        //echo '<pre>';
        //var_dump($tpr_arr);
        //$GLOBALS = $tpr_arr;
        //var_dump($GLOBALS);
        //cgs 单独逻辑
        $sql="select * from h4_aduit where (steps=1 or steps=3) and TPR='CGS' ";//前两步操作人为cgs（RMA）的 QA,括号不加，sql语句就是另一个意思了
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                $arr[]=$row;
            }

        }
        $sqlcr = "select * from h4_aduit where (steps=1 or steps=3) and TPR='CGS'";
        //bookst1
        $Owner_1=$arr[0]["Owner"];
        $Check_1=$arr[0]["Checker"];
        $Owner_2=$arr[1]["Owner"];
        $Check_2=$arr[1]["Checker"];

        $model=$data['model'];
        $Activity=$data['descript'];
        //$TPRS=$data['checkdata'];
        //echo $TPRS.'???';//勾选的tpr
        $Eco=$data['econo'];

        $New_comp=$data['newcomp'];
      
        $Now_time=date('Y-m-d H:i:s');
		  for($i=0;$i < count($tpr_arr);$i++){
            $Id = strtoupper(md5(uniqid(rand(),true)));
            if($tpm==''){
                $tsql="insert into eco_system (Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Owner,1_Checker,1_Endtime,1_Remark,1_Status,2_Begingtime,2_Owner,2_Checker,2_Status,D_bgtime,flag,tpm) values
            ('$Id','$smodel','$Activity','$tpr_arr[$i]','$tpr_arr[$i]','$Eco','$New_comp','$Now_time','$Owner_1','$Check_1','$Now_time','ok',1,'$Now_time','$Owner_2','$Check_2',0,'$Now_time','$flag',null )";
            }else{
                $tsql="insert into eco_system (Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Owner,1_Checker,1_Endtime,1_Remark,1_Status,2_Begingtime,2_Owner,2_Checker,2_Status,D_bgtime,flag,tpm) values
            ('$Id','$smodel','$Activity','$tpr_arr[$i]','$tpr_arr[$i]','$Eco','$New_comp','$Now_time','$Owner_1','$Check_1','$Now_time','ok',1,'$Now_time','$Owner_2','$Check_2',0,'$Now_time','$flag','$tpm')";
            }
			$sql = $tsql;
			$result=$mysqli->query($sql);
        }
      
         

        if(!$mysqli->errno){
            $mrk=1111;
        }else{
            $mrk=1040;
        }
        $mail_msg[]=$Owner_2;
        $mail_msg[]=$model;
		$mail_msg[]=$Eco;

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
		 if($TPR=='CGS'){//cgs逻辑
			
            $sql="select * from eco_system where Status!=1 and Status!=5 and Status!=6 order by 1_Begingtime desc";
			 //die($sql);
        }else{
			
            $sql="select * from eco_system where Status!=1 and Status!=5 and Status!=6 and TPR='$TPR' order by 1_Begingtime desc";
			//die($sql);
        }
		
		}else{
			if($ptpr=='rlg'){
				$ptpr = 'RLC_INDIA';
			}else if($ptpr=='rgs'){
				$ptpr = 'Regenersis_INDIA';
			}
			else if($ptpr=='bm'){
				$ptpr = 'Bizcom';
			}
			$sql="select * from eco_system where Status!=1 and Status!=5 and Status!=6 and TPR='$ptpr' order by 1_Begingtime desc";
		}
        $TPR=$_SESSION["utpr"];
        //echo $TPR;print cgs
       

        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $arr = array();
        if ($nums!=0) {
            while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                //var_dump($row);//["Id"]=>↵  string(32) "42232B5EFD653D27D2896F29812694D5"↵  ["Model"]=>↵  string(5) "EDC51"↵  ["Activity"]=>↵  string(4) "mmp7"↵
                //  ["TPR"]=>↵  string(3) "CGS"↵  ["TPRS"]=>↵  string(20) "RLC_SH,CEB,RLC_INDIA"↵
                if ($row['TPR'] == 'CGS') {
                    $arr['CGS'][] = $row;
                } else if ($row['TPR'] == 'RLC_SH') {
                    $arr['RLC_SH'][] = $row;
                } else if ($row['TPR'] == 'CEP') {
                    $arr['CEP'][] = $row;
                } else if ($row['TPR'] == 'IGS') {
                    $arr['IGS'][] = $row;
                } else if ($row['TPR'] == 'CEB') {
                    $arr['CEB'][] = $row;
                } else if ($row['TPR'] == 'CSAT') {
                    $arr['CSAT'][] = $row;
                } else if ($row['TPR'] == 'RLC_INDIA') {
                    $arr['RLC_INDIA'][] = $row;
                } else if ($row['TPR'] == 'Regenersis_INDIA') {
                    $arr['Regenersis_INDIA'][] = $row;
                } else if ($row['TPR'] == 'TSI') {
                    $arr['TSI'][] = $row;
                }
				else if ($row['TPR'] == 'Bizcom') {
                    $arr['Bizcom'][] = $row;
                }
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
    case 'sh_select':
        $sql="select distinct TPR,model,Eco_no from eco_system ";
        $result=$mysqli->query($sql);
        $arr=array();
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
   
    case 'load_all':
		$ptpr = $_POST['ptpr'];
		if($ptpr==''){
		 if($_SESSION["utpr"]=='CGS'){
            $sql="select * from eco_system order by 1_Begingtime desc ";
        }else{
            $tpr=$_SESSION["utpr"];
			
            $sql="select * from eco_system where TPR='$tpr' order by 1_Begingtime desc ";
			die($sql);
        }
		
		}else{
			if($ptpr == 'rlg'){
				$ptpr = 'RLC_INDIA';
			}else if($ptpr == 'rgs'){
				$ptpr = 'Regenersis_INDIA';
			}else if($ptpr=='bm'){
				$ptpr = 'Bizcom';
			}
		 $sql="select * from eco_system where TPR='$ptpr' order by 1_Begingtime desc ";
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
                    $arr['RLC_INDIA'][]=$row;
                }else if($row['TPR']=='Regenersis_INDIA'){
                    $arr['Regenersis_INDIA'][]=$row;
                }else if($row['TPR']=='TSI'){
                    $arr['TSI'][]=$row;
                }else if ($row['TPR'] == 'Bizcom') {
                    $arr['Bizcom'][] = $row;
                }
            }
        }
        echo json_encode($arr);
        @$result->free();
        $mysqli->close();
        break;
    case 'sh_data':
        $tpr=$_POST['tpr'];
        //var_dump($tpr);
        $model=$_POST['model'];
		$econo=$_POST['econo'];
        if($_SESSION["utpr"]=='CGS'||$_SESSION["utpr"]==$tpr){
          if($tpr!=''&&$model==''&&$econo==''){

                $sql="select * from eco_system where TPR='$tpr'  ";
               // die($sql);
            }else if($tpr==''&&$model!=''&&$econo==''){
                $sql="select * from eco_system where Model='$model'  ";
            }else if($tpr==''&&$model==''&&$econo!=''){
				//die($sql);
                $sql="select * from eco_system where Eco_no='$econo' ";
            }else if($tpr!=''&&$model!=''&&$econo==''){
                $sql="select * from eco_system where tpr='$tpr' and Model='$model' ";
            }else if($tpr!=''&&$model==''&&$econo!=''){
                $sql="select * from eco_system where tpr='$tpr' and Eco_no='$econo'  ";
            }else if($tpr==''&&$model!=''&&$econo!=''){
                $sql="select * from eco_system where Eco_no='$econo' and model='$model'  ";
            }else if($tpr!=''&&$model!=''&&$econo!=''){
                $sql="select * from eco_system where Eco_no='$econo' and tpr='$tpr' and model='$model'  ";
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
                    }else if ($row['TPR'] == 'Bizcom') {
                    $arr['Bizcom'][] = $row;
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
    case 'add_data'://暂时无用功能
        $data=$_POST['add_obj'];
        $Id=$data['data_id'];
        $tprs=$data['tpr'];

        $sql="select TPR,TPRS,Status,Model,New_comp from eco_system where Id='$Id' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $Is_T=$row['TPR'];
                $T=$row['TPRS'];
                $S=$row['Status'];
                $M=$row['Model'];
                $N=$row['New_comp'];
            }
        }//cgs单独逻辑
        /*if($Is_T!="CGS"){
            echo '1090';
            return;
        }*/

        $lock=0;
        $sql="select distinct suo from eco_system where Model='$M' and New_comp='$N' ";
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
                    //研究！！！
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
                    //???
                    $sql="insert into eco_system(Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,3_Begingtime,3_Owner,3_Checker,3_Status,3_file) select '$tpr_Id',Model,Activity,'$tprs[$i]','$tprs[$i]',Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,'$now_date','$Owner','$Checker',0,3_file from eco_system where Id='$Id' ";
                    $result=$mysqli->query($sql);
                    if($result!=0){
                        $T.=",".$tprs[$i];
                    }
                }else{
                    continue;
                }
            }
        }
        $sql="update eco_system set TPRS='$T' where Id='$Id' ";
        $result=$mysqli->query($sql);
        if($result==1){
            echo '1111';
        }else{
            echo '1030';
        }
       //@$result->free();
        $mysqli->close();
        break;

        //add_data 暂时不研究

   case 'del_data':
    $Id=$_POST['id'];
    //删除功能
    $sql="delete from eco_system where Id='$Id' ";
    //die($sql);
    $result=$mysqli->query($sql);
    $nums=$mysqli->affected_rows;
    if ($nums==1){
        $tag=1020;
    }else{
        $tag = '1404';
    }

    //每步文件上传



    echo json_encode($tag);
   // @$result->free();
    $mysqli->close();
    break;


    case 'step':
        $dataid=$_POST['dataid'];//前台传来的dataid
        $sql="select * from eco_system where Id='$dataid' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);//返回
        @$result->free();//释放资源
        $mysqli->close();//关闭mysqli链接
        break;
    case 'step_file':
		function array_iconv($in_charset,$out_charset,$arr)
{
    foreach($arr as $k => &$v){
        if(is_array($v)){
            foreach($v as $kk => &$vv){
                $vv = iconv($in_charset,$out_charset,$vv);
            }
        }else{
            $v = iconv($in_charset,$out_charset,$v);
        }
    }
    return $arr;
}
        $rqdata=$_POST['dataid'];
        //查询文件上传

        $sql="select 2_file,4_file,5_file from eco_system where id= '$rqdata'";
		//die($sql);

        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $arr=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_NUM ))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
		//var_dump($arr);
        $file=array();
        //判断是否查询到数据（有无文件）再到实体文件夹下查询文件名，拼接成可以下载的url
        if($arr[0]!=null){
            for($i=0;$i<count($arr[0]);$i++){
                if($arr[0][$i]!=null){
                    $path="../../eco_system_file/".$arr[0][$i];
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

		$incode = 'BIG5';
		$outcode = 'UTF-8';
		$file=array_iconv($incode,$outcode,$file);
        echo json_encode($file);
        @$result->free();
        $mysqli->close();
        break;
        
    case 'Edit_load'://加载，获得edit界面的数据
        //传送门1
        $val=$_POST['dataid'];

        //拼接步骤+字段名
        $Owner=$val[1].'_Owner';
        $Bgtime=$val[1].'_Begingtime';
        $Acty='Activity';
        $Remark=$val[1].'_Remark';
        $Checker=$val[1].'_Checker';

       // $score=$val[1].'_score';
        //$ck_mark=$val[1].'_ck_mark';
        //$day=$val[1].'_ck_date';

        //查询所需要的数据
        $sql="select $Owner,$Checker,$Acty,Model,$Bgtime,$Remark from eco_system where Id='$val[0]' ";
        //die($sql);
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
   
    //确认编辑
    case 'Edit_Owner':
        //传送门2
        //是否结束的方法
        function check_finish($status_field,$val){
            global $mysqli;
            $sql="select  $status_field from eco_system where Id='$val[0]' ";//查询状态
            $result= $mysqli->query($sql);
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                $status_arr=array();
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $status_arr[]=$row;
                }
            }
            return $status_arr[0][$status_field];//0 huo 1
       }

        function check_file($Id){ //检查上传文件
            if($Id==null||$Id==""){
                return '0';
            }
            $path="../../eco_system_file/".$Id."/";
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
        //状态是否超时
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
            //strtotime — 将任何字符串的日期时间描述解析为 Unix 时间戳
            $date_day=floor((strtotime($nowtime)-strtotime($arr[0][0]))/86400);

            if($date_day>2){
                return 5;
            }else{
                return 1;
            }
        }//接收前端传来的数组
        $val=$_POST['dataid'];
        $remark=$_POST['remark'];//前端填写的memo
        $now_date=date('Y-m-d H:i:s');
        $status=$_POST['status'];//结束还是继续
        //echo $pass;  介到了 网页传来的  pass 还是reject
        //拼接字段名以及步骤文件
        $this_owner_field=$val[1].'_Owner';
        $this_checker_field=$val[1].'_Checker';
        $remark_field=$val[1].'_Remark';
        $status_field=$val[1].'_Status';
        $edtime_field=$val[1].'_Endtime';
        $this_bgtime_field=$val[1].'_Begingtime';
        $file_field=$val[1].'_file';
        //var_dump($val);//val[1] 表示操作的是第几步
        //var_dump( $remark,$now_date,$status,$this_owner_field,$this_checker_field,$remark_field,$status_field,$edtime_field,$this_bgtime_field,$file_field);
        //判断当前步骤是否结束
       if((check_finish($status_field,$val)==1||check_finish($status_field,$val)==5)&&$val[1]!=2){
            $mrk=1040;//提示finish
            $msg[]=$mrk;
            echo json_encode($msg);
           //@$result->free();
            $mysqli->close();
            return;
        }
        $ending=0;
        //echo $val[1];
        //注释#
        //判断当前是否最后一步，最后一步不需要查询下一步需要的owner和checker
        if($val[1]==6){
            //echo '6'.'B';

            $ending=1;  //！！！//如果是第六步，停止带出后续check步骤
            /*echo 'BB';*/
        }
        if( $ending==0 )
    {
             if($val[2]!='CEB'){
            if ($val[1] <= 2) {
                //echo '3'.'B';
                $next_step = $val[1] + 1;//带出除了前两步的操作人  Mark1
                //上一步骤完成自动加载下一步操作
                $sql = "select Owner,Checker from h4_aduit where steps='$next_step' and  tpr='$val[2]' ";
                //die($sql);// select Owner,Checker from h4_aduit where steps='4' and  tpr='CGS'
                $result = $mysqli->query($sql);
                //echo '<pre>';
                //var_dump($result);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = $next_step . '_Owner';
                    $next_checker_field = $next_step . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = $next_step . '_Status';
                    $bgtime_field = $next_step . '_Begingtime';
                }

            }else if ($val[1] == 3) {
                //echo '4' . 'B';
                $next_step = $val[1] ;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='CGS' ";
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '4' . '_Owner';
                    $next_checker_field = '4' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '4' . '_Status';
                    $bgtime_field = '4' . '_Begingtime';
                }
            }
            else if ($val[1] == 4) {
                //echo '4' . 'B';
                $next_step = $val[1] - 1;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='$val[2]' ";
                //die($sql);
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '5' . '_Owner';
                    $next_checker_field = '5' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '5' . '_Status';
                    $bgtime_field = '5' . '_Begingtime';
                }
            } else if ($val[1] == 5) {
                //echo '5' . 'B';
                $next_step = $val[1] - 2;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='CGS'";
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '6' . '_Owner';
                    $next_checker_field = '6' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '6' . '_Status';
                    $bgtime_field = '6' . '_Begingtime';
                }
            }
    }else{
            if ($val[1] <= 2) {
                //echo '3'.'B';
                $next_step = $val[1] + 1;//带出除了前两步的操作人  Mark1
                //上一步骤完成自动加载下一步操作
                $sql = "select Owner,Checker from h4_aduit where steps='$next_step' and  tpr='$val[2]' ";
                //die($sql);// select Owner,Checker from h4_aduit where steps='4' and  tpr='CGS'
                $result = $mysqli->query($sql);
                //echo '<pre>';
                //var_dump($result);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = $next_step . '_Owner';
                    $next_checker_field = $next_step . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = $next_step . '_Status';
                    $bgtime_field = $next_step . '_Begingtime';
                }

            }else if ($val[1] == 3) {
                //echo '4' . 'B';
                $next_step = $val[1] ;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='CGS' ";
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '4' . '_Owner';
                    $next_checker_field = '4' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '4' . '_Status';
                    $bgtime_field = '4' . '_Begingtime';
                }
            }
            else if ($val[1] == 4) {
                //echo '4' . 'B';
                $next_step = $val[1] - 2;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='$val[2]' ";
                //die($sql);
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '5' . '_Owner';
                    $next_checker_field = '5' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '5' . '_Status';
                    $bgtime_field = '5' . '_Begingtime';
                }
            } else if ($val[1] == 5) {
                //echo '5' . 'B';
                $next_step = $val[1] - 2;
                $sql = "select Owner,Checker from h4_aduit where steps ='$next_step' and tpr='CGS'";
                $result = $mysqli->query($sql);
                $nums = mysqli_num_rows($result);

                $hand_arr = array();
                if ($nums != 0) {
                    while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                        $hand_arr[] = $row;
                    }

                    $next_owner_field = '6' . '_Owner';
                    $next_checker_field = '6' . '_Checker';
                    $next_Owner = $hand_arr[0]['Owner'];
                    $next_Checker = $hand_arr[0]['Checker'];
                    //var_dump($next_Owner,$next_Checker);
                    //var_dump($next_Owner,$next_Checker);带出下一步的操作人
                    $next_status_field = '6' . '_Status';
                    $bgtime_field = '6' . '_Begingtime';
                }
            }
		}

    }
        //查询当前owner和时间等信息
        $sql="select $this_owner_field,$this_checker_field,$this_bgtime_field,$file_field,Model,TPRS,Eco_no from eco_system where Id='$val[0]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $hand_arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $hand_arr[]=$row;
            }
        }
        $tpr=$val[2];//
        //echo $tpr.'bb';
        $this_Owner=$hand_arr[0][$this_owner_field];
        $this_Checker=$hand_arr[0][$this_checker_field];
        $this_bgtime=$hand_arr[0][$this_bgtime_field];
        $this_file=$hand_arr[0][$file_field];
        $model=$hand_arr[0]['Model'];
        $econo=$hand_arr[0]['Eco_no'];

        $tprs=explode(',',$hand_arr[0]['TPRS']);

        //???
        /*if(lock($model,$New_comp)==1){
            echo '1044';
           //@$result->free();
            $mysqli->close();
            return ;
        }*/
        //是否有权限操作，除了最高权限，看
        if($_SESSION["utpr"]!=$tpr&&$_SESSION["utpr"]!="CGS"){
            $time[]='is not Owner';
            $msg[]=$time;
            echo json_encode($msg);
            @$result->free();
            $mysqli->close();
            return ;
        }
            //如果是继续，那就直接更改memo的值
        if($status==0){
            $sql="update eco_system set $remark_field='$remark' where Id='$val[0]' ";
            $result=$mysqli->query($sql);
            if($mysqli->errno){
                $mrk=1010;
                $tag[]=$tpr;
                //$mail_msg[]=$next_Owner;
                $mail_msg[]=$model;
				$mail_msg[]=$econo;

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
                //$mail_msg[]=$next_Owner;
                $mail_msg[]=$model;
				$mail_msg[]=$econo;

                $msg[]=$mrk;
                $msg[]=$tag;
                $msg[]=$mail_msg;
                echo json_encode($msg);
                //@$result->free();
                $mysqli->close();
                return;
            }
        }
            //???CGS
        if ($tpr)
        { //如果是cgs则执行本段内容ddm
            //var_dump($val[1]);
            //ddm
            switch ($val[1])
            {
                case 2:
                    //echo '<pre>';

                    $m = check_file($this_file);
                    if ($m == 0) {
                        $mrk = 1041;
                        $msg[] = $mrk;
                        echo json_encode($msg);
                        //@$result->free();
                        $mysqli->close();
                        return;
                    }
                    //查询当前步骤是否超时
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //echo $this_status;
                    //mark4
                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                    //此处第二部走完后会更新eco表，并将第三部的操作人带出，status为 0
                    //die($sql);
                    $result = $mysqli->query($sql);
                    //var_dump($result) ;
                    if (!$mysqli->errno) {
                        $mrk = 1112;
                        $tag[] = $tpr;
                    } else {
                        $mrk = 1010;
                        $tag[] = $tpr;
                    }
                    $mail_msg[] = $next_Owner;
                    $mail_msg[] = $model;
					$mail_msg[]=$econo;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
               
                case 3://第三步
                    //tpr的执行步骤，第三步开始
                    $pon = $_POST['pon'];
                    //echo $pon;
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //???
                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,PO_number='$pon',D_bgtime='$now_date' where Id='$val[0]' ";
                    //die($sql);
                    $result = $mysqli->query($sql);
                    if(!$mysqli->errno) {
                        $mrk = 1113;
                        $tag[] = $tpr;
                        }else {
                        $mrk = 1010;//fail 标志
                        $tag[] = $tpr;
                        }
                        $mail_msg[] = $next_Owner;
                        $mail_msg[] = $model;
						$mail_msg[]=$econo;

                        $msg[] = $mrk;
                        $msg[] = $tag;
                        $msg[] = $mail_msg;
                        echo json_encode($msg);
                        //@$result->free();
                        $mysqli->close();
                        break;

                case 4:
                  $cftime = $_POST['cftime'];
                    if($cftime==''){
                       $cftime = date('Y-m-d');
                       //echo $cftime.'4';
                    }
                    $time = date('H:i:s');
                    //echo $time.'2';
                    //echo $cftime;
                    $rtime = $cftime.' '.$time;
					$cttime = date('Y-m-d H:i:s');
                    //echo $rtime.'3';
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //???newp
                    $sql = "update eco_system set $edtime_field='$cttime',4agtime='$rtime',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                    //die($sql);
                    $result = $mysqli->query($sql);
                    if (!$mysqli->errno) {
                        $mrk = 1114;
                        $tag[] = $tpr;
                    } else {
                        $mrk = 1010;
                        $tag[] = $tpr;
                    }
                    $mail_msg[] = $next_Owner;
                    $mail_msg[] = $model;
					$mail_msg[]=$econo;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                case 5://需要检测是否上传文件
                    //echo $val[1].'BB';
					$filename='';

					$tpm5 = 0;
                    $model5 = 0;
                    $rtpm5 = '';
					$this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    $m = check_file($this_file);
                    if ($m == 0) {
                        $mrk = 1041;
                        $msg[] = $mrk;
                        echo json_encode($msg);
                        return;
                    }
                    $path = "../../eco_system_file/" . $this_file . "/";
                    if (!file_exists($path)) {
                        echo '1047';
                        return;
                    }
                    $resdir = opendir($path);
                    while (false != ($file = readdir($resdir))) {
                        $path_t = $path . $file;
                        if ($file != '.' AND $file != '..') {
							 $filename=$file;
                             $log_file = $path_t;
                        }
                    }
			    if(pathinfo($filename)['extension']=='log'){
                    $file = fopen($log_file, "r");
                    $user = array();
                    $i = 0;
                    while (!feof($file)) {
                        $user[] = fgets($file);//fgets()从文件指针中读取一行,文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
                        //$i++;
                    }//打开文件，读取内容，用正则来匹配查询所需要的bios版本，根据版本类型查询数据库中是否一致，如果一致，则可以结束本步骤
                    fclose($file);
                    //echo pathinfo($file)['extension'];
                    //符合如下关键字的可以成功上传
                    //读取到的所有文本内容

                    $user = array_filter($user);
                    $preg = '/Firmware Version|FW Version is:/';
                    $ver = preg_grep($preg, $user);
                    $stpm = array_merge($ver);
                    //echo $stpm[0];
                    $utpm = strrpos($stpm[0],':');//找到最后 ：出现的位置
                   // echo $utpm;
                    $utpm1 = trim(substr($stpm[0],$utpm+1));
                    if($index = strpos($utpm1,'(')){
                        $rtpm = trim(substr($utpm1,0,$index));
                    }else{
                        $rtpm=$utpm1;
                    }
                    $sql = " select 1_Begingtime,5_Endtime,tpm,model,activity from eco_system where Id='$val[0]' ";
                    $result = $mysqli->query($sql);
                    $nums = mysqli_num_rows($result);
                    $arr = array();
                    if ($nums != 0) {
                        while (($row = mysqli_fetch_array($result)) !== false && $row > 0) {
                            $arr[] = $row;
                        }
                    }
                    $date_day = floor((strtotime($now_date) - strtotime($arr[0][0])) / 86400);//天数
                    $tpm5 = $arr[0][2];
                    $model5 = $arr[0][3];
                    //echo $
                    if($tpm5==''){
                        $sql5 = "select  distinct TPM_FW from matrix_rlc_sh where Compal_Name='$model5' ";
                       // die($sql5);
                        $result5 = $mysqli->query($sql5);
                        $nums5 = mysqli_num_rows($result5);
                        $arr5 = array();
                        if ($nums5 != 0) {
                            while (($row5 = mysqli_fetch_array($result5)) !== false && $row5 > 0) {
                                $arr5[] = $row5;
                            }
                        }
                        $rtpm5 =  $arr5[0][0];
                        //echo $rtpm5;
                    }else{
                        $rtpm5 = $tpm5;
                    }


                }else{
                    $sql = " select 1_Begingtime from eco_system where Id='$val[0]' ";
                    $result = $mysqli->query($sql);
                    $nums = mysqli_num_rows($result);
                    $arr = array();
                    if ($nums != 0) {
                        while (($row = mysqli_fetch_array($result)) !== false && $row > 0) {
                            $arr[] = $row;
                        }
                    }
                    $date_day = floor((strtotime($now_date) - strtotime($arr[0][0])) / 86400);//天数

                }
                    if ($date_day > 15) {
                        $all_stuatus = 5;
                    }else if($date_day > 30){
                        $all_stuatus = 6;
                    }
                    else {
                        $all_stuatus = 1;//延时判断？
                    }
                    //open rollback
                    $mysqli->autocommit(false);//设置为非自动提交——事务处理
                  

                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                 
                    //update eco_system set 5_Endtime='2019-10-21 09:13:02',5_Remark='qweqwe',5_Status='1',6_Begingtime='2019-10-21 09:13:02',6_Status=1,6_Owner='Henry',6_Checker='Henry',6_Remark='qweqwe',6_Endtime='2019-10-21 09:13:02',Status='1',D_bgtime='2019-10-21 09:13:02' where Id='2080D10BD0C8A67BAFDB7BC40AB18A0D'
                    $result = $mysqli->query($sql);
                 
                    $nums = $mysqli->affected_rows;
                 
                    if ($nums == 1) {
                        $mrk = "1115";
                        $mysqli->commit();//第五步要手动代码提交不然不close
                    }
                    //插眼
                    $tag = $tpr;

                    $mail_msg[] = $next_Owner;
                    $mail_msg[] = $model;//
					$mail_msg[]=$econo;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
					if(isset($rtpm)){
						$msg[] = $rtpm;
					}
					
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                case 6:
                    //6chayan

                       
                     
						$this_status = Status($now_date, $this_bgtime_field, $val[0]);
                        $sql3="select Model,New_comp from eco_system where Id='$val[0]' ";
                        //die($sql3); sql  ok
                        $result3=$mysqli->query($sql3);
                        $nums3=mysqli_num_rows($result3);
                        //echo $result3;
                        if ($nums3!=0){
                            $arr3=array();
                            while (($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC))!==false&&$row3>0) {
                                $arr3[]=$row;
                            }
                        }
                        $endtime6 = $val[1] . '_Endtime';
                        $comp = $arr3[0]['New_comp'];
                        //echo $comp;
                        $pass = $_POST['passed'];
                        $pass1 = 'pass';
                        $reject = 'reject';
                        $reason = $_POST['reason'];

                        $sql = " update  eco_system set 6_Endtime ='$now_date',$remark_field='$remark',$status_field='1',D_bgtime='$now_date',Status='$this_status',Verify='$pass' where Id ='$val[0]'";
                        //die($sql);//sql语句没问题
                        $res = $mysqli->query($sql);
                        $num2 = $mysqli->affected_rows;

                        if ($num2 == 1 && trim($pass)==$pass1) {//通过后发邮件提示eco事件完成
                           
                            $mrk = "1116";
                            $tag = $tpr;
                            //echo $tag; 发起的tpr
                            $mail_msg[] = $model;
                            $mail_msg[] = $tag ;
							$mail_msg[]=$econo;
							//这个mail_msg 是传到 邮件带的信息
                            $msg[] =$mrk;
                            $msg[] = $tag;
                            $msg[] = $mail_msg;
                            $table = 'heco';
                            $DMarr = explode(',',$model);//以逗号分隔字符串，并生成数组格式
                            //var_dump($DMarr);
                            $tarr = array();
                            $DMstr = '';
                            for($i= 0;$i<count($DMarr);$i++){
                                $sql="select distinct DMname from model where Model='$DMarr[$i]' ";
                                $result=$mysqli->query($sql);
                                $nums=mysqli_num_rows($result);
                                //echo $nums;
                                $arr=array();
                                if ($nums!=0){
                                    while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                                        $arr[]=$row;
                                        //var_dump($arr);

                                    }
                                    array_push($tarr,$arr[0][0]);
                                    //echo gettype($arr[0][0]);

                                }
                               $DMstr = implode(',',$tarr);//以逗号拼接  V
                            }
                            $sqle="select  Eco_no from eco_system where Id='$val[0]' ";
                            //die($sql);
                            $resulte=$mysqli->query($sqle);
                            $numse=mysqli_num_rows($resulte);
                            $arre=array();
                            if ($numse!=0){
                                while (($rowe = mysqli_fetch_array($resulte))!==false&&$rowe>0) {
                                    $arre[]=$rowe;
                                   //echo gettype($arre[0][0]) .'B';  string
                                    //var_dump($arre) ;
                                    //echo $arre[0][0].'BBB';//可以



                                }
                            }
                            $econ = $arre[0][0];
                            //echo $econ;
                            $sqlheco = "insert into $table (Model,DMname,history_ECO,uptime) values ('$model','$DMstr','$econ','$now_date')";
                            $mysqli->query($sqlheco);
                            for($j= 0;$j<count($DMarr);$j++){
                                $sqlsn = "insert into sneco(Model,eco,itime) values('$DMarr[$j]','$econ','$now_date')";
                                //die($sqlsn);
                                $mysqli->query($sqlsn);
                            }
                            //die($sqlheco);


                            //die($sqlheco);
                            echo json_encode($msg);
                            //@$res->free();
                            $mysqli->close();
                            break;
                              // 发给tpr
                        }else if($num2 == 1 && trim($pass)==$reject) {
                            $sqlj = " update eco_system set reason='$reason',5_Remark='',5_Status='0',5_Endtime=null,6_Remark='',6_Status='0',6_Begingtime=null,6_Endtime=null,6_Checker=null,6_Owner=null,Status='0' where Id='$val[0]'";
                            //$sqlj = " update eco_system set 5_Remark='',5_Status='0',6_Remark='',6_Status='0',Status='0' where Id='$val[0]'";
                            //die($sqlj);
                            $recj = $mysqli->query($sqlj);
                            $numj2 = $mysqli->affected_rows;
                          
                            if($numj2) {
                                //echo 'BBB';//满足
                                $sql2 = "select Checker from h4_aduit where steps= 3 and  tpr='$val[2]' ";
                                $res = $mysqli->query($sql2);
                                $nums = $mysqli->affected_rows;
                                $arrs = array();
                                if ($nums) {
                                    while (($rows = mysqli_fetch_array($res, MYSQLI_ASSOC)) !== false && $rows > 0) {
                                        $arrs[] = $rows;
                                        //echo '<pre>';
                                        //var_dump($arrs) ;
                                        $mailto = $arrs[0]['Checker'];

                                        $mrk = '1414';//reject后mail标志位
                                        $tag = $tpr;
                                        $mail_msg[] = $mailto;
                                        $mail_msg[] = $tag;
                                        $mail_msg[] = $model;
                                        $mail_msg[] = $reason;
										$mail_msg[]=$econo;
                                        $msg[] = $mrk;
                                        $msg[] = $tag;
                                        $msg[] = $mail_msg;
                                        echo json_encode($msg);
                                        //@$res->free();
                                        $mysqli->close();
                                        break;

                                    }

                                }
                            }
                        }
                }
            }
        break;


    case 'Upload_file':
        $tpr=$_POST['tpr'];
        $step=$_POST['step'];
        $file=$_FILES['file'];
		//echo $file;
        $Id=$_POST['Id'];

      
        $eco_file = strtoupper ( md5 ( uniqid ( rand (), true ) ) );

        $path="../../eco_system_file/".$eco_file."/";
        if(!mkdir($path)){
            echo '1140';
            return;
        }
        //CGS  单独逻辑
        //检测本步骤是否需要上传文件
        //echo $tpr;//
        /*if(!(($tpr=="CGS"&&$step==2)||($tpr!="CGS"&&$step==5))){ //???
            echo '1020';
            return ;
        }*/
        $this_file_field=$step."_file";
        //移动上传的文件到文件夹,并转换编码
        if(move_uploaded_file(iconv('UTF-8','BIG5//IGNORE',$file['tmp_name']),$path.iconv('UTF-8','BIG5//IGNORE',$file['name']))){
		  
            $sql="select $this_file_field from eco_system where Id='$Id' and LENGTH($this_file_field)>25";
              //die($sql);
			$result=$mysqli->query($sql);
			
            $nums=mysqli_num_rows($result);
            if ($nums==0){
                $sql="update eco_system set $this_file_field='$eco_file' where Id='$Id' ";
                $result=$mysqli->query($sql);
                if(!$mysqli->errno){
                    $msg=1;
                }else{
                    $msg=0;
                }
            }else{
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $del_file=$row[$this_file_field];
                }//移动失败，则删除文件夹
                del_sopfile($del_file);
				//die($sql);
                $sql="update eco_system set $this_file_field='$eco_file' where Id='$Id' ";
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
		//echo $msg;
        echo json_encode($msg);
        //$result->free();
        $mysqli->close();
        break;
     case 'Upload_evifile':
         $Id=$_POST['Id'];
         $tpr=$_POST['tpr'];
         $file=$_FILES['file'];
         $delay_file = strtolower(( md5 ( uniqid ( rand (), true ) ) )) ;
         $path="../../eco_delay_file/".$delay_file."/";
         if(!mkdir($path)){
             echo '1140';
             return;
         }
         if(move_uploaded_file($file['tmp_name'],$path.$file['name'])){
             $sql="select efile from eco_delay where Id='$Id' and LENGTH(efile)>50";
             $result=$mysqli->query($sql);
             $nums=mysqli_num_rows($result);
             if ($nums==0){
                 $sql="update eco_delay set efile='$delay_file' where Id='$Id' ";
                 $result=$mysqli->query($sql);
                 if(!$mysqli->errno){
                     $msg=1;
                 }else{
                     $msg=0;
                 }
             }else{
                 while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                     //echo '<pre>';
                     //var_dump($row);
                     $del_file=$row['efile'];
                 }//移动失败，则删除文件夹
                 del_sopfile($del_file);
                 $sql="update eco_delay set efile ='$delay_file' where Id='$Id' ";
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
        //echo count($tpr);
        //echo '<pre>';
       // var_dump($tpr);//介到inform 的tpr "<pre>array(2) {↵  [0]=>↵  string(3) "CEP"↵  [1]=>↵  string(3) "CEB"
        $msg=$_POST['msg'];
        //echo "<pre>";
        //var_dump($msg) ;//s6只介到msg【0】 model
        switch ($mrk){//产生数据时发送
            case 'cr'://eco事件创建所发的邮件标识，ignore
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' and spmaflag=1 ";
                    //$sql="select name,mail from mail where tpr='PE' ";
                    //die($sql);
                    //$sql="select name,mail from mail where tpr='PE'  ";
                    //die($sql);
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    $arr_to=array();
                    for($x=0;$x<count($arr);$x++){//把owner放在第一位
                        if ($arr[$x]['name']==$msg[0]){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
					 $tmp = '';
                    for($x=0;$x<count($msg[1]);$x++){

                        $tmp .= ','.$msg[1][$x];
                    }
                    //$title="WWW Repair Center BIOS Control System";//提示第二步的人
                    $title=" ".$tpr[$i]." Repair Center ECO trace System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi repair center :<br/>
	".$tpr[$i]." ".$tmp.",Eco_no:".$msg[2].". ECO case has been launched,please prepare ECO materials. <br/>Hi 【".$msg[0]."】, need you to handle it and upload rework SOP，if files are more than one,please zip them while uploading <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";

                $mg=sendmail($arr_to,$title,$text);
                //sleep(60);
                }
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            
            case 's2'://第二步结束提示第三部checker的时候发送
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' and spmaflag=1 ";
                    //$sql="select name,mail from mail where tpr='PE' ";
                    //die($sql);
                    //$sql="select name,mail from mail where tpr='PE'  ";
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
                    $title=" ".$tpr[$i]." Repair Center ECO trace System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i].",".$msg[1].",Eco_no:".$msg[2].". need you confirm ECO information and them release PO <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                }
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 's3'://第三步close后发送mail标志位
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr='$tpr[$i]' and spmaflag=1 ";
                    //$sql="select name,mail from mail where tpr='PE' ";
                    //die($sql);
                    //$sql="select name,mail from mail where tpr='PE'  ";
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
                    $title=" ".$tpr[$i]." Repair Center ECO trace System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i].",".$msg[1].",Eco_no:".$msg[2].". need you need you to confirm  SECO number<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                }
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
                case 's4'://cgs结束的时候发送
                //CGS 单独逻辑？？？
                //$tpr[]="CGS";
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr like '%$tpr[$i]' and spmaflag=1 ";
                    //$sql="select name,mail from mail where tpr='PE' ";
                    //die($sql);
                    //$sql="select name,mail from mail where tpr='PE' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    ///??? yanjiu
                    $sql="select username from h4_aduit where steps=2 and tpr='$tpr[$i]' ";
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
                    $title=" ".$tpr[$i]." Repair Center ECO trace System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr[$i].",".$msg[1].",Eco_no:".$msg[2].". need you confirm  importing ECO and maintaining eco_system,then upload FAI report <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                    $mg=sendmail($arr_to,$title,$text);
                }
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
            case 's5'://通知第六步
                //$tpr_arr[]=$tpr;
                //$tpr[]="CGS";
               // for($i=0;$i<count($tpr);$i++){ 
                $sql="select name,mail from mail where tpr='$tpr' and spmaflag=1 ";
                //$sql="select name,mail from mail where tpr='PE' ";//投递给谁
                //die($sql);
                //$sql="select name,mail from mail where tpr='PE'  ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    //  ??? step5
                    $sql="select username from h4_aduit where steps=3 and tpr='CGS' ";

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
                    $title=" ".$tpr." Repair Center ECO trace System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$tpr.",".$msg[1].",Eco_no:".$msg[2].". please check file uploaded by TPR QA,choose pass or not <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                    $mg=sendmail($arr_to,$title,$text);
                //}
                echo json_encode($mg);
                //@$result->free();
                $mysqli->close();
                break;
            case 's6': //第六步pass后mail标志位,通知 所有参与的的人
                $sql="select name,mail from mail where tpr='$tpr'  ";
                //$sql="select name,mail from mail where tpr='PE' ";
                //die($sql);
                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                    $arr=array();
                    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                }
                //  ??? step5
                $sql="select username from h4_aduit where steps=5 and tpr='$tpr' ";//

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
                $title=" ".$msg[1]." Repair Center ECO trace System";
                //$title="WWW Repair Center BIOS Control System";
                $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
	 ".$msg[1]." ,".$msg[0].",Eco_no:".$msg[2].". the ECO case you've launched has been approved  <br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                $mg=sendmail($arr_to,$title,$text);
                //}
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
                break;
            case 'rj'://第六步reject后mial标志位，通知tpr QA  重新上传资料

                $sql="select name,mail from mail where tpr='$tpr' and spmaflag=1 ";
                //$sql="select name,mail from mail where tpr='PE' ";
                //die($sql);
                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                    $arr=array();
                    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                }
                //
                $sql="select username from h4_aduit where steps=3 and tpr='$tpr' ";//通知tpr QA

                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                //$Owner=null;
                if ($nums!=0){
                    while (($row1 = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row1>0) {
                        $Owner=$row1['username'];
                    }
                }
                $arr_to=array();
                for($x=0;$x<count($arr);$x++){
                    if ($arr[$x]['name']==$Owner){
                        //echo 'bB';
                        array_unshift($arr_to,$arr[$x]);//array_unshift在数组开头插入一个或多个单元
                        //echo $arr[$x]['name'];
                        //echo $Owner;
                        ///echo "<pre>";
                        //var_dump($arr_to);
                    }else{

                        $arr_to[]=$arr[$x];
                        //echo "<pre>";
                        //var_dump($arr_to);
                    }
                }

                //$mailer[]=$arr_to;
                $title="".$msg[1]." Repair Center ECO trace System";
                //$title="WWW Repair Center BIOS Control System";
                $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$msg[0].":<br/>
	".$msg[1].",".$msg[2].",Eco_no:".$msg[4]." .you've launched has been rejected because of 【".$msg[3]." 】,system system had already rolled back to fifth step,please re-upload FAI report,if files are more than one,please zip them while uploading 。<br/>
	*Please login TPR ManageMent System(https://www.compal.top/Report/web/ECO_system/Show.php) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
                $mg=sendmail($arr_to,$title,$text);
                //}
                echo json_encode($mg);
                @$result->free();
                $mysqli->close();
                break;
        }
        break;
}
function del_sopfile($eco_file){ //删除上传文件
    $path="../../eco_system_file/".$eco_file."/";
    if(is_dir($path)){
        $p = scandir($path);
        foreach($p as $val){
            //闂傚倸鍊搁崐鎼佸磹妞嬪海鐭嗗ù锝夋交閼板潡姊洪锟界粔瀵稿閸ф鐓忛柛顐ｇ箖婢跺嫰鏌￠崱妯肩煉闁哄苯绉规俊鐑芥晜閻ｅ奔绱橀梻浣告惈椤戝懐绮旇ぐ鎺斿祦闁哄稁鐏旀惔顭戞晢闁跨喕濮ゆ穱濠冪鐎ｎ偆鍘遍柟鑲╄ˉ閿熻姤鍓氶崝澶愭⒑闂堟稒鎼愰悗姘緲椤曪綁顢氶敓钘夌暦閹偊妲哄┑顔款潐椤ㄥ牏妲愰幘瀛樺闁告挸寮剁瑧闂備浇顕х换鎴犳崲閸儱鏄ラ柕澶涚畱缁剁偤鏌熼柇锕�澧版い鏃�鎹囧娲川婵犲倸顫囬梺鍛婃煥閻偐鍒掗懡銈嗗珰婵炴潙顑嗛弬锟介梻浣虹帛閸旀浜稿▎鎰珷闁规儼濮ら悡娆撴煕閹存瑥锟芥牜锟芥熬鎷�.闂傚倸鍊搁崐鎼佸磹妞嬪海鐭嗗〒姘炬嫹妤犵偛顦甸弫宥夊礋椤愩垻浜伴梻浣瑰缁诲倿藝椤栨粎涓嶆い鏍仦閻撱儵鏌ｉ弴鐐诧拷鍦拷姘炬嫹..
            if($val !="." && $val !=".."){
                unlink($path.$val);
                //闂傚倸鍊搁崐鎼佸磹閻戣姤鍤勯柛顐ｆ礀绾惧潡鏌ｉ姀銏╃劸闁汇倝绠栭弻宥夊传閸曨剙娅ｇ紓浣瑰姈椤ㄥ﹪寮婚垾鎰佸悑閹肩补锟借尙鏁栫紓鍌欑筏閹峰嘲鈹戦悩鎻掝伒闁归鍏橀悰顕�宕归鐓庮潛闂備胶鎳撻崯鍧楁儗閸岀偛鏋侀柟鍓х帛閸ゅ秹鏌曟径鍫濆姕閻犲洨鍋ら幃妤冩喆閸曨剛锛橀梺鍛婃⒐閸ㄥ潡濡存担绯曟婵☆垱绮嶅褰掑箯閸涱垱鍠嗛柛鏇ㄥ幖缂嶏拷闂傚倸鍊搁崐鎼佸磹妞嬪海鐭嗗〒姘炬嫹妤犵偛顦甸弫鎾绘偐閸愬弶鐤勯梻浣虹帛閸旓箓宕滈敃锟介埢鎾寸鐎ｎ偆鍘甸梻鍌氬�搁顓⑺囬敃鍌涚厱闁靛鍎遍敓钘夘煼楠炲骞栨担鐟颁罕闂佸壊鍋呯换鍕偡閺屻儲鈷戦柟鎯板Г閺佽鲸淇婇銏犳殻鐎殿喖顭峰鎾閻樿鏁规繝鐢靛█濞佳兠洪妸鈹у洭鏌嗗鍡忔嫼闁哄鍋炴竟鍡浰囬敃鍌涘�垫慨姗嗗亜瀹撳棛锟芥鍠栭…鐑藉极閹剧粯鍋愰柤纰卞墾缁卞弶绻濆▓鍨灍闁挎洍鏅犲畷銏°偅閸愨晛浜楅梺鐟扮摠缁洪箖寮ㄦ禒瀣厽闁归偊鍓欑痪褎銇勯妷锔藉磳闁哄本鐩俊鎼佸Ψ閿旇棄鍓垫俊鐐�栧ú蹇涘磿闂堟稓鏆﹂柣鏃傗拡閺佸秵绻涢幋鐐垫噭妞ゅ繒鍠栧缁樻媴閼恒儳銆婇梺闈╃秶缁犳捇鐛箛娑欐櫢闁跨噦鎷�
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
    //$mail->Host = "smtp.qq.com";
    $mail->Host = "localhost";
    $mail->SMTPAuth = true;
    $mail->Username = "compaltpr@compal.top";
    $mail->Password = "XUDELIN8800275";
    /*$mail->Username = "1136309800@qq.com";
    $mail->Password = "ltdpgfkhplxoiifj";*/
    $mail->Port = 25;
    //$mail->SMTPSecure = 'ssl';
    $mail->setFrom('compaltpr@compal.top', 'compaltpr@compal.top');//send mailer
    //$mail->Host = "smtp.qq.com";
    //$mail->Username = "hijackutest@163.com";

    //$mail->Password = "pnwnklfsgblpjgef";
    //$mail->Password = "XUDELIN8800275";
    //$mail->setFrom('1409330098@qq.com', '1409330098@qq.com');//send mailer
    //$mail->setFrom('compaltpr@compaltpr.com', 'compaltpr@compaltpr.com');//send mailer
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
