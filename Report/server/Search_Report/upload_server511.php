<?php
session_start();
header("Content-type:text/html;charset=UTF-8");
$pathfolder=$_POST['select'];
$week=$_POST['weeks'];
$file_type_arr=array('xls','xlsx','txt');
//echo '<pre>';
//var_dump($_FILES);

if($_SESSION['utpr']=="CGS"||$_SESSION['utpr']==$pathfolder){
//    echo "1";
     $Year=$_POST['year'];
     $weeks=$Year."-W".$week;
     if($pathfolder=="CSAT"){
         $pathfolder="CTS";
     }
     $ph="../../TPR report/VFIR/Temp/".$pathfolder;
     $path="../../TPR report/VFIR/".$pathfolder."/".$weeks;
     //$ph="../../TPR Report/VFIR/Temp/".$pathfolder;
     //$path="../../TPR Report/VFIR/".$pathfolder."/".$weeks;
     if ($pathfolder==null||$pathfolder==''){
         echo "557";
         return ;
     }else {

         if ($week==null||$week==''){
             echo "552";
             return ;
         }else {

             if (!is_numeric($week)){
                 echo "5520";
                 return ;
            }else {
                   if (!file_exists($path)){
         mkdir($path);
     }
     $success="";
     for ($i=0;$i<count($_FILES);$i++){

        if (strpos($_FILES['file'.$i]['name'],"VFIR")!==false){
        if(strpos($_FILES['file'.$i]['name'],"MB")!==false){

            if (strpos($_FILES['file'.$i]['name'],"TB")!==false){
                $temp=7;
                $folder="TB_Report_txt";
            }
            else{
                $temp=2;
                $folder="NB_Report_txt";
            }
        }else if (strpos($_FILES['file'.$i]['name'],"GFX")!==false){
            $temp=3;
            $folder="GFX_Report_txt";
        }

        else if (strpos($_FILES['file'.$i]['name'],"NB")==false&&strpos($_FILES['file'.$i]['name'],"TB")==false){
            $temp=1;
            $folder="VFIR_Report_xls";
        }
    }else if(strpos($_FILES['file'.$i]['name'],"Quality")!==false&&strpos($_FILES['file'.$i]['name'],"Yield")!==false){
        $temp=4;
        $folder="RY_Report";
    }else if(strpos($_FILES['file'.$i]['name'],"RRR")!==false){
        $temp=5;
        $folder="RRR_Report";
    }else if(strpos($_FILES['file'.$i]['name'],"CID")!==false||strpos($_FILES['file'.$i]['name'],"Scrap")!==false||strpos($_FILES['file'.$i]['name'],"scrap")!==false){
        $temp=6;
        $folder="CID_Report";
    }else if(strpos($_FILES['file'.$i]['name'],"VFIR")==false&&strpos($_FILES['file'.$i]['name'],"COMPAL_RSH")==false&&strpos($_FILES['file'.$i]['name'],"Quality")==false&&strpos($_FILES['file'.$i]['name'],"Yield")==false&&(strpos($_FILES['file'.$i]['name'],"RRR")==false)){
            $temp=8;
            $folder= $_FILES['file'.$i]['name'] ;
        }

    $w=date('w');
    $table=$pathfolder."_wednesday";
    if(($temp==1&&$w==1)||($temp==1&&$w==2)||($temp==1&&$w==0)){
        $wek=date('W');
        if ($wek==1){
            $wk=52;
        }else{
            $wk=$wek-1;
        }
        include '../db/link_db.php';
        $result=mysqli_query($connID,"insert into $table (Week) values ('$wk') ");
        include '../db/close_db.php';
    }
    if (!file_exists($path."/".$folder)){
        mkdir($path."/".$folder);
        if(move_uploaded_file($_FILES['file'.$i]['tmp_name'],$path."/".$folder."/".$_FILES['file'.$i]['name'])){
            //过滤tpr产生temp文件
            if(($pathfolder=='RLC_INDIA' && $temp==2)||($pathfolder=='Regenersis_INDIA'&&$temp==2)||($pathfolder=='CTS'&&$temp==2)){

            }else{
            if (!file_exists($ph."/Temp".$temp)){
                mkdir($ph."/Temp".$temp);
                $myfile=fopen($ph."/Temp".$temp."/".$weeks.".temp","w");
            }else{
                $dh=opendir($ph."/Temp".$temp);
                while (false!==($filede=readdir($dh))) {
                    if($filede!="." && $filede!="..") {
                        $fullpath=$ph."/Temp".$temp."/".$filede;
                        if(!is_dir($fullpath)){
                            unlink($fullpath);
                        }
                    }
                }
                $myfile=fopen($ph."/Temp".$temp."/".$weeks.".temp","w");
            }
            }

            echo "1";
        }
    }else{
        $dh=opendir($path."/".$folder);
        while (false!==($filede=readdir($dh))) {
            if($filede!="." && $filede!="..") {
                $fullpath=$path."/".$folder."/".$filede;
                if(!is_dir($fullpath)){
                    unlink($fullpath);
                }
            }
        }
        if(move_uploaded_file($_FILES['file'.$i]['tmp_name'],$path."/".$folder."/".$_FILES['file'.$i]['name'])){
            //过滤tpr产生temp文件
            if(($pathfolder==='RLC_INDIA' && $temp==2)||($pathfolder=='Regenersis_INDIA'&&$temp==2)||($pathfolder=='CSAT'&&$temp==2)){

            }else{
        if (!file_exists($ph."/Temp".$temp)){
                mkdir($ph."/Temp".$temp);
                $myfile=fopen($ph."/Temp".$temp."/".$weeks.".temp","w");
            }else{
                $dh=opendir($ph."/Temp".$temp);
                while (false!==($filede=readdir($dh))) {
                    if($filede!="." && $filede!="..") {
                        $fullpath=$ph."/Temp".$temp."/".$filede;
                        if(!is_dir($fullpath)){
                            unlink($fullpath);
                        }
                    }
                }
                $myfile=fopen($ph."/Temp".$temp."/".$weeks.".temp","w");
            }
            }
            
            $mysqli=null;
            include '../../db/new_link_db.php';
            
            echo "1";
        }
    }

    }

            }
         }
 }
     }else{
         echo "550";
         return;
     }
function sendmail($arr,$title,$text){
         require_once '../../Tool/phpmail/PHPMailer.php';
         require_once '../../Tool/phpmail/SMTP.php';
         $mail = new PHPMailer(true);
         $mail->CharSet = "UTF-8";
         $mail->IsSMTP();
         $mail->Host = "smtp.ym.163.com";
         $mail->SMTPAuth = true;
         $mail->Username = "compaltpr@compaltpr.com";
         $mail->Password = "XUDELIN8800275";
         $mail->Port = 25;
         $mail->setFrom('compaltpr@compaltpr.com', 'compaltpr@compaltpr.com');//send mailer
         //$mail->setFrom('compaltpr@compaltpr.com', 'compaltpr@compaltpr.com');//send mailer
         for ($i=0;$i<count($arr);$i++){
             $email=$arr[$i]['mail'];
             $ename=$arr[$i]['name'];
             if($i==0){
                 $mail->AddAddress("$email", "$ename");
             }else{
                 $mail->AddCC("$email", "$ename");
             }
         }
         $mail->IsHTML(true);
         $mail->Subject = $title;
         $mail->Body = $text;
         //include '../db/close_db.php';
         if (!$mail->Send()) {
             //return "440: " . $mail->ErrorInfo;
             return '0';
             exit;
         }else{
             return '1';
         }
}
?>