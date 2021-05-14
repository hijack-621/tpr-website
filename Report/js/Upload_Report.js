
function load(){
	let flag="1";
    let flag2="2";
	$.ajax({
		type:"post",
		url:"../../server/Search_Report/session.php",
		data:{flag:flag},
		dataType:"json",
		success:function(msg){
			if(msg==0){
				//alert('please login ');
			location.href='../../../login.php';
			}else if(msg==1){
				//��½�ɹ�
			}
		},
		complete:function(){
			$.ajax({
				type:'post',
				url:"../../server/Search_Report/session.php",
				data:{flag:flag2},
				dataType:'json',
				success:function (msg) {
					console.log(msg);
					//console.log(msg[0]);
                    $('#inweek').css('text-align','center');
					 $('#inweek').val(msg[0]['DellWeek']);
					 $('#inweek').attr('disabled','disabled');
                    $('#FY').css('text-align','center');
                    $('#FY').val(msg[0]['FY']);
                    $('#FY').attr('disabled','disabled');
                },
				error:function (msg) {
					console.log(msg)
                }
			
			
			});
		},
		error:function(msg){
			console.log(msg);
			//alert('link failure');
			location.href='../../../login.php';
		}
	})
}

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

	}
if(stval=="IGS"){
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
	ra.style.display="inline";
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
	ra_6.style.display="none";
}else if(stval=="CEB"){
	ra_div.style.display="inline";
	ra_1.style.display="none";
	ra_2.style.display="none";
	ra_3.style.marginLeft = (ftb.clientWidth/2-109)+'px';
	ra_3.style.display="inline";
	ra_4.style.display="none";
	ra_5.style.display="none";
	ra_6.style.display="none";
}else if(stval=="Regenersis_INDIA"||stval=="RLC_INDIA"){
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
	ra.style.display="inline";
	ra_3.style.marginLeft = '12px';
	ra_3.style.display="inline";
	ra_4.style.display="inline";
	ra_5.style.display="inline";
	ra_6.style.display="inline";

}
}

//����ѡ���ļ�����
function chs_fe(){
	var ra_la=document.getElementById('ra_vfir_txt');
	var ra_11=document.getElementById('ra_vfir_nb_txt');
	var ra_12=document.getElementById('ra_vfir_tb_txt');
	var ra_13=document.getElementById('ra_vfir_xls');
	var ra_14=document.getElementById('ra_ry_pot');
	var ra_16=document.getElementById('ra_cd_pot');
	var ra_15=document.getElementById('ra_rr_pot');
	
	var mFile=document.getElementById('upfile');
	var st_val=document.getElementById('select').value;
	var files=mFile.files;
	if(st_val==""||st_val==null){
		alert("choose TPR");
		mFile.value="";
	}else {
		ra_la.style.background="url(../../../images/label_1.png) no-repeat";
		ra_11.style.background="url(../../../images/label_1.png) no-repeat";
		ra_12.style.background="url(../../../images/label_1.png) no-repeat";
		ra_13.style.background="url(../../../images/label_1.png) no-repeat";
		ra_14.style.background="url(../../../images/label_1.png) no-repeat";
		ra_15.style.background="url(../../../images/label_1.png) no-repeat";
		ra_16.style.background="url(../../../images/label_1.png) no-repeat";
		for(var i=0;i<files.length;i++){
			//alert(files[i]['name']);
			 if(files[i]['name'].indexOf("VFIR")>0){
				if(files[i]['name'].indexOf("NB")>0){
						ra_11.style.background="url(../../../images/label_2.png) no-repeat";
						}else if(files[i]['name'].indexOf("TB")>0){
							ra_12.style.background="url(../../../images/label_2.png) no-repeat";
						
				}else if(files[i]['name'].indexOf("TB")<0&&files[i]['name'].indexOf("NB")<0){
					ra_13.style.background="url(../../../images/label_2.png) no-repeat";
				}
			}else if(files[i]['name'].indexOf("COMPAL_RSH")>0){
				//alert("into vfir");
				if(files[i]['name'].indexOf("txt")>0){
					ra_la.style.background="url(../../../images/label_2.png) no-repeat";
					}else if(files[i]['name'].indexOf("xls")>0||files[i]['name'].indexOf("xlsx")>0){
					ra_13.style.background="url(../../../images/label_2.png) no-repeat";
					}
				
				}else if(files[i]['name'].indexOf("Quality")>0&&files[i]['name'].indexOf("Yield")>0){
				ra_14.style.background="url(../../../images/label_2.png) no-repeat";
			}else if(files[i]['name'].indexOf("RRR")>0){
				ra_15.style.background="url(../../../images/label_2.png) no-repeat";
			}else if(files[i]['name'].indexOf("CID")>0||files[i]['name'].indexOf("Scrap")>0||files[i]['name'].indexOf("Scrap")>0){
				ra_16.style.background="url(../../../images/label_2.png) no-repeat";
			}
		}
		}
	
				
}


//�ϴ��ļ�
function upload_file(){
		var rscss=document.getElementById('result');
		var formdata=new FormData();
		var files=document.getElementById('upfile').files;
		//console.log(files.length);
		var st_tpr=document.getElementById('select').value;//tpr
		var weeks=document.getElementById('inweek').value;//下拉框选择week
	    //console.log(weeks);
		var year=document.getElementById('FY').value;//year
		for(var i=0;i<files.length;i++){
			formdata.append("file"+i,files[i]);
			// if(files[i]['name'].indexOf("MB_COMPAL_RSH")<0&&files[i]['name'].indexOf("VFIR")<0&&files[i]['name'].indexOf("TB")<0&&files[i]['name'].indexOf("NB")<0&&files[i]['name'].indexOf("Quality")<0&&files[i]['name'].indexOf("RRR")<0&&files[i]['name'].indexOf("CID")<0&&files[i]['name'].indexOf("Scrap")<0&&files[i]['name'].indexOf("scrap")<0&&files[i]['name'].indexOf("GFX")<0){
			// alert("please upload ture file name");
			// return;
			// }
		}
		formdata.append("select",st_tpr);
		formdata.append("weeks",weeks);
		formdata.append("year",year);
		if(st_tpr==""||st_tpr==null){
			alert("please select TPR");
			return;
			}else if(year==""||year==null){
				alert("please chose year");
				return false;
				}else if(weeks==""||weeks==null||weeks>52||weeks<1){
				alert("please input week or true week");
				return;
				}else if(files.length==0){
					alert("please upload files");
					return;
					}
		
		$.ajax({
			url:"../../server/Search_Report/upload_server.php",
			type:"post",
			data:formdata,
			dataType:"json",
			contentType: false,
	        processData: false,
			
			xhr:function(){ 

            myXhr = $.ajaxSettings.xhr();
        if(myXhr.upload){

               myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
            }  
         return myXhr;
        },  
				beforSend:function(msg){

		 rscss.style.display="inline";
		 rscss.style.backgroundColor="DarkOrange";
		document.getElementById('result').innerHTML="uploading......";
					},
		     success: function(msg) {
				  console.log(msg);
				  var rscss=document.getElementById('result');


					  var str=String(msg);
					  if(str.indexOf("1")!==-1){
					  rscss.style.backgroundColor="Green";
					  rscss.innerHTML="upload success!";
					  }else 
					  if(msg=='553'){
						  rscss.style.backgroundColor="Red";
						  rscss.innerHTML="file type not true";
						  }else
					if(msg=='550'){
						rscss.style.backgroundColor="Red";
					  rscss.innerHTML="not this TPR user";
						}else
						 if(msg=='557'){
							 rscss.style.backgroundColor="Red";
							 rscss.innerHTML="not received TPR";
							 }else
							 if(msg=='552'){
							  rscss.style.backgroundColor="Red";
					  rscss.innerHTML="not received week";
							 }else
							 if(msg=='5520'){
							 rscss.style.backgroundColor="Red";
					  rscss.innerHTML="not true week";
							 }else
							 if(msg=='554'){
								
						rscss.style.backgroundColor="Red";
						rscss.innerHTML="upload file error";
								 
								 }

		        },
		     error:function(msg){
		        console.log(msg);
				rscss.style.backgroundColor="Red";
				rscss.innerHTML="error";
		        }
		       
			})
	}

	function progressHandlingFunction(e) {
    if (e.lengthComputable) {  
	document.getElementById('result').style.display="inline";
    	var percent = e.loaded/e.total*100;  
           // $('#progre').val(percent.toFixed(2));
            document.getElementById('result').style.backgroundColor="Green";
            $('#result').html(e.loaded + "/" + e.total+" bytes. " + percent.toFixed(2) + "%"); 
        }  
    }
    function makeupfile() {
        $('#inweek').removeAttr('disabled');
    }