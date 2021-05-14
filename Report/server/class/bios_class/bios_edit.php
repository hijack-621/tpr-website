<?php
class bios{
    function getdata($tpr,$Activity,$model,$type){
        $mysqli=null;
        include '../../../db/new_link_db.php';
        $arr=array();
        switch ($type){
            case 'unclose':
                $arr=array();
                $tpr_arr=Array("CGS","RLC_SH","IGS","CEP","CSAT","CEB","RLC_INDIA","Regenersis_INDIA");

                if($tpr=='CGS'){
                    $sql="select * from bios_system where Status!=1 and Status!=5 and Suo=0 ";
                }else{
                    $sql="select * from bios_system where Status!=1 and Status!=5 and TPR='$tpr' and Suo=0 ";
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
            }
        }
                break;
            case 'single':
                $temp_arr=array();
                $temp_arr[]=$tpr;
                $result=mysqli_query($connID,"select TPR,Model,Description,Begingtime,Endtime,State from project where TPR='$tpr' and Newver='$Activity' and Model='$model' ");
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                        $desc=$row['Description'];
                        //$temp_arr[]=$row;
                        $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                        $nums=mysqli_num_rows($result);
                        if ($nums!=0){
                            while (($lk = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$lk>0) {
                                $row['Lock']=$lk['lock'];
                            }
                            $temp_arr[]=$row;
                        }
                }

                $arr[]=$temp_arr;
                }
                break;
            case 'all':
                $arr=array();
                $tpr_arr=Array("CGS","RLC_SH","IGS","CEP","CSAT","CEB","RLC_INDIA","Regenersis_INDIA");
                if ($tpr=='CGS'){
                    for ($i=0;$i<count($tpr_arr);$i++){
                        $result=mysqli_query($connID,"select * from project where TPR='$tpr_arr[$i]' ");
                        $nums=mysqli_num_rows($result);
                        if($nums!=0){
                            $temp_arr=array();
                            $str=null;
                            $temp_arr[]=$tpr_arr[$i];
                            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {

                                $model=$row['Model'];
                                $desc=$row['Description'];
                                $results=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                                $nums=mysqli_num_rows($results);
                                if ($nums!=0){
                                    while (($lk = mysqli_fetch_array($results,MYSQLI_ASSOC))!==false&&$lk>0) {
                                        $row['Lock']=$lk['lock'];
                                    }
                                    $temp_arr[]=$row;
                                }
                            }
                            $arr[]=$temp_arr;
                        }
                    }
                }else{
                    $result=mysqli_query($connID,"select * from project where and TPR='$tpr' ");
                    $nums=mysqli_num_rows($result);
                    if($nums!=0){
                        $temp_arr=array();
                        $temp_arr[]=$tpr;
                        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                            $model=$row['Model'];
                            $desc=$row['Description'];
                            $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                            $nums=mysqli_num_rows($result);
                            if ($nums!=0){
                                while (($lk = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$lk>0) {
                                    $row['Lock']=$lk['lock'];
                                    //echo json_encode($lk);
                                }
                                $temp_arr[]=$row;
                            }
                        }

                        $arr[]=$temp_arr;
                    }
                }
                break;
            case 'model':
                $result=mysqli_query($connID,"select distinct Model from project");
                $arr=array();
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
                }
                }
                break;
            case 'ver':
                $result=mysqli_query($connID,"select distinct Newver,New_sysver from project");
                $arr=array();
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
                }
                }
                break;
        }
        include '../../db/close_db.php';
        return $arr;
    }
    function del($tpr,$Activity,$model){
        $connID="";
        include '../../db/link_db.php';
        $arr=array();
        switch ($tpr){
            case 'CGS':
                $result=mysqli_query($connID,"select TPRS from project where TPR='$tpr' and Description='$Activity' and Model='$model' ");
                $arr=array();
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
                }
                $tpr_arr=explode(',',$arr[0][0]);
                array_pop($tpr_arr);
                $tpr_arr[]='CGS';
                for ($i=0;count($tpr_arr);$i++){
                    mysqli_query($connID,"set autocommit=0 ");
                    mysqli_query($connID,"start transaction ");

                    $result1=mysqli_query($connID, "delete from checker where Activity='$Activity' and Model='$model' and TPR='$tpr_arr[$i]' ");
                    $result3=mysqli_query($connID, "delete from checker where Description='$Activity' and Model='$model' and TPR='$tpr_arr[$i]' ");
                    $result2=mysqli_query($connID, "delete from checker where Activity='$Activity' and Model='$model' and TPR='$tpr_arr[$i]' ");
                    $nums1=mysqli_num_rows($result1);
                    $nums2=mysqli_num_rows($result2);
                    $nums3=mysqli_num_rows($result3);
                    $nums=($nums1&&$nums2&&$nums3);
                    if ($nums==0){
                        mysqli_query($connID,"rollback");
                        mysqli_query($connID,"set autocommit=1");
                        $mark=0;
                        continue;
                    }else{
                        mysqli_query($connID,"commit");
                        mysqli_query($connID,"set autocommit=1");
                        file_del($tpr_arr[$i],$Activity,$model);
                        $mark=1;
                    }
                }
                break;
            default:

                mysqli_query($connID,"set autocommit=0 ");
                mysqli_query($connID,"start transaction ");

                $result1=mysqli_query($connID, "delete from checker where Activity='$Activity' and Model='$model' and TPR='$tpr' ");
                $result3=mysqli_query($connID, "delete from project where Description='$Activity' and Model='$model' and TPR='$tpr' ");
                $result2=mysqli_query($connID, "delete from steps where Activity='$Activity' and Model='$model' and TPR='$tpr' ");
                $nums1=mysqli_num_rows($result1);
                $nums3=mysqli_num_rows($result3);
                $nums2=mysqli_num_rows($result2);
                $nums=($nums1&&$nums2&&$nums3);
                if ($nums==0){
                    mysqli_query($connID,"rollback");
                    mysqli_query($connID,"set autocommit=1");
                    $mark=0;
                }else{
                    mysqli_query($connID,"commit");
                    mysqli_query($connID,"set autocommit=1");
                    file_del($tpr,$Activity,$model);
                    $mark=1;
                }

                break;
        }
        include '../../db/close_db.php';
        function file_del($tpr,$Activity,$model){
            $dir[]="../../../ECO_System_file/".$tpr.'/'.$model.'/'.$Activity;
            deldir($dir);
            //closedir($dir);
            //$mark=1;
        }
        return $mark;
    }
}

?>