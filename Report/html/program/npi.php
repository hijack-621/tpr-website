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
<table class="table table-bordered table-hover table-condensed" id="tb-data" style="width: 1160px;margin: 0 auto;">
<thead style="background-color:#F4987F">
<td>TPR</td>
<td>Model</td>
<td>Type</td>
<td>Description/Version</td>
<td>Ver</td>
<td>Sop Path</td>
<td>Station/FTP Path</td>
<td>Bgtime</td>
<td>Edtime</td>
<td style="background-color: #C60">Status</td>
<td>Del Data</td>
</thead>
<tbody id="bk-data" style="background-color:#FFF">
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
                // let model = [];
                //  let id = [];
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                       //   console.log(i);
                       //   console.log((msg[x][i]['id']));
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['tpr'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['tpr']] = earr;
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
                // let model = [];
                //  let id = [];
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                       //   console.log(i);
                       //   console.log((msg[x][i]['id']));
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['tpr'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['tpr']] = earr;
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
                // let model = [];
                //  let id = [];
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                       //   console.log(i);
                       //   console.log((msg[x][i]['id']));
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['tpr'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['tpr']] = earr;
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
                // let model = [];
                //  let id = [];
                 let tarr = [];
                 let earr = [];
               
              for(i=0;i<msg[x].length;i++)
                {
                  if( tarr.indexOf(msg[x][i]['id'])===-1  )
                    {
                       //   console.log(i);
                       //   console.log((msg[x][i]['id']));
                        earr.push({ //数组对象根据某一相同的key合并成新的数组！！！ 如果id相同的记录合并成一条显示
                            id:msg[x][i]['id'],
                            tpr:msg[x][i]['tpr'],
                            data:[msg[x][i]]
                        });
                        endarr[msg[x][i]['tpr']] = earr;
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
  
function show_data(msg,fg=''){
	var tb=document.getElementById('bk-data');
	$('#bk-data').empty();
    if(!$('#fhide').hasClass('fhide')){
        $('#fhide').addClass('fhide');
    }   
    if($.isEmptyObject(msg)){  //判断一个对象是否为空，需要依赖jquery库
        console.log(111);
        $('#fhide').removeClass('fhide');
    }
	for(x in msg){
        //console.log(x);
		for(i=0;i<msg[x].length;i++){
			var tr=document.createElement("tr");
			tr.id=msg[x][i]["id"];
			if(i==0){
				 var tpr_td=document.createElement("td"),
                     model_td=document.createElement("td")
					 type_td=document.createElement("td"),
					 type_a=document.createElement("a"),
					 desc_td=document.createElement("td"),
					 desc_a=document.createElement("a"),
                     over_td = document.createElement("td"),
                     over_a = document.createElement("a"),
					 sop_td=document.createElement("td"),
					 sop_a=document.createElement("a"),
					 st_td=document.createElement("td"),
					 st_a=document.createElement("a"),
					 bg_td=document.createElement("td"),
					 ed_td=document.createElement("td"),
					 sta_td=document.createElement("td"),
					 del_td=document.createElement("td"),
					 del_btn=document.createElement("button");
                     let tmodel = [];
                     let smodel = '';
                     if(msg[x][i]['data'].length>1){
                        
                        for(let j=0;j<msg[x][i]['data'].length;j++){
                            tmodel.push(msg[x][i]['data'][j]['model']);
                        }
                         
                        smodel = tmodel.join();
                        msg[x][i]['model'] = smodel;
                     }else{
                        msg[x][i]['model'] = msg[x][i]['data'][0]['model'];
                     }
                    
                    // console.log(smodel);
                     
                    // console.log(msg);
               
                tpr_td.innerHTML=msg[x][i]['data'][0]['tpr'];
                tpr_td.setAttribute("rowspan",msg[x].length);
                if( msg[x][i]['model'].indexOf(',')!==-1){
                    let modelarr = msg[x][i]['model'].split(',');
                    for(let m=0;m<modelarr.length;m++){
                        let mp = document.createElement('p');
                        mp.innerHTML = modelarr[m];
                        model_td.appendChild(mp);
                    }
                }else{
                    let mp = document.createElement('p');
                    mp.innerHTML = msg[x][i]['model'];
                    model_td.appendChild(mp);
                }
                over_a.innerHTML = 'Version'
                over_a.setAttribute('href','javascript:void(0)');
                //console.log(msg[x][i]);
               // window.ldata = msg[x][i]['data'];
                over_a.addEventListener('click',function(){//监听点击事件   js 超链接 a的setattriute 设置onclick事件
                    //console.log(this.parentNode.parentNode.id);
                    let id = this.parentNode.parentNode.id;
                    let flag = 'NPI'; 
                if(fg==''){
                    layui.use('layer',function () {
                  layer.ready(function () {
                    layer.open({        
                    type:2,
                    title:'访问确认',
                    maxmin:true,//最大最小话
                    shadeClose:true,//是否点击遮罩关闭
                    area:['550px','320px'],//弹出层大小
                    content:'./verlayer.html'+'?id='+id+'&flag='+flag,
                    btn: ['确定','关闭'],
                    yes:function (index) {
                        layer.close(index);
                    }

                      });
                     })
                    }); 
                }else{
                    let pmodel = msg[x][0]['model'];
                 //let ptpr = msg[x][0]['data'][0]['tpr'];
                // console.log(msg);
                // console.log(ptpr);
                layui.use('layer',function () {
                  layer.ready(function () {
                    layer.open({        
                    type:2,
                    title:'访问确认',
                    maxmin:true,//最大最小话
                    shadeClose:true,//是否点击遮罩关闭
                    area:['550px','320px'],//弹出层大小
                    content:'./verlayer.html'+'?id='+id+'&flag='+flag+'&pmodel='+pmodel,
                    btn: ['确定','关闭'],
                    yes:function (index) {
                        layer.close(index);
                    }

                      });
                     })
                    }); 
                } 
                                                                  //function 不好传递参数！！！ 用事件监听代替
                        // console.log('aaa');
                }) ;
                type_a.innerHTML=msg[x][i]['data'][0]['sort'];
                
                desc_a.innerHTML=msg[x][i]['data'][0]['reason'];
                sop_a.innerHTML=msg[x][i]['data'][0]['sop_path'];
                if(msg[x][i]['data'][0]['bstation']!==null){
                    st_a.innerHTML=msgmsg[x][i]['data'][0]['station'];
				}else{
                    st_a.innerHTML=msg[x][i]['data'][0]['station'];
				}
               
                type_a.style.color='blue';
                desc_a.style.color='blue';
                over_a.style.color='blue';
                sop_a.style.color='blue';
                st_a.style.color='blue';

                bg_td.innerHTML=msg[x][i]['data'][0]['bgtime'];
                ed_td.innerHTML=msg[x][i]['data'][0]['edtime'];

                type_a.setAttribute("href","npiStep.html?"+"id="+msg[x][i]['id']);
                type_a.setAttribute("target","_bank");
                desc_a.setAttribute("href","model_edit.html?"+"id="+msg[x][i]['id']);
                desc_a.setAttribute("target","_bank");
                sop_a.setAttribute("href","path_edit.php?"+"id="+msg[x][i]['id']+"&step=1");
                sop_a.setAttribute("target","_bank");
                st_a.setAttribute("href","station_path.html?"+"id="+msg[x][i]['id']);
                st_a.setAttribute("target","_bank");

                del_btn.innerHTML="Del";
                del_btn.type="button";
                del_btn.setAttribute("class","btn btn-danger");
                del_btn.setAttribute("onclick","delData(this)");
                
                if (msg[x][i]['data'][0]['status']==1){
                    sta_td.innerHTML='Close';
                    sta_td.style.backgroundColor="#00FF00";
				} else if (msg[x][i]['data'][0]['status']==5){
                    sta_td.innerHTML='Close';
                    sta_td.style.backgroundColor="#FF0000";
				} else{
                    sta_td.innerHTML='Beging';
                    sta_td.style.backgroundColor="#FFFF00";
                }
                
                type_td.appendChild(type_a);
                desc_td.appendChild(desc_a);
                over_td.appendChild(over_a);
                sop_td.appendChild(sop_a);
                st_td.appendChild(st_a);
                del_td.appendChild(del_btn);
                tr.appendChild(tpr_td);
                tr.appendChild(model_td);
                tr.appendChild(type_td);
                tr.appendChild(desc_td);
                tr.appendChild(over_td);
               // tr.appendChild(nver_td);
                tr.appendChild(sop_td);
                tr.appendChild(st_td);
                tr.appendChild(bg_td);
                tr.appendChild(ed_td);
                tr.appendChild(sta_td);
                tr.appendChild(del_td);
			}else{
                 var model_td=document.createElement("td"), 
                     type_td=document.createElement("td"),
                     type_a=document.createElement("a"),
                     desc_td=document.createElement("td"),
                     over_td = document.createElement("td"),
                     over_a = document.createElement("a"),
                    // nver_td = document.createElement("td"),
                     desc_a=document.createElement("a"),
                     sop_td=document.createElement("td"),
                     sop_a=document.createElement("a"),
                     st_td=document.createElement("td"),
                     st_a=document.createElement("a"),
                     bg_td=document.createElement("td"),
                     ed_td=document.createElement("td"),
                     sta_td=document.createElement("td"),
                     del_td=document.createElement("td"),
                     del_btn=document.createElement("button");
                     let tmodel = [];
                     let smodel = '';
                     if(msg[x][i]['data'].length>1){
                        
                        for(let j=0;j<msg[x][i]['data'].length;j++){
                            tmodel.push(msg[x][i]['data'][j]['model']);
                        }
                         
                        smodel = tmodel.join();
                        msg[x][i]['model'] = smodel;
                     }else{
                        msg[x][i]['model'] = msg[x][i]['data'][0]['model'];
                     }
                    
                     //console.log(smodel);
                    
                    /// console.log(msg);
                if( msg[x][i]['model'].indexOf(',')!==-1){
                    let modelarr = msg[x][i]['model'].split(',');
                    if(modelarr.length<=5){
                        for(let m=0;m<modelarr.length;m++){
                        let mp = document.createElement('p');
                        mp.innerHTML = modelarr[m];
                        model_td.appendChild(mp);
                        }
                    }//model 太多？？？
                    
                    }else{
                    let mp = document.createElement('p');
                    mp.innerHTML = msg[x][i]['model'];
                    model_td.appendChild(mp);
                }
                over_a.innerHTML = 'Version'
                over_a.setAttribute('href','javascript:void(0)');
                //console.log(msg[x][i]);
                over_a.addEventListener('click',function(){//监听点击事件   js 超链接 a的setattriute 设置onclick事件
                    //console.log(this.parentNode.parentNode.id);
                    let id = this.parentNode.parentNode.id;
                    let flag = 'NPI';
                if(fg==''){
                    layui.use('layer',function () {
                  layer.ready(function () {
                    layer.open({        
                    type:2,
                    title:'访问确认',
                    maxmin:true,//最大最小话
                    shadeClose:true,//是否点击遮罩关闭
                    area:['550px','320px'],//弹出层大小
                    content:'./verlayer.html'+'?id='+id+'&flag='+flag,
                    btn: ['确定','关闭'],
                    yes:function (index) {
                        layer.close(index);
                    }

                      });
                     })
                    });
                }else{
                let pmodel = msg[x][i-1]['model'];
                layui.use('layer',function () {
                  layer.ready(function () {
                    layer.open({        
                    type:2,
                    title:'访问确认',
                    maxmin:true,//最大最小话
                    shadeClose:true,//是否点击遮罩关闭
                    area:['550px','320px'],//弹出层大小
                    content:'./verlayer.html'+'?id='+id+'&flag='+flag+'&pmodel='+pmodel,
                    btn: ['确定','关闭'],
                    yes:function (index) {
                        layer.close(index);
                    }

                      });
                     })
                    }); 
                }  
                                                                    //function 不好传递参数！！！ 用事件监听代替
                        // console.log('aaa');
                }) ;
                type_a.innerHTML=msg[x][i]['data'][0]['sort'];
                desc_a.innerHTML=msg[x][i]['data'][0]['reason'];
                sop_a.innerHTML=msg[x][i]['data'][0]['sop_path'];
                if(msg[x][i]['data'][0]['bstation']!==null){
                    st_a.innerHTML=msg[x][i]['data'][0]['station'];
				}else{
                    st_a.innerHTML=msg[x][i]['data'][0]['station'];
				}
                type_a.style.color='blue';
                desc_a.style.color='blue';
                over_a.style.color='blue';
                sop_a.style.color='blue';
                st_a.style.color='blue';
                bg_td.innerHTML=msg[x][i]['data'][0]['bgtime'];
                ed_td.innerHTML=msg[x][i]['data'][0]['edtime'];

                type_a.setAttribute("href","npiStep.html?"+"id="+msg[x][i]['id']);
                type_a.setAttribute("target","_bank");
                desc_a.setAttribute("href","model_edit.html?"+"id="+msg[x][i]['id']);
                desc_a.setAttribute("target","_bank");
                sop_a.setAttribute("href","path_edit.php?"+"id="+msg[x][i]['id']+"&step=1");
                sop_a.setAttribute("target","_bank");
                st_a.setAttribute("href","station_path.html?"+"id="+msg[x][i]['id']);
                st_a.setAttribute("target","_bank");

                del_btn.innerHTML="Del";
                del_btn.type="button";
                del_btn.setAttribute("class","btn btn-danger");
                del_btn.setAttribute("onclick","delData(this)");

                if (msg[x][i]['data'][0]['status']==1){
                    sta_td.innerHTML='Close';
                    sta_td.style.backgroundColor="#00FF00";
                } else if (msg[x][i]['data'][0]['status']==5){
                    sta_td.innerHTML='Close';
                    sta_td.style.backgroundColor="#FF0000";
                } else{
                    sta_td.innerHTML='Beging';
                    sta_td.style.backgroundColor="#FFFF00";
                }
               
                type_td.appendChild(type_a);
                desc_td.appendChild(desc_a);
                over_td.appendChild(over_a);
                sop_td.appendChild(sop_a);
                st_td.appendChild(st_a);
                del_td.appendChild(del_btn);
                tr.appendChild(model_td);
                tr.appendChild(type_td);
                tr.appendChild(desc_td);
                tr.appendChild(over_td);
               // tr.appendChild(nver_td);
                tr.appendChild(sop_td);
                tr.appendChild(st_td);
                tr.appendChild(bg_td);
                tr.appendChild(ed_td);
                tr.appendChild(sta_td);
                tr.appendChild(del_td);
			}
			tb.appendChild(tr);
		}
	}
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
function delData(obj){
    var d=confirm('are you sure delete data and file ?');
    if(d==true){
        var tr=obj.parentNode.parentNode;
        var id=tr.id;
        $.ajax({
            type:'post',
            dataType:'json',
            url:" Controller.php",
            data:{action:'NPIController/delData',urldata:id},
            success:function(msg){
                console.log(msg);
                if(msg==1111){
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
