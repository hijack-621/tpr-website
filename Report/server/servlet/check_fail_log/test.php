<?php
/*
$tpr='RLC_SH';
$bgtime='2017-12-01';
$edtime='2017-12-30';
$table=$tpr.'_befor_time';
$table2=$tpr.'_log_fail_check';
$table3=$tpr.'_fail_data';
$connID="";
include '../db/link_db.php';
        mysqli_query($connID,"truncate table $table ");
        $result=mysqli_query($connID,"select distinct check_time,fail from $table3 order by check_time");
        $check_arr=array();
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $check_arr[]=$row;
        }
        for($i=0;$i<count($check_arr);$i++){
            $ck_time=$check_arr[$i][0];
            $fail=$check_arr[$i][1];
            $result=mysqli_query($connID,"insert into $table (check_time,fail) values ('$ck_time','$fail') ");

        }

        for($i=0;$i<count($check_arr);$i++){
            $ck_time=$check_arr[$i][0];
            $fail=$check_arr[$i][1];
            $result=mysqli_query($connID,"select check_time from $table where check_time<'$ck_time' and fail='$fail' order by check_time desc limit 1");
            //鏌ヨ鎴愬姛杩斿洖鏁版嵁
            $nums=mysqli_num_rows($result);
            if ($nums==0){
            }else{
                $arr_time=array();
                while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
                    $arr_time[]=$row;
                }
                $bf_time=$arr_time[0][0];
                $result=mysqli_query($connID,"update $table set befor_time='$bf_time' where check_time='$ck_time' and fail='$fail' ");
            }
        }

        $result=mysqli_query($connID,"select check_time,fail,befor_time from $table ");
        $arr_time=array();
        while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
            $arr_time[]=$row;
        }
        print_r($arr_time);
include '../db/close_db.php';
*/
$tpr="IGS";
$table1=$tpr.'_check_data';
$table2=$tpr.'_fail_data';
$connID="";
include '../../db/link_db.php';

$result=mysqli_query($connID,"select name,Checer from tpr_name where TPR='$tpr' ");
while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
    $tpr_name=$row["name"];
    $cpal_name=$row["Checer"];
}
$result=mysqli_query($connID,"select $table2.Test_time,$table2.Station,$table2.Fail_Item from $table2 left join $table1
    on $table2.PPID=$table1.PPID where $table1.PPID is null ");
$nums=mysqli_num_rows($result);
if ($nums!=0){
    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
        $bfdata_arr[]=$row;
    }
    //insert data
    mysqli_query($connID,"insert $table1(PPID,Test_time,Station,Fail_Item,Model,Correct,TPR_owner,Compal_owner) (select $table2.PPID,$table2.Test_time,$table2.Station,$table2.Fail_Item,$table2.Model,$table2.Correct,'$tpr_name' as TPR_owner,'$cpal_name' as Compal_owner from $table2 left join $table1
        on $table2.PPID=$table1.PPID where $table1.PPID is null) ");
    for($i=0;$i<count($bfdata_arr);$i++){
        $ck_time=$bfdata_arr[$i]["Test_time"];
        $fa_item=$bfdata_arr[$i]["Fail_Item"];
        $rs_time=mysqli_query($connID,"select Test_time from $table1 where Test_time<'$ck_time' and Fail_Item='$fa_item' order by Test_time desc limit 1 ");
        while (($bf = mysqli_fetch_array($rs_time,MYSQLI_ASSOC))!==false&&$bf>0) {
            $bf_time=$bf["Test_time"];
            echo json_encode($bf);
            mysqli_query($connID,"update $table1 set Befor_time='$bf_time' where Fail_Item='$fa_item' and Test_time='$ck_time'");
        }
    }
    echo 'success';
}
include '../../db/close_db.php';
function update_data($tpr){
    $table1=$tpr.'_check_data';
    $table2=$tpr.'_fail_data';
    $connID="";
    include '../../db/link_db.php';
    $result=mysqli_query($connID,"select name,Checer from tpr_name where TPR='$tpr' ");
    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
        $tpr_name=$row["name"];
        $cpal_name=$row["Checer"];
    }
    $result=mysqli_query($connID,"select $table2.Test_time,$table2.Station,$table2.Fail_Item from $table2 left join $table1
        on $table2.PPID=$table1.PPID where $table1.PPID is null ");
    $nums=mysqli_num_rows($result);
    if ($nums!=0){
        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
            $bfdata_arr[]=$row;
        }
        //insert data
        $result=mysqli_query($connID,"insert $table1(PPID,Test_time,Station,Fail_Item,Model,Correct,TPR_owner,Compal_owner) (select $table2.PPID,$table2.Test_time,$table2.Station,$table2.Fail_Item,$table2.Model,$table2.Corret,'$tpr_name' as TPR_owner,'$cpal_name' as Compal_owner from $table2 left join $table1
            on $table2.PPID=$table1.PPID where $table1.PPID is null) ");
        for($i=0;$i<count($bfdata_arr);$i++){
            $ck_time=$bfdata_arr[$i]["Test_time"];
            //$station=$bfdata_arr[$i]["Station"];
            $fa_item=$bfdata_arr[$i]["Fail_Item"];
            $rs_time=mysqli_query($connID,"select Test_time from $table1 where Test_time<'$ck_time' and Fail_Item='$fa_item' order by Test_time desc limit 1 ");
            while (($bf = mysqli_fetch_array($rs_time,MYSQLI_ASSOC))!==false&&$bf>0) {
                $bf_time=$bf["Test_time"];
                //echo json_encode($bf);
                mysqli_query($connID,"update $table1 set Befor_time='$bf_time' where Fail_Item='$fa_item' and Test_time='$ck_time'");
            }
        }
    }
    include '../../db/close_db.php';
}
?>