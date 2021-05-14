﻿<?php
	session_start();
	$user = $_SESSION['uname'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title> ECO Show Data</title>

<style type="text/css">
.navbar{display:none}
td {

	white-space: nowrap;
	text-align: center;
	padding: 0 auto;
	display: table-cell;
	vertical-align: middle;
	overflow: hidden;
	text-overflow: ellipsis;
	margin: 0 auto;

}
table {


	vertical-align: middle;
	overflow: hidden;
	margin-top: 30px;

	margin-left: auto;
	margin-right: auto;

}
	html body {
		width: 100%;
		height:100%;
		padding: 0;
		margin: 0;
	}


</style>
<link rel="stylesheet" href="../../../TPRindex/css/style.css"/>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<script src="../../js/jquery-3.2.1.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script  type="text/javascript" src="../../../../layui/layui.all.js"></script>
<link rel="stylesheet" href="../../css/bootstrap.min.css"/>
<link rel="stylesheet" href="../../css/jquery.searchableSelect.css" type="text/css">
<script src="../../js/jquery.searchableSelect.js"></script>
<script type="text/javascript">
let stval = setInterval(singleUsing,5000);
function singleUsing(){
 let jcookie = document.cookie.indexOf('sid');
 let user = '<?php echo $user; ?>';
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

function del_file(obj){
	var d=confirm('are you sure delete data and file ?');
	if(d==true){
		var tr=obj.parentNode.parentNode;
		var id=tr.id;
		$.ajax({
			type:'post',
			dataType:'json',
			url:"ECO_server.php",
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
	}//把需要传递的数据打包成对象
	var add_obj={
			data_id:id,
			tpr:checkarr,
	}//判读是否有没有填的输入选项
	for(var x in add_obj){
		if(add_obj[x]==null||add_obj[x]==""){
			alert(x+" is not choose");
			return;
		}
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
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
function show_page(){
    window.location.reload();
}


</script>
<script type="text/javascript">
        function load(){//数据的加载

			let ptpr='';
	let flag  = window.location.search.substring(0);
	if(flag!=''){
		ptpr =window.location.search.substring(0).split('?')[1]; 
	}
            $.ajax({
                type:'post',
                dataType:'json',
                url:"ECO_server.php",
                data:{flag:'load_data',ptpr:ptpr},
				beforeSend:function(){
                    let oimg = '<img alt="loading" src="./img/5-121204193Q9-50.gif" id="loading" />';
                    $('#load').append(oimg);
                },
                success:function(msg){
                    console.time('console');
                    console.log(msg);
                    console.timeEnd('console');

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

            })
            $.ajax({
                type:'post',
                dataType:'json',
                url:"ECO_server.php",
                data:{flag:'sh_select'},
                success:function(msg){
                    console.log(msg);
                    var selections=document.getElementById('tpr_st');
                    var mselections=document.getElementById('model_st');
					//mselections.style.overflowX = 'hidden';
                    var eselections=document.getElementById('ver_st');
                    let tprtmp = [];
                    let modeltmp = [];
                    let etmp = [];
                    if(msg.length>0){
                        for(var i=0;i<msg.length;i++){
                            //樓婥tpr杅擂
                            if(tprtmp.indexOf(msg[i]['TPR'])==-1){
                                tprtmp.push(msg[i]['TPR']);
                            }
                            if(modeltmp.indexOf(msg[i]['model'])==-1){
                                modeltmp.push(msg[i]['model']);
                            }
                            if(etmp.indexOf(msg[i]['Eco_no'])==-1){
                                etmp.push(msg[i]['Eco_no']);
                            }

                        }
                       //console.log(tprtmp);
                        for(let x=0;x<tprtmp.length;x++){
                            var toption=document.createElement("option");
                            toption.value=tprtmp[x];
                            toption.text=tprtmp[x];
                            selections.options.add(toption);
						}
                        for(let y=0;y<modeltmp.length;y++){
                            var moption=document.createElement("option");
                            moption.value=modeltmp[y];
                            moption.text=modeltmp[y];
                            mselections.options.add(moption);
                        }
                        for(let z=0;z<etmp.length;z++){
                            var eoption=document.createElement("option");
                            eoption.value=etmp[z];
                            eoption.text=etmp[z];
                            eselections.options.add(eoption);
                        }
                    }
					$('#tpr_st').searchableSelect();
					$('#model_st').searchableSelect();
					$('#ver_st').searchableSelect();

                },
                error:function(msg){
                    console.log(msg);
                }
            })
        }
        function sh_data() {
            var tpr = document.getElementById('tpr_st').value;
            var model = document.getElementById('model_st').value;
			var econo = document.getElementById('ver_st').value;
             if ((tpr == "" || tpr == null)&&(model == "" || model == null)&&(econo == "" || econo == null)) {
                alert("choose one item at least");
                return false;
            }
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "ECO_server.php",
                data: {flag: 'sh_data',tpr:tpr,model:model,econo:econo},
                success: function (msg) {
                    console.log(msg);//
                    show_data(msg);
                },
                error: function (msg) {
                    console.log(msg);
                }
            })


        }
        ///查询全部数据
function show_all(){
	let ptpr='';
	let flag  = window.location.search.substring(0);
	if(flag!=''){
		ptpr =window.location.search.substring(0).split('?')[1]; 
	}
            $.ajax({
                type:'post',
                dataType:'json',
                url:"ECO_server.php",
                data:{flag:'load_all',ptpr:ptpr},
                success:function(msg){
                    console.log(msg);
                    if(msg=='10000'){
                        //jump index
                        location.href='#';
                    }
                    show_data1(msg);
                },
                error:function(msg){
                    console.log(msg);
                }
            })
        }//把数据显示到表中
        function show_data(msg){
            cancel();//把添加所显示的清除
            var tb=document.getElementById('bk-data');
            let addtd  = document.getElementById('bk-data').getElementsByTagName('tr');
            $('#bk-data').empty();//清空表格，避免数据重复加载
            for(x in msg){
                //console.log(x);//  PRINT TPR
                //console.log(msg);
                for(i=0;i<msg[x].length;i++){
                    //console.log(msg[x].length);//每家tpr发起的eco活动数目
                    var tr=document.createElement("tr");
                    tr.id=msg[x][i]["Id"];//每个tr的id就是表中记录
                    if(i==0){
                        var tpr_td=document.createElement("td"),
                            model_td=document.createElement("td"),
                            seco_td=document.createElement("td"),
                            Acty_td=document.createElement("td"),
                            bgtime_td=document.createElement("td"),
                            edtime_td=document.createElement("td"),
                            new_comp = document.createElement("td"),
                            status_td=document.createElement("td"),
							 ck = document.createElement('td'),
                            del_td=document.createElement("td"),
                            //rap_td=document.createElement("td"),
                            a =document.createElement("a"),
                            // rap = document.createElement('a'),
                            del_btn=document.createElement("button");
                        tpr_td.innerHTML=msg[x][i]['TPR'];
                        a.innerHTML=msg[x][i]['Model'];
                        seco_td.innerHTML = msg[x][i]['Eco_no'];
                        seco_td.title = msg[x][i]['Eco_no'];
                        seco_td.style.width = '200px';
                        seco_td.style.overflow = 'hidden';
                        seco_td.style.textOverflow = 'ellipsis';
                        Acty_td.innerHTML=msg[x][i]['Activity'];
                        Acty_td.title = msg[x][i]['Activity'];
                        new_comp.innerHTML=msg[x][i]['New_comp'];
                        new_comp.title = msg[x][i]['New_comp'];
                        bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
                        //rap.innerHTML = "delay.html";
                        let date1 = new Date(msg[x][i]['4_Endtime']);
                        //console.log(date1);
                        let date5 = new Date(msg[x][i]['5_Begingtime']);
                        let s5 = date5.getTime();
                        let s1 = date1.getTime();//返回的毫秒数
                       
                        let day = Math.floor((s5 - s1)/86400000);
                       
                        if(msg[x][i]['TPR']){
                           if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']==null){
								ck.innerHTML=msg[x][i]['2_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
								ck.innerHTML=msg[x][i]['3_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
								ck.innerHTML=msg[x][i]['4_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['5_Checker']!=null&&msg[x][i]['6_Checker']==null){
								ck.innerHTML=msg[x][i]['5_Checker']
							}else{
								ck.innerHTML=msg[x][i]['6_Checker']
							}
                            edtime_td.innerHTML=msg[x][i]['6_Endtime'];
                        }
                        if(msg[x][i]['Suo']==1){
                            status_td.innerHTML='Lock';
                            tr.setAttribute("bgcolor","#A1A1A1");
                        }else if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){

							if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							}else{
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FFFF00");
							}
						}else if(msg[x][i]['Status']==1){
								status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FFFF00");
						}else{
							status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FF00");
						}
				
                        tpr_td.setAttribute("rowspan",msg[x].length);
                        tpr_td.style.backgroundColor="#FFF";
                        a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
                        a.target="_bank";
                        a.style.textDecoration="none";
						a.style.color='blue';
                        //rap.setAttribute('href','delay.html?'+msg[x][i]['Id']+'&'+msg[x][i]['TPR']);
                        //rap.target = "_bank";
                        // rap.style.textDecoration="none";
                       
                        model_td.appendChild(a);
                        model_td.style.width = '170px';
                        model_td.style.textOverflow = 'ellipsis';
                        model_td.overflow = 'hidden';
                        model_td.title = msg[x][i]['Model'];
                        //rap_td.setAttribute('att','BB'+i) ;
                        //console.log(rap_td.getAttribute('att111'));
                        //console.log(rap_td.className);
                        //rap_td.appendChild(rap);
                        tr.appendChild(tpr_td);
                        //del_td.appendChild(del_btn);
                        tr.appendChild(seco_td);
                        tr.appendChild(model_td);
                        tr.appendChild(Acty_td);
                        tr.appendChild(bgtime_td);
                        tr.appendChild(new_comp);
                        tr.appendChild(edtime_td);
                        tr.appendChild(status_td);
						tr.appendChild(ck);
                        //tr.appendChild(reason_td);
                        tr.appendChild(del_td);
                        //tr.appendChild(rap);
                       
                    }else{
                        var  model_td=document.createElement("td"),
                            Acty_td=document.createElement("td"),
                            seco_td=document.createElement("td"),
                            bgtime_td=document.createElement("td"),
                            new_comp=document.createElement("td"),
                            edtime_td=document.createElement("td"),
                            status_td=document.createElement("td"),
							 ck=document.createElement("td"),
                            //rap_td = document.createElement('td'),
                            del_td=document.createElement("td"),
                            a=document.createElement("a"),
                            rap = document.createElement('a'),
                            del_btn=document.createElement("button");
                        a.innerHTML=msg[x][i]['Model'];
                        seco_td.innerHTML = msg[x][i]['Eco_no'];
                        seco_td.style.width = '200px';
                        seco_td.style.overflow = 'hidden';
                        seco_td.style.textOverflow = 'ellipsis';
                        seco_td.title =msg[x][i]['Eco_no'] ;
                        Acty_td.innerHTML=msg[x][i]['Activity'];
                        Acty_td.title = msg[x][i]['Activity'];
                        new_comp.innerHTML=msg[x][i]['New_comp'];
                        new_comp.title = msg[x][i]['New_comp'];
                        bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
                      


                        //!!!  cgs
                        if(msg[x][i]['TPR']){
							if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']==null){
								ck.innerHTML=msg[x][i]['2_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
								ck.innerHTML=msg[x][i]['3_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
								ck.innerHTML=msg[x][i]['4_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['5_Checker']!=null&&msg[x][i]['6_Checker']==null){
								ck.innerHTML=msg[x][i]['5_Checker']
							}else{
								ck.innerHTML=msg[x][i]['6_Checker']
							}
                            edtime_td.innerHTML=msg[x][i]['6_Endtime'];
                        }

                        if(msg[x][i]['Suo']==1){
                            status_td.innerHTML='Lock';
                            tr.setAttribute("bgcolor","#A1A1A1");
                        }else if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){

							if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							}else{
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FFFF00");
							}
						}else if(msg[x][i]['Status']==1){
								status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FFFF00");
						}else{
							status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FF00");
						}
                        //tpr_td.setAttribute("rowspan",msg[x].length);
                        //tpr_td.style.backgroundColor="#FFF";
                        a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
                        a.target="_bank";
                        rap.setAttribute('href','delay.html?'+msg[x][i]['Id']);
                        rap.target = "_bank";
                        rap.style.textDecoration="none";
                        a.style.textDecoration="none";
						a.style.color='blue';
                       
                        model_td.appendChild(a);
                        model_td.style.width = '170px';
                        model_td.style.textOverflow = 'ellipsis';
                        model_td.overflow = 'hidden';
                        model_td.title = msg[x][i]['Model'];
                        //del_td.appendChild(del_btn);
                        //rap_td.setAttribute('att','BBB'+i);
                        //rap_td.appendChild(rap);
                        tr.appendChild(seco_td);
                        tr.appendChild(model_td);
                        tr.appendChild(Acty_td);
                        tr.appendChild(bgtime_td);
                        tr.appendChild(new_comp);
                        tr.appendChild(edtime_td);
                        tr.appendChild(status_td);
						tr.appendChild(ck);
                        tr.appendChild(del_td);
                       
                    }

                    tb.appendChild(tr);
                }
            }

        }
        function show_data1(msg){
            cancel();//把添加所显示的清除
            var tb=document.getElementById('bk-data');
            let addtd  = document.getElementById('bk-data').getElementsByTagName('tr');
            $('#bk-data').empty();//清空表格，避免数据重复加载
            for(x in msg){
                //console.log(x);//  PRINT TPR
                //console.log(msg);
                for(i=0;i<msg[x].length;i++){
                    //console.log(msg[x].length);//每家tpr发起的eco活动数目
                    var tr=document.createElement("tr");
                    tr.id=msg[x][i]["Id"];//每个tr的id就是表中记录
                    if(i==0){
                        var tpr_td=document.createElement("td"),
                            model_td=document.createElement("td"),
                            seco_td=document.createElement("td"),
                            Acty_td=document.createElement("td"),
                            bgtime_td=document.createElement("td"),
                            edtime_td=document.createElement("td"),
                            new_comp = document.createElement("td"),
                            status_td=document.createElement("td"),
							 ck = document.createElement('td'),
                            del_td=document.createElement("td"),
                            //rap_td=document.createElement("td"),
                            a =document.createElement("a"),
                            // rap = document.createElement('a'),
                            del_btn=document.createElement("button");
                        tpr_td.innerHTML=msg[x][i]['TPR'];
                        a.innerHTML=msg[x][i]['Model'];
                        seco_td.innerHTML = msg[x][i]['Eco_no'];
                        seco_td.title = msg[x][i]['Eco_no'];
                        seco_td.style.width = '200px';
                        seco_td.style.overflow = 'hidden';
                        seco_td.style.textOverflow = 'ellipsis';
                        Acty_td.innerHTML=msg[x][i]['Activity'];
                        Acty_td.title = msg[x][i]['Activity'];
                        new_comp.innerHTML=msg[x][i]['New_comp'];
                        new_comp.title = msg[x][i]['New_comp'];
                        bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
                        //rap.innerHTML = "delay.html";
                        let date1 = new Date(msg[x][i]['4_Endtime']);
                        //console.log(date1);
                        let date5 = new Date(msg[x][i]['5_Begingtime']);
                        let s5 = date5.getTime();
                        let s1 = date1.getTime();//返回的毫秒数
                       
                        let day = Math.floor((s5 - s1)/86400000);
                       
                        if(msg[x][i]['TPR']){
                           if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']==null){
								ck.innerHTML=msg[x][i]['2_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
								ck.innerHTML=msg[x][i]['3_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
								ck.innerHTML=msg[x][i]['4_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['5_Checker']!=null&&msg[x][i]['6_Checker']==null){
								ck.innerHTML=msg[x][i]['5_Checker']
							}else{
								ck.innerHTML=msg[x][i]['6_Checker']
							}
                            edtime_td.innerHTML=msg[x][i]['6_Endtime'];
                        }
                        if(msg[x][i]['Suo']==1){
                            status_td.innerHTML='Lock';
                            tr.setAttribute("bgcolor","#A1A1A1");
                        }else if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){

							if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							}else{
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FFFF00");
							}
						}else if(msg[x][i]['Status']==1){
								status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FFFF00");
						}else{
							status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FF00");
						}
				
                        tpr_td.setAttribute("rowspan",msg[x].length);
                        tpr_td.style.backgroundColor="#FFF";
                        a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
                        a.target="_bank";
                        a.style.textDecoration="none";
						a.style.color='blue';
                        //rap.setAttribute('href','delay.html?'+msg[x][i]['Id']+'&'+msg[x][i]['TPR']);
                        //rap.target = "_bank";
                        // rap.style.textDecoration="none";
                       
                        model_td.appendChild(a);
                        model_td.style.width = '170px';
                        model_td.style.textOverflow = 'ellipsis';
                        model_td.overflow = 'hidden';
                        model_td.title = msg[x][i]['Model'];
                        //rap_td.setAttribute('att','BB'+i) ;
                        //console.log(rap_td.getAttribute('att111'));
                        //console.log(rap_td.className);
                        //rap_td.appendChild(rap);
                        tr.appendChild(tpr_td);
                        //del_td.appendChild(del_btn);
                        tr.appendChild(seco_td);
                        tr.appendChild(model_td);
                        tr.appendChild(Acty_td);
                        tr.appendChild(bgtime_td);
                        tr.appendChild(new_comp);
                        tr.appendChild(edtime_td);
                        tr.appendChild(status_td);
						tr.appendChild(ck);
                        //tr.appendChild(reason_td);
                        tr.appendChild(del_td);
                        //tr.appendChild(rap);
                       
                    }else{
                        var  model_td=document.createElement("td"),
                            Acty_td=document.createElement("td"),
                            seco_td=document.createElement("td"),
                            bgtime_td=document.createElement("td"),
                            new_comp=document.createElement("td"),
                            edtime_td=document.createElement("td"),
                            status_td=document.createElement("td"),
							 ck=document.createElement("td"),
                            //rap_td = document.createElement('td'),
                            del_td=document.createElement("td"),
                            a=document.createElement("a"),
                            rap = document.createElement('a'),
                            del_btn=document.createElement("button");
                        a.innerHTML=msg[x][i]['Model'];
                        seco_td.innerHTML = msg[x][i]['Eco_no'];
                        seco_td.style.width = '200px';
                        seco_td.style.overflow = 'hidden';
                        seco_td.style.textOverflow = 'ellipsis';
                        seco_td.title =msg[x][i]['Eco_no'] ;
                        Acty_td.innerHTML=msg[x][i]['Activity'];
                        Acty_td.title = msg[x][i]['Activity'];
                        new_comp.innerHTML=msg[x][i]['New_comp'];
                        new_comp.title = msg[x][i]['New_comp'];
                        bgtime_td.innerHTML=msg[x][i]['1_Begingtime'];
                      


                        //!!!  cgs
                        if(msg[x][i]['TPR']){
							if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']==null){
								ck.innerHTML=msg[x][i]['2_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['3_Checker']!=null&&msg[x][i]['4_Checker']==null){
								ck.innerHTML=msg[x][i]['3_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['4_Checker']!=null&&msg[x][i]['5_Checker']==null){
								ck.innerHTML=msg[x][i]['4_Checker']
							}else if(msg[x][i]['Status']==0&&msg[x][i]['5_Checker']!=null&&msg[x][i]['6_Checker']==null){
								ck.innerHTML=msg[x][i]['5_Checker']
							}else{
								ck.innerHTML=msg[x][i]['6_Checker']
							}
                            edtime_td.innerHTML=msg[x][i]['6_Endtime'];
                        }

                        if(msg[x][i]['Suo']==1){
                            status_td.innerHTML='Lock';
                            tr.setAttribute("bgcolor","#A1A1A1");
                        }else if(msg[x][i]['Status']==0||msg[x][i]['Status']==3){

							if(msg[x][i]['2_Status']==5||msg[x][i]['3_Status']==5||msg[x][i]['4_Status']==5||msg[x][i]['5_Status']==5){
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FF0000");
							}else{
								status_td.innerHTML='Begin';
                                status_td.setAttribute("bgcolor","#FFFF00");
							}
						}else if(msg[x][i]['Status']==1){
								status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FFFF00");
						}else{
							status_td.innerHTML='Close';
                                status_td.setAttribute("bgcolor","#FF00");
						}
                        //tpr_td.setAttribute("rowspan",msg[x].length);
                        //tpr_td.style.backgroundColor="#FFF";
                        a.setAttribute("href","Step.php?"+msg[x][i]['Id']);
                        a.target="_bank";
                        rap.setAttribute('href','delay.html?'+msg[x][i]['Id']);
                        rap.target = "_bank";
                        rap.style.textDecoration="none";
                        a.style.textDecoration="none";
						a.style.color='blue';
                        model_td.appendChild(a);
                        model_td.style.width = '170px';
                        model_td.style.textOverflow = 'ellipsis';
                        model_td.overflow = 'hidden';
                        model_td.title = msg[x][i]['Model'];
                        //del_td.appendChild(del_btn);
                        //rap_td.setAttribute('att','BBB'+i);
                        //rap_td.appendChild(rap);
                        tr.appendChild(seco_td);
                        tr.appendChild(model_td);
                        tr.appendChild(Acty_td);
                        tr.appendChild(bgtime_td);
                        tr.appendChild(new_comp);
                        tr.appendChild(edtime_td);
                        tr.appendChild(status_td);
						tr.appendChild(ck);
                        tr.appendChild(del_td);
                       
                    }

                    tb.appendChild(tr);
                }
            }

        }
        function hidehtml() {
            let nid = document.getElementById('bk-data').getElementsByTagName('td')
            //console.log(nid);
            for(let i=0;i<nid.length;i++){
                if((nid[i].getAttribute('att')) != null){
                    nid[i].style.display = 'none';


                }
            }


        }
        function Send_Mail15(mrk,tpr,msg){ //延时15天发送催促邮件

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
                        console.log('success')

                    }
                },
                error:function(msg){
                    console.log(msg);

                }
            })
        }function Send_Mail30(mrk,tpr,msg){//延时30天催促邮件

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
                        console.log('success')
                    }

                },
                error:function(msg){
                    console.log(msg);

                }
            })
        }
function showdel(){
    let tr  = $('#bk-data').children('tr');
    console.log(tr);
    let user = '<?php echo $user;?>';
    console.log(user);
    if(user!='GavinG'){
		alert('sorry!,no permission to delete data');
        return '';
    }
    if(tr[0].childNodes[9].childNodes.length==0){

        for(let i=0;i<tr.length;i++){

            let del_btn=document.createElement("button");
            del_btn.innerHTML="Del";
            del_btn.style.width='45px';
            del_btn.type="button";
            del_btn.setAttribute("class","btn btn-danger");
            del_btn.setAttribute("onclick","del_file(this)");
            if(tr[i].children.length==10){
                tr[i].childNodes[9].appendChild(del_btn);
            }else{
                tr[i].childNodes[8].appendChild(del_btn);
            }

        }
    }else{for(let i=0;i<tr.length;i++) {
        if(tr[i].children.length==10){
            tr[i].childNodes[9].removeChild(tr[i].childNodes[9].childNodes[0]);
        }else{
            tr[i].childNodes[8].removeChild(tr[i].childNodes[8].childNodes[0]);
        }
    }
        // tr[i].childNodes[10].childNodes.;
        return '';
    }

}
	</script>
<style type="text/css">
body {
	background-image: url(../../../images/bg.png);

}
</style>
</head>

<body onload="load()" style="text-align: center">
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
<nav class="nav" style="margin-left:30px;margin-top:110px">
	<ul class="nav nav-pills">
		
		<li class="nav-item">
			<a class="nav-link" href="Create.php" target="_bank" style='background-color:#CC6633;margin-left: 3px;color:white'>Create</a>
		</li>
		<li class="nav-item">
		<a class="nav-link" href="javascript:void(0);" onclick="show_page()" style='background-color:#CC6633;margin-left: 3px;color:white'>show page</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="show_all()" style='background-color:#CC6633;margin-left: 3px;color:white'>show all</a>
		</li>
		<!--<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="add_data()">Add data</a>
		</li>-->
		<li class="nav-item">
			<a class="nav-link " href="tips.html" style="background-color:#CC6633;margin-left: 3px;color:white">[有问题点我]</a>
		</li>
		<li class="nav-item">
			<a class="nav-link " href="tipseng.html" style="background-color:#CC6633;margin-left: 3px;color:white">[some tips]</a>
		</li>
	</ul>
</nav>
<h4 style="color:black;">ECO trace System</h4>
<div class="container" style='margin-top:15px'>
	<div class="row" style="margin: 0 auto">
		<div class="col col-md-3">
			<select id="tpr_st" >
				<option value="">please choose TPR</option>
			</select>
		</div>
		<div class="col col-md-3">
			<select id="model_st" >
				<option value="">choose Model</option>
			</select>
		</div>
		<div class="col col-md-3">
			<select id="ver_st" >
				<option value="">choose new ECO-Materials</option>
			</select>
		</div>

		<div class="col col-md-3" >
			<div class="row">
             <div class="col-md-6"> <button type="button" class="btn btn-primary" style="margin-left: 10px;margin-right: 10px" onclick="sh_data()">search</button></div>
             <div class="col-md-6"> <button type="button" class="btn btn-primary" style="margin: 0 0 0 -55px" onclick="showdel()">DEL</button></div>
         </div>

		</div>
	</div>
</div>
	
	
	<table class="table table-bordered table-hover table-condensed" id="tb-data" style="background-color:#FFF;table-layout: fixed;width: 1200px;vertical-align: middle;margin-left:auto;margin-right:auto;margin-top:30px">
		<thead style="background-color:#F4987F" >
		<td width="120px">TPR</td>
		<td width="150px">SECO-Num</td>
		<td width="145">Model</td>
		<td width="150">Activity</td>
		<td width="170">Bgtime</td>
		<td width="150">ECO-Materials</td>
		<td width="170">Edtime</td>
		<td style="background-Color:#C60" width="68">Status</td>
        <td width="105">Checker</td>
		<td width="60">Del</td>
		</thead>
		
		<tbody id="bk-data">

		</tbody>
	</table>
<div id='load' style='width:62px;height:62px;margin-left:auto;margin-right:auto;margin-top:170px'>
		</div>




</body>

</html>
