<?php
 include '../class/Database.Class.php';
 //include 'Controller.php';
 class rrdoalog{
    private $result;

    public function insertdata($data){//对应 ajax index.html data:{action:rrdoalg/insertdata}
         
       // echo json_encode($data);
       $db = Mysql::getInstance();//单例模式 创建一个数据库db对象，用于操作数据库
       for($i=0;$i<count($data);$i++){ //excel 有几行数据就插入几行
          
            $sql = "insert into a31fa (Input_Date,Emp_id,Items,RMA_Date,DPS,WEEK,Dell_Model,PPID,Hold_Reason,Key_Words,Customer_Issue_Info
,FA_Date,Failure_Symptom,Repair_Location,Disposition,Duplicate_or_not,FA,CA,Evidence,Catagory,Status,Input_Date1,Emp_id1,Update_Date,PE,QA) values('{$data[$i]['Input_Date']}','{$data[$i]['Emp_id']}','{$data[$i]['Items']}','{$data[$i]['RMA_Date']}','{$data[$i]['DPS']}'
,'{$data[$i]['WEEK']}','{$data[$i]['Dell_Model']}','{$data[$i]['PPID']}','{$data[$i]['Hold_Reason']}'
,'{$data[$i]['Key_Words']}','{$data[$i]['Customer_Issue_Info']}'
,'{$data[$i]['FA_Date']}','{$data[$i]['Failure_Symptom']}','{$data[$i]['Repair_Location']}','{$data[$i]['Disposition']}'
,'{$data[$i]['Duplicate_or_not']}','{$data[$i]['FA']}','{$data[$i]['CA']}','{$data[$i]['Evidence']}'
,'{$data[$i]['Catagory']}','{$data[$i]['Status']}','{$data[$i]['Input_Date1']}','{$data[$i]['Emp_id1']}'
,'{$data[$i]['Update_Date']}','{$data[$i]['PE']}','{$data[$i]['QA']}') "; 
// {$data[$i]['QA']} 其中被{}包裹的变量是可以被php识别的，而且{}里面的单双引号不会对外面的造成影响！！！
            //die($sql);
            $res = $db->carrySql($sql);//封装在 Database.Class.php中的方法
            echo json_encode($res);
            
       }
    }


    public function query_select_data($condition){
        $db =Mysql::getInstance();//单例模式 创建一个数据库db对象，用于操作数据库
        $sql = "select distinct {$condition } from a31fa";
        //die($sql);
        $res = $db->getRows($sql);
        echo json_encode($res);

       // echo json_encode($condition);

    }
    public function query_excel_data($condition){
        $db = Mysql::getInstance();
       foreach($condition[0] as $key=>$value){
           //var_dump($value);
           $field = $value['value'];
       }
    //    echo $field;
    //    return '';
        $conditionarr = $condition[1];
        $sql = "select Input_Date,Emp_id,Items,RMA_Date,DPS,WEEK,Dell_Model,PPID,Hold_Reason,Key_Words,Customer_Issue_Info
,FA_Date,Failure_Symptom,Repair_Location,Disposition,Duplicate_or_not,FA,CA,Evidence,Catagory,Status,Input_Date1,Emp_id1,Update_Date,PE,QA
from a31fa where ";
        for($i=0;$i<count($conditionarr);$i++){
            if($i==0){
                $sql.="$field"."='{$conditionarr[$i]['value']}'";
            }else{
                $sql.="or"." {$field}"."='{$conditionarr[$i]['value']}'";
            }
           
        }
        //die($sql);
       $res =  $db->getRows($sql);
       echo json_encode($res);

    }
    public function showall(){
        $db = Mysql::getInstance();
        $sql = "select id,Input_Date,Emp_id,Items,RMA_Date,DPS,WEEK,Dell_Model,PPID,Hold_Reason,Key_Words,Customer_Issue_Info
        ,FA_Date,Failure_Symptom,Repair_Location,Disposition,Duplicate_or_not,FA,CA,Evidence,Catagory,Status,Input_Date1,Emp_id1,Update_Date,PE,QA
        from a31fa";
        $res = $db->getRows($sql);
        echo json_encode($res);
    }
 }