<?php
//����session
session_start();
//�жϱ�־λ
$flag=$_POST['flag'];
switch ($flag){
    case 1:
        if (empty($_SESSION["uname"])){
            echo "0";
        }else {
            echo "1";
        }
        break;
    case 2:
        require_once '../../class/bios_class/bios_edit.php';
        require_once '../../class/faca_class/faca_edit.php';

        $uname=$_SESSION['utpr'];
        $tpr=$_SESSION['utpr'];
        $type='unclose';
        $index_dt=array();
        $index_dt[]=$uname;

//        $bios=new bios();
//        $bios_dt=$bios->getdata($tpr,null,null,$type);
//        $index_dt[]=$bios_dt;
//
//        $faca=new n_faca();
//        $faca_dt=$faca->getdata($tpr,$type);
//        $index_dt[]=$faca_dt;
        echo json_encode($index_dt);
        break;
    case 3:
        require_once '../../class/bios_class/bios_edit.php';
        $msg_arr=$_POST['msg'];
        $msg_arr=explode(",",$msg_arr);
        $tpr=$msg_arr[0];
        $model=$msg_arr[1];
        $desc=$msg_arr[2];
        $bios=new bios();
        $type='single';
        $bios_dt=$bios->getdata($tpr,$desc,$model,$type);
        $index_dt[]=$bios_dt;

        echo json_encode($index_dt);
        break;
}
?>