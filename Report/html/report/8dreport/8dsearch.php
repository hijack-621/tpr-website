<?php
$darr = $_POST['data'];
$flag = $darr[0];
$date = $darr[1];
$tpr =  $darr[2];
//echo json_encode($date);
//$uptime = date('Ymd',$date);
if($flag=='notall'){
    $len = strlen($date);
    if($len==12){
        //echo json_encode($date);
        $dir="./8dfile/".$tpr.'/'.$date;
        $handle=opendir($dir);
        //read directory
        while (false!=($file=readdir($handle))){
            if ($file!='.'&&$file!='..'){
                $fname[]=$file;
                $spath[]=$dir."/".$file;
               
            }
        }
        
        $arr=array();
        
        $arr=array_merge($arr,$fname);
        $arr=array_merge($arr,$spath);
        echo json_encode($arr);
    }else{
   
        $dir="./8dfile/".$tpr;
        $folderarr = array();
         
        foreach (scandir($dir) as $filefloder){

            if ($filefloder!=='.'&&$filefloder!=='..'){
                
                if (is_dir( $dir.'/'.$filefloder)&&strstr($filefloder,$date)){
                     $folderarr[] = $filefloder;
                    // echo json_encode('aaa');
                }
            }
        } 
        
    if(count($folderarr)==1){
        $dir="./8dfile/".$tpr.'/'.$folderarr[0];
        $handle=opendir($dir);
        //read directory
        while (false!=($file=readdir($handle))){
            if ($file!='.'&&$file!='..'){
                $fname[]=$file;
                $spath[]=$dir."/".$file;
               
            }
        }
            $arr=array();
           
            $arr=array_merge($arr,$fname);
            $arr=array_merge($arr,$spath);
            echo json_encode($arr);
        }else{
            $arr=array();
            $arr_tag[]="1";
            $arr=array_merge($arr,$arr_tag);
            $arr=array_merge($arr,$folderarr);
            echo json_encode($arr); 
        }
        
    }// else

}elseif($flag=='all'){
    $arr_wk=array();
    $dir="./8dfile/".$tpr.'/';
    foreach (scandir($dir) as $filefloder){
        if ($filefloder!=='.'&&$filefloder!=='..'&&$filefloder!=='temp'){
            if (!is_dir($filefloder)){
                $arr_wk[]=$filefloder;
            }
        }
    }
    $arr=array();
    $arr_tag[]="1";
    $arr=array_merge($arr,$arr_tag);
    $arr=array_merge($arr,$arr_wk);
    echo json_encode($arr);
}

?>