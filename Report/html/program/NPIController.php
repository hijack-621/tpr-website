<?php
include 'Database.Class.php';
class NPIController{
	private $result;
	public function Create(){
		$model_json=$_POST['model_json'];
		$model_obj=json_decode($model_json);
		$now_time=date('Y-m-d H:i:s');
		$up=$_POST['up'];//npi or normal
		$station=$_POST['station'];
		
		$reason=$_POST['reason'];
		$npi_path=$_POST['npipath'];
		$st_arr=$_POST['st_group'];
		$change=$_POST['change'];
		$id=$_POST['id'];
		$val=$_POST['val'];
		$flag=$_POST['flag'];

		if(isset($_POST['bdview'])){
			$bdview =addslashes($_POST['bdview']);
			$sa1 = 'BoardViewPath';
		   }
		$st_group=explode(",",$st_arr);

		$checkdata=$_POST['checkdata'];
		$tpr_arr=explode(',',$checkdata);
		$send_tpr=array();
		$db=mysql::getInstance();
		$db->opencommit();
		for ($i=0;$i<count($tpr_arr);$i++){
			//$sql="select owner,checker from npi_owner where tpr='$up' and step=1 ";
			//echo $tpr_arr[$i];
			//$arr=SearchOwner($up,1);
			// if($flag=='NPI'){
			// 	$sql="select Owner,Checker from npi_owner where tpr='$up' and steps=1 ";
			// }
			$sql="select Owner,Checker from npi_owner where tpr='$up' and steps=1 "; //npi->lucky normal->will
 			$data=$db->getRow($sql);

			$this_owner=$data['Owner'];
			$this_checker=$data['Checker'];
			$data=array();
			if($up=='NPI'){ //如果sort字段为npi，第二步伟compal pe
				$sql="select Owner,Checker from npi_owner where tpr='$up' and steps=2 ";
			}else{
				//$sql="select Owner,Checker from npi_owner where tpr='$tpr_arr[$i]' and steps=3 ";//normal step2为tpr qa 数据库为steps 3为qa
				$sql="select Owner,Checker from npi_owner where tpr='$tpr_arr[$i]' and steps=4 ";//改成tpr compal qa 不签， step-4就是tpr pe
			}
			// $sql="select Owner,Checker from npi_owner where tpr='$tpr_arr[$i]' and steps=2 ";
			$data=$db->getRow($sql);

			$next_owner=$data['Owner'];
			$next_checker=$data['Checker'];
			$id= strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$sql="insert into npi_primary (id,sort,reason,tpr,station,sop_path,bgtime,dytime) values ('$id','$up','$reason','$tpr_arr[$i]','$station','$npi_path','$now_time','$now_time')";
			$affect_a=$db->carrySql($sql);
			$sql="insert into npi_step (step,primary_id,bgtime,owner,checker,status) values (1,'$id','$now_time','$this_owner','$this_checker',1)";
			$affect_b=$db->carrySql($sql);
			$sql="insert into npi_step (step,primary_id,bgtime,owner,checker,status) values (2,'$id','$now_time','System Auto Closed','System Auto Closed',1),(3,'$id','$now_time','$next_owner','$next_checker',0) ";
			//die($sql);
			$affect_c=$db->carrySql($sql);
			if ($affect_a!=1 || $affect_b!=1 || $affect_c!=2){
				
				// echo $affect_a.'a';
				// echo $affect_b.'b';
				// echo $affect_c.'c';

				$tag='1010';
				$msg[]=$tag;
				$msg[]=0;
				$db->backcommit();
				echo json_encode($msg);
				return false;
			}
			$st_rs=0;
			for ($c=0;$c<count($st_group);$c++){
				$sa=explode("_",$st_group[$c])[0];
				$path=explode("_",$st_group[$c])[1];
				$path2 = addslashes($path);
				$sql="insert into npi_station (primary_id,station,path) values ('$id','$sa','$path2')";
				//die($sql);   ok
				$affect=$db->carrySql($sql);
				
				if ($affect==1){
					$st_rs=1;
					
				}
			}
			
			if(isset($bdview)){
						$sql="insert into npi_station (primary_id,station,path) values ('$id','$sa1','$bdview')";
						$db->carrySql($sql);
			}
			$md_rs=0;
			$modelarr = [];
			if($change==1){
				foreach ($model_obj as $key=>$value){
					//cho $key;
					array_push($modelarr,$key);
					$time = date('Y-m-d H:i:s');
					$sql="insert into npi_model (primary_id,model,insertime,qc1_img,qc2_img,qc3_img,oba_img,runin_img) values ('$id','$key','$time',";
					//die($sql);
					for ($c=0;$c<count($value);$c++){
						$img=$value[$c][0];
						$sql.="'$img',";
					}
					$sql = substr($sql,0,strlen($sql)-1);
					$sql.=")";
					//die($sql);
					$affect=$db->carrySql($sql);
					//echo $affect;
					if ($affect==1){
						$md_rs=1;
					}
				}
			}
			
			$fe_rs=0;
			$primary_path="../../NPI_System_file/".$id."/";
			mkdir($primary_path);
			for ($c=0;$c<count($_FILES);$c++){
				$file_id=strtoupper ( md5 ( uniqid ( rand (), true ) ) );
				$path=$primary_path.$file_id."/";
				if (mkdir($path)){
					$file_name=$_FILES['file'.$c]['name'];
					if(copy($_FILES['file'.$c]['tmp_name'],$path.$_FILES['file'.$c]['name'])){
						$sql="insert into npi_file (primary_id,file_id,file_name,step) values ('$id','$file_id','$file_name',1)";
						//die($sql);
						$affect=$db->carrySql($sql);
						if ($affect==1){
							$sql="update npi_step set file_id='1' where primary_id='$id' and step='1' ";
							$db->carrySql($sql);
							$fe_rs=1;
							//echo $c;
						}
					}
				}
			}
			if ($fe_rs==0){
				del_folder($primary_path);
			}
			if ($md_rs!=1 || $st_rs!=1 ||$fe_rs!=1){
				// echo $md_rs.'a';
				// echo $st_rs.'b';
				// echo $fe_rs.'c';
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
		$msg[]=$md_rs; //触发 显示进度条和upload 状态
		$msg[]=$file_id; //file  id
		$msg[]=$modelarr;//model数组

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
		//die($sql);
		//$sql="SELECT Model,Oldver,Old_sysver FROM (SELECT Model,Oldver,Old_sysver FROM model ORDER BY Oldver DESC) a GROUP BY a.model";
	
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
	if ($nums!=0){
		$arr=array();
		while (($row = mysqli_fetch_array($result))!==false&&$row>0) {
			$arr[]=$row;
		}
	}
	echo json_encode($arr);
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
		$db=Mysql::getInstance();
		$tpr = $arr['tpr'];
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
			$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img qc1_img,npi_model_data.qc2_img qc2_img,npi_model_data.qc3_img qc3_img,npi_model_data.oba_img oba_img,npi_model_data.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0 and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model =	npi_model_data.model  ";
			//die($sql);
		}else{
			$tpr=$_SESSION["utpr"];
			$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model.qc1_img qc1_img,npi_model.qc2_img qc2_img,npi_model.qc3_img qc3_img,npi_model.oba_img oba_img,npi_model.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.status=0 and npi_primary.tpr='$tpr' and npi_primary.sort='$flag' and npi_primary.id=npi_model.primary_id and npi_model.model =npi_model_data.model   ";

			//$sql="select * from npi_primary where suo=0 and status=0 and tpr='$tpr' ";
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
		$db=Mysql::getInstance();
		$id=$arr[0];
		$step=$arr[1];
		$sql="select * from npi_file where primary_id='$id' and step='$step' ";
		$data=$db->getRows($sql,MYSQLI_BOTH);
		echo json_encode($data);
	}
	public function layergetver($arr){
		$id = $arr[0];
		$flag = $arr[1];
		$index = array();
		$db=Mysql::getInstance();
		if(isset($arr[2])){
			$pmodel = $arr[2];
		$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img qc1_img,npi_model_data.qc2_img qc2_img,npi_model_data.qc3_img qc3_img,npi_model_data.oba_img oba_img,npi_model_data.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.sort ='$flag' and npi_primary.id ='$id' and npi_model.model='$pmodel'  and npi_primary.id=npi_model.primary_id and npi_model.model =	npi_model_data.model  ";
		//die($sql);
		}else{
		$sql="select npi_primary.*,npi_model.model model,npi_model.qc1_img nqc1_img,npi_model.qc2_img nqc2_img,npi_model.qc3_img nqc3_img,npi_model.oba_img noba_img,npi_model.runin_img nrunin_img,npi_model_data.qc1_img qc1_img,npi_model_data.qc2_img qc2_img,npi_model_data.qc3_img qc3_img,npi_model_data.oba_img oba_img,npi_model_data.runin_img runin_img from npi_primary,npi_model,npi_model_data where npi_primary.suo=0 and npi_primary.sort ='$flag' and npi_primary.id ='$id'  and npi_primary.id=npi_model.primary_id and npi_model.model =	npi_model_data.model  ";

		}
		//die($sql);
		// if($_SESSION["utpr"]=='CGS'){
			
		$data=$db->getRows($sql,MYSQLI_BOTH);
		//echo json_encode(count($data));
		//return '';
		for($i=0;$i<count($data);$i++){
			$model = $data[$i]['model'];
			$tpr = $data[$i]['tpr'];
			if($tpr=='RLC_INDIA'){
				$tpr='ICC-RLG';
			}elseif($tpr=='Regenersis_INDIA'){
				$tpr='CTDI';
			}
		
			$sql = "select model,modeltotpr from modeltotpr where Model='$model' and ModelToTPR like '%$tpr%' ";
			// if($i==3){
			// 	die($sql);
			// }
			
			$res = $db->getRows($sql);
			if(count($res)==0){
				//echo $i;
				array_push($index,$i);

				//unset($data[$i]);
			}
		}
		if(count($index)>=1){
			foreach($index as $key=>$value){
				unset($data[$value]);
			}
		}
		//echo json_encode($index);
		$rdata = array_values($data);//重新让索引连续，array_values返回数组的值，索引重新从0递增！！！
		echo json_encode($rdata);
		
		//echo json_encode($arr);
	}


	public function upFile(){
		$db=Mysql::getInstance();
		$file=$_FILES['file'];
		$primary_id=$_POST['id'];
		$step=$_POST['step'];
		$now_time=date('Y-m-d H:i:s');
		$file_name=$_FILES['file']['name'];
		$file_id=strtoupper ( md5 ( uniqid ( rand (), true ) ) );
		$path="../../NPI_System_file/".$primary_id."/".$file_id."/";
		// if ($step!=1&&$step!=5&&$step!=2){
		// 	echo 1007;
		// 	return false;
		// }
		if (mkdir($path)){
			if(!move_uploaded_file($_FILES['file']['tmp_name'],$path.$_FILES['file']['name'])){
				echo '1009';
				return false;
			}else {
				$sql="insert into npi_file (primary_id,file_id,file_name,step,up_time) values  ('$primary_id','$file_id','$file_name','$step','$now_time')";
				$numsa=$db->carrySql($sql);
				$sql="update npi_step set file_id='1' where primary_id='$primary_id' and step='$step' ";
				$numsb=$db->carrySql($sql);
				if ($numsa==1){
					echo 1111;
				}else {
					$rs=del_file($primary_id,$file_id);
					echo $numsb;
					return false;
				}
			}
		}else {
			echo 1020;
			return false;
		}
	}
	public function delFile($arr){
		$db=Mysql::getInstance();
		$rs=del_file($arr[0],$arr[1]);

		if ($rs==true){
			$sql="delete from npi_file where file_id='$arr[1]' ";
			$db->carrySql($sql);
		}else{
			echo 3060;
			return false;
		}
		$sql="select * from npi_file where primary_id='$arr[0]' ";
		$result=$db->select($sql);
		$nums=mysqli_num_rows($result);
		if ($nums==0){
			del_folder($arr[0]);
		}
		echo json_encode(1111);

	}
	public function getStation($id){
		$db=Mysql::getInstance();
		//$id=$arr[0];
		$sql="select station,path from npi_station where primary_id='$id' ";
		$data=$db->getRows($sql);
		echo json_encode($data);
	}

	public function editStation($arr){
	$db=Mysql::getInstance();
	$id=$arr[0];
	$station=$arr[1];
	$path=$arr[2];
	$sql="update npi_station set station='$station',path='$path' where primary_id='$id' and station='$station' ";
	$nums=$db->carrySql($sql);
	if ($nums==1){
		echo json_encode("ok");
	}else{
		echo json_encode("fail");
	}
	}
	public function addStation($arr){
		$db=Mysql::getInstance();
		$id=$arr[0];
		$station=$arr[1];
		$path=$arr[2];
		$sql="insert into npi_station (primary_id,station,path) values ('$id','$station','$path')";
		$nums=$db->carrySql($sql);
		if ($nums==1){
			echo json_encode("ok");
		}else{
			echo json_encode("fail");
		}
	}
	public function delStation($arr){
		$db=Mysql::getInstance();
		$id=$arr[0];
		$station=$arr[1];
		$sql="delete from npi_station where primary_id='$id' and station='$station' ";
		$nums=$db->carrySql($sql);
		if ($nums==0){
			echo json_encode("fail");
		}else{
			echo json_encode("ok");
		}
	}
	public function delData($arr){
		$db=Mysql::getInstance();
		if($_SESSION["utpr"]!='CGS'){
			echo 1020;
			return false;
		}
		$sql="select file_id from npi_file where primary_id='$arr' ";
		$data=$db->getRows($sql);
		$db->opencommit();
		$sql="delete npi_file,npi_model,npi_primary,npi_station,npi_step from npi_file,npi_model,npi_primary,npi_station,npi_step where npi_file.primary_id='$arr' and npi_model.primary_id='$arr' and npi_primary.id='$arr' and npi_station.primary_id='$arr' and npi_step.primary_id='$arr' ";
		//SendMaildie($sql);
		$nums=$db->carrySql($sql);
		if ($nums>0){
			for ($i=0;$i<count($data);$i++){
				$rs=del_file($arr,$data[$i]['file_id']);
				if ($rs==false){
					echo 1010;
					$db->backcommit();
					exit;
				}
			}
			del_folder($arr);
			echo 1111;
			$db->surecommit();
		}else{
			echo 1011;
			$db->backcommit();
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
		$sql="select * from npi_primary where id='$id' ";
		$data=$db->getRow($sql);
		echo json_encode($data);
	}
	public function getStepData($id){
		$db=Mysql::getInstance();
		$sql="select * from npi_step where primary_id='$id' ";
		//die($sql);
		$data=$db->getRows($sql,MYSQLI_BOTH);
		echo json_encode($data);
	}
	public function getEditData($arr){
		$db=Mysql::getInstance();
		$sql="select * from npi_step where primary_id='$arr[0]' and step='$arr[1]' ";
		//die($sql);
		$data=$db->getRow($sql);
		echo json_encode($data);
	}
	public function EditNPI($arr){
		$db=Mysql::getInstance();
		$next_step=$arr[1]+1;
		$sql="select sort,tpr,suo,bgtime from npi_primary where id='$arr[0]' ";//0=>id
		
		$data=$db->getRow($sql);
		$tpr=$data['tpr'];
		$suo=$data['suo'];
		$type = $data['sort'];
		$primary_time=$data['bgtime'];
		if ($suo==1){
			echo '1010';
			return false;
		}
		if($type=='NPI'){
			if ($arr[1]!=8){
				if($arr[1]==2){ //如果step2,带出第三部checker为tpr qa
					//$next = $arr[1]+2;
					$sql="select Owner,Checker,steps from npi_owner where( (steps='$arr[1]' and tpr='NPI') or (steps='$next_step' and tpr='$tpr' ) ) order by steps ";
					//die($sql);
					$data=null;
					$data=$db->getRows($sql,MYSQLI_BOTH);
					$owner=$data[0]['Owner'];
					$checker=$data[0]['Checker'];
					$next_owner=$data[1]['Owner'];
					$next_checker=$data[1]['Checker'];

				}else if($arr[1]==3){//如果step4,带出第5部checker为tpr pe
				
					$sql="select Owner,Checker,steps from npi_owner where (  steps='$next_step' ) and tpr='$tpr' order by steps ";
					$data=null;
					$data=$db->getRows($sql,MYSQLI_BOTH);
					$owner=$data[0]['Owner'];
					$checker=$data[0]['Checker'];
					$next_owner=$data[0]['Owner'];
					$next_checker=$data[0]['Checker'];
				}
				else if($arr[1]==4){//如果step4,带出第5部checker为tpr pe
				
					$sql="select Owner,Checker,steps from npi_owner where (  steps='$arr[1]' ) and tpr='$tpr' order by steps ";
					$data=null;
					$data=$db->getRows($sql,MYSQLI_BOTH);
					$owner=$data[0]['Owner'];
					$checker=$data[0]['Checker'];
					$next_owner=$data[0]['Owner'];
					$next_checker=$data[0]['Checker'];
				}
				else{
					$sql="select Owner,Checker,steps from npi_owner where ( steps='$arr[1]' or steps='$next_step' ) and tpr='$tpr' order by steps  ";
					$data=null;
					$data=$db->getRows($sql,MYSQLI_BOTH);
					$owner=$data[0]['Owner'];
					$checker=$data[0]['Checker'];
					$next_owner=$data[1]['Owner'];
					$next_checker=$data[1]['Checker'];
				}
				//die($sql);
				
				}
				else{ // step8
					$sql="select Owner,Checker,steps from npi_owner where steps='$arr[1]' and tpr='$tpr' order by steps ";
					$data=null;
					$data=$db->getRow($sql);
					$owner=$data['Owner'];
					$checker=$data['Checker'];
				}
		}else{ //NORMAL
			
			if($arr[1]==3){
				//$next_step++; // program到达第三步的话，第四步owner设置为tpr pe
				$sql="select Owner,Checker,steps from npi_owner_program where  steps='$next_step'  and tpr='$tpr' order by steps ";
				//die($sql);
				$data=null;
				$data=$db->getRows($sql,MYSQLI_BOTH);
				$owner=$data[0]['Owner'];
				$checker=$data[0]['Checker'];
				$next_owner=$data[0]['Owner'];
				$next_checker=$data[0]['Checker'];
			}else if($arr[1]==5){
				$next_step = $arr[1]+3;
				$sql="select Owner,Checker,steps from npi_owner_program where ( steps='$arr[1]' or steps='$next_step' ) and tpr='$tpr' order by steps ";
				//die($sql);
				$data=null;
				$data=$db->getRows($sql,MYSQLI_BOTH);
				$owner=$data[0]['Owner'];
				$checker=$data[0]['Checker'];
				$next_owner=$data[1]['Owner'];
				$next_checker=$data[1]['Checker'];
				$next_step = 6;
			}
			else{
				$next_step++;
				$arr[1]++;
				$sql="select Owner,Checker,steps from npi_owner_program where ( steps='$arr[1]' or steps='$next_step' ) and tpr='$tpr' order by steps ";
				//die($sql);
				$data=null;
				$data=$db->getRows($sql,MYSQLI_BOTH);
				$owner=$data[0]['Owner'];
				$checker=$data[0]['Checker'];
				$next_owner=$data[1]['Owner'];
				$next_checker=$data[1]['Checker'];
				$arr[1]--;
				$next_step--;
			}
		}
		
		$sql="select * from npi_step where primary_id='$arr[0]' and step='$arr[1]' ";
		$data=null;
		$data=$db->getRow($sql);
		$this_owner=$data['owner'];
		$this_checker=$data['checker'];
		$statu=$data['status'];
		$now_date=date('Y-m-d H:i:s');
		$bgtime=$data['bgtime'];

		if ($statu==1||$statu==5){
			echo 1023;
			return false;
		}
		if($_SESSION["uname"]!=$this_owner&&$_SESSION["utpr"]!="CGS"){
			$time[]='1020';
			$msg[]=$time;
			echo json_encode($msg);
			return false;
		}

		if ($arr[3]==0){ 
			$sql="update npi_step set remark='$arr[2]' where primary_id='$arr[0]' and step='$arr[1]' ";
			$result=$db->carrySql($sql);
			if ($result==1){
				echo 1133;
				return false;
			}else{
				echo 1144;
				return false;
			}
		}

		if ($arr[1]==4&&$type=='Normal'){
			$sql="select file_id from npi_step where primary_id='$arr[0]' and step='$arr[1]' ";
			$file=$db->getRow($sql);
			if ($file['file_id']==0){
				echo 1146;
				return false;
			}
		}else if($arr[1]==5&&$type=='NPI'){
			$sql="select file_id from npi_step where primary_id='$arr[0]' and step='$arr[1]' ";
			$file=$db->getRow($sql);
			if ($file['file_id']==0){
				echo 1146;
				return false;
			}
		}
		
		

		$date_day=floor((strtotime($now_date)-strtotime($bgtime))/86400);
		if ($date_day>5){
			$single_status=5;
		}else {
			$single_status=1;
		}

		$date_day=floor((strtotime($now_date)-strtotime($primary_time))/86400);
		if ($date_day>5){
			$total_status=5;
		}else {
			$total_status=1;
		}

		$db->opencommit();
		$sql="update npi_step set remark='$arr[2]',edtime='$now_date',status='$single_status' where primary_id='$arr[0]' and step='$arr[1]' ";
		//die($sql);
		$result=$db->carrySql($sql);
		if ($result==1){
			if($type=='Normal'){
				//echo $type;
				if ($arr[1]!=6){
					if($next_step>6){
						$next_step--;
					}
					if($arr[1]==5){
						$sql="insert into npi_step (step,primary_id,bgtime,owner,checker,status) values ('$next_step','$arr[0]','$now_date','System Auto Closed','System Auto Closed',1)";
					}else{
						$sql="insert into npi_step (step,primary_id,bgtime,owner,checker) values ('$next_step','$arr[0]','$now_date','$next_owner','$next_checker')";
					}
					
					//die($sql);
					$affect_a=$db->carrySql($sql);
					$sql="update npi_primary set dytime='$now_date' where id='$arr[0]' ";
					$affect_b=$db->carrySql($sql);
					if ($affect_a==1&&$affect_b==1){
						$db->surecommit();
						echo 1111;
	
					}else{
						echo 1147;
						$db->backcommit();
						return false;
					}
				}else{

					$sql="update npi_primary set edtime='$now_date',dytime='$now_date',status='$total_status' where id='$arr[0]' ";
					//update model table;
					//die($sql);
					$resulta=$db->carrySql($sql);
					$sql="update npi_model_data a,npi_model b  set a.qc1_img=(if(b.qc1_img!='',b.qc1_img,a.qc1_img)),a.qc2_img=(if(b.qc2_img!='',b.qc2_img,a.qc2_img)),a.qc3_img=(if(b.qc3_img!='',b.qc3_img,a.qc3_img)),a.runin_img=(if(b.runin_img!='',b.runin_img,a.runin_img)),a.oba_img=(if(b.oba_img!='',b.oba_img,a.oba_img)) where b.primary_id='$arr[0]' and a.model=b.model ";
					$resultb=$db->carrySql($sql);
					if ($resulta>0&&$resultb>=0){
						$db->surecommit();
						echo 1111;
					}else{
						echo 1147;
						$db->backcommit();
						return false;
					}
				}
			}else{
				if ($arr[1]!=8){
					$sql="insert into npi_step (step,primary_id,bgtime,owner,checker) values ('$next_step','$arr[0]','$now_date','$next_owner','$next_checker')";
					//die($sql);
					$affect_a=$db->carrySql($sql);
					$sql="update npi_primary set dytime='$now_date' where id='$arr[0]' ";
					$affect_b=$db->carrySql($sql);
					if ($affect_a==1&&$affect_b==1){
						$db->surecommit();
						echo 1111;
	
					}else{
						echo 1147;
						$db->backcommit();
						return false;
					}
				}else{
					$sql="update npi_primary set edtime='$now_date',dytime='$now_date',status='$total_status' where id='$arr[0]' ";
					//update model table;
					$resulta=$db->carrySql($sql);
					$ssql = "select reason,tpr,station,bgtime from npi_primary where id='$arr[0]' ";
					$sres = $db->getRows($ssql);
					$reason = $sres[0]['reason'];
					$tpr = $sres[0]['tpr'];
					$station = $sres[0]['station'];
					$bgtime = $sres[0]['bgtime'];
					$sssql = "select file_id,file_name,step from npi_file where primary_id='$arr[0]' and step=1 ";
					//die($sssql);
					$ssres =  $db->getRows($sssql);
					//echo count($ssres);
					$ssssql = "select station,path from npi_station where primary_id='$arr[0]' ";
					$sssres =  $db->getRows($ssssql);
					$sssssql = "select model,qc1_img,qc2_img,qc3_img,oba_img,runin_img from npi_model where primary_id='$arr[0]' ";
					$ssssres =  $db->getRows($sssssql);
					//echo count($sssres);
					$rid =  strtoupper ( md5 ( uniqid ( rand (), true ) ) );
					$fsql1 = "insert into npi_primary (id,sort,reason,tpr,station,sop_path,bgtime,status) values('$rid','Normal','$reason','$tpr','$station','Attach','$bgtime','1')";
					//die($fsql1);
					$fres1 = $db->carrySql($fsql1);
					for($i=0;$i<count($ssres);$i++){
						$file_id = $ssres[$i]['file_id'];
						$file_name = $ssres[$i]['file_name'];
						$step = $ssres[$i]['step'];
						$fsql2 = "insert into npi_file (primary_id,file_id,file_name,step) values('$rid','$file_id','$file_name','$step')";
						//die($fsql2);
						$fres2 = $db->carrySql($fsql2);
					}
					for($j=0;$j<count($sssres);$j++){
						$bstation = $sssres[$j]['station'];
						$path =  $sssres[$j]['path'];
						$fsql3 = "insert into npi_station (primary_id,station,path) values('$rid','$bstation','$path')";
						//die($fsql3);
						$fres3 = $db->carrySql($fsql3);
					}
					for($j=0;$j<count($ssssres);$j++){
						$model = $ssssres[$j]['model'];
						$qc1 =  $ssssres[$j]['qc1_img'];
						$qc2 =  $ssssres[$j]['qc2_img'];
						$qc3 =  $ssssres[$j]['qc3_img'];
						$oba =  $ssssres[$j]['oba_img'];
						$runin =  $ssssres[$j]['runin_img'];
						$fsql4 = "insert into npi_model (primary_id,model,qc1_img,qc2_img,qc3_img,oba_img,runin_img) values('$rid','$model','$qc1','$qc2','$qc3','$oba','$runin')";
						//die($fsql3);
						$fres4 = $db->carrySql($fsql4);
					}
					//$sql="update npi_model_data a,npi_model b  set a.qc1_img=(if(b.qc1_img!='',b.qc1_img,a.qc1_img)),a.qc2_img=(if(b.qc2_img!='',b.qc2_img,a.qc2_img)),a.qc3_img=(if(b.qc3_img!='',b.qc3_img,a.qc3_img)),a.runin_img=(if(b.runin_img!='',b.runin_img,a.runin_img)),a.oba_img=(if(b.oba_img!='',b.oba_img,a.oba_img)) where b.primary_id='$arr[0]' and a.model=b.model ";
					//$resultb=$db->carrySql($sql);
					if ($resulta>0&&$fres1>0&&$fres2>0&&$fres3>0&&$fres4>0){
						$db->surecommit();
						echo 1111;
					}else{
						// echo $resulta.'a';
						// echo $fres1.'b';  
						// echo $fres2.'c'; 
						// echo $fres3.'d'; 
						echo 1147;
						$db->backcommit();
						return false;
					}
				}
			}
		
		}else{
			$db->backcommit();
			echo 1143;
			return false;
		}

	}

	function create_in($list = '')
	{
		if (empty($list)) {
			return " IN ('') ";
		} else {
			$str = $this->joinString($list);
			return trim($str) == '' ? " IN ('') " : " IN (" . $str . ") ";
		}
	}

	function joinString($list = '', $delimiter = ',', $res_arr = false)
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
					$sql="select Owner,Checker from npi_owner where tpr='$arrtpr[$c]' and steps=4 ";//创建直接通知（step4->tpr qa）pe
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
				//echo json_encode($mres);
				//die($msql);
				//return '';
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
					$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner.":<br/>
					".$arrtpr[$c]." ,[Model:".$modelstr."],[Activity:".$reason."] need you maintain program system  <br/>
				*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>
				*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				}else{
				if($arrtpr[$c]=='RLC_INDIA'){
						$arrtpr[$c]='ICC-RLG';
				}elseif($arrtpr[$c]=='Regenersis_INDIA'){
					$arrtpr[$c]='CTDI';
				}
					$title="NPI system testing mail,please ignore it";
					$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner.":<br/>
	".$arrtpr[$c].",[Model:".$modelstr."],[Activity:".$reason."] need you maintain NPI system  <br/>
*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Shownpi.html) for details.<br/>
*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				}

	
				$rs=sendmail($mailer,$title,$text);
			//die($text);	
			}
			echo json_encode($rs);
			//return '';
			
		}else if ($arr[0]=="E"){
			$db=Mysql::getInstance();
			$id=$arr[1];
			$step=$arr[2];
			$flag = $arr[3];
			 //每一步
			if($flag=='Normal'){
				if ($step==5){
					$sql="select owner,checker from npi_step where step=$step and primary_id='$id' ";
					$step = 6;
				}else{
					$step=$step+1;
					$sql="select owner,checker from npi_step where step=$step and primary_id='$id' ";
				}
				$result=$db->getRow($sql);
				$owner=$result['owner'];
				$checker=$result['checker'];
				$sql="select reason,tpr from npi_primary where id='$id' ";
				$result="";
				$result=$db->getRow($sql);
				$reason=$result['reason'];
				$tpr=$result['tpr'];
				$sql="select name,mail from mail where tpr='$tpr'  and spmaflag=1 ";
				$result="";
				$result=$db->getRows($sql,MYSQLI_BOTH);
				$mailer=array();
				for($x=0;$x<count($result);$x++){
					if ($result[$x]['name']==$owner){
						array_unshift($mailer,$result[$x]);
					}else{
						$mailer[]=$result[$x];
					}
				}
					//$title="WWW Repair Center Program Control System";
					// echo $step;
					// return $step;
					$title="programing system testing mail,please ignore it";
				if($step==6){
						$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
						".$tpr." ".$reason." this program item has been finished <br/>
				*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>
				*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				//die($text);		
			}
					
			else{
						$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner.":<br/>
						".$tpr." ".$reason." need you maintain NPI_System  <br/>
				*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>
				*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				//die($text);
			}
				
				$rs=sendmail($mailer,$title,$text);
				echo json_encode($rs);
			}else{ //npi
				if ($step==8){
					$sql="select owner,checker from npi_step where step=$step and primary_id='$id' ";
					$step = 9;
				}else{
					$step=$step+1;
					$sql="select owner,checker from npi_step where step=$step and primary_id='$id' ";
				}
				$result=$db->getRow($sql);
				$owner=$result['owner'];
				$checker=$result['checker'];
				$sql="select reason,tpr from npi_primary where id='$id' ";
				$result="";
				$result=$db->getRow($sql);
				$reason=$result['reason'];
				$tpr=$result['tpr'];
				$sql="select name,mail from mail where tpr='$tpr'  and spmaflag=6 ";
				$result="";
				$result=$db->getRows($sql,MYSQLI_BOTH);
				$mailer=array();
				for($x=0;$x<count($result);$x++){
					if ($result[$x]['name']==$owner){
						array_unshift($mailer,$result[$x]);
					}else{
						$mailer[]=$result[$x];
					}
				}
					//$title="WWW Repair Center Program Control System";
					$title="programing system testing mail,please ignore it";
					if ($step!==9){
						$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ".$owner."<br/>
						".$tpr." ".$reason." need you maintain NPI_System  <br/>
				*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Shownpi.html) for details.<br/>
				*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				//die('1'.$flag);		
				//die($text.$flag);
			}else{
						$text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi ALL:<br/>
						".$tpr." ".$reason." this npi item has been finished <br/>
				*Please login TPR ManageMent System(https://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>
				*This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
				//die('1'.$flag);				
				//die($text.$flag);		
			}
				
				
				$rs=sendmail($mailer,$title,$text);
				echo json_encode($rs); 
			}
			
			
			//echo json_encode(1);
	  }//else if关闭
	} //函数{}
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
	$mail->Host = "localhost";
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

function del_file($id,$file_id){
	$path="../../NPI_System_file/".$id."/".$file_id."/";
	if(is_dir($path)){
		$p = scandir($path);
		foreach($p as $val){
			if($val !="." && $val !=".."){
				$rs=unlink($path.$val);
				@rmdir($path);
				return $rs;
			}
		}
	}
}
function del_folder($folder){
	$path="../../NPI_System_file/".$folder."/";
	if(is_dir($path)){
		@rmdir($path);
	}
}

 
