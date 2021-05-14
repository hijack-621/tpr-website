<?php
class bios{
    function getdata($tpr,$Activity,$model,$type){
        $connID="";
        include '../../db/link_db.php';
        $arr=array();
        switch ($type){
            case 'unclose':
                if ($tpr=='CGS'){
                $result=mysqli_query($connID,"select TPR,Model,Description,Begingtime,Endtime,State from project where State=0 ");
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
                }
                }
                $lock=array();
                for($i=0;$i<count($arr);$i++){
                    $model=$arr[$i][1];
                    $desc=$arr[$i][2];
                    $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                            $arr[$i][]=$row[0][0];
                        }
                    }
                }
                }else{
                    $result=mysqli_query($connID,"select TPR,Model,Description,State from project where State=0 and TPR='$tpr' ");
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                    while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                    }
                    $lock=array();
                    for($i=0;$i<count($arr);$i++){
                        $model=$arr[$i][1];
                        $desc=$arr[$i][2];
                        $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                        $nums=mysqli_num_rows($result);
                        if ($nums!=0){
                            while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                                $arr[$i][]=$row[0][0];
                            }
                        }
                    }
                }
                break;
            case 'single':

                $result=mysqli_query($connID,"select TPR,Model,Description,Begingtime,Endtime,State from project where TPR='$tpr' ");
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                    while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                        $arr[]=$row;
                    }
                }
                $lock=array();
                for($i=0;$i<count($arr);$i++){
                    $model=$arr[$i][1];
                    $desc=$arr[$i][2];
                    $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$desc' ");
                    $nums=mysqli_num_rows($result);
                    if ($nums!=0){
                        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                            $arr[$i][]=$row[0][0];
                        }
                    }
                }
                /*
                $result=mysqli_query($connID,"select TPR,Model,Description,Begingtime,Endtime,State from project where TPR='$tpr' and Description='$Activity' and Model='$model' ");
                $arr=array();
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
                }
                $result=mysqli_query($connID,"select distinct `lock` from steps where Model='$model' and Activity='$Activity' ");
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                    while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                        $arr[0][]=$row[0][0];
                    }
                }
                }
                */
                break;
            case 'all':
                $result=mysqli_query($connID,"select TPR,Model,Description,Begingtime,Endtime,State from project ");
                $arr=array();
                $nums=mysqli_num_rows($result);
                if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                    $arr[]=$row;
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