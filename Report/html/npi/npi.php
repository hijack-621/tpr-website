<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>NPI System Show</title>

<style type="text/css">
    body{
	text-align: center;
	background-image: url(../../../images/beijin.jpg);
    }
    .navbar{display:none}
    h3{
        margin: auto;
    }
	.search-bar{
		width: 100%;
		height: 50px;
		margin-bottom: 12px;
	}
   
    .div-st{
		float:left;
        margin-left: 12px;
	}
	.div-tpr{
		float:left;
        margin-left: 12px;
	}
	.div-model{
		float:left;
		margin-left: 12px;
	}
	.div-btn{
		float:left;
		margin-left: 12px;
	}
    .fhide{
        display: none;
    }
    .ctd{
        overflow: hidden;
	    text-overflow: ellipsis;
        white-space: nowrap;
    }
    .gcolor{
        background-color:#ffff00;
    }
    .rcolor{
        background-color:red;
    }
    td>a{
        color:blue!important;
        text-decoration:none;    
    }
    .wtd{
        width:250px!important;
    }
</style>
<link rel="stylesheet" href="../../../TPRindex/css/style.css"/>
<script src="../../js/jquery-3.2.1.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="./layui.js"></script>
<link rel="stylesheet" href="./layer.css"/>
<link rel="stylesheet" href="./layui.css"/>
<link rel="stylesheet" href="../../css/bootstrap.min.css"/>


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
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Our Works</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>
<nav class="nav" style="margin-left:30px;margin-top:110px">
	<ul class="nav nav-tabs">
	
		<li class="nav-item">
			<a class="nav-link" href="npiCreate.html">Create</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="show_close()">show close</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="javascript:void(0);" onclick="show_all()">show all</a>
		</li>
	</ul>
</nav>
<div class="container" style="margin-top:30px;">
	<div class="search-bar">
        
        <div class="div-st">
			<select class="form-control" id="shbar-st">
                <option value="">choose station</option>
                <option value="QC1">QC1</option>
                <option value="QC2">QC2</option>
                <option value="QC3">QC3</option>
                <option value="OBA">OBA</option>
                <option value="RUNIN">RUNIN</option>
			</select>
        </div>
        <div class="div-model">
			<select class="form-control" id="shbar-model">
				<option value="">choose model</option>
			</select>
		</div>
		<div class="div-tpr">
			<select class="form-control" id="shbar-tpr">
				<option value="">choose tpr</option>
			</select>
		</div>
	
		<div class="div-btn">
			<button type="button" class="btn btn-primary" onclick="search()">
				Search
			</button>
		</div>
    </div>
    <h4 style="text-align:center">NPI Tracking System</h4>
<table class="table table-bordered table-hover table-condensed" id="tb-data" style="width: 1138px;margin: 0 auto;table-layout:fixed">
<thead style="background-color:#F4987F">
<td>TPR</td>
<td style="width:250px">series</td>
<td style="width:150px">Model</td>
<td>Remark</td>
<td style="width:50px">File</td>
<td style="width:120px">Bgtime</td>
<td>Edtime</td>
<td style="background-color: #C60;width:80px">Status</td>
<td style="width:65px;">Del</td>
<td>Delay</td>
</thead>
<tbody id="bk-data" style="background-color:#FFF;width:1130px!important">
    <div id='fhide' class='fhide' style="width: 250px;height: 50px;position: absolute;margin-top: 50px;left: 50%;background-color: #FFF;transform: translateX(-50%);text-align: center;line-height: 45px;">无符合条件的数据</div>
</tbody>
</table>
</div>

</body>
<script type="text/javascript">
function load(){
    let ptpr = '';
    let flag = window.location.search.substring(0);
    if( flag!=''){
        ptpr = window.location.search.substring(0).split('?')[1];
    }
	$.ajax({
		type:'post',
		dataType:'json',
		url:"Controller.php",
		data:{action:'NPIController/getUnclose',ptpr:ptpr,tflag:'NPI'},
		success:function(msg){
            console.log(msg);
            
           let endarr = {};
            for(x in msg){
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                     
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['TPR'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['TPR']] = earr;
                        tarr.push(msg[x][i]['id']);
                    }
                  else
                    {
                      for(let j=0;j<earr.length;j++){
                            if(earr[j].id == msg[x][i]['id']  ){
                                earr[j].data.push(msg[x][i]);
                                break;
                            }
                      }
                    }
                }
           
              //break;
            }
            console.log(endarr);
			if(msg=='10000'){
				location.href='#';
			}
			show_data(endarr);
			
		},
		error:function(msg){
			console.log(msg);
			}
		})
    $.ajax({
        type:'post',
        dataType:'json',
        url:"Controller.php",
        data:{action:'NPIController/getTPR'},
        success:function(msg){
            //console.log(msg);
           let selections=document.getElementById('shbar-tpr');
            if(msg.length>0){
                for(var i=0;i<msg.length;i++){
                    var option=document.createElement("option");
                    option.value=msg[i];
                    option.text=msg[i];
                    selections.options.add(option);
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
        url:"Controller.php",
        data:{action:'NPIController/getSHModel'},
        success:function(msg){
            //console.log(msg);
            let selections=document.getElementById('shbar-model');
            if(msg.length>0){
                for(var i=0;i<msg.length;i++){
                    var option=document.createElement("option");
                    option.value=msg[i];
                    option.text=msg[i];
                    selections.options.add(option);
                }
            }
        },
        error:function(msg){
            console.log(msg);
        }
    })
}
function search() {
    let tpr=document.getElementById('shbar-tpr').value;
    let model=document.getElementById('shbar-model').value;
   
    let station=document.getElementById('shbar-st').value;
    let search=new Object();
    
   
    if (station!=null&&station!=""){
	    search['station']=station;
	}
    if (model!=null&&model!=""){
	    search['model']=model;
	}
    if (tpr!=null&&tpr!=""){
        search['tpr']=tpr;
	}
	if (tpr==null&&model==null&&station==null||tpr==""&&model==""&&station==''){
	    alert("choose at least one choice ");
	    return false;
	}
    console.log(search);
    $.ajax({
        type:'post',
        dataType:'json',
        url:"Controller.php",
        data:{action:'NPIController/getSearch',urldata:search,flag:'NPI'},
        success:function(msg){
            console.log(msg);
            
           let endarr = {};
            for(x in msg){
                 let tarr = [];
                 let earr = [];
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['TPR'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['TPR']] = earr;
                        tarr.push(msg[x][i]['id']);
                    }
                  else
                    {
                      for(let j=0;j<earr.length;j++){
                            if(earr[j].id == msg[x][i]['id']  ){
                                earr[j].data.push(msg[x][i]);
                                break;
                            }
                      }
                    }
                }
            }
            console.log(endarr);
            if (msg==1010){
                alert("Users do not have permission to query");
                return;
			}
            
            show_data(endarr,'search');
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
        url:"Controller.php",
        data:{action:'NPIController/getAll',flag:'NPI'},
        success:function(msg){
            console.log(msg);
            
           let endarr = {};
            for(x in msg){
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['TPR'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['TPR']] = earr;
                        tarr.push(msg[x][i]['id']);
                    }
                  else
                    {
                      for(let j=0;j<earr.length;j++){
                            if(earr[j].id == msg[x][i]['id']  ){
                                earr[j].data.push(msg[x][i]);
                                break;
                            }
                      }
                    }
                }
                    //console.log(tarr);
                  // console.log(earr);
                   

           
              //break;
            }
            console.log(endarr);
            if(msg=='10000'){
                location.href='#';
            }
            show_data(endarr);
        },
        error:function(msg){
            console.log(msg);
        }
    })
}
function show_close(){
    $.ajax({
        type:'post',
        dataType:'json',
        url:"Controller.php",
        data:{action:'NPIController/getclose',flag:'NPI'},
        success:function(msg){
            console.log(msg);
            
           let endarr = {};
            for(x in msg){
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['TPR'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['TPR']] = earr;
                        tarr.push(msg[x][i]['id']);
                    }
                  else
                    {
                      for(let j=0;j<earr.length;j++){
                            if(earr[j].id == msg[x][i]['id']  ){
                                earr[j].data.push(msg[x][i]);
                                break;
                            }
                      }
                    }
                }
              //break;
            }
            console.log(endarr);
            if(msg=='10000'){
                location.href='#';
            }
            show_data(endarr);
        },
        error:function(msg){
            console.log(msg);
        }
    })
}
  
function show_data(msg,fg=''){
	var tb=document.getElementById('bk-data');
	$('#bk-data').empty();
    if(!$('#fhide').hasClass('fhide')){
        $('#fhide').addClass('fhide');
    }   
    if($.isEmptyObject(msg)){  //判断一个对象是否为空，需要依赖jquery库
        $('#fhide').removeClass('fhide');
    }
    // console.log(Object.entries(msg))
    let item = ``;
    for (const [,value] of Object.entries(msg)) {
        // console.log(key);
        console.log(value);
        value.forEach((v,i)=>{
            // console.log(v,i);
            if(i==0){
                item+=`
                        <tr>
                        <td class="ctd" rowspan='${value.length}'>${v['tpr']}</td>
                        <td class="ctd wtd" style="width:250px" title="${v['data'][0]['Series']}" onclick="alert(this.innerHTML)">${v['data'][0]['Series']}</td>
                        <td class="ctd" title="${v['data'][0]['Model']}" onclick="alert(this.innerHTML)"><a href="javascript:;" onclick="tostep('${v['id']}',event)">${v['data'][0]['Model']}</a></td>
                        <td class="ctd" title="${v['data'][0]['MEMO']}" onclick="alert(this.innerHTML)">${v['data'][0]['MEMO']}</td>
                        <td class="ctd"><a href="javascript:;" onclick="getfile('${v['id']}',1,'${v['data'][0]['batch']}')">File</a></td>
                        <td class="ctd" title="${v['data'][0]['Btime']}" onclick="alert(this.innerHTML)">${v['data'][0]['Btime']}</td>
                        <td class="ctd">${v['data'][0]['Etime']==null?'':v['data'][0]['Etime']}</td>
                        <td class="ctd gcolor">begin</td>
                        <td class="ctd"><a href="javascript:;" onclick="delData('${v['id']}')">Del</a></td>
                        <td class="ctd" title="${v['data'][0]['Delay']}" onclick="alert(this.innerHTML)">${v['data'][0]['Delay']==null?'':v['data'][0]['Delay']}</td>
                        </tr>
                `;
            }else{
                item+=`
                        <tr>
                        <td class="ctd wtd" title="${v['data'][0]['Series']}" onclick="alert(this.innerHTML)">${v['data'][0]['Series']}</td>
                        <td class="ctd" title="${v['data'][0]['Model']}" onclick="alert(this.innerHTML)"><a href="javascript:;" onclick="tostep('${v['id']}',event)">${v['data'][0]['Model']}</a></td>
                        <td class="ctd" title="${v['data'][0]['MEMO']}" onclick="alert(this.innerHTML)">${v['data'][0]['MEMO']}</td>
                        <td class="ctd"><a href="javascript:;" onclick="getfile('${v['id']}',1,'${v['data'][0]['batch']}')">File</a></td>
                        <td class="ctd" title="${v['data'][0]['Btime']}" onclick="alert(this.innerHTML)">${v['data'][0]['Btime']}</td>
                        <td class="ctd">${v['data'][0]['Etime']==null?'':v['data'][0]['Etime']}</td>
                        <td class="ctd gcolor">begin</td>
                        <td class="ctd"><a href="javascript:;" onclick="delData('${v['id']}')">Del</a></td>
                        <td class="ctd" title="${v['data'][0]['Delay']}" onclick="alert(this.innerHTML)">${v['data'][0]['Delay']==null?'':v['data'][0]['Delay']}</td>
                        </tr>
                `;
            }
            
        })
        

    }
   $('#bk-data').append(item);
//    setTimeout(() => {
//       let tds = document.querySelectorAll('ctd');
//    }, 2000);
}

function tostep(id,e){
    e.stopPropagation();//阻止冒泡
    window.open('step.php'+'?'+id);
}

function getfile(id,step,batch){
    layui.use('layer',function(){
        let layer = layui.layer;
        layer.ready(function(){
                layer.open({        
                type:2,
                title:'File_list',
                maxmin:true,//最大最小话
                shadeClose:true,//是否点击遮罩关闭
                area:['550px','470px'],//弹出层大小
                content:'./file_list.html'+'?'+id+'?'+batch,
                btn: ['确定','关闭'],
                yes:function (index) {
                        layer.close(index);
                }

            });
        })
    })
}



function fileselect(){
	var file_obj=document.getElementById('sop-file').files[0];
	if(file_obj!=null){
		
	if(file_obj.size>1024*1024){
		var fileSize=(Math.round(file_obj.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
	}else {
		var fileSize = (Math.round(file_obj.size * 100 / 1024) / 100).toString() + 'KB';
	}
	}else{
		var fileSize=null;
	}
	//document.getElementById('file-type').innerHTML=file_obj.type;
	document.getElementById('file-size').innerHTML=fileSize;
}
function progressHander(e){
	if(e.lengthComputable){
		if(e.total>1024*1024){
			var uploading=(Math.round(e.loaded * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
			var uploading = (Math.round(e.loaded * 100 / 1024) / 100).toString() + 'KB';
		}
		document.getElementById('file-up').innerHTML=uploading;
		var persent=(e.loaded/e.total*100).toFixed(1);
		document.getElementById('probar').innerHTML=persent+"%";
		var probar=Math.floor(e.loaded/e.total*100)+'%';
        document.getElementById('probar').style.width=probar;
		//console.log(e.loaded+'----'+e.total);
	}
}
function delData(id){
    console.log(id);
    var d=confirm('are you sure delete data and file ?');
    if(d==true){
       
       
        $.ajax({
            type:'post',
            dataType:'json',
            url:" Controller.php",
            data:{action:'NPIController/delData',urldata:id},
            success:function(msg){
                console.log(msg);
                if(msg==200){
                    alert("delete success");
                    window.location.reload();
                }else if(msg==1011){
                    alert("delete error")
                }else if(msg==1020){
                    alert('permission denied')
                }else if (msg==1010){
                    alert('delete file error');
				}
            },
            error:function(msg){
                console.log(msg);
                alert("error")
            }
        })
    }
}
</script>

</html>
