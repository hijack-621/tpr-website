<?php
include('Database.Class.php'); 
$flag = $_POST['flag'];

switch($flag){
    case 'getopts':
        $db = Mysql::getInstance();
        $sql = "select distinct Compal_Name as model from matrix_rlc_sh order by model asc ";
        $rows = $db->getRows($sql);
        echo json_encode($rows);
    break;
    case 'search':
        $db = Mysql::getInstance();
        $field = $_POST['data'];
        $nums = count($field);
        $sql = "select TPR,issueTime,owner,filename from 5c_tab ";
        foreach( $field as $key=>$val){ //sql 拼接完成多条件查询
            //issueTime或者 issueTime +status 作为搜索条件
            if($val['name']!='select' && $nums ==1){  //只有issueTime 
                $a = explode('~',$val['value']);
                $a[0]==$a[1] ? $sql.=" where issueTime='{$a[0]}' " :  $sql.=" where issueTime between '{$a[0]}' and '{$a[1]}'";   
            }
            else if($nums ==2){//issueTime +status
                if($key==0 && $val['name']!='select' ){
                    $a = explode('~',$val['value']);
                    $a[0]==$a[1] ? $sql.=" where issueTime='{$a[0]}' " :  $sql.=" where issueTime between '{$a[0]}' and '{$a[1]}'";    
                }else{
                    $a = explode('_',$val['value']);
                    $sql.=" and {$a[0]}='{$a[1]}'";
                }
            }else {
                if($val['name']=='select'){
                    $a = explode('_',$val['value']);
                    if($key==0){
                        $sql.=" where {$a[0]}='{$a[1]}'";
                    }else{
                        $sql.=" and {$a[0]}='{$a[1]}'";
                    }
                   
                }else{
                    $a = explode('~',$val['value']);
                    $a[0]==$a[1] ? $sql.=" and issueTime='{$a[0]}' " :  $sql.=" and issueTime between '{$a[0]}' and '{$a[1]}'";  
                }
            }
        }
        $ret = $db->getRows($sql);
        if(count($ret)>0){
            echo json_encode($ret);
        }else{
            echo json_encode([]);
        }
        
    break;
    case 'download':
    $zip = new ZipArchive();
    $zip_time = "reports.zip"; // 压缩的目录名
    $zip_filename = "../uploads/report/".$zip_time; // 指定一个压缩包地址
    if(file_exists($zip_filename)){
        unlink($zip_filename);
    }
    $filelists = list_dir("../uploads");
    // echo '<pre>';
    // var_dump($filelists);
    $zip->open($zip_filename, ZIPARCHIVE::CREATE); // 打开压缩包,没有则创建
 
    // 参数1是要压缩的文件,参数2为压缩后,在压缩包中的文件名「这里我们把 demo1.php 文件压缩,压缩后的文件为 dd.php」,如果需要的压缩后的文件跟原文件名一样 addFile() 的第二个参数可以改为 basename("../alg/demo1.php"),也就是原文件所在的路径
    foreach($filelists as $file){
        $zip->addFile($file,basename($file)); 
    }
    $rs = $zip->close();
    if($rs){
        echo json_encode('200');
    }    
    break;    
}

function list_dir($dir){
    $result = array();
    if (is_dir($dir)){
        $file_dir = scandir($dir);
        foreach($file_dir as $file){
            if ($file == '.' || $file == '..' ||is_dir($dir.'/'.$file)){
                continue;
        }
        // elseif (is_dir($dir.$file)){
        //         $result = array_merge($result, list_dir($dir.$file.'/'));
        // }
        else{
                array_push($result, $dir.'/'.$file); //只要../uoloads下的文件
            }
        }
    }
    return $result;
}