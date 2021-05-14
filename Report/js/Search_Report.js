function load(){
	var flag="1";
	$.ajax({
		type:"post",
		url:"../../server/Search_Report/search_VFIR_server.php",
		data:{flag:flag},
		dataType:"json",
		success:function(msg){
			if(msg==0){
				//alert('please login ');
			location.href='../../../login.php';
			}else if(msg==1){
				//登陆成功
			}
		},
		error:function(msg){
			console.log(msg);
			//alert('link failure');
		//location.href='../../../login.php';
		}
	})
}
//监听下拉框的值
function tprchange(){
	var stval=document.getElementById('select').value;
	var ra_div=document.getElementById('label_div');
	var ra=document.getElementById('vfir_txt');
	var ra_1=document.getElementById('vfir_nb_txt');
	var ra_2=document.getElementById('vfir_tb_txt');
	var ra_3=document.getElementById('vfir_xls');
	let ftb = document.getElementById('ftb');
	var ra_4=document.getElementById('ry_pot');
	var ra_5=document.getElementById('rr_pot');
	var ra_6=document.getElementById('cd_pot');
	
	if(stval==""){
	ra_div.style.display="none";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.display="none";
	ra_4.style.display="none";
	ra_5.style.display="none";
	ra_6.style.display="none";

	}else if(stval=="IGS"){
	ra_div.style.display="inline";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";
	}else if(stval=="CEP"){
	ra_div.style.display="inline";
	ra_1.style.display="inline";
	ra_2.style.display="inline";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";

}else if(stval=="RLC_SH"){
	ra_div.style.display="inline";
	ra.style.display="inline";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";

}else if(stval=="CSAT"){
	ra_div.style.display="inline";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";
}else if(stval=="CEB"){
	ra_div.style.display="inline";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = (ftb.clientWidth/2-109)+'px';
	ra_3.style.display="inline";
	ra_4.style.display="none";
	ra_5.style.display="none";
	ra_6.style.display="none";
}else if(stval=="RLC_INDIA"||stval=="Regenersis_INDIA"){
	ra_div.style.display="inline";
	ra.style.display="inline";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="none";
	
}else if(stval=="CGS"){
	ra_div.style.display="inline";
	ra.style.display="none";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = (ftb.clientWidth/2-109)+'px';
	ra_3.style.display="inline";
	ra_4.style.display="none";
	ra_5.style.display="none";
	ra_6.style.display="none";
}
else if(stval=="TSI"){
	ra_div.style.display="inline";
	ra_1.style.display="inline";
	ra_2.style.display="inline";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";

}
}

//点击周数查询里面的文件
function report_data(obj){
	var d_wk=obj.innerText;
	var flag="3";
	var d_tpr=obj.id.split("-")[0];
	
	$.ajax({
		type:"post",
	dataType:"json",
	url:"../../server/Search_Report/Search_VFIR_server.php",
	data:{d_wk:d_wk,flag:flag,d_tpr:d_tpr},
	success:function(msg){
		 console.log(msg);//click week
		 if(msg!=""&&msg!=null&&msg.leng!=0){
			 //显示顶部指示文件
			//把数组分成2份
				var d_brra=[];
				var d_brrb=[];
				d_brra=msg.slice(0,msg.length/2);
				d_brrb=msg.slice(msg.length/2);
				//把tpr删除之后的数组分为两份进行处理
	var ra_la=document.getElementById('ra_vfir_txt');
	var ra_11=document.getElementById('ra_vfir_nb_txt');
	var ra_12=document.getElementById('ra_vfir_tb_txt');
	var ra_13=document.getElementById('ra_vfir_xls');
	var ra_14=document.getElementById('ra_ry_pot');
	var ra_15=document.getElementById('ra_cd_pot');
	var ra_16=document.getElementById('ra_rr_pot');
		ra_la.style.background="url(../../../images/label_1.png) no-repeat";
		ra_11.style.background="url(../../../images/label_1.png) no-repeat";
		ra_12.style.background="url(../../../images/label_1.png) no-repeat";
		ra_13.style.background="url(../../../images/label_1.png) no-repeat";
		ra_14.style.background="url(../../../images/label_1.png) no-repeat";
		ra_15.style.background="url(../../../images/label_1.png) no-repeat";
		ra_16.style.background="url(../../../images/label_1.png) no-repeat";

					for(var x=0;x<d_brra.length;x++){
						
						 if(d_brra[x].indexOf("VFIR")>0){ 
						 if(d_brra[x].indexOf("txt")>0){
							 if(d_brra[x].indexOf("NB")>0){
								ra_11.style.background="url(../../../images/label_2.png) no-repeat";
							 }else if(d_brra[x].indexOf("TB")>0){
							 ra_12.style.background="url(../../../images/label_2.png) no-repeat";
							 }
							}else if(d_brra[x].indexOf("xls")>0){
								
									ra_13.style.background="url(../../../images/label_2.png) no-repeat";
							}
						}else if(d_brra[x].indexOf("COMPAL_RSH")>0){
							if(d_brra[x].indexOf("txt")>0){
					ra_la.style.background="url(../../../images/label_2.png) no-repeat";
					}else if(d_brra[x].indexOf("xls")>0||files[i]['name'].indexOf("xlsx")>0){
					ra_13.style.background="url(../../../images/label_2.png) no-repeat";
					}
							}else if(d_brra[x].indexOf("Quality")>0&&d_brra[x].indexOf("Yield")>0){
							ra_14.style.background="url(../../../images/label_2.png) no-repeat";
						}else if(d_brra[x].indexOf("RRR")>0){
						ra_15.style.background="url(../../../images/label_2.png) no-repeat";
						}else if(d_brra[x].indexOf("CID")>0||d_brra[x].indexOf("Scrap")>0||d_brra[x].indexOf("scrap")>0){
						ra_16.style.background="url(../../../images/label_2.png) no-repeat";
						}
					}
					//显示底部文件下载,生成表格
					var tb_re=document.getElementById('text');
					$('#text').empty();
					tb_re.style.backgroundColor="Green";
					for(var i=0;i<msg.length/2;i++){
						var tr=document.createElement("tr");
						var td=document.createElement("td");
						var a=document.createElement("a");
						var ck_box=document.createElement("input");
					a.href=""+d_brrb[i]+"";
					a.download=""+d_brra[i]+"";
					a.innerHTML=""+d_brra[i]+"";
					ck_box.type="checkbox";
					ck_box.name="ck_dele";
					ck_box.class=d_tpr;
					ck_box.value=""+d_brrb[i]+"";
					ck_box.style.float="left";
					ck_box.style.display="none";
					td.appendChild(ck_box);
					tb_re.appendChild(tr);
					tr.appendChild(td);
					td.appendChild(a);
					
					}	
		 }else{
			//传输时无文件
			 var div_re=document.getElementById('a12');
			 div_re.style.display="block";
			var tb_re=document.getElementById('text');
			$('#text').empty();
			tb_re.style.backgroundColor="Red";
			var tr=document.createElement("tr");
			var td=document.createElement("td");
			td.innerHTML="not data";
			tb_re.appendChild(tr);
			tr.appendChild(td);
		 }
	},
	error:function(msg){
		 console.log(msg);
	}
	})
	
}
//查询
var tprs="";
	function search(){
			var st=$('#select').val();
			var wk=$('#in_week').val();
			var flag="2";
			var year=$('#select_y').val();
				if(st==null||st==""){
				alert("please choose TPR ");
				return;
				}
				 if((year==null||year=="")&&(wk!=null&&wk!="")){
		 alert("choose year");
		 return;
	 }
		 	//把显示清空
		 	var ra_la=document.getElementById('ra_vfir_txt');
		 	var ra_11=document.getElementById('ra_vfir_nb_txt');
			var ra_12=document.getElementById('ra_vfir_tb_txt');
			var ra_13=document.getElementById('ra_vfir_xls');
			var ra_14=document.getElementById('ra_ry_pot');
			var ra_15=document.getElementById('ra_cd_pot');
			var ra_16=document.getElementById('ra_rr_pot');
			ra_la.style.background="url(../../../images/label_1.png) no-repeat";
			ra_11.style.background="url(../../../images/label_1.png) no-repeat";
			ra_12.style.background="url(../../../images/label_1.png) no-repeat";
			ra_13.style.background="url(../../../images/label_1.png) no-repeat";
			ra_14.style.background="url(../../../images/label_1.png) no-repeat";
			ra_15.style.background="url(../../../images/label_1.png) no-repeat";
			ra_16.style.background="url(../../../images/label_1.png) no-repeat";
		$.ajax({
				type:"post",
				url:"../../server/Search_Report/Search_VFIR_server.php",
				data:{st:st,flag:flag,wk:wk,year:year},
				dataType:"json",
				success:function(msg){
	 			var div_re=document.getElementById('a12');
	 			document.getElementById('b_st').style.display="block";
					if(Array.isArray(msg)!=false){
		 				div_re.style.display="block";
	 					data=msg;
	 					//console.log(data);//no year
						//接收返回值赋值给data
	
						ff=data[0];
	
						if(ff==1){
						var a_id=data[1];
						//a_id=tpr;
						data.splice(0,2);
					if(data.length==0){
			 			var div_re=document.getElementById('a12');
		 				div_re.style.display="block";
						var tb_re=document.getElementById('text');
					$('#text').empty();
						tb_re.style.backgroundColor="Red";
						var tr=document.createElement("tr");
						var td=document.createElement("td");
						td.innerHTML="can't find file";
						tb_re.appendChild(tr);
						tr.appendChild(td);
						}else if(data.length>0&&data.length<5){
							var tb_re=document.getElementById('text');
					$('#text').empty();
						tb_re.style.backgroundColor="Green";
						var tr=document.createElement("tr");
					for(var i=0;i<data.length;i++){
						var td=document.createElement("td");
						var a=document.createElement("a");
						var ck_box=document.createElement("input");
						a.href="javascript:void(0)";
						a.id=""+a_id+""+"-"+""+i+"";
						a.setAttribute("onclick","report_data(this)");
						a.innerHTML=""+data[i]+"";
			
						ck_box.type="checkbox";
						ck_box.name="ck_dele";
						ck_box.class=a_id;
						ck_box.style.float="left";
						ck_box.style.display="none";
						ck_box.value=""+data[i]+"";
					
						td.appendChild(ck_box);
			
						tr.appendChild(td);
						td.appendChild(a);
						}
				tb_re.appendChild(tr);
				}else{
			
				var rs_row=parseInt(data.length/5);
				var rs_col=data.length%5;
				var tb_re=document.getElementById('text');
			$('#text').empty();
				tb_re.style.backgroundColor="Green";
				var j=0;
		for(var i=0;i<rs_row;i++){
			var tr=document.createElement("tr");
			for(var x=0;x<5;x++){
				var td=document.createElement("td");
				var a=document.createElement("a");
				var ck_box=document.createElement("input");
				a.href="javascript:void(0)";
				
				a.id=""+a_id+""+"-"+""+j+"";
				a.setAttribute("onclick","report_data(this)");
				a.innerHTML=""+data[j]+"";
				a.title="下载类型为txt文件时，右键另存为";
				ck_box.type="checkbox";
				ck_box.name="ck_dele";
				ck_box.value=""+data[j]+"";
				ck_box.class=a_id;
				ck_box.style.float="left";
				ck_box.style.display="none";
				td.appendChild(ck_box);
				
				tr.appendChild(td);
				td.appendChild(a);
				j++;
			}
		
		tb_re.appendChild(tr);
		}
		var tr=document.createElement("tr");
		for(var t=data.length-rs_col;t<data.length;t++){
			var td=document.createElement("td");
			var a=document.createElement("a");
			var ck_box=document.createElement("input");
			a.href="javascript:void(0)";
			a.id=""+a_id+""+"-"+""+t+"";
			a.setAttribute("onclick","report_data(this)");
			a.innerHTML=""+data[t]+"";
			a.title="下载类型为txt文件时，右键另存为";
			
			ck_box.type="checkbox";
			ck_box.name="ck_dele";
			ck_box.class=a_id;
			ck_box.value=""+data[t]+"";
			ck_box.style.float="left";
			ck_box.style.display="none";
			td.appendChild(ck_box);
			
			tr.appendChild(td);
			td.appendChild(a);
		}
		tb_re.appendChild(tr);
			}
	}else if(ff==2){
		//var s_tpr=data[1];
		data.splice(0,2);
		//把数组分成2份
		var brra=[];
		var brrb=[];
		brra=data.slice(0,data.length/2);
		brrb=data.slice(data.length/2);
		//把tpr删除之后的数组分为两份进行处理
	
			for(var x=0;x<brra.length;x++){
				if(brra[x].indexOf("VFIR")>0){ 
					if(brra[x].indexOf("txt")>0){
					if(brra[x].indexOf("NB")>0){
						ra_11.style.background="url(../../../images/label_2.png) no-repeat";
					}else if(brra[x].indexOf("NB")>0){
						ra_12.style.background="url(../../../images/label_2.png) no-repeat";
					}
				}else if(brra[x].indexOf("xls")>0){
								ra_13.style.background="url(../../../images/label_2.png) no-repeat";
					}
				}else if(brra[x].indexOf("COMPAL_RSH")>0){
					if(brra[x].indexOf("txt")>0){
					ra_la.style.background="url(../../../images/label_2.png) no-repeat";
					}else if(brra[x].indexOf("xls")>0||files[i]['name'].indexOf("xlsx")>0){
					ra_13.style.background="url(../../../images/label_2.png) no-repeat";
					}
				}else if(brra[x].indexOf("RY")>0){
							ra_14.style.background="url(../../../images/label_2.png) no-repeat";
				}else if(brra[x].indexOf("RRR")>0){
						ra_15.style.background="url(../../../images/label_2.png) no-repeat";
				}else if(brra[x].indexOf("CID")>0||brra[x].indexOf("Scrap")>0||brra[x].indexOf("scrap")>0){
						ra_16.style.background="url(../../../images/label_2.png) no-repeat";
						}
					}

		//生成表格内的单元格
		var tb_re=document.getElementById('text');
		$('#text').empty();
		tb_re.style.backgroundColor="Green";
		for(var i=0;i<data.length/2;i++){
			var tr=document.createElement("tr");
			var td=document.createElement("td");
			var a=document.createElement("a");
			var ck_box=document.createElement("input");
		a.href=""+brrb[i]+"";
		a.download=""+brra[i]+"";
		a.innerHTML=""+brra[i]+"";
		a.title="下载类型为txt文件时，右键另存为";
		ck_box.type="checkbox";
				ck_box.name="ck_dele";
				ck_box.value=""+brrb[i]+"";
				ck_box.class=a_id;
				ck_box.style.float="left";
				ck_box.style.display="none";
				td.appendChild(ck_box);
		tb_re.appendChild(tr);
		tr.appendChild(td);
		td.appendChild(a);
		
		}	
		
	}
	

	}else if(msg==0){

		location.href='../../../login.php';
	}else if(msg==5){
		alert("user not this TPR");
	}
	},
	error:function(msg){
		//传输错误时显示无文件
		 var div_re=document.getElementById('a12');
		 div_re.style.display="block";
		var tb_re=document.getElementById('text');
		$('#text').empty();
		tb_re.style.backgroundColor="Red";
		var tr=document.createElement("tr");
		var td=document.createElement("td");
		td.innerHTML="can't find file";
		tb_re.appendChild(tr);
		tr.appendChild(td);
}
});
}
function de_file(){
	var box_arr=document.getElementsByName('ck_dele');
	if(box_arr[0].style.display=='none'){
		for(var i=0;i<box_arr.length;i++){
			box_arr[i].style.display='block';
		}
	}else if(box_arr[0].style.display=='block'){
		var checkdata="";
		for(var i=0;i<box_arr.length;i++){
			if(box_arr[i].checked){
				checkdata+=box_arr[i].value+",";
			}
		}
		if(checkdata==""||checkdata==null||checkdata==undefined){
			for(var i=0;i<box_arr.length;i++){
				box_arr[i].style.display='none';
			}
		}else{
			var d=confirm('delete file ?');
			if(d==true){
				//确认删除后的操作
				//alert(checkdata);
				delete_file(checkdata,box_arr[0].class);
				//是否增加删除temp?
				search();
				
			}else{
				for(var i=0;i<box_arr.length;i++){
					box_arr[i].checked="";
				}
			}
		}
		
	}
	
}
function delete_file(paths,tpr){
	$.ajax({
	type:'post',
	dataType:'json',
	url:'../../server/Search_Report/search_VFIR_server.php',
	data:{paths:paths,tpr:tpr,flag:4},
	success:function(msg){
		console.log(msg);
		if(msg==0){
			alert("delete error");
			return;
		}else if(msg==1){
			alert("delete success");
		}
	}
	})
	
}