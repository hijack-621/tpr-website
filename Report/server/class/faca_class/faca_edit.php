<?php
class n_faca{
    function getdata($tpr,$type,$utpr){
        switch ($type){
            case 'unclose':
                $connID="";
                include '../../db/link_db.php';
                $arr = array();
                if($tpr=='CGS'){
					if($utpr==''){
						//echo '1';
					 $sql = 'select * from facaview';//建立视图
					//die($sql);
					 $result = mysqli_query($connID,$sql);
					 while(($row = mysqli_fetch_array($result,MYSQLI_NUM)) !=false && $row >0){
						$arr[] = $row;
						  }
	               }
					else{
						//echo '2';
					$table = $utpr.'_check_data';
					 $sql = "select Model, PPID,Station,Fail_Item,Fail_Detail,Test_time,Correct,TPR_owner,Compal_owner,TPR_FA,Action,Compal_check,update_time from $table where Compal_check is null order by Test_time";
					 $result = mysqli_query($connID,$sql);
					 while(($row = mysqli_fetch_array($result,MYSQLI_NUM)) !=false && $row >0){
						$arr[] = $row;
                 }
					
					}
                //$dataarr[] =array($tpr);
               
                 //$stpr=array("RLC_SH","CEP","CEB","IGS","CTS","TSI","CGS");
                }else{
                    //echo $tpr;
                    $table = $tpr.'_check_data';
                    //$dataarr[] =array($tpr);
                    $sql = "select Model, PPID,Station,Fail_Item,Fail_Detail,Test_time,Correct,TPR_owner,Compal_owner,TPR_FA,Action,Compal_check,update_time from $table where Compal_check is null order by Test_time";
                    //die($sql);
                    $result = mysqli_query($connID,$sql);
                    while(($row = mysqli_fetch_array($result,MYSQLI_NUM)) !=false && $row >0){
                        $arr[] = $row;
                    }

                }

                include '../../db/close_db.php';
                return $arr;
                break;
            case 'search':
                update_data($tpr);
                break;
        }
    }
}
function update_data($tpr){
    if ($tpr=="CSAT"){
        $tpr="cts";
    }
    $table1=$tpr.'_check_data';//check表
    $table2=$tpr.'_fail_data';//fail表
    $connID="";
    include '../../db/link_db.php';
    $result=mysqli_query($connID,"select name,Checer from tpr_name where TPR='$tpr' ");
    while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
        $tpr_name=$row["name"];
        $cpal_name=$row["Checer"];
    }
//	die("select $table2.Test_time,$table2.Station,$table2.Fail_Item from $table2 left join $table1
//        on $table2.PPID=$table1.PPID where $table1.PPID is null ");
    $result=mysqli_query($connID,"select $table2.Test_time,$table2.Station,$table2.Fail_Item from $table2 left join $table1
        on $table2.PPID=$table1.PPID where $table1.PPID is null ");//将fail表中的这些字段和check表中的ppid为空的的字段以ppid为桥梁连接起来，没有的字段以null写入
    $nums=mysqli_num_rows($result);                                 //fail表时间
    if ($nums!=0){
		//echo '1B';
        while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
            $bfdata_arr[]=$row;
        }
        //insert data
//		die("insert $table1(PPID,Test_time,Station,Fail_Item,Fail_Detail,Model,Correct,TPR_owner,Compal_owner) (select $table2.PPID,$table2.Test_time,$table2.Station,$table2.Fail_Item,$table2.Fail_Detail,$table2.Model,$table2.Correct,'$tpr_name' as TPR_owner,'$cpal_name' as Compal_owner from $table2 left join $table1
//            on $table2.PPID=$table1.PPID where $table1.PPID is null) ");
//        $result=mysqli_query($connID,"insert $table1(PPID,Test_time,Station,Fail_Item,Fail_Detail,Model,Correct,TPR_owner,Compal_owner) (select $table2.PPID,$table2.Test_time,$table2.Station,$table2.Fail_Item,$table2.Fail_Detail,$table2.Model,$table2.Correct,'$tpr_name' as TPR_owner,'$cpal_name' as Compal_owner from $table2 left join $table1
//            on $table2.PPID=$table1.PPID where $table1.PPID is null) ");//将fail表时间等字段插入到check表
//      for($i=0;$i<count($bfdata_arr);$i++){
//            $ck_time=$bfdata_arr[$i]["Test_time"];//fail表时间
//           //$station=$bfdata_arr[$i]["Station"];
//            $fa_item=$bfdata_arr[$i]["Fail_Item"];
//           $rs_time=mysqli_query($connID,"select Test_time from $table1 where Test_time<'$ck_time' and Fail_Item='$fa_item' order by Test_time desc limit 1 ");
//            while (($bf = mysqli_fetch_array($rs_time,MYSQLI_ASSOC))!==false&&$bf>0) {
//                $bf_time=$bf["Test_time"];//取出check中testtime时间小于fail表中的testtime
//               //echo json_encode($bf);
//                mysqli_query($connID,"update $table1 set Befor_time='$bf_time' where Fail_Item='$fa_item' and Test_time='$ck_time'");//把check表中的before——time字段更新为check表的
//            }
//        }
    }

    include '../../db/close_db.php';
}
