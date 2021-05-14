
<?php
date_default_timezone_set("PRC");//设置时区为中国，
$flag=$_POST['flag'];//获得网页传过来的标志位
$connID="";
//初始化数据库连接
include '../../server/db/link_db_4.php';
//引入link_db_4.php文件为本文件所用
switch ($flag){
    case 1:
        //查询出temp_table_tmp_fcg里的所有数据
        $result=mysqli_query($connID,"select * from temp_table_tmp_fcg ");
        //返回有几条记录并保存于nums中
        $nums=mysqli_num_rows($result);

        //定义一个空数组
        $arr=array();
        if ($nums!=0){  //如果查询到有数据的执行下面循环体
            //获取查询到的数组形式的记录
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
             //用数组保存从数据库取出的数据
                $arr[]=$row;
            }
        }
       /* echo json_encode($arr);*/
        break;//结束switch循环
}
    echo json_encode($arr);//将数据转换成json格式的数据

   /* case 2:
        $set=$_POST['set'];
        $bg_date=date('Y-m-d 00:00:00');
        $no_date=date('Y-m-d H:i:00');
        $now_time=floor((strtotime($no_date)-strtotime($bg_date))%86400/1800);
        $temp=array();
        $humi=array();
        for ($i=0;$i<=$now_time;$i++){
            $bg_date_c=strtotime($bg_date)+($i*1800);
            $now_date=date("Y-m-d H:i:s",$bg_date_c);
            $result=mysqli_query($connID,"select * from temp_table_fcg where cord_time<='$now_date' and cord_time>='$bg_date_c' and device='$set' order by cord_time desc limit 1 ");
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $temp[0][]=$row['cord_time'];
                    $temp[1][]=$row['temp'];
                    $humi[0][]=$row['cord_time'];
                    $humi[1][]=$row['humi'];
                }
            }
        }
        $arr[]=$temp;
        $arr[]=$humi;
        break;
        case 3:
            $set=$_POST['set'];
        	$bgtime=$_POST['bgtime'];
        	$edtime=$_POST['edtime'];
            $result=mysqli_query($connID,"select temp,humi,cord_time from temp_table_fcg where cord_time>='$bgtime' and cord_time<='$edtime' and device='$set' order by cord_time desc");
            $nums=mysqli_num_rows($result);
            $arr=array();
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $arr[]=$row;
                }
            }
            break;
        case 4:
            $device=$_POST['set'];
            $bg_date=date('Y-m-d 00:00:00');
            $no_date=date('Y-m-d H:i:00');
            $how_time=floor((strtotime($no_date)-strtotime($bg_date))%86400/1800);
            $temp=array();
            $humi=array();
            $sqlc="";
            for ($i=0;$i<$how_time;$i++){
                $bg_date_c=date("Y-m-d H:i:s",strtotime($bg_date)+($i*1800));
                $sql="(select humi,temp,cord_time from temp_table_fcg where device=1 and cord_time<='$bg_date_c' order by cord_time desc limit 1)";
                $sqlc.=$sql." union ";
            }
            $sqlc=substr($sqlc,0,strlen($sqlc)-6);
            $result=mysqli_query($connID,$sqlc);
            $nums=mysqli_num_rows($result);
            if ($nums!=0){
                while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                    $temp[0][]=$row['cord_time'];
                    $temp[1][]=$row['temp'];

                    $humi[0][]=$row['cord_time'];
                    $humi[1][]=$row['humi'];
                }
            }
            $arr[]=$temp;
            $arr[]=$humi;
        break;*/
/*}*/
/*echo json_encode($arr);*/

