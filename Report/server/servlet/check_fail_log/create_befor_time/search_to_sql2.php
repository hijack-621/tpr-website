<?php
$tpr="RLC_SH";
$path="D:/TestLog/TestReport/".$tpr;
$table=$tpr.'_befor_time';
//閺屻儴顕梩pr娑撳娈戦弬鍥︽
$resdir=opendir($path);
while(false!=($file=readdir($resdir))){
    $path_t=$path.'/'.$file;
    if(is_dir($path_t) AND $file!='.' AND $file!='..'){
            $resdir_s=opendir($path_t);
            while(false!=($files=readdir($resdir_s))){
                $path_o=$path_t.'/'.$files;
                if($files!='.' AND $files!='..' AND strpos($files,'csv')!==false){
                    $file_arr[]=$path_o;
                }
            }
    }
}
//濡拷绁撮弰顖氭儊娑撹櫣鈹�
if (count($file_arr)==0){
    echo "0001";
    return;
}
$temp_arr=array();
//瀵拷鎯庨弫鐗堝祦鎼达拷
$connID="";
include '../../db/link_db.php';
//濞撳懐鈹栭弫鐗堝祦鎼达拷
mysqli_query($connID,"truncate table $table ");
//閹绘帒鍙嗛弫鐗堝祦
for ($i=0;$i<count($file_arr);$i++){
    $ft=0;
    $rdfile=fopen($file_arr[$i],'r');
    while(($temp=fgetcsv($rdfile))!=false){
        if($ft=="0"){
            $temp_arr[]=$temp;
            $result=mysqli_query($connID,"insert into $table (check_time,fail) values ('$temp[0]','$temp[3]') ");
            if ($result==0){
                return ;
            }
            $ft++;
    }
    }
}
for($i=0;$i<count($temp_arr);$i++){
    $ct=$temp_arr[$i][0];
    $fa=$temp_arr[$i][3];
    $result=mysqli_query($connID,"select check_time from $table where check_time<'$ct' and fail='$fa' order by check_time desc limit 1");
    //閺屻儴顕楅幋鎰鏉╂柨娲栭弫鐗堝祦
    $nums=mysqli_num_rows($result);
    if ($nums==0){

    }else{
        $arr_time=array();
    while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
        $arr_time[]=$row;
    }
    $bf_time=$arr_time[0][0];
    $result=mysqli_query($connID,"update $table set befor_time='$bf_time' where check_time='$ct' and fail='$fa' ");
}
}
include '../../db/close_db.php';
print_r($arr_time[0][0]);

?>