<?php
$TPR=$_POST['tpr'];
$ppid=$_POST['ppid'];
$bgtime=$_POST['bgtime'];
$edtime=$_POST['edtime'];
$table=$TPR.'_testlog';
$connID="";
include '../../server/db/link_db.php';
if(empty($bgtime)&&empty($edtime)){
    $result=mysqli_query($connID,"select * from $table where PPID='$ppid' ");

}else if(empty($bgtime)){
    $edtime=$_POST['edtime'];
    $result=mysqli_query($connID,"select * from $table where PPID='$ppid' and Date<='$edtime' ");

}else if(empty($edtime)){
    $bgtime=$_POST['bgtime'];
    $result=mysqli_query($connID,"select * from $table where PPID='$ppid' and Date>='$bgtime' ");

}else{
    $bgtime=$_POST['bgtime'];
    $edtime=$_POST['edtime'];
    $result=mysqli_query($connID,"select * from $table where PPID='$ppid' and Date>='$bgtime' and Date<='$edtime' ");

}
$nums=mysqli_num_rows($result);
$arr=array();
if ($nums!=0){
    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
        $arr[]=$row;
    }
}
include '../../server/db/close_db.php';
if(count($arr)>0){
    $file_arr=array();
    for($i=0;$i<count($arr);$i++){
        $dir_ph='D:/TestLog/'.$TPR.'/'.$arr[$i]['Station'].'/'.$arr[$i]['Date'];
        $log_arr=scandir($dir_ph);

        foreach ($log_arr as $val){
            $k=strpos($val,$arr[$i]['PPID']);
            if($k!==false){
                $file='D:/TestLog/'.$TPR.'/'.$arr[$i]['Station'].'/'.$arr[$i]['Date'].'/'.$val;
            }
        }
        $file_arr[]=$file;
    }
}
    if (count($file_arr)>0){
    $path="temp/";
    if(count(array_diff(scandir($path),array('..','.')))!=0){
        deldir($path);
    }
    for ($i=0;$i<count($file_arr);$i++){

        if(!file_exists('temp/'.$arr[$i]['Id'])){
            mkdir('temp/'.$arr[$i]['Id']);
        }
        if(@copy($file_arr[$i],'temp/'.$arr[$i]['Id'].'/'.$arr[$i]['PPID'].'.log')){

        }else{
            continue;
        }

    }
}
echo json_encode($arr);
function deldir($path){
    //�����Ŀ¼�����
    if(is_dir($path)){
        //ɨ��һ���ļ����ڵ������ļ��к��ļ�����������
        $p = scandir($path);
        foreach($p as $val){
            //�ų�Ŀ¼�е�.��..
            if($val !="." && $val !=".."){
                //�����Ŀ¼��ݹ���Ŀ¼���������
                if(is_dir($path.$val)){
                    //��Ŀ¼�в���ɾ���ļ��к��ļ�
                    deldir($path.$val.'/');
                    //Ŀ¼��պ�ɾ����ļ���
                    @rmdir($path.$val.'/');
                }else{
                    //������ļ�ֱ��ɾ��
                    unlink($path.$val);
                }
            }
        }
    }
}
?>