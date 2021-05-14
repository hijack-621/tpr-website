<?php
	session_start();
	$user = $_SESSION['uname'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title> BIOS show data</title>

<style type="text/css">
.navbar{display:none}
</style>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<script type="text/javascript" src="../../js/jquery-3.2.1.js"></script>
<script  type="text/javascript" src="../../js/bootstrap.min.js"></script>
<script  type="text/javascript" src="../../../layui/layui.all.js"></script>
<link rel="stylesheet" href="../../css/bootstrap.min.css"/>
<script type="text/javascript">
let stval = setInterval(singleUsing,2000);
function singleUsing(){
 let jcookie = document.cookie.indexOf('sid');
 let user = '<?php echo $user; ?>';
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
function del_file(obj){
	var d=confirm('are you sure delete data and file ?');
	if(d==true){
		var tr=obj.parentNode.parentNode;
		var id=tr.id;
		$.ajax({
			type:'post',
			dataType:'json',
			url:"BIOS_server.php",
			data:{flag:'del_data',id:id},
			success:function(msg){
				console.log(msg);
				if(msg==1111){
					alert("delete success");
					window.location.reload();
				}else if(msg==1020){
					alert("delete error")
				}
			},
			error:function(msg){
				console.log(msg);
				}
		})
	}
}
var ck_st=0;
function add_data(){
	if(ck_st==0){
		//add td
		var tr=$('#tb-data').find('tr');

			var td=document.createElement("td"),
				up=document.createElement("a");
				no=document.createElement("a");
				up.innerHTML="add ";
				no.innerHTML=" cancel";
				up.href="javascript:void(0);";
				no.href="javascript:void(0);";
				no.setAttribute("onclick","cancel()");
				up.setAttribute("onclick","add()");

				td.appendChild(up);
				td.appendChild(no);
				tr[0].appendChild(td);
		for(var i=1;i<$('#tb-data').find('tr').length;i++){
			var td=document.createElement("td");
			var radio=document.createElement("input");
				radio.type="radio";
				radio.name="add-data";
				radio.setAttribute("class","radio");
				td.appendChild(radio);
			tr[i].appendChild(td);
		}

		ck_st=1;
	}else{
		//delete td
		var tr=$('#tb-data').find('tr');
		for(var i=0;i<tr.length;i++){
			var td=tr[i].cells;
			var lh=td.length;
			tr[i].removeChild(td[lh-1]);
		}
		ck_st=0;
	}


}
function cancel(){
	if(ck_st==1){
		var tr=$('#tb-data').find('tr');
		for(var i=0;i<tr.length;i++){
			var td=tr[i].cells;
			var lh=td.length;
			tr[i].removeChild(td[lh-1]);
		}
		ck_st=0;
	}
}
function add(){
	$('#myModal').modal('show');
}
function sure_add(){
	var radio_ck=document.getElementsByName("add-data");
	var tpr_ck=document.getElementsByName("checkbox");
	var checkarr=new Array();
	var k=0;
	for(var i=0;i<radio_ck.length;i++){
		if(radio_ck[i].checked){
			var id=radio_ck[i].parentNode.parentNode.id;

		}
	}
	for(var i=0;i<tpr_ck.length;i++){
		if(tpr_ck[i].checked){
			var tpr=tpr_ck[i].value;
			checkarr[k]=tpr;
			k++;
		}
	}
	var add_obj={
			data_id:id,
			tpr:checkarr,
	}
	for(var x in add_obj){
		if(add_obj[x]==null||add_obj[x]==""){
			alert(x+" is not choose");
			return;
		}
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'add_data',add_obj:add_obj},
		success:function(msg){
			console.log(msg);
			if(msg==1090){
				alert("tpr not CGS please choose CGS tpr add data")
			}else if(msg==1111){
				alert("success");
			}else if(msg==1042){
				alert("this model is lock");
			}
		},
		error:function(msg){
			console.log(msg);
			}
	})
}

</script>
<style type="text/css">
body {
	background-image: url(../../../images/beijin.jpg);
	text-align:center;
}

</style>
</head>

<body onload="load()">

<nav class="nav" style="margin-left:30px;">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="../../../index.php" style="background-color:#CC6633">home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="Create.php" target="_bank">Create</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="show_page()">show page</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="show_all()">show all</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="add_data()">Add data</a>
		</li>
	</ul>
</nav>
<h4 style="color:#FFF;">BIOS Control System</h4>
<div class="container" style="margin-top:30px;">
<div class="row">
	<div class="col col-md-3">
		<select id="tpr_st" class="form-control"  >
		<option value="">please choose TPR</option>
		</select>
	</div>
	<div class="col col-md-3">
		<select id="model_st" class="form-control" >
			<option value="">choose model</option>
		</select>
	</div>
	<div class="col col-md-3">
		<select id="ver_st" class="form-control">
			<option value="">choose new ver</option>
		</select>
	</div>

	<div class="col col-md-3">
		<button type="button" class="btn btn-primary" style="margin-left:12px" onclick="sh_data()">search</button>
		<button type="button" class="btn btn-primary" style="margin-left:14px" onclick="lock()">Lock</button>
		<button type="button" class="btn btn-primary" style="margin-left:14px" onclick="unlock()">Unlock</button>
	</div>
</div>
</div>
<div class="container" style="margin-top:30px;">

	<table class="table table-bordered table-hover table-condensed" id="tb-data" style="background-color:#FFF;margin-top: 50px">
		<thead style="background-color:#F4987F">
		<td   style="background-color:#F4987F;font-family: Segoe UI;font-weight: normal " >TPR</td>
		<td   style="background-color:#F4987F;font-family: Segoe UI;font-weight: normal;width:150px " >Eco_no</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal">Model</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal" >Activity</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal">Bgtime</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal" >O-ver</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal"  >N-ver</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal" >Edtime</td>
		<td   style="background-Color:#C60;font-family:Segoe UI;font-weight: normal">Status</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal" >Checker</td>
		<td   style="background-color:#F4987F;font-family:Segoe UI;font-weight: normal" >Del</td>
		</thead>
		
		<tbody id="bk-data">

		</tbody>
	</table>
	<div id='load' style='width:62px;height:62px;margin-left:auto;margin-right:auto;margin-top:-5px'>
		</div>
</div>




</body>
<script type="text/javascript">
function load(){

	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'load_data'},
		beforeSend:function(){
                    let oimg = '<img alt="loading" src="./img/5-121204193Q9-50.gif" id="loading" />';
                    $('#load').append(oimg);
                },
		success:function(msg){
			console.log(msg);
			if(msg=='10000'){
				//back index
				location.href='../../../login.php';
			}
			show_data(msg);


		},

		error:function(msg){
			console.log(msg);
			},
		complete:function(){
			$('#load').remove();
		},

		});
		$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'sh_select'},
		success:function(msg){
			console.log(msg);
			if(msg.length>0) {
                let selections = document.getElementById('tpr_st');
                let mselections = document.getElementById('model_st');
                let eselections = document.getElementById('ver_st');
                let tprtmp = [];
                let modeltmp = [];
                let etmp = [];
				let obj = {};
				let keys = [];
                if (msg.length > 0) {
                    for (var i = 0; i < msg.length; i++) {
                        //加载tpr数据
                        if (tprtmp.indexOf(msg[i]['TPR']) == -1) {
                            tprtmp.push(msg[i]['TPR']);
                        }
                        if (modeltmp.indexOf(msg[i]['model']) == -1) {
                            modeltmp.push(msg[i]['model']);
                        }
                        if (etmp.indexOf(msg[i]['New_ver']) == -1) {
                            etmp.push(msg[i]['New_ver']);
                        }

                    }
                    //console.log(tprtmp);
                    for (let x = 0; x < tprtmp.length; x++) {
                        let toption = document.createElement("option");
                        toption.value = tprtmp[x];
                        toption.text = tprtmp[x];
                        selections.options.add(toption);
                    }
                    for (let y = 0; y < modeltmp.length; y++) {
						obj[modeltmp[y]] = modeltmp[y];
						keys = Object.keys(obj).sort();
                        
                    }
					for(let s=0;s<keys.length;s++){
					let moption = document.createElement("option");
                        moption.value = keys[s];
                        moption.text = keys[s];
                        mselections.options.add(moption);
					}

                    for (let z = 0; z < etmp.length; z++) {
                        let eoption = document.createElement("option");
                        eoption.value = etmp[z];
                        eoption.text = etmp[z];
                        eselections.options.add(eoption);
                    }
                }
            }

		},
		error:function(msg){
			console.log(msg);
			}
		})
}

function sh_data(){
	var tpr=document.getElementById('tpr_st').value;
	var model=document.getElementById('model_st').value;
	var newver=document.getElementById('ver_st').value;
	if((tpr==""||tpr==null)&&(model==""||model==null)&&(newver==""||newver==null)){
		alert("choose one item at least ");
		return false;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'sh_data',tpr:tpr,model:model,newver:newver},
		success:function(msg){
			//console.log(msg);
			show_data(msg);
		},
		error:function(msg){
			console.log(msg);
			}
		})
}
function show_page(){
    window.location.reload();
}
function lock(){
	var model=document.getElementById('model_st').value;
	var new_ver=document.getElementById('ver_st').value;
	var tpr=document.getElementById('tpr_st').value;
	if(model==""||model==null){
		alert("choose model");
		return false;
	}
	if(new_ver==""||new_ver==null){
		alert("choose new_ver");
		return false;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'lock_model',model:model,new_ver:new_ver,tpr:tpr},
		success:function(msg){
			//console.log(msg);
			if(msg==1111){
				alert("lock success")
			}else if(msg==1041){
				alert("lock fail")
			}else if(msg==1040){
				alert("already lock")
			}
		},
		error:function(msg){
			console.log(msg);
			}
		})
}
function unlock(){
	var model=document.getElementById('model_st').value;
	var new_ver=document.getElementById('ver_st').value;
	var tpr=document.getElementById('tpr_st').value;
	if(model==""||model==null){
		alert("choose model");
		return false;
	}
	if(new_ver==""||new_ver==null){
		alert("choose new_ver");
		return false;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'unlock_model',model:model,new_ver:new_ver,tpr:tpr},
		success:function(msg){
			//console.log(msg);
			if(msg==1111){
				alert("unlock success")
			}else if(msg==1041){
				alert("unlock fail")
			}else if(msg==1040){
				alert("already unlock")
			}
		},
		error:function(msg){
			console.log(msg);
			}
		})
}
function show_all(){
	$.ajax({
		type:'post',
		dataType:'json',
		url:"BIOS_server.php",
		data:{flag:'load_all'},
		success:function(msg){
			 console.log(msg);
			if(msg=='10000'){
				//jump index
				location.href='#';
			}
			show_data(msg);
		},
		error:function(msg){
			console.log(msg);
			}
		})
}
function show_data(msg){
	cancel();
	var tb=document.getElementById('bk-data');
	$('#bk-data').empty();
	for(x in msg){
		for(i=0;i<msg[x].length;i++){
			var tr=document.createElement("tr");
			tr.id=msg[x][i]["Id"];
			if(i==0){
				 var tpr_td=document.createElement("td"),
				  eco_td=document.createElement("td"),
				 model_td=document.createElement("td"),
				 Acty_td=document.createElement("td"),
				 bgtime_td=document.createElement("td"),
				 old_sys=document.createElement("td"),
				 new_sys=document.createElement("td"),
				 edtime_td=document.createElement("td"),
				 status_td=document.createElement("td"),
				 del_td=document.createElement("td"),
				 ck=document.createElement("td"),
				 a=document.createElement("a");
				 del_btn=document.createElement("button");

				tpr_td.innerHTML=msg[x][i]['TPR'];
				eco_td.innerHTML = msg[x][i]['Eco_no'];
				a.innerHTML=msg[x][i]['Model'];
				Acty_td.innerHTML=msg[x][i]['Activity'];
				old_sys.innerHTML=msg[x][i]['Old_sysver'];
				new_sys.innerHTML=msg[x][i]['New_sysver'];
				bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
				if(msg[x][i]['TPR']=="CGS"){
					if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']==null){
						ck.innerHTML=msg[x][i]['2_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']!=null){
						ck.innerHTML=msg[x][i]['3_Checker']
					}
					edtime_td.innerHTML=msg[x][i]['3_Endtime'];
					if(msg[x][i]['Status']==0||msg[x][i]['Status']==3&&msg[x][i]['2_Status']==5){
						status_td.innerHTML='Begin';
						status_td.setAttribute("bgcolor","#FF0000");
					}else{
						status_td.innerHTML='Begin';
						status_td.setAttribute("bgcolor","#FFFF00");
					}
				}else{
						if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']==null){
						ck.innerHTML=msg[x][i]['2_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
						ck.innerHTML=msg[x][i]['3_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
						ck.innerHTML=msg[x][i]['4_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['5_Checker']!=null){
						ck.innerHTML=msg[x][i]['5_Checker']
					}
						edtime_td.innerHTML=msg[x][i]['5_Endtime'];
						if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){
							 if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							 }else{
								  status_td.innerHTML='Begin';
								  status_td.setAttribute("bgcolor","#FFFF00");
							 }
						
							
						}else if(msg[x][i]['Status']==1){
						 status_td.innerHTML='Close';
                         status_td.setAttribute("bgcolor","#00FF00");
						}else if(msg[x][i]['Status']==5){
							status_td.innerHTML='Close';
							status_td.setAttribute("bgcolor","#FF0000");
					    }else {
							status_td.innerHTML='Begin';
							status_td.setAttribute("bgcolor","#FFFF00");
						}

					}
				

				if(msg[x][i]['Suo']==1){
					status_td.innerHTML='Lock';
					tr.setAttribute("bgcolor","#A1A1A1");
					status_td.setAttribute("bgcolor","#A1A1A1");
				}

				tpr_td.setAttribute("rowspan",msg[x].length);
				tpr_td.style.backgroundColor="#FFF";
				a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
				a.target="_bank";
				a.style.textDecoration="none";
				del_btn.innerHTML="Del";
				del_btn.type="button";
				del_btn.setAttribute("class","btn btn-danger");
				del_btn.setAttribute("onclick","del_file(this)");

				model_td.appendChild(a);
				//del_td.appendChild(del_btn);
				tr.appendChild(tpr_td);
				tr.appendChild(eco_td);
				tr.appendChild(model_td);
				tr.appendChild(Acty_td);
				tr.appendChild(bgtime_td);
				tr.appendChild(old_sys);
				tr.appendChild(new_sys);
				tr.appendChild(edtime_td);
				tr.appendChild(status_td);
				tr.appendChild(ck);
				tr.appendChild(del_td);
			}else{
				 var model_td=document.createElement("td"),
				  eco_td=document.createElement("td"),
				 Acty_td=document.createElement("td"),
				 bgtime_td=document.createElement("td"),
				 old_sys=document.createElement("td"),
				 new_sys=document.createElement("td"),
				 edtime_td=document.createElement("td"),
				 status_td=document.createElement("td"),
				 del_td=document.createElement("td"),
				 ck = document.createElement("td"),
				 a=document.createElement("a");
				 del_btn=document.createElement("button");

				 a.innerHTML=msg[x][i]['Model'];
				 eco_td.innerHTML = msg[x][i]['Eco_no'];
					Acty_td.innerHTML=msg[x][i]['Activity'];
					old_sys.innerHTML=msg[x][i]['Old_sysver'];
					new_sys.innerHTML=msg[x][i]['New_sysver'];
					bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
					if(msg[x][i]['TPR']=="CGS"){
						if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']==null){
						ck.innerHTML=msg[x][i]['2_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']!=null){
						ck.innerHTML=msg[x][i]['3_Checker']
					}
						edtime_td.innerHTML=msg[x][i]['3_Endtime'];
						if(msg[x][i]['Status']==0||msg[x][i]['Status']==3&&msg[x][i]['2_Status']==5){
						status_td.innerHTML='Begin';
						status_td.setAttribute("bgcolor","#FF0000");
					}else{
						status_td.innerHTML='Begin';
						status_td.setAttribute("bgcolor","#FFFF00");
					}
					}else{
						if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']==null){
						ck.innerHTML=msg[x][i]['2_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
						ck.innerHTML=msg[x][i]['3_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
						ck.innerHTML=msg[x][i]['4_Checker']
					}else if((msg[x][i]['Status']==0||msg[x][i]['Status']==3)&&msg[x][i]['5_Checker']!=null){
						ck.innerHTML=msg[x][i]['5_Checker']
					}
						edtime_td.innerHTML=msg[x][i]['5_Endtime'];
						if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){
							 if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							 }else{
								  status_td.innerHTML='Begin';
								  status_td.setAttribute("bgcolor","#FFFF00");
							 }
						
							
						}else if(msg[x][i]['Status']==1){
						 status_td.innerHTML='Close';
                         status_td.setAttribute("bgcolor","#00FF00");
						}else if(msg[x][i]['Status']==5){
							status_td.innerHTML='Close';
							status_td.setAttribute("bgcolor","#FF0000");
					    }else {
							status_td.innerHTML='Begin';
							status_td.setAttribute("bgcolor","#FFFF00");
						}

					}

					if(msg[x][i]['Suo']==1){
						status_td.innerHTML='Lock';
						tr.setAttribute("bgcolor","#A1A1A1");
						status_td.setAttribute("bgcolor","#A1A1A1");
					}
					tpr_td.setAttribute("rowspan",msg[x].length);
					tpr_td.style.backgroundColor="#FFF";
					a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
					a.target="_bank";
					a.style.textDecoration="none";
					del_btn.innerHTML="Del";
					del_btn.type="button";
					del_btn.setAttribute("class","btn btn-danger");
					del_btn.setAttribute("onclick","del_file(this)");

					model_td.appendChild(a);
					//del_td.appendChild(del_btn);
					tr.appendChild(eco_td);
					tr.appendChild(model_td);
					tr.appendChild(Acty_td);
					tr.appendChild(bgtime_td);
					tr.appendChild(old_sys);
					tr.appendChild(new_sys);
					tr.appendChild(edtime_td);
					tr.appendChild(status_td);
					tr.appendChild(ck);
					tr.appendChild(del_td);
			}

			tb.appendChild(tr);
		}
	}
}
</script>
</html>
