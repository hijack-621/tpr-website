<?php
include 'Database.Class.php';
class NPIController{
private $result;
public function Create(){
		$models=json_decode($_POST['models']);
		$amodel = [];
		$as = [];
		foreach($models as $val){
			array_push($amodel,$val->model);
		}
		$smodel = implode($amodel,',');
		$series = json_decode($_POST['series']);
		foreach($series as $val){
			array_push($as,$val->value);
		}
		$sas =  implode($as,',');
		$now_time=date('Y-m-d H:i:s');
		$up=$_POST['up'];//npi or normal
		$reason=$_POST['reason'];//发起npi时的描述
		$flag=$_POST['flag'];
		if(isset($_POST['bdview'])){
			$bdview =addslashes($_POST['bdview']);
			$sa1 = 'BoardViewPath';
		   }
		$checkdata=$_POST['checkdata'];//tpr arr
		$tpr_arr=explode(',',$checkdata);
		$send_tpr=array();
		$db=mysql::getInstance();
		$db->opencommit();
		$batch = md5 ( uniqid ( rand (), true ) );
		for ($i=0;$i<count($tpr_arr);$i++){
			$sql="select Owner,Checker from npi_owner where tpr='$up' and steps=1 "; //npi->lucky normal->will
 			$data=$db->getRow($sql);
			$this_owner=$data['Owner'];
			$this_checker=$data['Checker'];
			$data=array();
			if($up=='NPI'){ //如果sort字段为npi，第二步伟compal pe
				$sql="select Owner,Checker from npi_owner where tpr='$up' and steps=2 ";
			}else{
				$sql="select Owner,Checker from npi_owner where tpr='$tpr_arr[$i]' and steps=3 ";//normal step2为tpr qa 数据库为steps 3
			}
			// $sql="select Owner,Checker from npi_owner where tpr='$tpr_arr[$i]' and steps=2 ";
			$data=$db->getRow($sql);

			$next_owner=$data['Owner'];
			$next_checker=$data['Checker'];
			$id= strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$sql="insert into npi_npi (id,MEMO,TPR,Model,Series,Checker,Btime,status,batch) values ('$id','$reason','$tpr_arr[$i]','$smodel','$sas','$next_checker','$now_time',0,'$batch')";
			$affect_a=$db->carrySql($sql);
			$sql="insert into npi_npi_step (step,primary_id,bgtime,owner,checker,status,file_id) values (1,'$id','$now_time','COMPAL-QA-Team','COMPAL-QA-Team',0,1),(2,'$id','$now_time','COMPAL-PE-Team','COMPAL-PE-Team',0,0),(3,'$id','$now_time','TPR-ConfirmNPITime','TPR-ConfirmNPITime',0,0)";//第一步默认完成
			//插入三步，第一步默认有文件， file_id=>1 ，file_id=>0，并且需要上传文件的步骤，提示 need upload file 
			$affect_b=$db->carrySql($sql);
			if ($affect_a!=1 || $affect_b!=3){
				// echo $affect_a.'a';
				// echo $affect_b.'ab';
				// echo $affect_c.'ac';
				$tag='1010';
				$msg[]=$tag;
				$msg[]=0;
				$db->backcommit();
				echo json_encode($msg);
				return false;
			}
			$fe_rs = 0;
			$primary_path="../../NPI_System_file/".$id."/";
			mkdir($primary_path);
			$step = 1;
			for ($c=0;$c<count($_FILES);$c++){
				$path=$primary_path.$step."/";
				if(!is_dir($path)){ //没有文件夹就创建
					if (mkdir($path)){
						if(copy($_FILES['file'.$c]['tmp_name'],$path.$_FILES['file'.$c]['name'])){
							$fe_rs = 1;
						}
					}
				}else{ //有就直接放
					if(copy($_FILES['file'.$c]['tmp_name'],$path.$_FILES['file'.$c]['name'])){
						$fe_rs = 1;
					}
				}
			}
			if ($fe_rs==0){
				del_folder($primary_path);
			}
			if ($fe_rs!=1){//文件上传有问题
				$tag='1020';
				$msg[]=$tag;
				$msg[]=$md_rs.$st_rs.$fe_rs;
				//$msg[]=0;
				$db->backcommit();
				echo json_encode($msg);
				return false;
			}
			$send_tpr[]=$tpr_arr[$i];
		}
		//$db->backcommit();
		$db->surecommit();
		$msg[]='1111';
		$msg[]=$send_tpr;
		$msg[]=$fe_rs; //触发 显示进度条和upload 状态
		$msg[]='step'.$step; //表示第几步 的file 
		$msg[]=$smodel;//model数组

		echo json_encode($msg);

		$db->closeMysql($data);
	}
	public function getModel(){
		$db=Mysql::getInstance();
		$flag = $_POST['flag'];
		if($flag=='Normal'){
			$sql="select distinct model from modeltotpr order by model asc";
		}else{
			$sql="select distinct model from  modeltotpr";
		}
		$arr=array();
		$arr[] = $db->getRows($sql);
		$ssql = "select distinct DELL_Name from matrix_rlc_sh";
		$dearr = $db->getRows($ssql);
		$arr[] = $dearr;
		echo json_encode($arr);
	}

	public function getfile(){
		$path = '../../NPI_System_file/'.$_POST['id'].'/1';
		if(is_dir($path)){
			$file_arr = $this->readdir($path);
		}

		echo json_encode($file_arr);
	}

// function list_file($date){
    //     //1、首先先读取文件夹
    //     $temp=scandir($date);
    //     //遍历文件夹
    //     foreach($temp as $v){
    //         $a=$date.'/'.$v;
    //        if(!is_dir($a)){//如果是文件夹则执行
	// 		if($v!=='.'&& $v!=='..'){
	// 			echo $v;
	// 		}
              
    //        }
          
    //     }
    // }

	public function readdir($path){
        $handle = opendir($path);
		$all = [];
		if($handle){
			while( ($files = readdir($handle)) !== false ){
					if( !is_dir($path.'/'.$files) && $files!='.' && $files!='..' ){
						$arr = [];
						$arr[] = $files;
						$arr[] = $path.'/'.$files;
						array_push($all,$arr);
					}
			}
		}
		closedir($handle);
		return $all;
		
	}

	public function judgedir($path,$mfile){
        $handle = opendir($path);
		$mp = [];
		$mpfile = $mfile;
		if($handle){
			while( ($files = readdir($handle)) !== false ){
					if( !is_dir($path.'/'.$files) && $files!='.' && $files!='..' ){
						if( ($key = array_search($files,$mpfile['file']['name']))!==false  ){ //区分大小判断数组中是否存在元素,成功返回键名
							array_push($mp, $key);	//判断路径下是否已经存在同样文件，记录索引
						}
					}
			}
		}
		closedir($handle);
		echo '<pre>';
		var_dump($mp);
		if(count($mp)>0){
			foreach($mp as $val){ //如果索引数组不为空，表示有重复，去除重复的文件
				echo $val;
				array_splice($mpfile['file']['name'], $val, 1);
				array_splice($mpfile['file']['tmp_name'], $val, 1);
			}
			return $mpfile;	
		}else{
			return $mpfile;
		}
		
		//return $all;
		
	}


	function makeupfile(){
		$mpfiles = $_FILES;
		$batch = $_POST['batch'];
		$db = Mysql::getInstance();
		$sql ="select id,TPR,Model from npi_npi where batch='$batch' ";
		$rows = $db->getRows($sql);
		$f = 0;
		foreach($rows as $item){
			$path = '../../NPI_System_file/'.$item['id'].'/1';
			if(is_dir($path)){
				$handle = opendir($path);
				if($handle){
					while( ($files = readdir($handle)) !== false ){
							if( !is_dir($path.'/'.$files) && $files!='.' && $files!='..' ){
								if( ($key = array_search($files,$mpfiles['file']['name']))!==false  ){
									unlink($path.'/'.$files);//如果路径下已经存在和上传重名的文件，先删除重名在进行上传。
								}
							}
					}
				}
				// closedir($handle);
			}
			
			for ($c=0;$c<count($mpfiles['file']['name']);$c++){
				if( copy($mpfiles['file']['tmp_name'][$c],$path.'/'.$mpfiles['file']['name'][$c]) ){
					$f++;
				}
			}
		} 
		
	
		if( $f== count($mpfiles['file']['name'])*count($rows)  ){
			$id =$_POST['id'] ;
			$db=Mysql::getInstance();
			$sql = "select TPR,Model from npi_npi where id='$id' ";
			$res = $db->getRow($sql);
			$tpr = $res['TPR'];
			$model = $res['Model'];
			$msql = "select name,mail from mail where tpr='$tpr' and spmaflag=1 ";
			$mails = $db->getRows($msql);
			//var_dump($mails);
			$title="NPI System Auto Mail";
			$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
			<strong><b>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's attachment has been updated by Compal QA, please pay attention to it <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$mailer = [['name'=>'iori','mail'=>'1409330098@qq.com']];
			$rs = sendmail($mailer,$title,$text);
			echo json_encode($rs);//success: 1111;
		}
}
public function upFile(){
		$db=Mysql::getInstance();
		$mpfiles = $_FILES;
		$primary_id=$_POST['id'];
		$step=$_POST['step'];
		$now_time=date('Y-m-d H:i:s');
		$f = 0;
		if($step==2){
			$query_batch = "select batch from npi_npi where id='$primary_id' ";
			$get = $db->getRow($query_batch);
			//var_dump($get);
			$batch = $get['batch']; //先查询出batch 在根据batch 批量更新文件
			$sql ="select id,TPR,Model from npi_npi where batch='$batch' ";
			$rows = $db->getRows($sql);
			$tprarr = [];
			$idarr = [];
			for($i=0;$i<count($rows);$i++){
				array_push($tprarr,$rows[$i]['TPR']);
				array_push($idarr,$rows[$i]['id']);
			}
			foreach($rows as $item){
				$path = '../../NPI_System_file/'.$item['id'].'/'.$step;
				
				if(!is_dir($path)){
					mkdir($path);
					sleep(0.5);
					$handle = opendir($path);
					if($handle){
						while( ($files = readdir($handle)) !== false ){
								if( !is_dir($path.'/'.$files) && $files!='.' && $files!='..' ){
									if( ($key = array_search($files,$mpfiles['file']['name']))!==false  ){
										unlink($path.'/'.$files);//如果路径下已经存在和上传重名的文件，先删除重名在进行上传。
									}
								}
						}
					}
					// closedir($handle);
				}
				
				for ($c=0;$c<count($mpfiles['file']['name']);$c++){
					if( copy($mpfiles['file']['tmp_name'][$c],$path.'/'.$mpfiles['file']['name'][$c]) ){
						$f++;
					}
				}
			} 
			if( $f== count($mpfiles['file']['name'])*count($rows)  ){
				$qfd = "select file_id from npi_npi_step where step='$step' and primary_id".$this->create_in($idarr);
				$qres = $db->getRows($qfd);
				if($qres[0]['file_id']==0){ //step2 没有上传过文件
					$up = "update npi_npi_step  set file_id=1 where step='$step' and primary_id".$this->create_in($idarr);
					$upres = $db->carrySql($up);
					if($upres>0){
					echo $this->cmail($tprarr,$step,$rows)==count($tprarr)?json_encode('200'):json_encode('mail error');
						return false;	
					}
				
				}else{
					echo $this->cmail($tprarr,$step,$rows)==count($tprarr)?json_encode('200'):json_encode('mail error');
					return false;	
				}
				//echo json_encode($rs);//success: 1111;
			}else{
				echo json_encode('upload step2 by batch error');//step2 批量更新失败
			}	
		}
		else if($step==4){
			$sql="select id,TPR,Model from npi_npi where id='$primary_id' ";
			$row = $db->getRow($sql);
			// var_dump($row);
			$path = '../../NPI_System_file/'.$primary_id.'/'.$step;
			if(!is_dir($path)){
				mkdir($path);
				sleep(0.5);
				$handle = opendir($path);
				if($handle){
					while( ($files = readdir($handle)) !== false ){
							if( !is_dir($path.'/'.$files) && $files!='.' && $files!='..' ){
								if( ($key = array_search($files,$mpfiles['file']['name']))!==false  ){
									unlink($path.'/'.$files);//如果路径下已经存在和上传重名的文件，先删除重名在进行上传。
								}
							}
					}
				}
				// closedir($handle);
			}
			for ($c=0;$c<count($mpfiles['file']['name']);$c++){
				if( copy($mpfiles['file']['tmp_name'][$c],$path.'/'.$mpfiles['file']['name'][$c]) ){
					$f++;
				}
			}
			if( $f== count($mpfiles['file']['name'])){
				$qfd = "select file_id from npi_npi_step where step='$step' and primary_id= '$primary_id' ";
				$qres = $db->getRow($qfd);
				$tprarr[] = $row['TPR']; //getRow返回一维数组
				$rows[] = $row['Model'];
				if($qres['file_id']==0){ //step4 没有上传过文件
					$up = "update npi_npi_step  set file_id=1 where step='$step' and primary_id= '$primary_id'";
					$upres = $db->carrySql($up);
					if($upres>0){
					echo $this->cmail($tprarr,$step,$rows)==count($tprarr)?json_encode('200'):json_encode('mail error');
						return false;	
					}
				
				}else{
					echo $this->cmail($tprarr,$step,$rows)==count($tprarr)?json_encode('200'):json_encode('mail error');
					return false;	
				}
				//echo json_encode($rs);//success: 1111;
			}else{
				echo json_encode('upload step4 error');//step2 批量更新失败
			}
			
		}
}

public function cmail($tprarr,$step,$rows){
	$count = 0;
	$db = Mysql::getInstance();
	for($j=0;$j<count($tprarr);$j++){
		$msql = "select name,mail from mail where tpr='$tprarr[$j]' and spmaflag=1 ";
		$mails = $db->getRows($msql);
		//var_dump($mails);
		$title="NPI System Auto Mail";
		$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
		<strong><b>".$tprarr[$j]." ,Model: ".$rows[$j]."</b></strong>, this NPI-item's step".$step."  attachment has been updated, please pay attention to it <br/>
		*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
		*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
		$mailer = [['name'=>'iori','mail'=>'1409330098@qq.com']];
		$rs = sendmail($mailer,$title,$text);
		if($rs=='1111'){
			$count++;
		}
	}
	return $count;
}
public function getVer($model){

		$db=Mysql::getInstance();
		$sql="select model,qc1_img,qc2_img,qc3_img,oba_img,runin_img from npi_model_data where model='$model'";
		//die($sql);
		$data=$db->getRow($sql);
		if(count($data)==0){
			$time = date('Y-m-d H:i:s');
			$sql1 = "insert into npi_model_data (model,qc1_img,qc2_img,qc3_img,runin_img,oba_img,update_time) values('$model','1.0','1.0','1.0','1.0','1.0','$time')";
			//die($sql1);
			$nums = $db->carrySql($sql1);
			echo json_encode($nums);

		}else{
			echo json_encode($data);
		}
		
	}
	public function getMV(){
		$db=Mysql::getInstance();
		$sql="select model,qc1_img,qc2_img,qc3_img,oba_img,runin_img from npi_model_data";
		$data=$db->getRows($sql,MYSQLI_BOTH);
		echo json_encode($data);
	}
	public function getAllModel($arr){
		$db=Mysql::getInstance();
		$sql="select model,qc1_img,qc2_img,qc3_img,oba_img,runin_img from npi_model where primary_id='$arr' ";
		$data=$db->getRows($sql);
		echo json_encode($data);
	}
	public function delAllModel($arr){
		$db=Mysql::getInstance();
		$db->opencommit();
		$sql="delete from npi_model where primary_id='$arr[0]' and model='$arr[1]' ";
		$rs=$db->carrysql($sql);
		if ($rs==1){
			$msg=1111;
		}else{
			$msg=1010;
		}
		//$db->backcommit();
		$db->surecommit();
		echo json_encode($msg);
	}
	public function editAllModel($arr){
		$db=Mysql::getInstance();
		$sql="update npi_model set qc1_img='$arr[2]',qc2_img='$arr[3]',qc3_img='$arr[4]',oba_img='$arr[5]',runin_img='$arr[6]' where primary_id='$arr[0]' and model='$arr[1]' ";
		$rs=$db->carrysql($sql);
		if ($rs!=-1){
			$msg=1111;
		}else{
			$msg=1010;
		}
		//$db->backcommit();
		$db->surecommit();
		echo json_encode($msg);
	}
	public function addAllModel($arr){
		$db=Mysql::getInstance();
		$db->opencommit();
		$sql="select count(*) from npi_model where primary_id='$arr[0]' and model='$arr[1]' ";
		$data=$db->getRow($sql);
		if ($data[0]=="0"){
			$sql="insert into npi_model (primary_id,model,qc1_img,qc2_img,qc3_img,oba_img,runin_img) values ('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]')";
			$rs=$db->carrySql($sql);
			if ($rs==1){
				$db->surecommit();
				echo 1111;
			}else {
				$db->backcommit();
				echo 1010;
			}
		}else{
			echo '1011';
		}
	}
	public function judgemodel($arr){
		return 1;
		$db=Mysql::getInstance();
		$tpr = $arr['TPR'];
		if($tpr=='RLC_INDIA'){
			$tpr='ICC-RLG';
		}elseif($tpr=='Regenersis_INDIA'){
			$tpr='CTDI';
		}
		$model = $arr['model'];
		$sql = "select model,modeltotpr from modeltotpr where Model='$model' and ModelToTPR like '%$tpr%' ";
		//die($sql);
		$res = $db->getRows($sql);
		return count($res);
	}
	public function getUnclose(){

		$db=Mysql::getInstance();
		$flag = $_POST['tflag'];
		$arr = [];
		if($_SESSION["utpr"]=='CGS'){
			$sql="select * from npi_npi where status=0";
			//die($sql);
		}else{
			$tpr=$_SESSION["utpr"];
			$sql="select * from npi_npi where TPR='$tpr' and status=0";
		}
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		if ($nums!=0){
			
			while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
				if ($row['TPR']=='CGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['TPR']=='RLC_SH'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_SH'][]=$row;
					}else{
						continue;
					}
				}else if($row['TPR']=='CEP'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEP'][]=$row;
					}else{
						continue;
					}
				}else if($row['TPR']=='IGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['TPR'][]=$row;
					}else{
						continue;
					}
				}else if($row['TPR']=='CEB'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEB'][]=$row;
					}else{
						continue;
					}
					//echo count($row);
					
				}else if($row['TPR']=='RLC_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_INDIA'][]=$row;
					}else{
						continue;
					}
				}else if($row['TPR']=='Regenersis_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['Regenersis_INDIA'][]=$row;
					}else{
						continue;
					}
				}
			}
		}
		
		
	
		 echo json_encode($arr);
	}
	public function getclose(){
		$db=Mysql::getInstance();
		$flag = $_POST['flag'];

		if($_SESSION["utpr"]=='CGS'){
			$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img qc1_img,npi_model_data.qc2_img qc2_img,npi_model_data.qc3_img qc3_img,npi_model_data.oba_img oba_img,npi_model_data.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status!=0 and npi_primary.sort ='$flag'  and npi_primary.id=npi_model.primary_id and npi_model.model =	npi_model_data.model  ";

			//$sql="select * from npi_primary where status!=0 ";
		}else{
			$tpr=$_SESSION["utpr"];
			$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img qc1_img,npi_model_data.qc2_img qc2_img,npi_model_data.qc3_img qc3_img,npi_model_data.oba_img oba_img,npi_model_data.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status!=0 and npi_primary.tpr='$tpr' and npi_primary.sort ='$flag'  and npi_primary.id=npi_model.primary_id and npi_model.model =	npi_model_data.model  ";

			//$sql="select * from npi_primary where status!=0 and tpr='$tpr' ";
		}
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		if ($nums!=0){
			while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
				if ($row['tpr']=='CGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='RLC_SH'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_SH'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEP'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEP'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='IGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['IGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEB'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEB'][]=$row;
					}else{
						continue;
					}
					//echo count($row);
					
				}else if($row['tpr']=='RLC_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_INDIA'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='Regenersis_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['Regenersis_INDIA'][]=$row;
					}else{
						continue;
					}
				}
			}
		}
		echo json_encode($arr);
	}
	public function getAll(){
		$db=Mysql::getInstance();
		$flag = $_POST['flag'];

		if($_SESSION["utpr"]=='CGS'){
			$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.sort='$flag' and  npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";
			//$sql="select * from npi_primary ";
		}else{
			$tpr=$_SESSION["utpr"];
			$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where pi_primary.sort='$flag' and npi_primary.tpr='$tpr' and  npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

			//$sql="select * from npi_primary where tpr='$tpr' ";
		}
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		$arr=array();
		if ($nums!=0){
			while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
				if ($row['tpr']=='CGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='RLC_SH'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_SH'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEP'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEP'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='IGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['IGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEB'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEB'][]=$row;
					}else{
						continue;
					}
					//echo count($row);
					
				}else if($row['tpr']=='RLC_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_INDIA'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='Regenersis_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['Regenersis_INDIA'][]=$row;
					}else{
						continue;
					}
				}
			}
		}
		echo json_encode($arr);
	}
	public function getSopFile($arr){
		$id=$arr[0];
		$step=$arr[1];
		$path = '../../NPI_System_file/'.$id.'/'.$step;
		if(is_dir($path)){
			$file_arr = $this->readdir($path);
		}

		echo json_encode($file_arr);
	}

	public function delFile($arr){
		$db=Mysql::getInstance();
		//var_dump($arr);
		$rs= $this->del_file( $arr[0],$arr[1],$arr[2] );
		if ($rs==true){
			echo json_encode(1111);
		}else{
			echo json_encode('delete error');
		}
		

	}
    function del_file($id,$step,$name){
		$path="../../NPI_System_file/".$id."/".$step."/";
		if(is_dir($path)){
			$p = scandir($path);
			foreach($p as $val){
				if($val !="." && $val !=".."){
					//echo $p."<br/>";
					if($val==$name){
						$rs=unlink($path.$val);
						return $rs;
					}
					
				}
			}
		}
	}
	


	public function delData($arr){
		$db=Mysql::getInstance();
		if($_SESSION["utpr"]!='CGS'){
			echo 1020;
			return false;
		}
		if(isset($arr)){
			$sql = "delete from npi_npi where id='$arr' ";
			$aft = $db->carrySql($sql);
			if($aft>0){
				echo json_encode('200');
			}else {
				echo 1011;
			}
		}
	}
	public function getSearch($arr){
		$db=Mysql::getInstance();
		$flag = $_POST['flag'];
		$key= array_keys($arr);
		if (count($key)>1){
			if(count($key)==2&&($key[0]=='model'&&$key[1]=='tpr')){
				$model=$arr[$key[0]];
				$tpr=$arr[$key[1]];
				if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
					echo 1010;
					return false;
				}
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0 and npi_model.model='$model' and npi_primary.tpr='$tpr' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";
				//$sql="select npi_primary.id,npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' and npi_primary.tpr='$tpr' ";
			}elseif(count($key)==2&&($key[0]=='station'&&$key[1]=='model')){

				$station=$arr[$key[0]];
				$model=$arr[$key[1]];
				if ($_SESSION["utpr"]=='CGS'){
					$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_model.model='$model' and npi_primary.station like '%$station%' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

					//$sql="select npi_primary.id,npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' and npi_primary.station like '%$station%' ";
				}else{
					$tpr=$_SESSION["utpr"];
					$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_model.model='$model' and npi_primary.station like '%$station%' and npi_primary.sort='$flag' and npi_primary.tpr='$tpr'  and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";


					//$sql="select npi_primary.id,npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' and npi_primary.station like '%$station%' and npi_primary.tpr='$tpr' ";
				}

			}elseif(count($key)==2&&($key[0]=='station'&&$key[1]=='tpr')){
				if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
					echo 1010;
					return false;
				}
				$station=$arr[$key[0]];
				$tpr=$arr[$key[1]];
			$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_primary.station like '%$station%' and npi_primary.tpr='$tpr' and npi_primary.sort='$flag'  and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

			//$sql="select id,sort,reason,tpr,station,sop_path,bgtime,edtime,status from npi_primary where station like '%$station%' and tpr='$tpr' ";

			}else if(count($key)==3){
				$station=$arr[$key[0]];
				$model=$arr[$key[1]];
				$tpr=$arr[$key[2]];
				if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
					echo 1010;
					return false;
				}
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0    and npi_primary.station like '%$station%' and npi_primary.tpr='$tpr' and npi_model.model='$model' and npi_primary.sort='$flag'  and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

				//$sql="select npi_primary.id,npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' and npi_primary.station like '%$station%'  and npi_primary.tpr='$tpr' ";
			}
			
		}elseif ($key[0]=='tpr'){ // 一个search条件
			$tpr=$arr[$key[0]];
			if($_SESSION["utpr"]!='CGS'&&$_SESSION["utpr"]!=$tpr){
				echo 1010;
				return false;
			}
			$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_primary.tpr='$tpr' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

			//$sql="select * from npi_primary where tpr='$tpr' ";

		}elseif ($key[0]=='model'){
			$model=$arr[$key[0]];
			if ($_SESSION["utpr"]=='CGS'){
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_model.model='$model' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

				//$sql="select npi_primary.id,npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' ";
			}else{
				$tpr=$_SESSION["utpr"];
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0  and npi_primary.tpr='$tpr' and npi_primary.sort='$flag' and npi_model.model='$model' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

				//$sql="select npi_primary.id, npi_primary.sort,npi_primary.reason,npi_primary.tpr,npi_primary.station,npi_primary.sop_path,npi_primary.bgtime,npi_primary.edtime,npi_primary.status from npi_model,npi_primary where npi_model.primary_id=npi_primary.id and npi_model.model='$model' and npi_primary.tpr='$tpr' ";
			}

		}elseif ($key[0]=='station'){
			$station=$arr[$key[0]];
			if ($_SESSION["utpr"]=='CGS'){
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0   and npi_primary.station like '%$station%' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

				//$sql="select id,sort,reason,tpr,station,sop_path,bgtime,edtime,status from npi_primary where station like '%$station%' ";
			}else{
				$tpr=$_SESSION["utpr"];
				$sql = "select npi_primary.*,npi_model.model model,npi_model.primary_id,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img,npi_model_data.qc2_img,npi_model_data.qc3_img,npi_model_data.oba_img,npi_model_data.runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0   and npi_primary.station like '%$station%' and npi_primary.tpr ='$tpr' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model = npi_model_data.model";

				//$sql="select id,sort,reason,tpr,station,sop_path,bgtime,edtime,status from npi_primary where station like '%$station%' and tpr='$tpr' ";
			}

		}
		//die($sql);
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		$arr=array();
		if ($nums!=0){
			while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
				if ($row['tpr']=='CGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='RLC_SH'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_SH'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEP'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEP'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='IGS'){
					if( $this->judgemodel($row)>=1 ){
						$arr['IGS'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='CEB'){
					if( $this->judgemodel($row)>=1 ){
						$arr['CEB'][]=$row;
					}else{
						continue;
					}
					//echo count($row);
					
				}else if($row['tpr']=='RLC_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['RLC_INDIA'][]=$row;
					}else{
						continue;
					}
				}else if($row['tpr']=='Regenersis_INDIA'){
					if( $this->judgemodel($row)>=1 ){
						$arr['Regenersis_INDIA'][]=$row;
					}else{
						continue;
					}
				}
			}
		}
		echo json_encode($arr);
	}
	public function getTPR(){
		$db=Mysql::getInstance();
		$sql="select distinct tpr from npi_primary";
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		$arr=array();
		if ($nums!=0){
			while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
				$arr[]=$row[0];
			}
		}
		echo json_encode($arr);
	}
	public function getSHModel(){
		$db=Mysql::getInstance();
		$sql="select distinct model from npi_model_data";
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		$arr=array();
		if ($nums!=0){
			while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
				$arr[]=$row[0];
			}
		}
		echo json_encode($arr);
	}
	public function getStepTitle($id){
		$db=Mysql::getInstance();
		$sql="select * from npi_npi where id='$id' ";
		//die($sql);
		$data=$db->getRow($sql);
		echo json_encode($data);
	}
	public function getStepData($id){
		$db=Mysql::getInstance();
		$sql="select * from npi_NPI_step where primary_id='$id' ";
		//die($sql);
		$data=$db->getRows($sql);
		echo json_encode($data);
	}
	public function getEditData($arr){
		$db=Mysql::getInstance();
		$sql="select * from npi_npi_step where primary_id='$arr[0]' and step='$arr[1]' ";
		//die($sql);
		$data=$db->getRow($sql);
		echo json_encode($data);
	}
public function EditNPI($arr){
		$db=Mysql::getInstance();
		$id = $arr[0];
		$step = $arr[1];
		$remark = $arr[2];
		$status = $arr[3];
		$db->opencommit(); //开启事务
		$steps = [1,2,3];
		$file_step = [1,2,4];
		if(array_search($step,$file_step)!==false){ //如果是1 2 4 步 需要上传文件
			$fsql="select file_id from npi_npi_step where primary_id='$id' and step='$step' "; //
			$file=$db->getRow($fsql);
			if ($file['file_id']==0){ //没有上传文件 提示 1146
				echo 1146;
				return false;
			}
		}
	
		$sql = "update npi_npi_step set remark= '$remark' ";
		if(array_search($step,$steps)!==false){ //如果是 1、2、3 步

			
			if($status==0){ //continue
				//die($sql."where step='$step' and primary_id='$id'");
				$aft = $db->carrySql($sql."where step='$step' and primary_id='$id'");
				if($aft==1){
					echo json_encode('1111');
					$db->surecommit();
					return false;
				}
			}else{
				$etime = date('Y-m-d H:i:s');
				$sql .= ","."status=1,edtime='$etime' where step='$step' and primary_id='$id' ";
				//die($sql);
				$aft = $db->carrySql($sql);
				$in_steps = $this->create_in([1,2,3]);//把数组[1,2,3]转成  " in ('1','2','3')" 便于sql执行 in 关键字语句 
				$check_status = "select status from npi_npi_step where primary_id='$id' and step".$in_steps;
				//die($check_status);
				$rows = $db->getRows($check_status);
				$newarr = array_filter($rows,function($v){
					return $v['status'] == 1;
				});
				//var_dump($newarr);
				if(count($newarr)==3&&$aft==1){ //表示1、2、3三步都finish 带出第四部
					$time = date('Y-m-d H:i:s');
					$isql = "insert into npi_npi_step (step,primary_id,bgtime,owner,checker,status,file_id) values(4,'$id','$time','TPR-PE-Team','TPR-PE-Team',0,0) ";
					$ires = $db->carrySql($isql);
					if($ires==1){ //step4 生成
						$db->surecommit();
						echo json_encode('1111');
					}else{
						$db->backcommit();
						echo json_encode('error in insert');
					}
				}else if(count($newarr)!=3&&$aft==1){
						echo json_encode(['1111','not up to step 4']);
						$db->surecommit();
				} 
			}
			
			//print_r($newarr);
		}else if($step==4) { //step4
			if($status==0){ //continue
				//die($sql."where step='$step' and primary_id='$id'");
				$aft = $db->carrySql($sql."where step='$step' and primary_id='$id'");
				if($aft==1){
					echo json_encode('1111');
					$db->surecommit();
					return false;
				}
			}else{
				$etime = date('Y-m-d H:i:s');
				$sql .= ","."status=1,edtime='$etime' where step='$step' and primary_id='$id' ";
				//die($sql);
				$aft = $db->carrySql($sql);
				if($aft==1){
					$time = date('Y-m-d H:i:s');
					$isql = "insert into npi_npi_step (step,primary_id,bgtime,owner,checker,status,file_id) values(5,'$id','$time','Compal-PE-Team','Compal-PE-Team',0,0) ";
					$ires = $db->carrySql($isql);
					if($ires==1){ //step5 生成
						$db->surecommit();
						echo json_encode('1111');
					}else{
						$db->backcommit();
						echo json_encode('error in insert');
					}
				} 
			}
		}
		else if($step==5) { //step5
			if($status==0){ //continue
				//die($sql."where step='$step' and primary_id='$id'");
				$aft = $db->carrySql($sql."where step='$step' and primary_id='$id'");
				if($aft==1){
					echo json_encode('1111');
					$db->surecommit();
					return false;
				}
			}else{
				$etime = date('Y-m-d H:i:s');
				$sql .= ","."status=1,edtime='$etime' where step='$step' and primary_id='$id' ";
				//die($sql);
				$aft = $db->carrySql($sql);
				if($aft==1){
					$time = date('Y-m-d H:i:s');
					$isql = "insert into npi_npi_step (step,primary_id,bgtime,owner,checker,status,file_id) values(6,'$id','$time','Compal-QA-Team','Compal-QA-Team',0,0) ";
					$ires = $db->carrySql($isql);
					if($ires==1){ //step5 生成
						$db->surecommit();
						echo json_encode('1111');
					}else{
						$db->backcommit();
						echo json_encode('error in insert');
					}
				} 
			}
		}
		else if($step==6) { //step6
			if($status==0){ //continue
				//die($sql."where step='$step' and primary_id='$id'");
				$aft = $db->carrySql($sql."where step='$step' and primary_id='$id'");
				if($aft==1){
					echo json_encode('1111');
					$db->surecommit();
					return false;
				}
			}else{
				$etime = date('Y-m-d H:i:s');
				$sql .= ","."status=1,edtime='$etime' where step='$step' and primary_id='$id' ";
				//die($sql);
				$aft = $db->carrySql($sql);
				if($aft==1){
					$lsql = "update npi_npi set status=1 where id='$id' ";
					$laft =  $db->carrySql($lsql);
					if($laft==1){
						echo json_encode('1111');
						$db->surecommit();
					}else{
						$db->backcommit();
						echo json_encode('error in step6 update');
					}
				} 
			}
		}
		

	}

public function create_in($list = '')
	{
		if (empty($list)) {
			return " IN ('') ";
		} else {
			$str = $this->joinString($list);
			return trim($str) == '' ? " IN ('') " : " IN (" . $str . ") ";
		}
	}

public function joinString($list = '', $delimiter = ',', $res_arr = false)
	{
	if (!is_array($list)) {
		$list = explode($delimiter, $list);
	}
	$list = array_unique($list);
	$arr  = array();
	foreach ($list AS $v) {
		if (is_array($v)) {
			foreach ($v as $key => $val) {
				$arr[] = "'" . $val . "'";
			}
		} elseif ($v !== '') {
			$arr[] = "'$v'";
		}
	}
	if ($res_arr) {
		return $arr;
	}
	return count($arr) == 0 ? " " : join($delimiter, $arr);
}
public function SendMail($arr){
	$db=Mysql::getInstance();
	if ($arr[0]=="C"){
			$flag = $arr[4];
			$reason = $arr[3];
			$cnt = count($arr[1]);
			$arrtpr = $arr[1];
			//$smodel = implode(',',$arr[5]);//implode 讲数组元素以给定符号连接成字符串！！
			$model = $this->create_in($arr[5]);//class内  函数调用另一个函数需要用this关键字
			// 	if( strpos($res0[$m]['modeltotpr'],',') ){//如果不只对应一家tpr
			// 		$tmp = explode(',',$res0[$m]['modeltotpr']);//用，号分割字符串形成tpr数组
			// 		//echo json_encode($tmp);
			// 		for($mm=0;$mm<count($tmp);$mm++){
			// 			if(!in_array( $tmp[$mm],$dtpr,true ) ){ //往dtpr中push不存在于dtpr中的的需要通知的tpr
			// 			//如果使用array_search时，如果返回的键值是0时，if判断会有问题！！！！去重等操作就会出现重复值情况
			// 			//尽量使用in_array判断
			for ($c=0;$c<count($arrtpr);$c++){
				if($flag=='Normal'){
					$sql="select Owner,Checker from npi_owner where tpr='$arrtpr[$c]' and steps=3 ";
				}else{
					$sql="select Owner,Checker from npi_owner where tpr='NPI' and steps=2 ";
				}
				if($arrtpr[$c]=='RLC_INDIA'){
					$msql = "select model,modeltotpr from modeltotpr where modelToTPR like '%ICC-RLG%' and model ".$model;
				}elseif($arrtpr[$c]=='Regenersis_INDIA'){
					$msql = "select model,modeltotpr from modeltotpr where modelToTPR like '%CTDI%' and model ".$model;
				}else{
					$msql = "select model,modeltotpr from modeltotpr where modelToTPR like '%$arrtpr[$c]%' and model ".$model;

				}
				$mres =$db->getRows($msql); 
				$modelstr = '';
				//$len = count(mres)-1;
				if(count($mres)>=1){
					for($m=0;$m<count($mres);$m++){
						if($m!=count($mres)-1){
							$modelstr .=$mres[$m]['model'].','; 
						}else{
							$modelstr .=$mres[$m]['model']; 
						}
						
						
					}
				}else{
					continue;
				}
				$result=$db->getRow($sql);
				$owner=$result['Owner'];
				$sql1="select name,mail from mail where tpr='$arrtpr[$c]' and spmaflag=1 ";
				$result="";
				$result=$db->getRows($sql1);
				$mailer=array();
				for($x=0;$x<count($result);$x++){
					if ($result[$x]['name']==$owner){
						array_unshift($mailer,$result[$x]);
					}else{
						$mailer[]=$result[$x];
					}
				}
				//$title="WWW Repair Center Program Control System";
				
				if($flag =='Normal'){
					if($arrtpr[$c]=='RLC_INDIA'){
						$arrtpr[$c]='ICC-RLG';
				}elseif($arrtpr[$c]=='Regenersis_INDIA'){
					$arrtpr[$c]='CTDI';
				}
					$title="programing system testing mail,please ignore it";
					$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner.":<br/>".$arrtpr[$c]." ,[Model:".$modelstr."],[Activity:".$reason."] need you maintain program system  <br/>*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				}else{
				if($arrtpr[$c]=='RLC_INDIA'){
						$arrtpr[$c]='ICC-RLG';
				}elseif($arrtpr[$c]=='Regenersis_INDIA'){
					$arrtpr[$c]='CTDI';
				}
					$title="NPI system testing mail,please ignore it";
					$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner.":<br/>".$arrtpr[$c].",[Model:".$modelstr."],[Activity:".$reason."] need you maintain NPI system  <br/>*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Shownpi.html) for details.<br/>*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				}

	
				$rs=sendmail($mailer,$title,$text);
			//die($text);	
			}
			echo json_encode($rs);
			//return '';
}
		else if ($arr[0]=="E"){
			$id=$arr[1];
			$step=$arr[2];
			$flag = $arr[3];
			$query = "select TPR,Model from npi_npi where id='$id'";
			$tpr = $db->getRow($query)['TPR'];
			$model =$db->getRow($query)['Model'];
			$title="NPI System Auto Mail";
			$msql = "select name,mail from mail where tpr='$tpr' and spmaflag=1 ";
			$mrows = $db->getRows($msql);
			// $mailer = $mrows;
			$mailer = [['name'=>'iori','mail'=>'1409330098@qq.com']];
			$cont1 = "<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's step".$step."  has been signed, please pay attention to it <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$cont2 ="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's step".$step."  has been signed, please pay attention to it <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$cont3 = "<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's step".$step."  TPR has confirm the time of NPI begining, Next step please upload report! tks  <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$cont4 = "<span style='font-family: Calibri,serif;font-size: 18px'>Hi Compal-PE-Team:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's step".$step."  has been signed, TPR has uploaded report,Please have a check <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$cont5 = "<span style='font-family: Calibri,serif;font-size: 18px'>Hi Hi Compal-QA-Team:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item's step".$step."  has been signed,TPR has uploaded report,Please have a check <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			$cont6 = "<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
			<strong><b style='color:blue;'>".$tpr." ,Model: ".$model."</b></strong>, this NPI-item has been finished <br/>
			*Please login TPR ManageMent System(https://www.compal.top) for details.<br/>
			*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
			switch ($step) {
				case '1':
					$rs=sendmail($mailer,$title,$cont1);
					break;
				case '2':
					$rs=sendmail($mailer,$title,$cont2);
					break;
				case '3':
					$rs=sendmail($mailer,$title,$cont3);
					break;
				case '4':
					$rs=sendmail($mailer,$title,$cont4);
					break;
				case '5':
					$rs=sendmail($mailer,$title,$cont5);
					break;
				case '6':
					$rs=sendmail($mailer,$title,$cont6);
					break;	
			}
			echo json_encode($rs);
			//return $rs;
		}
} 
public	function  insertcookie($arr){
		//echo json_encode($arr);
		$db = $db=Mysql::getInstance();
		$id = $arr[0];
		$cookiename = $arr[1];
		$value = $arr[1];

		
		for($i=0;$i<count($data);$i++){
			
			// $nowtime = $this->msectime();//获得当前时间的毫秒数！
			// $value = $arr[$i][1]-$nowtime;
			$sql = "insert into timecookie (primary_id,cookiename,value) values('$id','$cookiename[$i]','$value[$i]')";
			$res = $db->carrySql(sql);
		}
		echo json_encode($res);
		// $cookiename = $arr[0];
		// $value =  $arr[1];
		// $db = $db=Mysql::getInstance();
		// $ssql = "select * from timecookie where cookiename='$cookiename' ";
		// //die($ssql);
		// $sres = $db->getRow($ssql);
		// if(count($sres)==0){
		// 	$nowtime = $this->msectime();//获得当前时间的毫秒数！
		// 	$value = $value-$nowtime;
		// 	$sql = "insert into timecookie (cookiename,value) values ('$cookiename','$value') ";
		// 	//die($sql);
		// 	$res = $db->carrySql($sql);
		// 	echo json_encode($res);
		// }else{
		// 	echo json_encode('added');
		// }
		
	}

	public	function  querycookie($arr){
		//echo json_encode($arr);
		$tarr = array();
		for($i=0;$i<count($arr);$i++){
			
			array_push($tarr,$arr[$i][0]);

		}
		$cookiename = $this->create_in($tarr);
		//$value =  $arr[1];
		$db = $db=Mysql::getInstance();
		$ssql = "select * from timecookie where cookiename".$cookiename;
		//die($ssql);
		$sres = $db->getRow($ssql);
		// if(count($sres)==0){
		// 	for($j=0;$j<count($arr);$j++){
		// 		$sql = "insert into timecookie (cookiename,value) values('$arr[$j][0]','$arr[$j][1]')";
		// 		$db->carrySql(sql);
		// 	}
		// }
		echo json_encode($sres);
	}
	
//获取毫秒时间戳
public function msectime(){
		list($msec, $sec) = explode(' ', microtime());
		$msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
		return $msectime;
	}
public	function  getcookie($arr){
		//echo json_encode($arr);
		$cookiename = $arr;
		
		$db = $db=Mysql::getInstance();
		$ssql = "select * from timecookie where cookiename='$cookiename' ";
		//die($ssql);
		$sres = $db->getRows($ssql);
		//echo json_encode(count($sres));
		if(count($sres)!==0){
			echo json_encode($sres);
		}else{
			echo json_encode('not sign2');
		}
		
	}
	
}//class 
function sendmail($arr,$title,$text){
		
	require_once '../../Tool/phpmail/PHPMailer.php';
	require_once '../../Tool/phpmail/SMTP.php';
	$mail = new PHPMailer(true);
	//$mail->ClearAllRecipients();
	//$mail->SMTPDebug = true;
	$mail->CharSet = "UTF-8";

	$mail->IsSMTP();
	$mail->Host = "154.85.52.96";
	//$mail->Host = "smtp.163.com";
	$mail->SMTPAuth = true;

	$mail->Username = "compaltpr@compal.top";
	$mail->Password = "XUDELIN8800275";
	//$mail->Username = "13771992334@163.com";
	//$mail->Password = "qaz123456";

	$mail->Port = 25;
	$mail->setFrom('compaltpr@compal.top', 'compaltpr@compal.top');//send mailer

	for ($i=0;$i<count($arr);$i++){
		$email=$arr[$i]['mail'];
		$ename=$arr[$i]['name'];
		if($i==0){
			$mail->AddAddress("$email", "$ename");//收件人
		}else{
			$mail->AddCC("$email", "$ename");//抄送
		}
	}

	$mail->IsHTML(true);
	$mail->Subject = $title;
	$mail->Body = $text;

	//include '../db/close_db.php';
	if (!$mail->Send()) {
		//return "440: " . $mail->ErrorInfo;
		return '0000';
		exit;
	}else{
		// echo'<pre>';
		// var_dump($asql);
		return '1111';
		//$mail->ClearAllRecipients();
	}
}


function del_folder($folder){
	$path="../../NPI_System_file/".$folder."/";
	if(is_dir($path)){
		@rmdir($path);
	}
}

 
