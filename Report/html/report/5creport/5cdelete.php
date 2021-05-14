<?php
session_start();
$path = $_POST['paths'];
$tpr = $_POST['tpr'];
$paths_arr=explode(',',$path);
array_pop($paths_arr);
$j=null;
$temp=0;
if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
    echo 0;
    return;
}

for($i=0;$i<count($paths_arr);$i++){
    if(is_file($paths_arr[$i])==true){
        $file_name=trim(strrchr($paths_arr[$i],'/'),'/');
        
        $dir=substr($paths_arr[$i],0,strrpos($paths_arr[$i], '/'));
        //echo json_encode($paths_arr[$i]);
        echo json_encode(deldir($dir)); 
    }else{
        $dir = './5cfile/'.$tpr.'/'.$paths_arr[$i];
        // if(is_file($paths_arr[$i])==true){
         echo json_encode(deldir($dir)); 
    }
    // echo json_encode($paths_arr[$i]);
    
    
}





function deldir($dir){
    $dh=opendir($dir);
    while (false!=($file=readdir($dh))) {
        if($file!="." && $file!="..") {
            $fullpath=$dir."/".$file;
            if(!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    if(rmdir($dir)) {
        //echo "1";
        return 1;
    } else {
        //echo "0";
        return 0;
    }
}