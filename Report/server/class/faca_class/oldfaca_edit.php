<?php
class n_faca{
    function getdata($tpr,$type){
        switch ($type){
            case 'unclose':
                $connID="";
                include '../../db/link_db.php';
                if($tpr=='CGS'){
                    $stpr=array("RLC_SH","CEP","CEB","IGS","CTS","CGS","TSI");
                }else{
                    $stpr=array($tpr);
                }
                $arr=array();
                for($i=0;$i<count($stpr);$i++){
                    if ($stpr[$i]=="CSAT"){
                        $table1='cts_check_data';
                    }else{
                        $table1=$stpr[$i].'_check_data';
                    }

                    //$table2=$stpr[$i].'_fail_data';
                    update_data($stpr[$i]);
                    $data_arr=array();
                    $data_arr[]=$stpr[$i];
                    $result=mysqli_query($connID,"select PPID,Test_time,Station,Fail_Item,Model,Correct,Befor_time,TPR_owner,Compal_owner,TPR_FA,Action,update_time from $table1 where isnull(Compal_check) order by Test_time");
                    while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
                        $data_arr[]=$row;
                    }
                    if(count($data_arr)>1){
                        $arr[]=$data_arr;
                    }
                }
                include '../../db/close_db.php';
                return $arr;
                break;
            case 'search':
                update_data($tpr);
                break;
        }
    }
}
function update_data($tpr){
    if ($tpr=="CSAT"){
        $tpr="cts";
    }
    $table1=$tpr.'_check_data';
    $table2=$tpr.'_fail_data';
    $connID="";
    include '../../db/link_db.php';
    $result=mysqli_query($connID,"select name,Checer from tpr_name where TPR='$tpr' ");
    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
        $tpr_name=$row["name"];
        $cpal_name=$row["Checer"];
    }
	$sql = "select $table2.Test_time,$table2.Station,$table2.Fail_Item from $table2 left join $table1 on $table2.PPID=$table1.PPID where $table1.PPID is null ";
    $result=mysqli_query($connID,$sql);
	//die($sql);
    $nums=mysqli_num_rows($result);
    if ($nums!=0){
        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
            $bfdata_arr[]=$row;
        }
        //insert data
        $result=mysqli_query($connID,"insert $table1(PPID,Test_time,Station,Fail_Item,Model,Correct,TPR_owner,Compal_owner) (select $table2.PPID,$table2.Test_time,$table2.Station,$table2.Fail_Item,$table2.Model,$table2.Correct,'$tpr_name' as TPR_owner,'$cpal_name' as Compal_owner from $table2 left join $table1
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