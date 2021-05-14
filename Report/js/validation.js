
function load(){
	$.ajax({
		type:"post",
		url:"Report/server/servlet/validation/validation.php",
		data:{flag:1},
		dataType:"json",
		success:function(msg){
			if(msg==0){
				//alert('please login ');
			location.href='login.php';
			}else if(msg==1){
				//µÇÂ½³É¹¦
			}
		},
		error:function(msg){
			console.log(msg);
			//alert('link failure');
			location.href='login.php';
		}
	})
	$.ajax({
		type:'post',
		url:'Report/server/servlet/validation/validation.php',
		dataType:'json',
		data:{flag:2},
		success:function(msg){
			console.log(msg);
			document.getElementById('username').innerHTML=msg[0];
			if(msg[1].length==0){
				var tb=document.getElementById('dt-bios');
				var tr=document.createElement("tr");
				var td=document.createElement("td");
				tb.appendChild(tr);
				tr.appendChild(td);
				td.innerHTML="no data";
				td.setAttribute("colspan","4");
			}else{
				
				}
			},
			error:function(msg){
				
				console.log(msg);
				}
		})
}
function summary_dt(msg){
	$('#cgs').empty();
	$('#rlc_sh').empty();
	$('#igs').empty();
	$('#cep').empty();
	$('#ceb').empty();
	$('#csat').empty();
	$('#ria').empty();
	$('#res').empty();
	var tb_arr=new Array("cgs","rlc_sh","igs","cep","ceb","csat","ria","res");
	var tr_arr=new Array("cgs_t","sh_t","igs_t","cep_t","ceb_t","csa_t","ria_t","res_t");
	for(var i=0;i<msg.length;i++){
		if(msg[i][8].indexOf("CGS")!=-1){
			var cgs=document.getElementById('cgs');
			var tr=document.createElement("tr");
			cgs.appendChild(tr);
		}
		else if(msg[i][8].indexOf("CEB")!=-1){
			var ceb=document.getElementById('ceb');
			var tr=document.createElement("tr");
			ceb.appendChild(tr);
		}else if(msg[i][8].indexOf("IGS")!=-1){
			var igs=document.getElementById('igs');
			var tr=document.createElement("tr");
			igs.appendChild(tr);
			
		}else if(msg[i][8].indexOf("CEP")!=-1){
			var cep=document.getElementById('cep');
			var tr=document.createElement("tr");
			cep.appendChild(tr);
			
		}else if(msg[i][8].indexOf("RLC_SH")!=-1){
			var sh=document.getElementById('rlc_sh');
			var tr=document.createElement("tr");
			sh.appendChild(tr);
			
		}else if(msg[i][8].indexOf("RLC_INDIA")!=-1){
			var ria=document.getElementById('ria');
			var tr=document.createElement("tr");
			ria.appendChild(tr);
			
		}else if(msg[i][8].indexOf("Regenersis_INDIA")!=-1){
			var res=document.getElementById('res');
			var tr=document.createElement("tr");
			res.appendChild(tr);
			
		}
		
		var td1=document.createElement("td");
		var td2=document.createElement("td");
		var td3=document.createElement("td");
		var td4=document.createElement("td");
		var td5=document.createElement("td");
		var text=document.createElement("textarea");
		var a=document.createElement("a");
		td1.style.width="120px";
		a.setAttribute("target","_bank");
		td2.style.width="200px";
		text.setAttribute("rows","2");
		text.setAttribute("cols","24");
		text.setAttribute("readonly","readonly");
		text.style.resize="none";
		td3.style.width="190px";
		td4.style.width="190px";
		td5.style.width="40px";
		td1.style.color="#000";
		td2.style.color="#000";
		td3.style.color="#000";
		td4.style.color="#000";
		td5.style.color="#000";
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		tr.appendChild(td4);
		tr.appendChild(td5);
		td1.appendChild(a);
		td2.appendChild(text);
		
		a.innerHTML=msg[i][1];
		if(msg[i][8]=="CGS"){
			a.setAttribute("href","Report/html/Bios_System/Steps/BIOS_System_Steps .html?"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][1]);	
		}else{
			a.setAttribute("href","Report/html/Bios_System/Steps/BIOS_System_Steps.html?"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][1]);	
		}
		text.innerHTML=msg[i][2];
		
		if(msg[i][13]==0){
			td5.setAttribute("bgcolor","#FFFF00");
			td5.setAttribute("style","color:#000");
			td5.innerHTML="begin";
		}else if(msg[i][13]==1){
			td5.setAttribute("bgcolor","#00FF00");
			td5.setAttribute("style","color:#000");
			td5.innerHTML="closed";
		}else if(msg[i][13]==5){
			td5.setAttribute("bgcolor","#FF0000");
			td5.setAttribute("style","color:#000");
			td5.innerHTML="closed";
		}
		td3.innerHTML=msg[i][10];
		td4.innerHTML=msg[i][11];
	}
	for(var i=0;i<tb_arr.length;i++){
		var tb=document.getElementById(tb_arr[i]);
		var tr=tb.getElementsByTagName("tr");
		var tb_tr=document.getElementById(tr_arr[i]);
		if(tr.length==0){
			tb_tr.style.display='none';
		}else{
			//tb_tr.style.display='true';
		}
		
	}
}