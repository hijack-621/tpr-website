<?php
session_start();
$flag=$_POST['flag'];
if (empty($_SESSION["uname"])){
    echo "10000";
    return;
}
$data=$_POST['urldata'];

$mysqli=null;
include '../../db/new_link_db.php';

if($mysqli -> connect_errno){
    echo 'link error'.$mysqli -> connect_error;
    return;
}
if(isset($data)){
    $flag = $data[0];
    $tpr = $data[1];
    $act = $data[3];
    // echo json_encode($data);
    // return '';
    for($i=0;$i<count($tpr);$i++){
        $sql="select name,mail from mail where tpr like '%$tpr[$i]' and spmaflag=6 ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        if ($nums!=0){
            $arr=array();
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $arr[]=$row;
            }
        }
        $sql="select Owner from npi_owner where steps=2 and tpr='$tpr[$i]' ";
        $result=$mysqli->query($sql);
        $nums=mysqli_num_rows($result);
        //$Owner=null;
        if ($nums!=0){
            while (($row = mysqli_fetch_array($result,MYSQLI_ASSOC))!==false&&$row>0) {
                $Owner=$row['Owner'];
            }
        }
        $arr_to=array();
        for($x=0;$x<count($arr);$x++){
            if ($arr[$x]['name']==$Owner){
                array_unshift($arr_to,$arr[$x]);
            }else{
                $arr_to[]=$arr[$x];
            }
        }
      //$title=" WWW Repair Center Program Control System";
        $title="programing system testing mail,please ignore it";
        
        $text="<span style='font-family: Calibri,serif;font-size: 18px'>Hi:".$Owner."<br/>
        ".$tpr[$i]." 【Activity:".$act." 】 need you trail run and upload NPI program <br/>
        *Please login TPR ManageMent System(http://www.compal.top/Report/web/NPI_System/Show.html) for details.<br/>
        *This is System Auto mail If any suggestion,please contact Compal SOD Xu. Bruce (Ext.32836,MP.18936110464)</span>";
        
        $mg=sendmail($arr_to,$title,$text);
        
    }
    //die($text);
    echo json_encode($mg);
    @$result->free();
    $mysqli->close();
    //break;
}


function sendmail($arr,$title,$text){
	require_once '../../Tool/phpmail/PHPMailer.php';
	require_once '../../Tool/phpmail/SMTP.php';
	$mail = new PHPMailer(true);
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
		return '1111';
	}
}
?>