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
       //@$result->free();
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
       //@$result->free();
        $mysqli->close();
        echo json_encode($arr);
        break;
    case 'add_model':
        $model=$_POST['model'];
        $new_ver=$_POST['new_ver'];
        $new_sysver=$_POST['new_sysver'];
        $sql="select * from model where Model='$model' and Oldver='$new_ver' and Old_sysver='$new_sysver' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            echo '102';
        }else{
            $sql="insert into model (Model,Oldver,Old_sysver) values ('$model','$new_ver','$new_sysver')";
            $result=$mysqli->query($sql);
            if($result==1){
                echo '1';
            }else{
                echo '0';
            }
        }
       //@$result->free();
        $mysqli->close();
        break;
    case 'Find_model':
        $model=$_POST['model'];

        $t=0;
         $table="matrix_example";
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
       //@$result->free();
        $mysqli->close();

        break;
    case 'Create':
        $data=$_POST['obj_pro'];
        $activity=$data['descript'];
        $model=$data['model'];
        $new_comp=$data['newcomp'];
        //$addtpr = $data['checkdata'];
        //echo $addtpr;
        //$tpr_arr=explode(',',$data['checkdata']);//hijack
        //$GLOBALS['tprst'] = $GLOBALS['tpr_arr'];
        //创建之前先判断数据库是否存在相同的eco事件
        //echo json_encode($activity.$model.$new_ver);
        //return;
        $sql="select * from eco_system where Model='$model' and Activity='$activity' and New_comp='$new_comp' ";
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
        //cgs单独逻辑？？？
        $Now_time=date('Y-m-d H:i:s');
        for($i=0;$i < count($tpr_arr);$i++){

            $Id = strtoupper(md5(uniqid(rand(),true)));
            $sql="insert into eco_system (Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Owner,1_Checker,1_Endtime,1_Remark,1_Status,2_Begingtime,2_Owner,2_Checker,2_Status,D_bgtime) values
            ('$Id','$model','$Activity','$tpr_arr[$i]','$tpr_arr[$i]','$Eco','$New_comp','$Now_time','$Owner_1','$Check_1','$Now_time','ok',1,'$Now_time','$Owner_2','$Check_2',0,'$Now_time')";
            $result=$mysqli->query($sql);

        }

        if(!$mysqli->errno){
            $mrk=1111;
        }else{
            $mrk=1040;
        }
        $mail_msg[]=$Owner_2;
        $mail_msg[]=$model;

        $msg[]=$mrk;
        $msg[]=$mail_msg;

        echo json_encode($msg);
        //@@$result->free();
        $mysqli->close();
        break;
    case 'load_data':
        $TPR=$_SESSION["utpr"];
        //echo $TPR;print cgs
        if($TPR=='CGS'){//cgs逻辑
            $sql="select * from eco_system where Status!=1 and Status!=5 and Status!=2 order by 1_Begingtime desc";
        }else{
            $sql="select * from eco_system where Status!=1 and Status!=5 and Status!=2 and TPR='$TPR' order by 1_Begingtime desc";
        }

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
                    $arr['RLC-INDIA'][] = $row;
                } else if ($row['TPR'] == 'Regenersis_INDIA') {
                    $arr['Regenersis-INDIA'][] = $row;
                } else if ($row['TPR'] == 'TSI') {
                    $arr['TSI'][] = $row;
                }
            }
        }
        echo json_encode($arr);
        //@@$result->free();
        $mysqli->close();
        break;
    case 'sh_tpr':
        $sql="select distinct TPR from eco_system ";
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
    case 'cg_model':
        $tpr=$_POST['tpr'];
        $sql="select distinct Model from eco_system where TPR='$tpr' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $model=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $model[]=$row;
            }
        }
        echo json_encode($model);
       //@$result->free();
        $mysqli->close();
        break;
    case 'cg_ver':
        $tpr=$_POST['tpr'];
        $model=$_POST['model'];
        $sql="select distinct New_comp from eco_system where TPR='$tpr' and Model='$model' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $new_comp=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $new_comp[]=$row;
            }
        }
        echo json_encode($new_comp);
       //@$result->free();
        $mysqli->close();
        break;
    case 'load_all':
        if($_SESSION["utpr"]=='CGS'){
            $sql="select * from eco_system order by 1_Begingtime desc ";
        }else{
            $tpr=$_SESSION["utpr"];
            $sql="select * from eco_system where TPR='$tpr' order by 1_Begingtime desc ";
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
                }else if($row['TPR']=='TSI'){
                    $arr['TSI'][]=$row;
                }
            }
        }
        echo json_encode($arr);
       //@$result->free();
        $mysqli->close();
        break;
    case 'sh_data':
        $tpr=$_POST['tpr'];
        //var_dump($tpr);
        //echo 'JOJO';
        $model=$_POST['model'];
        //？？？cgs逻辑
        if($_SESSION["utpr"]=='CGS'||$_SESSION["utpr"]==$tpr){
            $sql="select * from eco_system where TPR='$tpr' and Model='$model' ";
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
                }
            }
            echo json_encode($arr);
        }else{
            echo '1040';
        }
       //@$result->free();
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
        if($_SESSION["uname"]!=='compalsod'){
            echo '1040';
            return;
        }

        //删除功能
        $sql="select TPR,TPRS,Model,Activity,New_comp,2_file,5_file,6_file from eco_system where Id='$Id' ";

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
        $new_comp=$arr[0]['New_comp'];
        $file_2=$arr[0]['2_file'];
        $file_5=$arr[0]['5_file'];
        $file_6=$arr[0]['6_file'];
        //每步文件上传
        $tag=1020;
        //cgs 单独逻辑
        if($T=="CGS"){
            $sql="delete from eco_system where Id='$Id' ";
            $result=$mysqli->query($sql);
            if(!$mysqli->errno){
                if($file_2!=null){
                    del_sopfile($arr[0]['2_file']);
                }
                $tag=1111;
            }else{
                echo json_encode($tag);
               //@$result->free();
                $mysqli->close();
                return ;
            }
            $TPR_arr=explode(',',$arr[0]['TPRS']);
            for($i=0;$i<count($TPR_arr);$i++){
                $tpr=$TPR_arr[$i];
                //？？？
                $sql="select 5_file from eco_system where Model='$model' and Activity='$activity' and TPR='$tpr' and New_comp='$new_comp' ";

                $result=$mysqli->query($sql);
                $nums=mysqli_num_rows($result);
                $arr=array();
                if ($nums!=0){
                    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                }
                $sql="delete from eco_system where Model='$model' and Activity='$activity' and TPR='$tpr' and New_cmop='$new_comp' ";
                $result=$mysqli->query($sql);
                //删除第五步文件？
                if(!$mysqli->errno){
                    if($arr!=null&&$arr!=""){
                        del_sopfile($arr[0]['5_file']);
                    }
                    $tag=1111;
                }
            }

        }else{
            //cgs逻辑？？
            $sql="select Id,TPRS from eco_system where TPR='CGS' and Model='$model' and Activity='$activity' and New_cmop='$new_comp' ";
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
            $sql="update eco_system set TPRS='$tprs' where Id='$CGS_Id' ";
            $result=$mysqli->query($sql);
            if(!$mysqli->errno){
                $sql="delete from eco_system where Id='$Id' ";
                $result=$mysqli->query($sql);
                if(!$mysqli->errno){

                    //？？？
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
       //pass


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
       //@$result->free();
        $mysqli->close();
        break;
    case 'step_file':
        $rqdata=$_POST['dataid'];
        //查询文件上传

        $sql="select 2_file,5_file,6_file from eco_system where id= '$rqdata'";

        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        $arr=array();
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_NUM ))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        $file=array();
        //判断是否查询到数据（有无文件）再到实体文件夹下查询文件名，拼接成可以下载的url
        if($arr[0]!=null){
            for($i=0;$i<count($arr[0]);$i++){
                if($arr[0][$i]!=null){
                    $path="../../eco_system_file/".$arr[0][$i];
                    if(is_dir($path)){
                        $p = scandir($path);
                        foreach($p as $val){
                            //闂傚倸鍊搁崐鎼佸磹妞嬪海鐭嗗ù锝夋交閼板潡姊洪锟界粔瀵稿閸ф鐓忛柛顐ｇ箖婢跺嫰鏌￠崱妯肩煉闁哄苯绉规俊鐑芥晜閻ｅ奔绱橀梻浣告惈椤戝懐绮旇ぐ鎺斿祦闁哄稁鐏旀惔顭戞晢闁跨喕濮ゆ穱濠冪鐎ｎ偆鍘遍柟鑲╄ˉ閿熻姤鍓氶崝澶愭⒑闂堟稒鎼愰悗姘緲椤曪綁顢氶敓钘夌暦閹偊妲哄┑顔款潐椤ㄥ牏妲愰幘瀛樺闁告挸寮剁瑧闂備浇顕х换鎴犳崲閸儱鏄ラ柕澶涚畱缁剁偤鏌熼柇锕�澧版い鏃�鎹囧娲川婵犲倸顫囬梺鍛婃煥閻偐鍒掗懡銈嗗珰婵炴潙顑嗛弬锟介梻浣虹帛閸旀浜稿▎鎰珷闁规儼濮ら悡娆撴煕閹存瑥锟芥牜锟芥熬鎷�.闂傚倸鍊搁崐鎼佸磹妞嬪海鐭嗗〒姘炬嫹妤犵偛顦甸弫宥夊礋椤愩垻浜伴梻浣瑰缁诲倿藝椤栨粎涓嶆い鏍仦閻撱儵鏌ｉ弴鐐诧拷鍦拷姘炬嫹..
                            if($val !="." && $val !=".."){
                                $file[]=$path."/".$val;
                            }
                        }
                    }
                }
            }
        }
       //echo '<pre>';
        //var_dump($arr[0]);
        echo json_encode($file);
       //@$result->free();
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
           //@$result->free();
            $mysqli->close();
            return ;
        }
        $sql="select TPR,Model,New_ver,New_sysver from eco_system where Id='$Id' ";
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
           //@$result->free();
            $mysqli->close();
            return;
        }

        //for link sql
        $sql="update eco_system set ";
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
       //@$result->free();
        $mysqli->close();
        break;
        */
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
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        echo json_encode($arr);
       //@$result->free();
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
        if(check_finish($status_field,$val)==1||check_finish($status_field,$val)==5){
            $mrk=1040;
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
                //die($sql);
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

    }
        //查询当前owner和时间等信息
        $sql="select $this_owner_field,$this_checker_field,$this_bgtime_field,$file_field,Model,TPRS,New_comp from eco_system where Id='$val[0]' ";
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
        $New_comp=$hand_arr[0]['New_comp'];

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
           //@$result->free();
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

                $msg[]=$mrk;
                $msg[]=$tag;
                $msg[]=$mail_msg;
                echo json_encode($msg);
               //@$result->free();
                $mysqli->close();
                return;
            }else{
                $mrk=1051;
                $tag[]=$tpr;
                //$mail_msg[]=$next_Owner;
                $mail_msg[]=$model;

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
        { //如果是cgs则执行本段内容
            //var_dump($val[1]);
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
                    if (!$mysqli->errno) {
                        $mrk = 1111;
                        $tag[] = $tpr;
                    } else {
                        $mrk = 1010;
                        $tag[] = $tpr;
                    }
                    $mail_msg[] = $next_Owner;
                    $mail_msg[] = $model;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                //error mark
                /*case 3:
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);

                    $sql = "update eco_system set $edtime_field='$now_date',$remark_field='$remark',$status_field='$this_status',Status=1,D_bgtime='$now_date' where Id='$val[0]' ";
                    //die($sql);// 控制台打印"3" ↵update eco_system set 3_Endtime='2019-10-17 15:18:11',3_Remark='z',3_Status='1',Status=1,D_bgtime='2019-10-17 15:18:11' where Id='03350132BD8D0730A18883954924A34E'

                    $result = $mysqli->query($sql);

                    if (!$mysqli->errno) {//sql语句执行没问题
                        for ($i = 0; $i < count($tprs); $i++) {
                            $sql = "select Owner,Checker from h4_aduit where steps='$val[1]' and  tpr='$tprs[$i]' ";
                            $result = $mysqli->query($sql);
                            $nums = mysqli_num_rows($result);
                            $hand_arr = array();
                            if ($nums != 0) {
                                while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) !== false && $row > 0) {
                                    $hand_arr[] = $row;
                                }
                                $Owner = $hand_arr[0]['Owner'];
                                $Checker = $hand_arr[0]['Checker'];
                            }
                //循环产生多条tpr的数据
                            $Id = strtoupper(md5(uniqid(rand(), true)));

                            //???问题点?
                            $sql1 = "insert into eco_system(Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,3_Begingtime,3_Owner,3_Checker,3_Status,3_file,D_bgtime) select '$Id',Model,Activity,'$tprs[$i]','$tprs[$i]',Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,'$now_date','$Owner','$Checker',1,3_file,'$now_date' from eco_system where Id='$val[0]' ";
                            //die($sql1);//"string(1) "3" insert into eco_system(Id,Model,Activity,TPR,TPRS,Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,3_Begingtime,3_Owner,3_Checker,3_Status,3_file,D_bgtime)
                            // select '040058358470621BEFA8240E466E6EC5',Model,Activity,'CGS','CGS',Eco_no,New_comp,1_Begingtime,1_Endtime,1_Remark,1_Status,1_Owner,1_Checker,1_file,2_Begingtime,2_Endtime,2_Remark,2_Status,2_Owner,2_Checker,2_file,'2019-10-17 15:49:25','Henry','Henry',0,3_file,'2019-10-17 15:49:25' from eco_system where Id='03350132BD8D0730A18883954924A34E' "

                            $result = $mysqli->query($sql1);
                            if (!$mysqli->errno) {
                                $tag[] = $tprs[$i];
                                $time[] = 1;
                            }
                        }
                        if (in_array(1, $time)) {
                            $mrk = 1101;
                        } else {
                            $mrk = 1010;
                        }
                    } else {
                        $mrk = 1010;
                        $tag[] = null;
                    }
                    $mail_msg[] = $this_Owner;
                    $mail_msg[] = $model;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;*/
                case 3://第三步
                    //tpr的执行步骤，第三步开始
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //???
                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";

                    $result = $mysqli->query($sql);
                    if(!$mysqli->errno) {

                        $mrk = 1101;
                        }else {
                        $mrk = 1010;
                        $tag[] = $tprs;
                        }
                        $mail_msg[] = $next_Owner;
                        $mail_msg[] = $model;

                        $msg[] = $mrk;
                        //$msg[] = $tag;
                        $msg[] = $mail_msg;
                        echo json_encode($msg);
                        //@$result->free();
                        $mysqli->close();
                        break;

                case 4:
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //???newp
                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";

                    $result = $mysqli->query($sql);
                    if (!$mysqli->errno) {
                        $mrk = 1111;
                        $tag[] = $tpr;
                    } else {
                        $mrk = 1010;
                        $tag[] = $tpr;
                    }
                    $mail_msg[] = $next_Owner;
                    $mail_msg[] = $model;

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                case 5://需要检测是否上传文件
                    //echo $val[1].'BB';
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
                            $log_file = $path_t;
                        }
                    }
                    $file = fopen($log_file, "r");
                    $user = array();
                    $i = 0;
                    while (!feof($file)) {
                        $user[] = fgets($file);//fgets()从文件指针中读取一行,文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
                        //$i++;
                    }//打开文件，读取内容，用正则来匹配查询所需要的bios版本，根据版本类型查询数据库中是否一致，如果一致，则可以结束本步骤
                    fclose($file);
                    //符合如下关键字的可以成功上传
                    //读取到的所有文本内容

                    $user = array_filter($user);
                    $preg = '/Bios|BIOS/';
                    $ver = preg_grep($preg, $user);
                    $preg = '/Version|Revision|version/';
                    $ver = preg_grep($preg, $ver);
                    $preg = '/\=|\:|\"|\s/';
                    $ver = preg_grep($preg, $ver);
                    $preg = '/[0-9]/';
                    $ver = preg_grep($preg, $ver);
                    /*$ver = array_merge($ver);
                    //分割版本=号后面的版本号
                    if (strpos($ver[0], "=") !== false) {
                        $new_ver = str_replace("\r\n", "", explode("=", $ver[0])[1]);
                    } else {
                        $new_ver = str_replace("\r\n", "", explode(":", $ver[0])[1]);
                    }*/
                    /*if ($new_ver != $New_comp) {
                        echo $new_ver;
                        echo $New_comp;
                        $mrk = "4404";
                        $msg[] = $mrk;
                        echo json_encode($msg);
                        return;
                    }*/
                    $this_status = Status($now_date, $this_bgtime_field, $val[0]);
                    //status 相关
                    $sql = "select 1_Begingtime from eco_system where Id='$val[0]' ";
                    $result = $mysqli->query($sql);
                    $nums = mysqli_num_rows($result);
                    $arr = array();
                    if ($nums != 0) {
                        while (($row = mysqli_fetch_array($result)) !== false && $row > 0) {
                            $arr[] = $row;
                        }
                    }
                    $date_day = floor((strtotime($now_date) - strtotime($arr[0][0])) / 86400);
                    if ($date_day > 6) {
                        $all_stuatus = 5;
                    } else {
                        $all_stuatus = 1;//延时判断？
                    }
                    //open rollback
                    $mysqli->autocommit(false);//设置为非自动提交——事务处理
                    //$val[2]，就是当前的inform  的TPR
                    // Mark2
                   /* $sql1 = "select Owner,Checker from h4_aduit where steps= 3 and  tpr='$val[2]' ";
                    $result1 = $mysqli->query($sql1);
                    $nums1 = mysqli_num_rows($result1);
                    $hand_arr1 = array();
                    if ($nums1 != 0) {
                        while (($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) !== false && $row1 > 0) {
                            $hand_arr1[] = $row1;
                        }
                    }

                    $owner6 = $hand_arr1[0]['Owner'];
                    $check6 = $hand_arr1[0]['Checker'];*/
                    //var_dump($owner6,$check6);



                    $sql = "update eco_system set $edtime_field='$now_date',$next_owner_field='$next_Owner',$next_checker_field='$next_Checker',$remark_field='$remark',$status_field='$this_status',$bgtime_field='$now_date',$next_status_field=0,D_bgtime='$now_date' where Id='$val[0]' ";
                    //die($sql);
                    //var_dump($this_Owner,$this_Checker);第五步的人
                    //die($sql);
                    //update eco_system set 5_Endtime='2019-10-21 09:13:02',5_Remark='qweqwe',5_Status='1',6_Begingtime='2019-10-21 09:13:02',6_Status=1,6_Owner='Henry',6_Checker='Henry',6_Remark='qweqwe',6_Endtime='2019-10-21 09:13:02',Status='1',D_bgtime='2019-10-21 09:13:02' where Id='2080D10BD0C8A67BAFDB7BC40AB18A0D'
                    $result = $mysqli->query($sql);
                    //echo '<pre>';
                    //var_dump($result);
                    $nums = $mysqli->affected_rows;
                    //echo $nums.'bbA'; echo  出  -1
                    if ($nums == 1) {
                        $mrk = "1011";
                        $mysqli->commit();//第五步要手动代码提交不然不close
                        /*//？？？
                        $sql = "insert into model (Model,Oldver,Old_sysver) values ('$model','$New_ver','$New_sysver')";
                        $result = $mysqli->query($sql);
                        $tol_model = explode("&", $model);
                        $tb_Matir = "matrix_rlc_sh";
                        // 升级matrix表中的版本号
                        //查询matrix_rlc_sh和matrix_example这两个表中是否有这个model，如果没有的话需要在页面
                        //Add这个model到models表之后，再去matrix_rlc_sh和matrix_example这两个表中手动添加，否则升级bios可能提示model is null错误
                        $st_model = explode("_", $tol_model[0])[0];

                        $sql = "select BIOS_Ver from $tb_Matir where Compal_Name='$st_model' ";
                        $result = $mysqli->query($sql);
                        $nums = mysqli_num_rows($result);
                        $arr = array();
                        if ($nums != 0) {
                            while (($row = mysqli_fetch_array($result)) !== false && $row > 0) {
                                $arr[] = $row;
                            }
                        }
                        //检测matrix表中版本是否与升级的版本号，如果升级的版本比原来的低，则不升级   //eco 没用到
                        $old_model = $arr[0][0];
                        if ($new_ver != $old_model) {
                            $change = 0;
                            if (strpos($old_model, 'A') !== false) {
                                if ($old_model < $New_ver) {
                                    $change = 1;
                                }
                            } else {
                                if ($old_model < $New_sysver) {
                                    $change = 1;
                                }
                            }
                            if ($change == 1) {
                                for ($i = 0; $i < count($tol_model); $i++) {
                                    $field_model = explode("_", $tol_model[$i]);
                                    $header = substr($field_model[0], 0, 3);

                                    for ($x = 0; $x < count($field_model); $x++) {
                                        //分割model版本，拼接成可以升级的model版本
                                        if ($x == 0) {
                                            $one_model = substr($field_model[0], 3, 2);
                                            $final_model = $header . $one_model;
                                        } else {
                                            $final_model = $header . $field_model[$x];
                                        }
                                        //$k[]=$field_model[$x];
                                        $sqla = "update $tb_Matir set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$now_date',NewBios_Time='$now_date' where Compal_name='$final_model' ";
                                        $sqlb = "update matrix_example set Old_BIOS_Ver='$old_model',BIOS_Ver='$new_ver',Last_Update_Date='$now_date',NewBios_Time='$now_date' where Compal_name='$final_model' ";
                                        $result = $mysqli->query($sqla);
                                        $numsa = $mysqli->affected_rows;
                                        $mysqli->query($sqlb);
                                        $result = $mysqli->query($sqlb);
                                        $numsb = $mysqli->affected_rows;
                                        if ($numsa > 0) {
                                            $t[] = 1;
                                            $mrk = "1011";
                                            //$mysqli->rollback();
                                            $mysqli->commit();
                                        } else {
                                            $mrk = "10101";
                                            //$mysqli->commit();
                                            $mysqli->rollback();
                                        }
                                    }
                                }
                            } else {
                                $t[] = 1;
                                $mrk = "1011";
                                //$mysqli->rollback();
                                $mysqli->commit();
                            }
                        } else {
                            $t[] = 1;
                            $mrk = "1011";
                            //$mysqli->rollback();
                            $mysqli->commit();
                        }
                    } else {
                        $mrk = "10102";
                        $mysqli->rollback();*/

                    }
                    //插眼
                    $tag = $tpr;
                    $mail_msg[] = $this_Owner;
                    $mail_msg[] = $model;//

                    $msg[] = $mrk;
                    $msg[] = $tag;
                    $msg[] = $mail_msg;
                    echo json_encode($msg);
                    //@$result->free();
                    $mysqli->close();
                    break;
                case 6:
                    //6chayan

                        //echo '6'.'BBB';
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
                                $log_file = $path_t;
                            }
                        }
                        $file = fopen($log_file, "r");
                        $user = array();
                        $i = 0;
                        while (!feof($file)) {
                            $user[] = fgets($file);//fgets()从文件指针中读取一行,文件指针必须是有效的，必须指向由 fopen() 或 fsockopen() 成功打开的文件(并还未由 fclose() 关闭)。
                            //$i++;
                        }//打开文件，读取内容
                        fclose($file);
                        $sql3="select Model,New_comp from eco_system where Id='$val[0]' ";
                        //die($sql3); sql  ok
                        $result3=$mysqli->query($sql3);
                        $nums3=mysqli_num_rows($result3);
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
                        //echo $pass;
                        //echo $pass1;
                        //echo '||';
                        //echo $pass.'输出pass?';  //jiedao  pass
                        $sql = " update  eco_system set 6_Endtime ='$now_date',$remark_field='$remark',$status_field='1',D_bgtime='$now_date',Status='1',Verify='$pass' where Id ='$val[0]'";
                        //die($sql);//sql语句没问题
                        $res = $mysqli->query($sql);
                        $num2 = $mysqli->affected_rows;
                        //$rec = strcmp($pass,'pass');//  echo 1
                        //echo $rec.'bbJ';
                        //echo $num2.'MMP';//  1
                        //echo $pass.'MMP2';//  pass
                        if ($num2 == 1 && trim($pass)==$pass1) {//通过后发邮件提示eco事件完成
                            //此函数返回字符串 str 去除首尾空白字符后的结果。如果不指定第二个参数，trim() 将去除这些字符：
                            /*" " (ASCII 32 (0x20))，普通空格符。
                            ◦ "\t" (ASCII 9 (0x09))，制表符。
                            ◦ "\n" (ASCII 10 (0x0A))，换行符。
                            ◦ "\r" (ASCII 13 (0x0D))，回车符。
                            ◦ "\0" (ASCII 0 (0x00))，空字节符。
                            ◦ "\x0B" (ASCII 11 (0x0B))，垂直制表符。 */
                            //echo '1';
                            $tag = $tpr;
                            $mrk = "1011";
                            $msg[] =$mrk;
                            $mail_msg[] = $model;
                            $mail_msg[] = $comp;//cy
                            $msg[] = $tag;
                            $msg[] = $mail_msg;
                            echo json_encode($msg);
                            $mysqli->close();
                            break;
                              // 发给tpr
                        }else if($num2 == 1 && trim($pass)==$reject) {
                            //echo '2';
                            $sqlj = " update eco_system set reason='$reason' where Id='$val[0]'";
                            $recj = $mysqli->query($sqlj);
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
                                    $tag = $mailto;
                                    $mrk = '1414';
                                    $mail_msg[] = $model;
                                    $mail_msg[] = $comp;
                                    $msg[] = $mrk;
                                    $msg[] = $tag;
                                    $msg[] = $mail_msg;
                                    echo json_encode($msg);
                                    //@$result->free();
                                    $mysqli->close();
                                    break;

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
        $Id=$_POST['Id'];

        /*
        $status_field=$step."_Status";

        $sql="select $status_field from eco_system where Id='$Id' ";
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
        //移动上传的文件到文件夹
        if(move_uploaded_file($file['tmp_name'],$path.$file['name'])){
            $sql="select $this_file_field from eco_system where Id='$Id' and LENGTH($this_file_field)>25";
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
        echo json_encode($msg);
       //@$result->free();
        $mysqli->close();
        break;
    case 'Send_mail':
        $mrk=$_POST['mrk'];
        $tpr=$_POST['tpr'];
        $msg=$_POST['msg'];
        switch ($mrk){//产生数据时发送
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
                    for($x=0;$x<count($arr);$x++){//把owner放在第一位
                        if ($arr[$x]['name']==$msg[0]){
                            array_unshift($arr_to,$arr[$x]);
                        }else{
                            $arr_to[]=$arr[$x];
                        }
                    }
                    //$title="WWW Repair Center BIOS Control System";
                    $title="WWW Repair Center BIOS Control System";
                    $text="this is a test mail for eco system,please ignore it <br/>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." need you trail run and upload BIOS program <br/>
	*Please login TPR ManageMent System(http://www.compal.top/Report/web/eco_system/Show.html) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)";
                }
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
               //@$result->free();
                $mysqli->close();
                break;
            case 'c'://继续的时候发送
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
                    $title="WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="this is a test mail for eco system,please ignore it <br/>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." need you pay more action<br/>
	*Please login TPR ManageMent System(http://www.compal.top/Report/web/eco_system/Show.html) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)";
                }
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
               //@$result->free();
                $mysqli->close();
                break;
            case 'f'://结束的时候发送
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
                    $title="WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="this is a test mail for eco system,please ignore it <br/>Hi ".$msg[0].":<br/>
	".$tpr[$i]." ".$msg[1]." need you trail run and upload BIOS program<br/>
	*Please login TPR ManageMent System(http://www.compal.top/Report/web/eco_system/Show.html) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)";
                }
                $mg=sendmail($arr_to,$title,$text);
                echo json_encode($mg);
               //@$result->free();
                $mysqli->close();
                break;
            case 'cf'://cgs结束的时候发送
                //CGS 单独逻辑？？？
                $tpr[]="CGS";
                for($i=0;$i<count($tpr);$i++){
                    $sql="select name,mail from mail where tpr like '%$tpr[$i]' ";
                    $result=$mysqli->query($sql);
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        $arr=array();
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $arr[]=$row;
                        }
                    }
                    ///??? yanjiu
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
                    $title="WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="this is a test mail for eco system,please ignore it <br/>Hi Repair Center:<br/>
	".$tpr[$i]." ".$msg[1]." need you infrom engineer team to do it<br/>
	*Please login TPR ManageMent System(http://www.compal.top/Report/web/eco_system/Show.html) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)";
                    $mg=sendmail($arr_to,$title,$text);
                }
                echo json_encode($mg);
               //@$result->free();
                $mysqli->close();
                break;
            case 'tf'://tpr最后一步结束的时候发送
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
                    //  ??? step5
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
                    $title="WWW Repair Center BIOS Control System";
                    //$title="WWW Repair Center BIOS Control System";
                    $text="this is a test mail for eco system,please ignore it <br/>Hi ALL:<br/>
	".$tpr." ".$msg[1]." update successful<br/>
	*Please login TPR ManageMent System(http://www.compal.top/Report/web/eco_system/Show.html) for details.<br/>
	*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)";
                    $mg=sendmail($arr_to,$title,$text);
                //}
                echo json_encode($mg);
               //@$result->free();
                $mysqli->close();
                break;
            case 'rs': //传送门4
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
    $mail->Host = "smtp.ym.163.com";
    $mail->SMTPAuth = true;
    $mail->Username = "compaltpr@compaltpr.com";
    $mail->Password = "XUDELIN8800275";
    $mail->Port = 25;
    $mail->setFrom('compaltpr@compaltpr.com', 'compaltpr@compaltpr.com');//send mailer
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
