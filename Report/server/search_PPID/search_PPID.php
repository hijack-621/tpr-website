<?php
$ppid=$_POST['ppid'];
$bgtime=$_POST['bgtime'];
$edtime=$_POST['edtime'];
//$ppid="CN0C7K681296355F087C";
//$bgtime="2017-02-01";
//$edtime="2017-11-26";
$path="D:/TestLog/*";
$arr_path=glob($path);
$path_arr=array();
$qc2_file=array();
$qc3_file=array();
$time=array();
for ($i=0;$i<count($arr_path);$i++){
    if (is_dir($arr_path[$i])){
        $resDir=opendir($arr_path[$i]);
        while(false!=($file=readdir($resDir))){
            $path=$arr_path[$i].'/'.$file;//QC2,QC3
            if(is_dir($path) AND $file!='.' AND $file!='..'){
                $resDir_o=opendir($path);
                while(false!=($files=readdir($resDir_o))){
                    $path_o=$path.'/'.$files;//date
                    if(is_dir($path_o) AND $files!='.' AND $files!='..'){
                        //date
                        if ($files>=$bgtime&&$files<=$edtime){
                        $resDir_s=opendir($path_o);
                        while(false!=($file_s=readdir($resDir_s))){
                            if($file_s!='.' AND $file_s!='..'){
                                if ($ppid==substr($file_s,0,20)){

                                    if (strpos($path_o,"QC2")){
                                        $qc2_file[]=$path_o.'/'.$file_s;//$i

                                    }else if(strpos($path_o,"QC3")){
                                        $qc3_file[]=$path_o.'/'.$file_s;//$i

                                    }

                                }
                            }
                        }
                    }
                    }
                }

            }
        }
    }

//     if (count($arr_file)>0){
//         break;
//     }

}
if(count($qc2_file)>0){
    $time=explode("/",$qc2_file[0]);
    $final_path=$qc2_file[0];
    $temp_file=explode("/",$qc2_file[0]);
    for($d=0;$d<count($qc2_file);$d++){
        $temp=explode("/",$qc2_file[$d]);
        if($temp[4]>$time[4]){
            $time=explode("/",$qc2_file[$d]);
            $temp_file=explode("/",$qc2_file[$d]);
            $final_path= $qc2_file[$d];
        }
    }
    @copy($final_path,"../../html/search_PPID/tempqc2/".$temp_file[5]);
    $path_arr[]=$final_path;
}
if(count($qc3_file)>0){
    $time=explode("/",$qc3_file[0]);
    $final_path=$qc3_file[0];
    $temp_file=explode("/",$qc3_file[0]);
    for($d=0;$d<count($qc3_file);$d++){
        $temp=explode("/",$qc3_file[$d]);
        if($temp[4]>$time[4]){
            $time=explode("/",$qc3_file[$d]);
            $temp_file=explode("/",$qc3_file[$d]);
            $final_path= $qc3_file[$d];
        }
    }
    @copy($final_path,"../../html/search_PPID/tempqc3/".$temp_file[5]);
    $path_arr[]=$final_path;
}
echo json_encode($path_arr);
?>