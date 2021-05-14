<?php
session_start();
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
        $path=$_POST['st'];//tpr
        $week=$_POST['wk'];
        $year=$_POST['year'];
        $arr_tpr[]=$path;

        if($_SESSION['utpr']=="CGS"||$_SESSION['utpr']==$path){
            if($path=="CSAT"){
                $path="CTS";
            }
            if ($path==null||$path==''){
                echo "3";
                return ;
            }else {
                if($year==''||$year==''){
                    $arr_wk=array();
                    $dir="../../TPR report/VFIR/".$path;
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
                    $arr=array_merge($arr,$arr_tpr);
                    $arr=array_merge($arr,$arr_wk);
                    echo json_encode($arr);
                }else{
                    if($week==''||$week==null){
                        $arr_wk=array();
                        $dir="../../TPR report/VFIR/".$path;
                        foreach (scandir($dir) as $filefloder){
                            if ($filefloder!=='.'&&$filefloder!=='..'&&$filefloder!=='temp'){
                                if (!is_dir($filefloder)&&strpos($filefloder,$year)!==false){
                                    $arr_wk[]=$filefloder;
                                }
                            }
                        }
                        $arr=array();
                        $arr_tag[]="1";
                        $arr=array_merge($arr,$arr_tag);
                        $arr=array_merge($arr,$arr_tpr);
                        $arr=array_merge($arr,$arr_wk);
                        echo json_encode($arr);
                    }else{
                        $weeks=$year."-W".$week;
                        $dir="../../TPR report/VFIR/".$path."/".$weeks;
                        //open directory
                        $handle=opendir($dir);
                        //read directory
                        while (false!=($file=readdir($handle))){
                            if ($file!='.'&&$file!='..'){
                                if (is_dir("$dir/$file")){
                                    $dirs=$dir."/".$file;
                                    $handles=opendir($dirs);
                                    while (false!=($files=readdir($handles))){
                                        if ($files!='.'&&$files!='..'){
                                            // @copy($dirs."/".$files,"temp/".$files);
                                            $fname[]=$files;
                                            $spath[]=$dirs."/".$files;
                                            //FileUtil::copyFile("$dirs."/".$files");
                                        }
                                    }
                                }
                            }
                        }
                        $arr=array();
                        $arr_tag[]="2";
                        $arr=array_merge($arr,$arr_tag);
                        $arr=array_merge($arr,$arr_tpr);
                        $arr=array_merge($arr,$fname);
                        $arr=array_merge($arr,$spath);
                        echo json_encode($arr);
                    }
                }
            }
        }else{
            echo "5";
        }
            break;
            case 3:
                $d_week=$_POST['d_wk'];
                $d_tpr=$_POST['d_tpr'];
                if($d_tpr=="CSAT"){
                    $d_tpr="CTS";
                }
                $paths="../../TPR Report/VFIR/".$d_tpr."/".$d_week;
                $handle=opendir($paths);
                $d_fname="";
                $d_spath="";
                while (false!=($d_file=readdir($handle))){
                    if ($d_file!='.'&&$d_file!='..'){
                        if (is_dir("$paths/$d_file")){
                            $dirs=$paths."/".$d_file;
                            $handles=opendir($dirs);
                            while (false!=($files=readdir($handles))){
                                if ($files!='.'&&$files!='..'){
                                    //@copy($dirs."/".$files,"temp/".$files);
                                    $d_fname[]=$files;
                                    $d_spath[]=$dirs."/".$files;

                                }
                            }
                        }
                    }
                }
                $d_arr=array();
                if ($d_fname==null || $d_spath=='undefined' || $d_spath==null || count($d_fname)==0 || count($d_spath)==0 || $d_fname=='undefined' ){
                    echo json_encode($d_arr);
                }else{
                $d_arr=array_merge($d_arr,$d_fname);
                $d_arr=array_merge($d_arr,$d_spath);
                echo json_encode($d_arr);
                }
                break;
            case 4:
                $tpr=$_POST['tpr'];
                $path_arr=$_POST['paths'];
                $paths_arr=explode(',',$path_arr);
                $table=$tpr."_wednesday";
                array_pop($paths_arr);
                $j=null;
                $temp=0;
                if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
                    echo 0;
                    return;
                }
                if ($tpr=="CSAT"){
                    $tpr="CTS";
                }
                include '../../db/new_link_db.php';
                if($mysqli -> connect_errno){
                    echo 0;
                    return;
                }
                $this_week=date("W");

                for($i=0;$i<count($paths_arr);$i++){
                    if(is_file($paths_arr[$i])==true){

                        $file_name=trim(strrchr($paths_arr[$i],'/'),'/');
                        //寰楀埌$temp
                        if (strpos($file_name,"VFIR")!==false){
                            if(strpos($file_name,"NB")!==false){
                                $temp=2;
                            }else if (strpos($file_name,"TB")!==false){
                                $temp=3;
                            }else if (strpos($file_name,"NB")==false&&strpos($file_name,"TB")==false){
                                $temp=1;
                            }
                        }else if (strpos($file_name,"COMPAL_RSH")!==false){
                            if(strpos($file_name,"txt")!==false){
                                $temp=2;
                            }else if (strpos($file_name,"xls")!==false||strpos($file_name,"xlsx")!==false){
                                $temp=1;
                            }
                            //RY is befor file
                        }else if (strpos($file_name,"Quality")!==false&&strpos($file_name,"Yield")!==false||strpos($file_name,"RY")!==false){
                            $temp=4;
                        }else if(strpos($file_name,"RRR")!==false){
                            $temp=5;
                        }else if(strpos($file_name,"CID")!==false||strpos($file_name,"Scrap")!==false||strpos($file_name,"scrap")!==false){
                            $temp=6;
                        }



                        //鎶婃枃浠惰矾寰勬埅鍙�,璋冪敤鏂囦欢澶瑰垹闄ゅ嚱鏁�
                        $dir=substr($paths_arr[$i],0,strrpos($paths_arr[$i], '/'));
                        deldir($dir);

                        //temp_ph($paths_arr[$i]);//寰楀埌$temp
                        $temp_path='../../TPR Report/VFIR/Temp/'.$tpr.'/Temp'.$temp;
                        $dires=substr($dir,0,strrpos($dir, '/'));
                        $wk=trim(strrchr($dires,'/'),'/').'.temp';
                        $temp_dir=opendir($temp_path);
                        while (false!=($file=readdir($temp_dir))) {
                            if($file!="." && $file!="..") {
                                if ($file==$wk){
                                    if(deldir($temp_path)!=0){
                                        $sql="delete from $table where Week='$this_week' ";
                                        $result=$mysqli->query($sql);
                                    }
                                }
                            }
                            }
                            $dir_wk=substr($dir,0,strrpos($dir, '/'));
                        del_wk($dir_wk);
                    }else {

                        //璋冪敤鏂囦欢澶瑰垹闄ゅ嚱鏁�
                        $dir='../../TPR Report/VFIR/'.$tpr.'/'.$paths_arr[$i];
                        deldir($dir);
                        $wk=$paths_arr[$i].'.temp';
                        $temp_path='../../TPR Report/VFIR/Temp/'.$tpr;
                        $tp_dir=opendir($temp_path);
                        while (false!=($num_ph=readdir($tp_dir))) {
                            if($num_ph!="." && $num_ph!="..") {
                                $wk_path=$temp_path."/".$num_ph;
                                $wk_tp=opendir($wk_path);
                            while (false!=($temp_file=readdir($wk_tp))) {
                                if($temp_file!="." && $temp_file!="..") {
                                    if($temp_file==$wk){
                                        $flg=deldir($wk_path);
                                        if($flg=='1'){
                                            $sql="delete from $table where Week='$this_week' ";
                                            $result=$mysqli->query($sql);
                                        }
                                    }
                                }
                            }
                        }
                        }
                        $j='p';
                    }
                }
                //妫�鏌ユ枃浠跺す鏄惁瀛樺湪鏂囦欢

                break;

}
//鍒犻櫎鏂囦欢澶逛互鍙婃枃浠�
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
//鍒犻櫎绌虹殑鏄熸湡鏂囦欢
function del_wk($dir_wk){
    //$dirs=substr($dir,0,strrpos($dir, '/'));
    $is_et=opendir($dir_wk);
    $c=0;
    while (false!=($file=readdir($is_et))) {
        if($file!="." && $file!="..") {
            $c++;
        }
    }
    closedir($is_et);
    if($c==0){
        deldir($dir_wk);
        echo "1";
    }else{
        echo "2";
    }
}
?>