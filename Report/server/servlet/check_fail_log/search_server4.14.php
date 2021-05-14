<?php
session_start();
$flag=$_POST['flag'];
$mysqli=null;
include '../../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}

switch ($flag){
    case 1:
        if (empty($_SESSION["uname"])){
            echo "0";
        }else {
            echo "1";
        }
        break;
    case 2:
        $tpr=$_POST['tpr'];
        $stpr=$_SESSION['utpr'];
        if ($tpr!==$stpr&&$stpr!=="CGS"){
            echo json_encode("0010");
            return ;
        }
        $bgtime=$_POST['bgtime'];
        $edtime=$_POST['edtime'];
        if ($tpr=='CSAT'){
            $tpr='CTS';
        }
        $table1=$tpr.'_check_data';
        $table2=$tpr.'_fail_data';
        $data_arr[]=$tpr;
        require_once '../../class/faca_class/faca_edit.php';
        $type='search';
        $faca=new n_faca();
        $faca_dt=$faca->getdata($tpr,$type);
        //杩炴帴鏁版嵁搴�
        $connID="";
        include '../../db/link_db.php';
        if($bgtime==null&&$edtime!=null){
            $result=mysqli_query($connID,"select * from $table1 where Test_time<='$edtime' order by Test_time");
        }elseif($bgtime!=null&&$edtime==null){
            $result=mysqli_query($connID,"select * from $table1 where Test_time>='$bgtime' order by Test_time");
        }elseif ($edtime==null&&$bgtime==null){
            $result=mysqli_query($connID,"select * from $table1 order by Test_time");
        }elseif ($edtime!=null&&$bgtime!=null){
            $result=mysqli_query($connID,"select * from $table1 where Test_time>='$bgtime' and Test_time<='$edtime' order by Test_time");
        }
        while (($row = mysqli_fetch_array($result,MYSQLI_NUM))!==false&&$row>0) {
            $data_arr[]=$row;
        }
        include '../../db/close_db.php';
        echo json_encode($data_arr);
        break;
    case 3:
        require_once '../../class/faca_class/faca_edit.php';
        $type='unclose';
        $tpr=$_SESSION['utpr'];
        $faca=new n_faca();
        $faca_dt=$faca->getdata($tpr,$type);
        echo json_encode($faca_dt);
        break;

    case 4:
        $arrppid = $_POST['distppidarr'];
        //echo (gettype($arrppid));
        $pstr = implode(',',$arrppid);
        //echo $pstr;
        //$pstr = explode(',',$arrppid);
        $nowtime = date('Y-m-d H:i:s');
        $sql = "insert into mppid (multippid,mtime) values ('$pstr','$nowtime')";
        //die($sql);
        $res = $mysqli->query($sql);
        $num = $mysqli->affected_rows;
       if($num > 0){
           echo json_encode($arrppid);
       }else{
           return json_encode('error');
       }




        break;
}
