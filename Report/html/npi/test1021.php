<?php
/**
 * Created by PhpStorm.
 * User: Iori
 * Date: 2020/10/21
 * Time: 10:35
 */
include 'Database.Class.php';
class NPIController{
    public function test(){
        $arr = ['CEP','CEB'];
        //$tarr = [];
        $db=mysql::getInstance();
        for($i=0;$i<count($arr);$i++){
            //mysqli_result::free();
            $sql="select name,mail,tpr from mail where tpr='$arr[$i]' and spmaflag=6 ";
            $res =  $db->getRows($sql);
            var_dump($res) ;
            unset($res);
            //$res = [];
            //array_push($tarr,$sql);
           // $tarr[$i] = $res;
            //echo $arr[$i].'<br/>';

        }

    }
}
$instance = new NPIController();
echo '<pre>';
var_dump($instance->test());