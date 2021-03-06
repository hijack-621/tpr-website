<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>BIOS Detail Data</title>

<style type="text/css">
body{
	background-image: url(../../../images/beijin.jpg);	
}
</style>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<script type="text/javascript" src="../../js/jquery-3.2.1.js"></script>
    <script  type="text/javascript" src="../../../layui/layui.all.js"></script>

<script type="text/javascript"    src="../../js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../css/bootstrap.min.css"/>

<script type="text/javascript">
    let stval = setInterval(SingleUsing,2000);
    function SingleUsing(){

        let jcookie = document.cookie.indexOf('sid');
        let user = '<?php echo $user;?>';
        if(jcookie>0){
            let sid = document.cookie.slice(jcookie,jcookie+36);
            //console.log(sid+'aaa');
            let rsid = sid.split('=')[1];
            $.ajax({
                type:'post',
                url:'../../../SSO/getsid.php',
                data:{rsid:rsid,user:user},
                dataType:'json',
                success:function (msg) {
                    console.log(msg);
                    if(msg.length!=0){
                        console.log('valid');
                    }else{
                        clearInterval(stval);
                        layui.use('layer',function () {

                            layer.confirm('this account is logged in other devices,please click sure and login in again', {
                                title:'info',
                                btn : [ 'sure', 'cancel' ],//按钮

                            }, function(index1) {


                                layer.close(index1);


                                setTimeout(backlogin,1500);
                                // console.log('aaa');
                                //此处请求后台程序，下方是成功后的前台处理……
                                // var index = layer.load(0,{shade: [0.7, '#393D49']}, {shadeClose: true}); //0代表加载的风格，支持0-2

                            },function () {
                                alert('click cancel,webpage will jump to login page');
                                window.location.href='../../../../login.php';


                                // alert('click cancel,webpage will close immediately ');

                            });


                        });
                    }
                },
                error:function (msg) {
                    console.log(msg);
                }
            })

        }

    }
    function backlogin() {

        window.location.href = '../../../../login.php';

    }
function load(){
	var dataid=window.location.search.substring(1);
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'step',dataid:dataid},
		success:function(msg){
			console.log(msg);
			document.getElementById('tpr').innerHTML="TPR: "+ msg[0]['TPR'];
			document.getElementById('model').innerHTML="Model: "+ msg[0]['Model'];
			document.getElementById('old-ver').innerHTML="Old ver: "+msg[0]['Old_ver'];
			document.getElementById('new-ver').innerHTML="New ver: "+msg[0]['New_ver'];
			
			//table data
			var td=document.getElementById("step-tb").getElementsByTagName("td");
			//console.log(Object.keys(msg[0]));
			
			for(var i=0;i<td.length;i++){
				if($.inArray(td[i].id,Object.keys(msg[0]))!=-1){
					if(td[i].id.indexOf("Owner")!==-1||td[i].id.indexOf("Checker")!==-1){
						var a=document.createElement("a"),
						id=msg[0]['Id'],
						step=td[i].id.substring(0,1),
						tpr=msg[0]['TPR'];
						a.innerHTML=msg[0][td[i].id];
						
						a.href="Edit.php?"+id+'&'+step+'&'+tpr;
						a.target = '_blank';
						
						td[i].appendChild(a);
					}else{
						td[i].innerHTML=msg[0][td[i].id];
					}
					if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==0){
						var tr=td[i].parentNode;
						tr.style.backgroundColor="#F2F2F2";
						td[i].innerHTML="Beging";
						td[i].setAttribute("bgcolor","#FFFF00");
					}else if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==1){
						td[i].innerHTML="close";
						td[i].setAttribute("bgcolor","#00FF00");
					}else if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==5){
						td[i].innerHTML="close";
						td[i].setAttribute("bgcolor","#FF0000");
					}
				}
						
			}
			
		},
		error:function(msg){
			console.log(msg);
			}
		})
$.ajax({
	type:'post',
	dataType:'json',
	url:"bios_server.php",
	data:{flag:'step_file',dataid:dataid},
	success:function(msg){
		console.log(msg);
		if(msg.length==1){
			var td=document.getElementsByName("attach_2");
			for(var i=0;i<td.length;i++){
				var a=document.createElement("a");
				var img=document.createElement("img");
				a.href=msg[0];
				var file_arr=msg[0].split("/");
				a.download=file_arr[file_arr.length-1];
				img.src="img/file.png";
				img.alt="file";
				td[i].appendChild(a);
				a.appendChild(img);
			}
		}else if(msg.length==2){
              var td=document.getElementsByName("attach_2");
              for(var i=0;i<td.length;i++){
                  var a=document.createElement("a");
                  var img=document.createElement("img");
                  a.href=msg[0];
                  var file_arr=msg[0].split("/");
                  a.download=file_arr[file_arr.length-1];
                  img.src="img/file.png";
                  img.alt="file";
                  td[i].appendChild(a);
                  a.appendChild(img);
              }
      if(msg[1].indexOf('.log')==-1){
          //console.log(msg[1].indexOf('.log'));
          //console.log(msg[1]);
          console.log(2);
                  var td_5=document.getElementById("sop_file4");//第六步上传文件
                  var a=document.createElement("a");
                  var img=document.createElement("img");
                  a.href=msg[1];
                  var file_arr=msg[1].split("/");
                  a.download=file_arr[file_arr.length-1];
                  img.src="img/file.png";
                  img.alt="file";
                  td_5.appendChild(a);
                  a.appendChild(img);
      }else{
         // console.log(1);
                  var td_4=document.getElementById("sop_file5");//第六步上传文件
                  var a=document.createElement("a");
                  var img=document.createElement("img");
                  a.href=msg[1];
                  var file_arr=msg[1].split("/");
                  a.download=file_arr[file_arr.length-1];
                  img.src="img/file.png";
                  img.alt="file";
                  td_4.appendChild(a);
                  a.appendChild(img);
      }
}
	},
	error:function(msg){
		console.log(msg);
	}
	})
	
}
</script>
</head>

<body onload="load()">
<nav class="nav" style="margin-left:30px;margin-bottom:30px">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="Show.html" style="background-color:#CC6633">home</a>
		</li>
	</ul>
</nav>
<div style="width:1050px;position: absolute;margin-top: -25px;margin-left: 25% ">

		<div>
		<li class="list-group-item" style="width: 200px;float: left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"  id="tpr"></li>
	</div>
	<div >
	<li class="list-group-item" style="width: 200px;float: left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;margin-left: 60px"  id="model"></li>
	</div>
	<div >
		<li class="list-group-item"  style="width: 200px;float: left;margin-left: 60px" id="old-ver"></li>
	</div>
	<div >
		<li class="list-group-item"  style="width: 200px;float: left;margin-left: 60px" id="new-ver"></li>
	</div>

	</div>

<div class="container">
<div class="col">

<table class="table table-bordered table-condensed" style="margin-top:100px;text-align:center; background-color:#FFF" id="step-tb">
<thead style="background-color:#F4987F">
<td>Actvity</td><td>Attach</td><td>ECO_Number</td><td>Begingtime</td><td>Checker</td><td>Owner</td><td>remark</td><td>Endtime</td><td style="background-Color:#C60">Status</td><td>Score</td>
</thead>

<tbody>
<tr>
<td id="Activity"></td><td id="sop_file1"></td><td id="Eco_no"></td><td id="1_Begingtime"></td><td id="1_Checker"></td><td id="1_Owner"></td><td id="1_Remark"></td><td id="1_Endtime"></td><td id="1_Status"></td><td id="1_Score"></td>
</tr>
<tr>
<td>Compal PE Trail Run And Upload Program</td>
<td id="sop_file2" name="attach_2"></td><td id="Eco_no"></td><td id="2_Begingtime"></td><td id="2_Checker"></td><td id="2_Owner"></td><td id="2_Remark"></td><td id="2_Endtime"></td><td id="2_Status"></td><td id="2_Score"></td>
</tr>
<tr>
<td>TPR QA Receive message</td>
<td id="sop_file3" name="attach_2"></td><td id="Eco_no"></td><td id="3_Begingtime"></td><td id="3_Checker"></td><td id="3_Owner"></td><td id="3_Remark"></td><td id="3_Endtime"></td><td id="3_Status"></td><td id="3_Score"></td>
</tr>
<tr>
<td>TPR PE trail Run</td>
<td id="sop_file4" name="attach_2"></td><td id="Eco_no"></td><td id="4_Begingtime"></td><td id="4_Checker"></td><td id="4_Owner"></td><td id="4_Remark"></td><td id="4_Endtime"></td><td id="4_Status"></td><td id="4_Score"></td>
</tr>
<tr>
<td>Cut In Process And Upload Testlog</td>
<td id="sop_file5"></td><td id="Eco_no"></td><td id="5_Begingtime"></td><td id="5_Checker"></td><td id="5_Owner"></td><td id="5_Remark"></td><td id="5_Endtime"></td><td id="5_Status"></td><td id="5_Score"></td>
</tr>
<tr>
<td>Compal System Auto Confim</td>
<td id="sop_file6"></td><td id="Eco_no"></td><td id="6_Begingtime"></td><td id="6_Checker"></td><td id="6_Owner"></td><td id="6_Remark"></td><td id="6_Endtime"></td><td id="6_Status"></td><td id="6_Score"></td>
</tr>
</tbody>
</table>
</div>
</div>
</body>
<script>

</script>
</html>
