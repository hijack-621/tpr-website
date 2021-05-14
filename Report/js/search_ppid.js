function load(){
	var flag="1";
	$.ajax({
		type:"post",
		url:"../../server/search_PPID/session.php",
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
			location.href='../../../login.php';
		}
	})
}
$(function () {
	$('#bgtime').calendar({
		controlId: "divDate",
		})
	 $('#edtime').calendar({ 
	 
	 })
	})
//查询数据库中log文件
$(function(){
$('#stn').click(function(){
var ppid=$('#ppid').val();
var bgtime=$('#bgtime').val();
var edtime=$('#edtime').val();
if(ppid==""||ppid==""){
	alert("please scan PPID");
	}else{
		if(bgtime==""||bgtime==null||edtime==""||edtime==null){
			alert("please input date");
			}
	
$.ajax({
	type:"post",
	url:"../../server/search_PPID/search_PPID.php",
	data:{ppid:ppid,bgtime:bgtime,edtime:edtime},
	dataType:"json",
	timeout:20000,
	beforeSend:function(msg){
	document.getElementById('wait-hint').style.display="inline";
	$("#stn").attr("disabled", true);
	},
complete:function(msg,status){
	if(status=='timeout'){
		$("#stn").attr("disabled", false);
		document.getElementById('wait-hint').style.display="none";
	document.getElementById('rs').style.display="inline";
	var top=window.document.getElementById('top');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r1');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r2');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r3');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r4');
		top.style.backgroundColor="#FF0000";
		
		document.getElementById('TPR').innerHTML="No fund";
		document.getElementById('QC2i').innerHTML="No Test log";
		document.getElementById('QC2i').removeAttribute('href');
		document.getElementById('QC2date').innerHTML="Null";
		document.getElementById('QC3i').innerHTML="No Test log";
		document.getElementById('QC3i').removeAttribute('href');
		document.getElementById("QC3date").innerHTML="Null";
		}else if(status=='success'){
			$("#stn").attr("disabled", false);
	document.getElementById('wait-hint').style.display="none";
	document.getElementById('rs').style.display="inline";
	if(msg!=""){
	console.log(msg);
	var data_arr=JSON.parse(msg.responseText);

	//var length=data.legnth;
	//document.getElementById('wait-hint').style.display="none";
	//判断是否有数据
 if(data_arr.length!=0){
		//有的话顶部就改变颜色显示得到的tpr
		
		var top=window.document.getElementById('top');
		top.style.backgroundColor="#00FF00";
		var tpr_qc=data_arr[0].split("/");
		document.getElementById('TPR').innerHTML=tpr_qc[2];
		
		var qc2_date=new Array();
		var qc3_date=new Array();
		var d_1=0;
		var d_2=0;
		for(var a=0;a<data_arr.length;a++){
			if(data_arr[a].indexOf("QC2")!==-1){
				
				qc2_date[d_1]=data_arr[a];
				d_1++;
			}else if(data_arr[a].indexOf("QC3")!==-1){
				qc3_date[d_2]=data_arr[a];
				d_2++;
			}
		}
		if(qc2_date.length!==0){
			var new_dt=(qc2_date[0].split("/"))[4];
			var qc2_data_f=qc2_date[0];
			for(var d=1;d<qc2_date.length;d++){
				if((qc2_date[d].split("/"))[4]>new_dt){
					new_dt=(qc2_date[d].split("/"))[4];
					 qc2_data_f=qc2_date[d];
				}
			}
			
			var top=window.document.getElementById('r1');
			top.style.backgroundColor="#00FF00";
			var top=window.document.getElementById('r2');
			top.style.backgroundColor="#00FF00";
			
			document.getElementById('QC2i').innerHTML="YES";
			document.getElementById('QC2i').href=""+"tempqc2/"+(qc2_data_f.split("/"))[5]+"";
			document.getElementById('QC2i').download=""+(qc2_data_f.split("/"))[5]+""
			document.getElementById('QC2date').innerHTML=(qc2_data_f.split("/"))[4];
			
		}else{
			//qc2没有数据
			document.getElementById('QC2i').removeAttribute('href');
			var top=window.document.getElementById('r1');
			top.style.backgroundColor="#FF0000";
			var top=window.document.getElementById('r2');
			top.style.backgroundColor="#FF0000";
			
			document.getElementById('QC2i').innerHTML="No Test log";
			document.getElementById('QC2date').innerHTML="Null";
		}
		if(qc3_date.length!==0){
			
			var new_dt=(qc3_date[0].split("/"))[4];
			var qc3_data_f=qc3_date[0];
			for(var d=1;d<qc3_date.length;d++){
				if((qc3_date[d].split("/"))[4]>new_dt){
					new_dt=(qc3_date[d].split("/"))[4];
					var qc3_data_f=qc3_date[d];
				}
			}
			var top=window.document.getElementById('r3');
			top.style.backgroundColor="#00FF00";
			var top=window.document.getElementById('r4');
			top.style.backgroundColor="#00FF00";
			
			document.getElementById('QC3i').innerHTML="YES";
			document.getElementById('QC3i').href=""+"tempqc3/"+(qc3_data_f.split("/"))[5]+"";
			document.getElementById('QC3i').download=""+(qc3_data_f.split("/"))[5]+""
			document.getElementById('QC3date').innerHTML=(qc3_data_f.split("/"))[4];
			
		}else{
			document.getElementById('QC3i').removeAttribute('href');
			var top=window.document.getElementById('r3');
			top.style.backgroundColor="#FF0000";
			var top=window.document.getElementById('r4');
			top.style.backgroundColor="#FF0000";
			
			document.getElementById('QC3i').innerHTML="No Test log";
			document.getElementById("QC3date").innerHTML="Null";
		}
	}else{
		var top=window.document.getElementById('top');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r1');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r2');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r3');
		top.style.backgroundColor="#FF0000";
		var top=window.document.getElementById('r4');
		top.style.backgroundColor="#FF0000";
		
		document.getElementById('TPR').innerHTML="No fund";
		document.getElementById('QC2i').innerHTML="No Test log";
		document.getElementById('QC2i').removeAttribute('href');
		document.getElementById('QC2date').innerHTML="Null";
		document.getElementById('QC3i').innerHTML="No Test log";
		document.getElementById('QC3i').removeAttribute('href');
		document.getElementById("QC3date").innerHTML="Null";
	}
	//XML!=0;
	}
			}else if(status=='error'){
				$("#stn").attr("disabled", false);
				document.getElementById('rs').style.display="none";
				alert("error");
				}
	}
})
	}
});

})