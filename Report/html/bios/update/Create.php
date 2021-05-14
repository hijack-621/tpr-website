<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>BIOS Create</title>

<style type="text/css">
input[type='checkbox']{
	margin-left:20px;
}
input[type='checkbox'] label{
	margin-left:10px;
}
#hidebox {
   	display:none;
    width:160px;
    height:56px;
    position: absolute;
    top:40%;
    left:40%;
    line-height:56px;
    color:#fff;
	padding-left:60px;
    font-size:15px;
    background: #000 url(../../../../images/wait.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
}

</style>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<script src="../../js/jquery-3.2.1.js"></script>
<script src="../../js/bootstrap.min.js"></script>
    <script  type="text/javascript" src="../../../layui/layui.all.js"></script>

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
function show_dialog(){
	document.getElementById("hidebox").style.display="block";
}
function hidden_dialog(){
	document.getElementById("hidebox").style.display="none";
}
function load(){
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'sh_model'},
		success:function(msg){
			console.log(msg);
			var selections=document.getElementById('st-model');
			if(msg.length>0){
				for(var i=0;i<msg.length;i++){
					var option=document.createElement("option");
					option.value=msg[i]['Model'];
					option.text=msg[i]['Model'];
					selections.options.add(option);
				}
			}

		},
		error:function(msg){
			console.log(msg);

		}
	})
}
var ver_arr=new Array();
function change_old(){
	var model=document.getElementById('st-model').value;
	if(model==""||model==null){
		var selections=document.getElementById('st-oldver');
		selections.length=0;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'sh_ver',model:model},
		success:function(msg){
			//console.log(msg);

			var selections=document.getElementById('st-oldver');
			//娓呯┖鏁版嵁,閲嶆柊璧嬪��
			selections.length=0;
			document.getElementById('o_ver').value=msg[0][1];
			if(msg!=""||msg!=null){
				for(var i=0;i<msg.length;i++){
					var option=document.createElement("option");
					option.value=msg[i][0];
					option.text=msg[i][0];
					selections.options.add(option);
				}
				ver_arr=msg;
			}

		},
		error:function(msg){
			console.log(msg);

		}
	})
}
function submit(){
	var model=$('#st-model').val();
	$.ajax({
		type:"post",
		dataType:"json",
		url:"BIOS_server.php",
		data:{flag:"Find_model",model:model},
		success:function(msg){
			console.log(msg);
			if(msg[0]==1111){
				//continue_create();
				var mod="";
				if(msg[1].length==0){
					//alert("success");
					continue_create();
				}else{
					for(var i=0;i<msg[1].length;i++){
						 mod+=msg[1][i]+"-";
					}
					alert("success  "+mod+"is null ");
					continue_create();
				}
			}else if(msg[0]==1041){
				alert("model is null");
			}
		},
		error:function(msg){
			console.log(msg);
		}
	})
}
function continue_create(){
	var model=$('#st-model').val();
	var descript=$('#Activity').val();
	var oldver=$('#st-oldver').val();
	var newver=$('#New-ver').val();
	var econo=$('#Eco-no').val();
	var oldsys=$('#o_ver').val();
	var newsys=$('#New-sysver').val();
	if(newver.indexOf('A')==-1&&newver!=""){
		newver="A"+newver;
	}
	//鍒╃敤name閬嶅巻鑾峰緱checkbox鐨勫��
	tprcheck=document.getElementsByName('checkbox');
	var checkarr=new Array();
	var x=0;
	for(var i=0;i<tprcheck.length;i++){
		if(tprcheck[i].checked){
			checkarr[x]=tprcheck[i].value;
			x++;
		}
	}
	checkdata=checkarr.join(",");
	var obj_pro={
			oldsys:oldsys,
			model:model,
			descript:descript,
			oldver:oldver,
			newver:newver,
			econo:econo,
			checkdata:checkdata,

	}
	for(var x in obj_pro){
		if(obj_pro[x]==null||obj_pro[x]==""){
			alert(x+" is null");
			return;
		}
	}
	obj_pro.newsys=newsys;
	$.ajax({
		type:"post",
		dataType:"json",
		url:"BIOS_server.php",
		data:{flag:"Create",obj_pro:obj_pro},
		success:function(msg){
			console.log(msg);
			if(msg[0]==1111){
				//Send_Mail(msg[1]);
			}else if(msg[0]==1040){
				alert("fail");
			}else if(msg[0]==1041){
				alert("Matrix table model is null");
			}else if(msg[0]==1042){
				alert("model is lock");
			}else if(msg[0]==1043){
				alert("already add data")
			}
		},
		error:function(msg){
			console.log(msg);
		}
	})
}

function Send_Mail(msg){
	var tpr=new Array("CGS");
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'Send_mail',mrk:'cr',tpr:tpr,msg:msg},
		success:function(msg){
			console.log(msg);
			if(msg==1){
				alert("create success")
				window.open("Show.html","_self");
			}else if(msg==0){
				alert("send mail fail");
			}
		},
		error:function(msg){
			console.log(msg);
		}
		})
}
function add_model(){
	window.open("Add_model.html","");
}
function sys_ver(){
	var option=document.getElementById('st-oldver');
	var x=option.selectedIndex;
	document.getElementById('o_ver').value=ver_arr[x][1];
}

</script>
<style type="text/css">
body {
	background-image: url(../../../images/beijin.jpg);
}
</style>
</head>

<body onload="load()">
<nav class="nav" style="margin-left:30px;">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" style="background-color:#CC6633" href="Show.html">home</a>
		</li>
	</ul>
</nav>

<div id="hidebox" onClick="hide();" class="loading">Send mail鈥︹��</div>

<div class="container">
<div class="col-1"></div>
<div class="col-11" style="text-align:center">
<table class="table table-bordered" style=" margin:auto;margin-top:15px;text-align:center;background-color:#FFF;width:90%">
<tbody>
<tr>
<td style="width:40%">Model</td>
<td>
<div class="row">
<div class="col col-md-4">
<select id="st-model" onchange="change_old()" class="form-control" style="width:155px;">
<option value="">choose model</option>
</select>
</div>
<div class="col col-md-4">
<button type="button" onclick="add_model()" class="btn btn-secondary" style="margin-left:20px">Add Model</button>
</div>

</div>
</td>
</tr>
<tr>
<td>Description</td>
<td><input type="text" id="Activity" style="border:none;border-bottom:1px solid #000;width:254px"></input></td>
</tr>
<tr>
<td>
<div class="row">
<div class="col col-md-3">
<label>Old_ver:</label>
</div>
<div class="col col-md-3">
<select id="st-oldver" name="st-oldver" class="form-control" style="width:80px" onchange="sys_ver()"></select>
</div>
<div class="col col-md-3">
<label>sysver:</label>
</div>
<div class="col col-md-3">
<input type="text" id="o_ver" style="border:none;border-bottom:1px solid #000;width:70px"/>
</div>
</div>
</td>
<td>
<label>New_ver:</label>
<input type="text" id="New-ver" style="border:none;border-bottom:1px solid #000;width:60px"></input>
<label>sysver:</label>
<input type="text" id="New-sysver" style="border:none;border-bottom:1px solid #000;width:70px"></input>
</td>
</tr>
<tr>
<td>ECO Number</td>
<td>
<input type="text" id="Eco-no" style="border:none;border-bottom:1px solid #000;width:254px"></input>
</td>
</tr>
<tr>
<td colspan="2">
<h3>Infrom TPR</h3>
</td>
</tr>
<tr>
<td colspan="2">
<div class="col">
<div>
<input type="checkbox" value="CGS" disabled=disabled name="checkbox"><label>CGS</label></input><input type="checkbox" value="RLC_SH" name="checkbox"><label>RLC-SH</label></input><input type="checkbox" value="IGS" name="checkbox"><label>IGS</label></input><input type="checkbox" value="CEP" name="checkbox"><label>CEP</label></input>
</div>
<div>
<input type="checkbox" value="CSAT" name="checkbox">CSAT</input><input type="checkbox" value="CEB" name="checkbox">CEB</input><input type="checkbox" value="RLC_INDIA" name="checkbox">RLC-INDIA</input><input type="checkbox" value="Regenersis_INDIA" name="checkbox">Regenersis-INDIA</input><input type="checkbox" value="TSI"   name="checkbox"><label>TSI</label></input>
</div>
</div>
</td>
</tr>
<tr>
<td colspan="2">
<button type="button" class="btn btn-primary" onclick="submit()">sure</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</body>

</html>
