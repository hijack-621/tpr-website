<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>eco Edit</title>

<style type="text/css">
body{
	text-align:center;
	background-image: url(../../../images/beijin.jpg);
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
    background: #000 url(../../../images/wait.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
}
</style>
<link rel="stylesheet" href="../../../TPRindex/css/style.css"/>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<script src="../../js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
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
                url:'../../../../SSO/getsid.php',
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
								 cancel:function(index,layero){
								 alert('pop-up layer will close and webpage will locate to login page');
								   window.location.href='../../../../login.php';

								  }

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
    //substring 方法将返回一个包含从 start 到最后（不包含 end ）的子字符串的字符串。
    //substring 方法使用 start 和 end 两者中的较小值作为子字符串的起始点。例如， strvar.substring(0, 3) 和 strvar.substring(3, 0) 将返回相同的子字符串。
    /*split 方法
    将一个字符串分割为子字符串，然后将结果作为字符串数组返回。
    stringObj.split([separator[, limit]])*/
    var dataid=window.location.search.substring(1).split("&");//从第一个字符串开始以&分割字符串
	let PO = document.getElementById('PO');
	let PON = document.getElementById('PON');
	let step4t = document.getElementById('4Endtime');
	let stept4 = document.getElementById('Endtime4');
	let ct = document.getElementById('ct');
	let rpo = document.getElementById('rpo');
	//console.log(rpo);
    //判断如果是cgs的第二步或者是其他tpr的第五步，则可以上传文件
	/*if(!((dataid[1]==2&&dataid[2]=="CGS")||(dataid[1]==5&&dataid[2]!="CGS"))){
		document.getElementById('upload').disabled="disabled";
	}*/
	console.log(dataid[1]);//输出几表示该步骤是第几步
    //只有2 5 6步可以上传文件
    if(!(dataid[1]==2||dataid[1]==5||dataid[1]==4)){
        document.getElementById('upload').disabled="disabled";
    }
	if(dataid[1]==3){
	    PO.style.display = 'block';
	    PON.style.display = 'block';
	    PON.style.marginLeft = 'auto';
		PON.style.marginRight = 'auto';
	}
    if(dataid[1]==4){
        step4t.style.display = 'block';
        stept4.style.display = 'block';
        rpo.colSpan='4';
    }
	step=dataid[1];
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'Edit_load',dataid:dataid},
		success:function(msg){
			console.log(msg);
			var td=document.getElementById("table-edit").getElementsByTagName("td");
			//var id_arr=new Array(),
			k=0;//根据表中单元格的id循环把查到的数据赋值
			for(var i=0;i<td.length;i++){
				if(td[i].id.length>0){
					//console.log(td[i].id);
					if(Object.keys(msg[0]).indexOf(td[i].id)!==-1){
						td[i].innerHTML=msg[0][td[i].id];

				}
				}
			}//显示开始时间，owner还有remark
			td['Begingtime'].innerHTML=msg[0][dataid[1]+'_Begingtime'];
			td['Owner'].innerHTML=msg[0][dataid[1]+'_Owner'];
			document.getElementById("remark").value=msg[0][dataid[1]+'_Remark'];
			document.getElementById("remark").defaultValue =msg[0][dataid[1]+'_Remark'];
			//console.log(id_arr);
		},
		error:function(msg){
		console.log(msg);
		}
		})

}
function show_score(){
	var dit=document.getElementById("btn-edit"),
	 ore=document.getElementById("btn-score"),
	 tb_edit=document.getElementById("tb-edit"),
	 tb_score=document.getElementById("tb-score");
	dit.style.boxShadow="0px 8px 8px 4px";
	dit.style.backgroundColor="#F2F2F2";
	ore.style.backgroundColor="#1CBBFF";
	ore.style.boxShadow="0px 0px 0px 0px";
	dit.style.top="0px";
	ore.style.top="10px";

	tb_score.style.display="inline";
	tb_edit.style.display="none";
}
function show_edit(){
	var dit=document.getElementById("btn-edit");
	 var ore=document.getElementById("btn-score");
	 var tb_edit=document.getElementById("tb-edit");
	 tb_score=document.getElementById("tb-score");
	ore.style.boxShadow="0px 8px 8px 4px";
	ore.style.backgroundColor="#F2F2F2";
	dit.style.backgroundColor="#1CBBFF";
	dit.style.boxShadow="0px 0px 0px 0px";
	ore.style.top="0px";
	dit.style.top="10px";

	tb_score.style.display="none";
	tb_edit.style.display="inline";

}//确认上传编辑好的内容(Owner)
function Owner(){
	var defaul_val=document.getElementById("remark").defaultValue;
	var dataid=window.location.search.substring(1).split("&");

	var remark=$("#remark").val();
	let pon = $('#PON').val();
	var statu=document.getElementsByName('status');
	let cftime = $('#Endtime4').val();
	//console.log(cftime);
    //var reason = $('#reason').val();
//查看是选择继续还是结束本步骤
	for(var i=0;i<statu.length;i++){
		if(statu[i].checked==true){
			status=statu[i].value;
		}
	}
	 k = remark.split(" ").join("");//检测是否只有输入空格，没有内容
	 //alert(k.length)
	if(remark==""||remark==undefined||k.length==0){
		alert("input Memo")
		 return false;
	}
	if(dataid[1]!=2){
		if(defaul_val==remark){
		 alert("Memo not change");//检测内容是否改变，防止直接点击确定按钮而没有编辑内容
         alert("Memo not change");
		 return false;
	 	}
    }

	
    const foowwLocalStorage = {
        set: function (key, value, ttl_ms) {
            var data = { value: value, expirse: new Date(ttl_ms).getTime() };
            localStorage.setItem(key, JSON.stringify(data));
        },
        get: function (key) {
            var data = JSON.parse(localStorage.getItem(key));
            if (data !== null) {
                //debugger
                if (data.expirse != null && data.expirse < new Date().getTime()) {
                    localStorage.removeItem(key);
                } else {
                    return data.value;
                }
            }
            return null;
        }
    };

    $.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'Edit_Owner',dataid:dataid,remark:remark,status:status,pon:pon,cftime:cftime},
		success:function(msg){
			console.log(msg);
           //根据返回标志位判断邮件的发送方式以及提示信息
			if(msg[0]==1112){
				Send_Mail("s2",msg[1],msg[2]);

			}else if(msg[0]==1113){
				Send_Mail("s3",msg[1],msg[2]);
			}else if(msg[0]==1114){
				Send_Mail('s4',msg[1],msg[2]);
			}else if(msg[0]==1115){
				 if(foowwLocalStorage.get('tpm')==null){
                       let ltpm = msg[3];//log里的tpm
                       let stpm = msg[4];//数据库查出tpm；
                       if(ltpm!=stpm){
                           alert(' please upload correct log file ');
                           return false;
                       }else{
                           Send_Mail("s5",msg[1],msg[2]);
                       }

                    }else {
                       if(foowwLocalStorage.get('tpm')!=msg[3]){
                           alert(' please upload correct log file ');
                           return false;
                       }else{
                           Send_Mail("s5",msg[1],msg[2]);
                       }
                    }
//				Send_Mail("s5",msg[1],msg[2]);
//				console.log(msg[1]);
//				console.log(msg[2]);
			}else if(msg[0]=='1040'){
				alert("finish")
			}else if(msg[0]=='1041'){
				alert("need upload file");
			}else if(msg[0]==1010){
				alert("fail");
			}else if(msg=='4404'){
				alert("log file bios ver not ture");
			}
		},
		error:function(msg){
			console.log(msg);
			alert("fail");
			}
		})
}

/*
function Score(){
	var dataid=window.location.search.substring(1).split("&");
	var score=document.getElementById('in-score').value;
	var remark=document.getElementById('sc_mark').value;
	var check=document.getElementsByName('score_ra');
	for(var i=0;i<check.length;i++){
		if(check[i].checked==true){
			var days=check[i].value;

		}
	}
	alert(days)
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:"Edit_score",score:score,remark:remark,days:days,dataid:dataid},
	success:function(msg){
		console.log(msg);
	},
	error:function(msg){
		console.log(msg);
		}
	})
}
*/
function Send_Mail(mrk,tpr,msg){
	show_dialog();
	var dataid=window.location.search.substring(1).split("&");
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'Send_mail',mrk:mrk,tpr:tpr,msg:msg},
		success:function(msg){
			console.log(msg);
			console.log(mrk);//mail  标志位
			console.log(tpr);//TPR
			if(msg==1){
				alert("edit success");//发送成功后跳转回step详细步骤页面
				window.opener.location.reload();
				window.close();
			}
			hidden_dialog();//隐藏提示信息
		},
		error:function(msg){
			console.log(msg);
			hidden_dialog();
		}
		})
}//上传文件功能
function upload(){
	var dataid=window.location.search.substring(1).split("&");
	var Id=dataid[0];
	var TPR=dataid[2];
	var step=dataid[1];
	var file_obj=document.getElementById('eco-file').files[0];
	//判断是否选中文件
	if(file_obj==""||file_obj==undefined||file_obj==null){
		alert("file null");
		return;
	}
	/*if(step==5){//判断第五步是否上传的是log文件
		var mrk=file_obj['name'].split(".")[1].toLowerCase();
		if(mrk!="log"){
			alert("upload file error,please upload log file");
			return;
		}

	}*///把所需要的数据以及文件打包成formdata上传
	formdata=new FormData();
	formdata.append("Id",Id);
	formdata.append("flag","Upload_file");
	formdata.append("step",step);
	formdata.append("tpr",TPR);
	formdata.append("file",file_obj);
	//console.log(formdata);
//监听上传文件进度
	var hint_upload=document.getElementById('hint-up');
	hint_upload.innerHTML="uploading";
	$.ajax({
		type:"post",
		dataType:"json",
		url:"ECO_server.php",
		contentType: false,
        processData: false,
		data:formdata,
		
		
		xhr:function(){
        	myxhr=$.ajaxSettings.xhr();
        	if(myxhr.upload){
        		myxhr.upload.addEventListener('progress',progressHander,false);
        	}
        	return myxhr;
        },
		success:function(msg){
			console.log(msg);
			 if(msg==1){
				  hint_upload.innerHTML="upload success";
	        	  hint_upload.style.color="green";
	          }else if(msg==1130){
	        	  hint_upload.innerHTML="already close";
	        	  hint_upload.style.color="red";
	          }else{
	        	  hint_upload.innerHTML="upload fail";
	        	  hint_upload.style.color="red";
	          }
		},
		error:function(msg){
			console.log(msg);
			hint_upload.innerHTML="upload error";
			hint_upload.style.color="red";
		}
	})
}//监听input上传文件标签，如果有文件选中，则计算文件大小以及显示
function fileselect(){
	var file_obj=document.getElementById('eco-file').files[0];
	if(file_obj!=null){

	if(file_obj.size>1024*1024){
		var fileSize=(Math.round(file_obj.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
	}else {
		var fileSize = (Math.round(file_obj.size * 100 / 1024) / 100).toString() + 'KB';
	}
	}else{
		var fileSize=null;
	}
	document.getElementById('file-size').innerHTML=fileSize;
}//计算显示文件的大小
function progressHander(e){
	if(e.lengthComputable){
		if(e.total>1024*1024){
			var uploading=(Math.round(e.loaded * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
			var uploading = (Math.round(e.loaded * 100 / 1024) / 100).toString() + 'KB';
		}
		var persent=(e.loaded/e.total*100).toFixed(1);
		document.getElementById('probar').innerHTML=persent+"%";
		var probar=Math.floor(e.loaded/e.total*100)+'%';
		document.getElementById('probar').style.width=probar;
	}
}
//一键close数据的功能，弹出模态框
function close_data(){
	var dataid=window.location.search.substring(1).split("&");
	var TPR=dataid[2];
	if(TPR=="CGS"){
		alert("this tpr is CGS ");
		return false ;
	}
	$('#myModal').modal('show');

}//填好信息，确定添加
function sure_add(){
	var dataid=window.location.search.substring(1).split("&");
	var Id=dataid[0];
	var TPR=dataid[2];
	var step=dataid[1];
	var eco_rd=document.getElementsByName("eco");
	for(var i=0;i<eco_rd.length;i++){
		if(eco_rd[i].checked){
			var eco=eco_rd[i].value;

		}
	}
	//?
	if(eco ==undefined||eco ==""){
		alert("choose ");
		return false;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'close_data',Id:Id,TPR:TPR,step:step,new_comp:eco},
		success:function(msg){
			console.log(msg);
			if(msg[0]==1111){
				Send_Mail("tf",msg[1],msg[2]);
			}else if(msg[0]==1041){
				alert("this step already finish");
			}else {
				alert("fail");
			}
		},
		error:function(msg){
			console.log(msg);
		}
		})
}
function show_dialog(){
	document.getElementById("hidebox").style.display="block";
}
function hidden_dialog(){
	document.getElementById("hidebox").style.display="none";
}
</script>
</head>

<body onload="load()">
<div id="header-wrap">
    <header>
        <hgroup>
            <h1><a href="../../../index.php"></a></h1>

        </hgroup>
        <nav style="margin-top: 24px">
            <div >
                <ul id="dh">
                    <li><a href="../../../index.php">Home</a></li>
                    <li><a href="../../../total_system_sop.html">Sop</a></li>
                    <li><a href="#">Our Works</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>
<nav class="nav" style="margin-left:30px;margin-bottom:10px;margin-top:110px">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="Show.php" style="background-color:#CC6633;color:white">home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="tips.html" style="background-color:#CC6633;color:white">[有问题点我]</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="tipseng.html" style="background-color:#CC6633;color:white">[some tips]</a>
		</li>

		<!--
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" onclick="close_data()">close data</a>
        </li>
        -->
	</ul>
</nav>

<div id="hidebox" onClick="hide();" class="loading">Send mail……</div>

<div class="container" align="center" style="text-align:center;">

	<div class="row">

		<div class="col col-md-10" style="width:100%;height:auto;margin-top:-60px">

			

			<div class="row" style="text-align:center;margin-left:50%;transform:translateX(-50%)">
				<div class="col col-md-1" style="width:100%;height:auto;"></div>

				<div class="col col-md-10" style="margin:auto;text-align:center;display:inline;margin-top:18px;" name="table-edit" id="tb-edit">
					<table class="table table-bordered" id="table-edit" style=" background-color:#FFF;width:75%;margin:auto;" >
						<tr>
							<td colspan="4">Owner</td>
						</tr>

						<tr>
							<td style="width:25%">Model</td>
							<td id="Model" style="width:25%"></td>
							<td style="width:25%">Owner</td>
							<td id="Owner" style="width:25%"></td>
						</tr>
						<tr>
							<td>Begingtime</td>
							<td colspan="3" id="Begingtime"></td>
						</tr>
						<tr>
							<td>Activity</td>
							<td colspan="3" id="Activity"></td>
						</tr>
						<tr>
							<td>
								Memo:
							</td>
							<td colspan="3">
								<textarea rows="3" cols="40" id="remark" style="resize: none;"></textarea>
							</td>
						</tr>
						<tr>
							<td style="display: none" id="PO">
								PO number:
							</td>
							<td colspan="3" id="rpo">
								<textarea rows="1" cols="40" id="PON" style="resize: none;display: none"></textarea>
							</td>
						</tr>
						<tr id="trct">
							<td style="display: none" id="4Endtime">
								Confirm Time:
							</td>
							<td colspan="4" >
								<div class="input-group input-group-sm">

								<div style="width: 275px;margin-left:auto;margin-right:auto">
									<input   type="text" class=" form-control " id="Endtime4" placeholder=" input as this format : 2020-12-12" style="margin-left: 3px;display: none;width:270px"/>

								</div>
								</div>
							</td>
						</tr>
						<tr>
							<td rowspan="2">
								<label>upload file:</label>
							</td>
							<td colspan="2">

								<input type="file" id="eco-file" onchange="fileselect()"/>

							</td>
							<td>
								<button type="button" id="upload" class="btn" onclick="upload()">upload</button>
							</td>
						</tr>

						<tr>
							<td>
								<div class="progress">
									<div class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%;" id="probar"></div>
								</div>
							</td>
							<td>
								<label id="hint-up">none</label>
							</td>

							<td>
								<label id="file-size" class="file-msg"></label>
							</td>
						</tr>

						<tr>
							<td colspan="4">

								<div class="row">
									<div class="col col-md-6"><span>Status</span></div>
									<div class="col col-md-6">
										<div class="row">
											<label><input type="radio" name="status" id="status_1" value="1"/>finish</label>
											<label><input type="radio" name="status" id="status_0" value="0" checked="checked"/>continue</label>

										</div>
										<div class="row">

										</div>

									</div>
								</div>
							</td>
						</tr>

						<tr>
							<td colspan="4">
								<button typ="button" class="btn btn-primary" onclick="Owner()" id="Owner_btn">Sure</button>
							</td>
						</tr>

					</table>
				</div>
				<div  style="text-align:center;display:none;margin-top:18px;width:660px;" name="table-score" id="tb-score">
					<table class="table table-bordered" id="table-score" style=" background-color:#FFF;width:100%;margin-left:25%" >
						<tr>
							<td colspan="4">Score</td>
						</tr>

						<tr>
							<td style="width:25%">Approw</td>
							<td style="width:25%" id="Checker"></td>
							<td style="width:25%">Date</td>
							<td style="width:25%" id="ck_date"></td>
						</tr>

						<tr>
							<td>Rate</td>
							<td>10</td>
							<td>Score</td>
							<td id="Score">
							</td>
						</tr>

						<tr>
							<td>Check</td>
							<td colspan="3">
								<label><input type="radio" name="score_ra" value="1" checked="checked"/>0-1 day</label>
								<label><input type="radio" name="score_ra" value="3"/>1-3 day</label>
								<label><input type="radio" name="score_ra" value="5"/>3-5 day</label>
								<label><input type="radio" name="score_ra" value="0"/>over 5 day</label>

							</td>
						</tr>

						<tr>
							<td>Score</td>
							<td colspan="3">
								<input type="number" min="0" max="10" class="number" id="in-score"/>
							</td>
						</tr>

						<tr>
							<td>Remark</td>
							<td colspan="3">
<textarea rows="3" cols="40" id="sc_mark" style="resize: none;">
</textarea>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<button typ="button" class="btn btn-primary" onclick="Score()" >Sure</button>
							</td>
						</tr>

						<tr>
							<td>Singer</td>
							<td colspan="3">Date</td>
						</tr>

						<tr>
							<td id="Owner"></td>
							<td colspan="3" id="Date"></td>
						</tr>

						<tr>
							<td id="Checker"></td>
							<td colspan="3" id="s-Date"></td>
						</tr>
					</table>
				</div>

			</div>

		</div>
		<div class="col col-md-1" style="width:100%;height:auto;"></div>
	</div>

</div>

<div class="container">
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- 模态框头部 -->
				<div class="modal-header">
					<h4 class="modal-title">choose please</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- 模态框主体 -->
				<div class="modal-body">
					<div class="col">
						<div class="row">

							<div class="radio">
								<label><input type="radio" id="V" name="eco" value="0"/>Axx</label>
							</div>
							<div class="radio" style="margin-left:50px">
								<label><input type="radio" id="S" name="eco" value="1"/>1.x.x</label>
							</div>

						</div>
						<div class="col">
							<button type="button" class="btn " id="sure-add" onclick="sure_add()">add</button>
						</div>

					</div>

				</div>

				<!-- 模态框底部 -->
				<div class="modal-footer">
					<div class="row">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
</body>

</html>

