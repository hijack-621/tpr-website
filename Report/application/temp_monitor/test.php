<?php
$connID="";
include '../../server/db/link_db_3.php';
$device=$_POST['device'];
$bg_date=date('2019-03-21 00:00:00');
$no_date=date('2019-03-21 H:i:00');
$how_time=floor((strtotime($no_date)-strtotime($bg_date))%86400/1800);
$temp=array();
$humi=array();
for ($i=0;$i<$how_time;$i++){
    $bg_date_c=date("Y-m-d H:i:s",strtotime($bg_date)+($i*1800));
    $sql="(select humi,temp,cord_time from temp_table where device=1 and cord_time<='$bg_date_c' order by cord_time desc limit 1)";
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
echo json_encode($arr);
?>