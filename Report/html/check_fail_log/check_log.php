<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TestLog Issue FACA</title>
<link rel="stylesheet" href="../../../TPRindex/css/style1.css" type="text/css" media="screen" />
<script src="../../../../layui/layui.all.js"></script>
<script src="../../../js/jquery-3.2.1.js"></script>
<link href="../../css/checkfacacss.css" rel="stylesheet" type="text/css">
<link href="../../../css/lyz.calendar.css" rel="stylesheet" type="text/css" />
<link href="../../../css/lyz.calendar1.css" rel="stylesheet" type="text/css" />
<script src="../../../js/lyz.calendar.min.js"></script>
<script src="../../../js/lyz.calendar1.min.js"></script>
<script src="../../js/jquery.table2excel.js"></script>
<script src="../../js/date.format.js"></script>
<script type="text/javascript">
//let stval = setInterval(singleUsing,2000);
function load(){//flag1
	let lat = window.location.search.substring(0);
	let lat1 = '';
	if(lat!=''){
		lat1 = window.location.search.substring(0).split('?')[1];
	}
	//cosole.log(lat1);


	var flag="1";

	$.ajax({
		type:"post",
		url:"../../server/servlet/check_fail_log/search_server.php",
		data:{flag:flag},//1
		dataType:"json",
		success:function(msg){
			console.log(msg);
			if(msg==0){
				//alert('please login ');
			location.href='../../../login.php';
			}else if(msg==1){
				//登陆成功

			}
		},
		error:function(msg){
			console.log(msg);
			location.href='../../../login.php';
		}
	});

	$.ajax({
		type:"post",
		url:'../../server/servlet/check_fail_log/search_server.php',
		data:{flag:3,lat1:lat1},//flag3
		dataType:"json",
		beforeSend:function(){
            let oimg = ' <img src="./5-121204193Q9-50.gif" id="loading"  />';
		    $('#load').append(oimg);
        },

        success:function(msg){
			console.log(msg);
			if(msg.length==0||msg==null){
			var tb=document.getElementById('f_data');
				tb.style.visibility="visible";
				$('#t_data tr:not(:first)').empty();
				var tr=document.createElement("tr");
				var td=document.createElement("td");
				tr.appendChild(td);

				td.setAttribute("colspan","14");
				td.style.backgroundColor="#008800";
				td.style.color="#FFF";
				td.style.fontSize="20px";
				td.innerHTML='No Fail DATA';
				tb.style.border="none";
				td.style.border="none";
				tb.appendChild(tr);
			}else{
				show_unclose(msg);



			}
		},
		error:function(msg){
			console.log(msg);
		},
        complete:function () {
            $('#loading').css('display','none');
        }
	})
}

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

$(function (){
	$('#bgtime').calendar({
		controlId: "divbeginDate",
		upperLimit: new Date(),                               // 日期上限，默认：NaN(不限制)
        lowerLimit: new Date("2011/01/01"),

    });
    $('#edtime').calendar1({
        controlId: "divendDate",
        upperLimit: new Date(),                               // 日期上限，默认：NaN(不限制)
        lowerLimit: new Date("2011/01/01"),
            })
});
function show_unclose(msg){
	var tb=document.getElementById('f_data');
    for(let i=0;i<msg.length;i++){
     //console.log(i);
     let tr = document.createElement('tr');
     let td = document.createElement('td');
     let td1 = document.createElement('td');
     td.style.height = '40px';
     td.innerHTML = i+1;

     //console.log(typeof msg[i][7]);
     if(msg[i][7]=='Sunny'){
            td1.innerHTML = 'CEP';

        }else if(msg[i][7]=='Robson'){

         td1.innerHTML = 'CEB';


        }else if(msg[i][7]=='Dennis'||msg[i][7]=='Will'){

         td1.innerHTML = 'CGS';

        }else if(msg[i][7]=='Gary'){

         td1.innerHTML = 'IGS';


        }else if(msg[i][7]=='Luolei'){

         td1.innerHTML = 'RLC_SH';


        }else if(msg[i][7]=='Grodriguez'){

         td1.innerHTML = 'TSI';

        }
     tr.appendChild(td);
     tr.appendChild(td1);
     let tpr = ['CEP','CEB','CGS','IGS','RLC_SH','TSI'];
     var tpr_tr=document.createElement("tr");
        for(let j=0;j<msg[i].length-1;j++){
            let td1 = document.createElement('td');
            if(j==0){
                td1.innerHTML = msg[i][0];
                //console.log(msg[i][0]);
            }
            else if (j==1) {
                let a =document.createElement("a");
                if(msg[i][7]=='Sunny'){
                    a.setAttribute("href","check_owner.html?"+tpr[0]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][5]);


                }else if(msg[i][7]=='Robson'){
                    a.setAttribute("href","check_owner.html?"+tpr[1]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][5]);

                }else if(msg[i][7]=='Dennis'||msg[i][7]=='Will'){
                    a.setAttribute("href","check_owner.html?"+tpr[2]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]);
                }else if(msg[i][7]=='Gary'){
                    a.setAttribute("href","check_owner.html?"+tpr[3]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][5]);

                }else if(msg[i][7]=='Luolei'){
                    a.setAttribute("href","check_owner.html?"+tpr[4]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][5]);

                }else if(msg[i][7]=='Grodriguez'){
                    a.setAttribute("href","check_owner.html?"+tpr[5]+"&line"+msg[i][1]+"&line"+msg[i][2]+"&line"+msg[i][8]+"&line"+msg[i][7]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][5]);
                }
                a.target = '_blank';
                a.innerHTML = msg[i][1];
                td1.appendChild(a);
                //td1.innerHTML = msg[i][1];
            }else if (j==2) {

                td1.innerHTML = msg[i][2];
            }else if (j==3) {
                td1.innerHTML = msg[i][3];
            }else if (j==4) {
                td1.innerHTML = msg[i][4];
            }else if (j==5) {
                td1.innerHTML = msg[i][5];
            }else if (j==6) {
                td1.innerHTML = msg[i][6];
            }else if (j==7) {
                td1.innerHTML = msg[i][7];
            }else if (j==8) {
                td1.innerHTML = msg[i][8];
            }else if (j==9) {
                td1.innerHTML = msg[i][9];
            }else if (j==10) {
                td1.innerHTML = msg[i][10];
            }else if (j==11) {
                td1.innerHTML = msg[i][12];
            }
            tr.appendChild(td1);

        }



	 if( (i+1)%2==0){
         tr.style.backgroundColor="#FFF";
     }else{
         tr.style.backgroundColor="#CCC";
     }

        tb.appendChild(tr);
	}

	//console.log(mck);

}

function take_check(){//flag2//输入功能的实现
	var flag="2";
	var tpr=$('#select').val();
	var bgtime=$('#bgtime').val();
	var edtime=$('#edtime').val();
	let open='';
    if($('#copen').is(':checked')){
        //console.log($('#copen').val());
         open = $('#copen').val();
    }else{
         open = null;
    }
    //console.log(open);

	if(tpr==""||tpr==null){
		alert("please chose tpr");
		return;
	}
	$.ajax({
		type:'post',
		url:'../../server/servlet/check_fail_log/search_server.php',
		dataType:'json',
		data:{flag:flag,tpr:tpr,bgtime:bgtime,edtime:edtime,open:open},
		beforeSend:function(msg){
			//等待提示
			//$("#search").attr("disabled", true);
		},
		success:function(msg){
			$('#t_data tr:not(:first)').remove();
			document.getElementById('f_data').style.display="none";
			console.log(msg);
			if(msg.length==1){
				//alert("no data");
				var tb=document.getElementById('t_data');
				tb.style.visibility="visible";
				$('#t_data tr:not(:first)').remove();
				var tr=document.createElement("tr");
				var td=document.createElement("td");
				tr.appendChild(td);

				td.setAttribute("colspan","14");
				td.style.backgroundColor="#008800";
				td.style.color="#FFF";
				td.style.fontSize="20px";
				td.innerHTML='No Fail DATA';
				tb.style.border="none";
				td.style.border="none";
				tb.appendChild(tr);
				}
				else{
				var tb=document.getElementById('t_data');
				tb.style.visibility="visible";
				var no=1;
				//alert(msg[2][3]);
				for(var i=1;i<=msg.length-1;i++){
					var tr=document.createElement("tr");
					//console.log(msg[i].length);

					for(var x=0;x<=msg[i].length-2;x++){
					var td=document.createElement("td");


					 if(x==0){
							td.innerHTML=no;
						}else if(x==1){
							var a=document.createElement("a");
							a.innerHTML=msg[i][x-1];
                            // tpr +ppid+ QC3+ tpr-er+compal-er +fail item +before time 
							a.setAttribute("href","check_owner.html?"+msg[0]+"&line"+msg[i][0]+"&line"+msg[i][2]+"&line"+msg[i][9]+"&line"+msg[i][8]+"&line"+msg[i][3]+"&line"+msg[i][4]+"&line"+msg[i][1]);
							a.target = '_blank';
							td.appendChild(a);
						}
						else if(x==2||x==3||x==4){
							td.innerHTML=msg[i][x-1];
						}
						else if(x==5||x==6){
							 td.innerHTML=msg[i][x];

						}
						

						else if(x==9||x==10||x==11){
							var text=document.createElement("textarea");
							text.innerHTML=msg[i][x+1];
							text.setAttribute("rows","3");
							text.setAttribute("cols","20");
							text.setAttribute("readonly","readonly");
							text.style.resize="none";

							td.appendChild(text);
						}
						else if(x==13){
							continue;
						}

						
						
						else{
                         td.innerHTML=msg[i][x+1];
                     }
						tr.appendChild(td);
                        //tr.appendChild(cktd);



					}

					if(no%2==0){
						tr.style.backgroundColor="#FFF";
						}else{
							tr.style.backgroundColor="#CCC";
							}
					tb.appendChild(tr);
					no++;

				}

			}
			//$("#search").attr("disabled", false);
		},
		error:function(msg){
			console.log(msg);
			//$("#search").attr("disabled", false);
		}
	})
}
function showck() {
    if($('input[type=checkbox]').css('display')== 'none'){
        $('input[type=checkbox]').css('display', 'block');
    }else{
        $('input[type=checkbox]').css('display', 'none');
    }

   /* $('input[type=checkbox]').css('display', 'block');
    $('#multiselect').click(function () {
        $('input[type=checkbox]').css('display', 'none');
    });*/


}
function Topagemk(){

    window.open("./multicheck.html");
}

function save(){
    //console.log(msg);

    var tpr=$('#select').val();
   // console.log(tpr);
   // console.log(1);
    let open='';
    if($('#copen').is(':checked')){
        //console.log($('#copen').val());
        open = $('#copen').val();
    }else{
        open = null;
    }
    if(open){
        if(tpr){
			//if($('#t_data').filter('tr').children('td')){
			 $("#t_data").table2excel({           
                exclude: ".noExl",
              
                name: tpr+' '+"Unchecked-FACA-Data" +' '+ new Date().format('Y-m-d'),
               
                filename: tpr+' '+"Unchecked-FACA-Data" + ' '+ new Date().format('Y-m-d') + ".xls",
                bootstrap: false
            });
			//}
            //console.log(1);
           
        }else{
            $("#f_data").table2excel({           
              
                exclude: ".noExl",
               
                name: "Unchecked-FACA-Data" +' '+ new Date().format('Y-m-d'),
                
                filename: "Unchecked-FACA-Data" + ' '+ new Date().format('Y-m-d') + ".xls",
                bootstrap: false
            });
        }

    }else{
        if(tpr){
			//if($('#t_data').filter('tr').children('td')){
			 $("#t_data").table2excel({            
                exclude: ".noExl",
               
                name: tpr+' '+"All-FACA-Data"+ ' '+new Date().format('Y-m-d'),
               
                filename: tpr+' '+"All-FACA-Data"+' '+ new Date().format('Y-m-d') + ".xls",
                bootstrap: false
            });
		//}
           
        }else{
            $("#f_data").table2excel({           
               
                exclude: ".noExl",
               
                name: "All-FACA-Data"+ ' '+new Date().format('Y-m-d'),
               
                filename: "All-FACA-Data"+' '+ new Date().format('Y-m-d') + ".xls",
                bootstrap: false
            });
        }

    }


}

</script>

</head>

<body onload="load()">
<div id="header-wrap">
    <header>
        <hgroup>
            <h1><a href="../../../index.php">Compal</a></h1>
            <h3>Just Another Styleshout Template</h3>
        </hgroup>
        <nav>
            <div >
                <ul id="dh">
                    <li><a href="../../../index.php">Home</a></li>
                    <li><a href="../../../total_system_sop.html">Services</a></li>
                    <li><a href="#portfolio">Our Works</a></li>
                    <li><a href="#about-us">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </div>
        </nav>

    </header>

</div>
<div id="title"><h3>TestLog Issue FACA</h3></div>
<div class="d_title">
<label class="marg" style='color:black' >TPR:</label>
<select id="select" name="select" class="marg1">
<option value="">Please Chose TPR</option>
<option value="IGS" >IGS</option>
<option value="RLC_SH" >RLC-SH</option>
<option value="CEP" >CEP</option>
<option value="CEB" >CEB</option>
<option value="Regenersis_INDIA" >ICC-RGS</option>
<option value="RLC_INDIA" >ICC-RLG</option>
<option value="CSAT" >CSAT</option>
<option value="TSI" >TSI</option>
<option value="CGS" >CGS</option>
</select>
<label style="margin-left: 10px;color:black">Begin time:</label>
<input type="text" id="bgtime" class="insearch" placeholder="chose begin time" style="width:105px;padding:2px 10px;border:1px solid #ccc;margin-left:20px;"/>
<label style="margin-left: 10px;color:black">End time:</label>
<input type="text" id="edtime" class="insearch" placeholder="chose end time" style="width:100px;padding:2px 10px;border:1px solid #ccc;margin-left:20px;"/>
<input type="checkbox" value="open" id="copen"  style="margin-left: 20px;margin-top: 10px;position: absolute"/><label style="margin-left: 40px;color:black">open</label>
<input id="search" class="btn" type="button" onclick="take_check()" value="search" />

<input id="multiselect" class="btn1" type="button" onclick="Topagemk()" value="multi-select" style="float: left"/>
<input id="multiselect" class="btn1p" type="button" onclick="save()" value="FailItem-To-Excel" style="float: left"/>

</div>
<div class="d_data" >
    <table id="t_data" align="center" cellspacing="0" style=" width:1300px">
        <tr style="background-color:#F4987F;" id="tr_1">
            <td width="34" class="td_color">No</td>
            <td width="49" class="td_color">PPID</td>
            <td width="90" class="td_color">Time</td>
            <td width="56" class="td_color">Station</td>
            <td width="71" class="td_color">Fail_Item</td>
            <td width="71" class="td_color">Model</td>
            <td width="120" class="td_color">Correct</td>
            <td width="77" class="td_color">TPR Owner</td>
            <td width="77" class="td_color">Compal Owner</td>
            <td width="93" class="td1_color">TPR_FA</td>
            <td width="87" class="td1_color">Action</td>
            <td width="121" class="td1_color">Compal_Check</td>
            <td width="90" class="td1_color" >Update Time</td>

        </tr>
    </table>
<table id="f_data" align="center" cellspacing="0" style="table-layout: fixed;width: 1310px;margin: 0 auto">
<tr style="background-color:#F4987F;" id="fr_1">
<td width="46px" class="td_color" id="tpr">NO</td>
<td width="66px" class="td_color">TPR</td>
<td width="81px" class="td_color">Model</td>
<td width="150px" class="td_color">PPID</td>
<td width="44px" class="td_color">Station</td>
<td width="82px" class="td_color">Fail</td>
<td width="82px" class="td_color">Fdetail</td>
<td width="77px" class="td_color">Time</td>
<td width="117px" class="td_color">Correct</td>
<td width="79px" class="td_color">TPR Owner</td>
<td width="79px" class="td_color">Compal Owner</td>
<td width="125px" class="td1_color">TPR_FA</td>
<td width="125px" class="td1_color">Action</td>
<td width="90px" class="td1_color">Check Time</td>

</tr>
</table>
    <div id="load" style='width:62px;height:62px;margin-left:auto;margin-right:auto;margin-top:55px' >

    </div>
</div>
</body>
</html>
