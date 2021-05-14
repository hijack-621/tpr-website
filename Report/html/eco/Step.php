<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>ECO Detail Data</title>

<style type="text/css">
body{
	background-image: url(../../../images/beijin.jpg);

}
div{
    text-align: center;
}

td {

	text-align: center;
	padding: 0 auto;
	display: table-cell;
	vertical-align: middle;
	overflow: hidden;
	/*white-space: nowrap;
	text-overflow: ellipsis;*/
	margin: 0 auto;
}
.mtd{
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
}
table {
	vertical-align: middle;
	overflow: hidden;


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
<script src="../../js/jquery.cookie.js"></script>
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
	var dataid=window.location.search.substring(1);
	//console.log(dataid);//Id
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'step',dataid:dataid},
		success:function(msg){
			console.log(msg);
			document.getElementById('tpr').innerHTML="TPR: "+msg[0]['TPR'];
			document.getElementById('model').innerHTML="Model: "+msg[0]['Model'];
            document.getElementById('model').title = msg[0]['Model'];
			document.getElementById('new-eco').innerHTML="ECO_Num: "+msg[0]['Eco_no'];
			document.getElementById('new-eco').title = msg[0]['Eco_no'];
            //标题栏三个赋值
			//table data
			var td=document.getElementById("step-tb").getElementsByTagName("td");


			for(var i=0;i<td.length;i++){
				if($.inArray(td[i].id,Object.keys(msg[0]))!=-1){
                    //如果遇到Owner和Checker 的单元格则产生a标签连接，链接至edit.html编辑页面
					//console.log(td[i].id.indexOf('Owner'));
					if(td[i].id.indexOf("Owner")!==-1||td[i].id.indexOf("Checker")!==-1){

					    var a=document.createElement("a"),
						id=msg[0]['Id'],
						step=td[i].id.substring(0,1), //六个步骤  step
						tpr=msg[0]['TPR'];
						 a.innerHTML=msg[0][td[i].id];//页面信息带出checker和owner
						 a.style.color='blue';
						//console.log(a.innerHTML=msg[0][td[i].id]);//打印的是每一步的操作人
						if(step==6){ //如果是第六步，就跳转到Edit6.html这个网页
						    a.href='Edit6.php?'+id+'&'+step+'&'+tpr;
							a.target = '_blank';
							a.style.color='blue';
						}else{
                            a.href="Edit.php?"+id+'&'+step+'&'+tpr;
							a.target = '_blank';
							a.style.color='blue';
						}
                        //传递编辑页面所需要的数据
						td[i].appendChild(a);//
					}else{
                        //console.log(msg[0][td[69].id]);//reject  reason

						  td[i].innerHTML=msg[0][td[i].id];//带出时间和状态，reason
						  td[i].title = msg[0][td[i].id];
                        if(td[i].id=='New_comp') {
                            console.log(i);
                        td[i].title = msg[0][td[i].id];}


					}


					if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==0){
						var tr=td[i].parentNode;
                        //console.log(td[i].id.indexOf("Status"));  //-1
						tr.style.backgroundColor="#F2F2F2";
						td[i].innerHTML="Beging";
						td[i].setAttribute("bgcolor","#FFFF00");
					}else if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==1){
						td[i].innerHTML="close";
                        //console.log(td[i].id.indexOf("Status")); //2
						td[i].setAttribute("bgcolor","#00FF00");
					}else if(td[i].id.indexOf("Status")!==-1&&msg[0][td[i].id]==5){
						td[i].innerHTML="close";
                        //console.log(td[i].id.indexOf("Status")); //-1
						td[i].setAttribute("bgcolor","#FF0000");//延迟close
					}
				}
                if(i%11 == 0){
					//console.log(i);
					td[i].style.display = 'table-cell';
					td[i].style.whiteSpace = 'nowrap';
					td[i].style.overflow = 'hidden';
					td[i].style.textOverflow = 'ellipsis';


                }
			}

			//getwidth();
			var first = true;

            if(first) {
                var rea = msg[0]['reason'] ;
                sessionStorage.setItem('reason1',rea);
                first = false;
			}
			/*var target = document.getElementById('reason');
			console.log(target);
			var observe = new MutationObserver(function (mutations,observe){
			});
             config = {
                childList:true,
                attributes:true,
                subtree:true,
                attributeFilter:['innerHTML'],
            }
            observe.observe(target,config);
            console.log();

*/			 setInterval(function () {
                var td = document.getElementById('reason'), ovalue = td.getAttribute('ovalue');
                if (ovalue && ovalue !=sessionStorage.getItem('reason1'))
				alert('td内容改变');
                td.setAttribute('ovalue', td.innerHTML);
                td.title = msg[0]['reason'];
            }, 1000);


            setTimeout(function () { document.getElementById('reason').innerHTML = msg[0]['reason']; }, 3000);
            //console.log(msg[0]['2_Endtime']);
			if(msg[0]['4_Endtime']){
                if(msg[0]['5_Endtime']==null&&msg[0]['4agtime']==null){
                    let data4 = new Date(msg[0]['4_Endtime']);
                    let data5 = new Date();
                    let day = Math.floor((data5.getTime()-data4.getTime())/86400000);
                    console.log(day);
                    console.log(1);
                    $('#TAT5').html(day+' '+'day');
                    if(day >=15 ){
                        $('#TAT5').css('background','red');
                        $('#TAT6').css('background','red');
                    }
                    console.log(msg[0]['4agtime']);
                }else if(msg[0]['5_Endtime']==null&&msg[0]['4agtime']!=null){
                    let data4 = new Date(msg[0]['4agtime']);
                    let data5 = new Date();
                    console.log(data5);
                    console.log(data4);
                    // console.log(msg[0]['4agtime']);
                    let day = Math.floor((data5.getTime()-data4.getTime())/86400000);
                    console.log(day);
                    console.log(2);

                    $('#TAT5').html(day+' '+'day');
                    if(day >=15 ){
                        $('#TAT5').css('background','red');
                        $('#TAT6').css('background','red');
                    }

                }else if(msg[0]['5_Endtime']!=null&&msg[0]['4agtime']!=null){
                    let data4 = new Date(msg[0]['4agtime']);
                    let data5 = new Date(msg[0]['5_Endtime']);
                    console.log(data5);
                    console.log(data4);
                    console.log(msg[0]['4agtime']);
                    let day = Math.floor((data5.getTime()-data4.getTime())/86400000);
                    console.log(day);
                    console.log(3);
                    $('#TAT5').html(day+' '+'day');
                    if(day >=15 ){
                        $('#TAT5').css('background','red');
                        $('#TAT6').css('background','red');
                    }
                }
                else if(msg[0]['5_Endtime']!=null&&msg[0]['4agtime']==null){
                    let data4 = new Date(msg[0]['4_Endtime']);
                    let data5 = new Date(msg[0]['5_Endtime']);
                    console.log(data5);
                    console.log(data4);
                    // console.log(msg[0]['4agtime']);
                    let day = Math.floor((data5.getTime()-data4.getTime())/86400000);
                    console.log(day);
                    console.log(4);
                    $('#TAT5').html(day+' '+'day');
                    if(day >=15 ){
                        $('#TAT5').css('background','red');
                        $('#TAT6').css('background','red');
                    }
                }
			}else{
                $('#TAT5').html('');
                console.log('5');
			}
			
		

        },
		error:function(msg){
			console.log(msg);
			}
		});
$.ajax({
	type:'post',
	dataType:'json',
	url:"ECO_server.php",
	data:{flag:'step_file',dataid:dataid},
	success:function(msg){
		console.log(msg);
		//目前length为3
		if(msg.length==1){
            //判断文件数多少，如果为1则只有第二步有文件，如果为2则第五步也有文件
			var td=document.getElementsByName("attach_2");
			for(var i=0;i<td.length;i++){
				var a=document.createElement("a");
				var img=document.createElement("img");
				a.href=msg[0];
				var file_arr=msg[0].split("/");
				a.download=file_arr[file_arr.length-1];
				img.src="img/file.png";
				img.alt="file";
				td[i].appendChild(a);
				a.appendChild(img);
			}
		}else if(msg.length==2){
			var td=document.getElementsByName("attach_2");
			var td4=document.getElementsByName("attach_5");
			for(var i=0;i<td.length;i++){
				var a=document.createElement("a");
				var img=document.createElement("img");
				a.href=msg[0];
				var file_arr=msg[0].split("/");
				a.download=file_arr[file_arr.length-1];
				img.src="img/file.png";
				img.alt="file";
				td[i].appendChild(a);
				a.appendChild(img);
			}
            var a4=document.createElement("a");
            var img=document.createElement("img");
            img.src="img/file.png";
            img.alt="file";
            a4.href=msg[1];
            var file_arr4=msg[1].split("/");
            a4.download=file_arr4[file_arr4.length-1];
            td4[0].appendChild(a4);
            a4.appendChild(img);
			
		}else if(msg.length==3){ //菴鞠祭恅璃
            var td=document.getElementsByName("attach_2");
            var td4=document.getElementsByName("attach_4");
            var t5=document.getElementsByName("attach_5");
            for(var i=0;i<td.length;i++){
                var a=document.createElement("a");
                var img=document.createElement("img");
                a.href=msg[0];//祭腔閉蟈諉url
                var file_arr=msg[0].split("/");
                a.download=file_arr[file_arr.length-1];
                img.src="img/file.png";
                img.alt="file";
                td[i].appendChild(a);
                a.appendChild(img);
            }

            var td_4=document.getElementById("sop_file4");//菴鞠祭奻換恅璃
            var td_5=document.getElementById("sop_file5");//菴鞠祭奻換恅璃

            var a=document.createElement("a");
            var b=document.createElement("a");//斐膘腔岆<a>梓
            var img=document.createElement("img");
            var img1=document.createElement("img");
            a.href=msg[1];

            b.href=msg[2];

            var file_arr1=msg[1].split("/");
            var file_arr2=msg[2].split("/");
            //console.log(file_arr,file_arr2);
            a.download=file_arr1[file_arr1.length-1];
            b.download=file_arr2[file_arr2.length-1];
            img.src="img/file.png";
            img1.src="img/file.png";
            img.alt="file";
            img1.alt="file";
            td_4.appendChild(a);
            td_5.appendChild(b);
            a.appendChild(img);
            b.appendChild(img1);
          
        }
	},
	error:function(msg){
		console.log(msg);
	}
	})
	
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
                    <li><a href="../../../total_system_sop.html">sop</a></li>
                    <li><a href="#">Our Works</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>
<nav class="nav" style="margin-left:30px;margin-bottom:30px;margin-top:110px">
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
	</ul>
</nav>
	<div style="width:900px;position: absolute;margin-top: -25px;margin-left: 28% " >

			<div  >
				<li class="list-group-item" id="tpr" style="width: 200px;float: left" ></li>
			</div>
		<div >
			<li class="list-group-item" id="model" style="width: 200px;float: left;margin-left: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" ></li>
		</div>
			<div >
				<li class="list-group-item" id="new-eco" style="width: 200px;float: left;margin-left: 100px"></li>
			</div>

	</div>

		<table class="table table-bordered table-condensed" style="text-align:center; background-color:#FFF;margin-top: 80px;table-layout: fixed;height: 400px;vertical-align: middle;width: 1260px;margin-left:auto;margin-right:auto" id="step-tb" >
			<thead style="background-color:#F4987F">
			<td id="act" width="200" >Actvity</td>
			<td width="60" >Attach</td>
			<td style="width: 150px" >ECO-Materials</td>
			<td width="95" style="text-align: center">Begingtime</td>
			<td width="84" >Checker</td>
			<td width="84" >Owner</td>
			<td width="150" >remark</td>
			<td width="95" >Endtime</td>
			<td style="background-Color:#C60;width: 55px" >Status</td>
			<td style="background-Color:#C60;width: 55px" id="tat" >TAT</td>
			<td width="75">Reason</td>
			</thead>

			<tbody style="height: 350px">
			<tr>
				<td id="Activity"></td><td id="sop_file1"></td><td id="New_comp"></td><td id="1_Begingtime"></td><td id="1_Checker"></td><td id="1_Owner"></td><td id="1_Remark"></td><td id="1_Endtime" ></td><td id="1_Status"></td></td><td id="TAT1"></td></td><td id="reason1"></td>
			</tr>
			<tr>
				<td title="Compal RMA QA comfirm and upload rework sop">Compal RMA QA comfirm and upload rework sop</td>
				<td id="sop_file2" name="attach_2"></td><td id="New_comp"></td><td id="2_Begingtime"></td><td id="2_Checker"></td><td id="2_Owner"></td><td id="2_Remark"></td><td id="2_Endtime"></td><td id="2_Status"></td></td><td id="TAT2"></td></td><td id="reason2"></td>
			</tr>
			<tr>
				<td title='TPR QA Receive  eco message'>TPR QA Receive  eco message</td>
				<td id="sop_file3" name="attach_2"></td><td id="New_comp"></td><td id="3_Begingtime"></td><td id="3_Checker"></td><td id="3_Owner"></td><td id="3_Remark"></td><td id="3_Endtime"></td><td id="3_Status"></td></td><td id="TAT3"></td></td><td id="reason3"></td>
			</tr>
			<tr>
				<td title="RMA QA confirm SECO/Agile Eco/Agile release">RMA QA confirm SECO/Agile Eco/Agile release</td>
				<td id="sop_file4" name="attach_4"></td><td id="New_comp"></td><td id="4_Begingtime"></td><td id="4_Checker"></td><td id="4_Owner"></td><td id="4_Remark"></td><td id="4_Endtime"></td><td id="4_Status"></td></td><td id="TAT4"></td></td><td id="reason4"></td>
			</tr>
			<tr>
				<td title="TPR QA confirm import ECO and maintenance system">TPR QA confirm import ECO and maintenance system</td>
				<td id="sop_file5" name="attach_5"></td><td id="New_comp"></td><td id="5_Begingtime"></td><td id="5_Checker"></td><td id="5_Owner"></td><td id="5_Remark"></td><td id="5_Endtime"></td><td id="5_Status"></td><td id="TAT5"></td></td><td id="reason5"></td>
			</tr>
			<tr id="x">
				<td title="RMA QA confirm file uploaded in fifth step and decide pass or not (if not please input reason)">RMA QA confirm file uploaded in fifth step and decide pass or not (if not please input reason)</td>
				<td id="sop_file6"></td><td id="New_comp" style="white-space: nowrap"></td><td id="6_Begingtime"></td><td id="6_Checker"></td><td id="6_Owner"></td><td id="6_Remark"></td><td id="6_Endtime"></td><td id="6_Status"></td><td id="TAT6"></td></td><td id="reason"></td>
			</tr>
			</tbody>
		</table>



</body>
</html>
