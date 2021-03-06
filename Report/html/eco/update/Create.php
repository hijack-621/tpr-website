<?php
session_start();
$user = $_SESSION['uname'];

?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>ECO Create</title>

<style type="text/css">
    *{ padding: 0; margin:0}
input[type='checkbox']{
	margin-left:20px;
}
input[type='checkbox'] label{
	margin-left:10px;
}
#hidebox {
   	display:none;
    width:160px;
    height:56px;
    position: absolute;
    top:40%;
    left:40%;
    line-height:56px;
    color:#fff;
	padding-left:60px;
    font-size:15px;
    background: #000 url(../../../images/wait.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
}
.words-split label{
    display: inline-block;
    padding:0 20px 0 8px;
    position: relative;
    margin-top: 14px;
    margin-left: 14px;
}
.words-split label em{
    display:none;
    width: 16px;
    height: 100%;
    position: absolute;
    background: #f60;
    right: 0;top: 0;


}
.words-split label em:after{ content: "-"; color: #fff; font: bold 20px 'Microsoft Yahei';}
.words-split label:hover em{ display: block;}
label.words-split-add{display: inline-block;font: bold 20px 'Microsoft Yahei'; color: #2cac93}
.words-split{
    vertical-align: middle;
    height: 44px;
    display:table;
    margin-top: 42px;

}
label{
    text-decoration:none;
    color:#000;
}
.station-lb {
    display: inline-block;
    text-align: center;
    color: #fff;
    height: 28px;
    line-height: 28px;
    font-size: 16px;
    padding: 0 1em;
    border-radius: 3px;
    opacity: .9;
    filter: alpha(opacity=90);
    background:#2cac93;

}
.main-frame{
    display: flex;
    display: -webkit-flex;
    align-items: center;
    flex-direction: column;
    width: 600px;
    height: 550px;
    position: center;
    margin: 0 auto;
}
#table td tr{
    border-collapse:collapse;
    border-spacing:0;
    text-align: center;
    display: inline-block;

}
#td  div{
    text-align: center;
    margin: 0 auto;
}
tr td{
    vertical-align: middle;
}


.tag-by label{display: inline-block; padding:0 25px 0 8px; position: relative; margin:3px 4px; }
.d-down{display: inline-block; padding:0 5px 0 8px; position: relative; margin:3px 4px; }
.tag-by label em{display:none; width: 16px; height: 100%; position: absolute; background: #f60;right: 0;top: 0;}
.tag-by label em:after{ content: "x"; color: #fff; font: bold 20px 'Microsoft Yahei';}
.tag-by label:hover em{ display: block; }

</style>
<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="stylesheet" href="../../js/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../js/formSelects-v4.css"/>
    <link rel="stylesheet" type="text/css" href="../../js/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="../../js/bootstrap-select.css"/>
    <script src="../../js/popper.js"></script>
    <script src="../../js/jquery-3.2.1.js"></script>
    <script src="../../js/bootstrap-select.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/layui.all.js"></script>
    <script src="../../js/formSelects-v4.min.js" type="text/javascript" charset="utf-8"></script>
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
                                btn : [ 'sure', 'cancel' ],//??????

                            }, function(index1) {


                                layer.close(index1);


                                setTimeout(backlogin,1500);
                                // console.log('aaa');
                                //??????????????????????????????????????????????????????????????????
                                // var index = layer.load(0,{shade: [0.7, '#393D49']}, {shadeClose: true}); //0??????????????????????????????0-2

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
function show_dialog(){
	document.getElementById("hidebox").style.display="block";
}
function hidden_dialog(){
	document.getElementById("hidebox").style.display="none";
}
function load() {
    $(function () {
        loadParkdata();    //???????????????????????????????????????????????????option??????????????????select?????????
        //?????????????????????
        $(window).on('load', function () {
            $('.selectpicker').selectpicker('refresh');
        });
    });
    function loadParkdata() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "ECO_server.php",
            data: {flag: 'sh_model'},
            success: function (msg) {
                console.log(msg);
                let parkdata = [];
                if(msg.length > 0){
                    //console.log(1);
                     let html =  $("#st-model").html();
                    for(let i=0;i<msg.length;i++){
                        parkdata.push(msg[i][0]);
                        //console.log(parknames);

                    }
                    //console.log(parkdata.length);
                    //???????????????<option><option/>
                    for(let j = 0;j<parkdata.length;j++){
                        //console.log(j);
                        html +="<option value='"+parkdata[j]+"'>"+parkdata[j]+"</option>";
                        $("#st-model").append(html);
                    }
                    $("select").each(function(i,n){ //??????
                        let options = "";
                        $(n).find("option").each(function(j,m){
                            if(options.indexOf($(m)[0].outerHTML) == -1)
                            {
                                options += $(m)[0].outerHTML;
                            }
                        });
                        $(n).html(options);
                    });
                    //??????refresh????????????UI?????????????????????
                    $('#st-model').selectpicker('refresh');

                    //render???????????????????????????????????? - ??????ui???
                    $('#st-model').selectpicker('render');
                        //?????????select?????????
                }
            },

            error: function (msg) {
                console.log(msg);

            }
        })
    }
}
var ver_arr=new Array();
var ver_arr1=new Array();
function change_old(){
    //??????model???????????????????????????
	let model=document.getElementById('st-model').value;
	let modelmultiple = $('#st-model').find('option:selected');
	let contmodel = [];
	//let cmodel = [];
	for(let i=0;i<modelmultiple.length;i++){
	    contmodel.push(modelmultiple[i].value)
    }
    console.log(contmodel);
	//console.log(typeof contmodel );object
    /*for(let i=0;i<modelmultiple.length;i++){
        cmodel.push(modelmultiple[i].textContent)
    }
    console.log(cmodel);*/
	//console.log(modelmultiple);//????????????????????????
	//console.log(model);
	if(model==""||model==null){
		var selections=document.getElementById('st-oldeco');
		var DMselections=document.getElementById('st-DMname');
		selections.length=0;
		DMselections.length=0;
	}
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'sh_eco',contmodel:contmodel},
		success:function(msg){
			console.log(msg);
			//console.log(msg2);
			let selections=document.getElementById('st-oldeco');
            //???????????????????????????
			selections.length=0;
			if(msg!=""||msg!=null){
                for(let i= 0;i<msg.length;i++){
                    let option = document.createElement("option");
                    option.value = msg[i]['Model']+':'+msg[i]['eco'];
                    option.text =msg[i]['Model']+':'+msg[i]['eco'];
                    selections.options.add(option);
                }



				ver_arr=msg;
			}

		},
		error:function(msg){
			console.log(msg);

		}
	});
    $.ajax({
        type:'post',
        dataType:'json',
        url:'ECO_server.php',
        data:{flag:'sh_dmname',contmodel:contmodel },
        success:function (msg) {
            console.log(msg);
            var DMselections=document.getElementById('st-DMname');
            DMselections.length=0;
            if(msg!=""||msg!=null){
                for(let i = 0;i<msg.length;i++){
                    var DMoption = document.createElement('option');
                    DMoption.value = msg[i];
                    DMoption.text = msg[i];
                    DMselections.options.add(DMoption);
                }

            }
            ver_arr1 = msg;

        },
        error:function (msg) {
            console.log(msg);
        }
    })
}
/*function submit(){
	var model=$('#st-model').val();
	//console.log(model[0]);

	$.ajax({
		type:"post",
		dataType:"json",
		url:"ECO_server.php",
		data:{flag:"Find_model",model:model},
		success:function(msg){
			console.log(msg);
			if(msg[0]==1111){
				//continue_create();
				var mod="";
				if(msg[1].length==0){
					//alert("success");
					continue_create();
				}else{
					for(var i=0;i<msg[1].length;i++){
						 mod+=msg[1][i]+"-";
					}
					alert("success  "+mod+"is null ");
					continue_create();
				}
			}else if(msg[0]==1041){
				alert("model is null");
			}
		},
		error:function(msg){
			console.log(msg);
		}
	})
}*/
function submit(){
	var model=$('#st-model').val();
	var descript=$('#Activity').val();
	var econo=$('#Eco-no').val();
	let tprcheck=document.getElementsByName('checkbox');
	let flag=document.getElementsByName('checkbox2');
	//console.log(flag);
    let rvalue = '';
    for(let x = 0;x<flag.length;x++){
        if(flag[x].checked){
            rvalue =flag[x].value
        }
    }
   //console.log(rvalue);
	let ecomaterials = document.getElementById('lb').getElementsByTagName('label');
	//console.log(ecomaterials);
    let matarr = new Array();
    //var len = $("input[type='checkbox']:checked").length//?????????checkbox????????????????????????
    //console.log(len);
	let checkarr=new Array();

    /*for(k in tprcheck){
        if(tprcheck[k].checked){
            checkdata.push(tprcheck[k].value);//???checkbox??????????????????????????????
        }

    }*/
	let x1=0;
	let y=0;
	for(let i=0;i<tprcheck.length;i++){
		if(tprcheck[i].checked){
			checkarr[x1]=tprcheck[i].value;
			x1++;
		}
	}
    for(let j=0;j<ecomaterials.length;j++){
        if(ecomaterials[j].innerHTML){
            matarr[y]=ecomaterials[j].innerText;
            y++;
        }
    }
	let checkdata=checkarr.join(",");
    let newcomp = matarr.join(',');//??????
   // console.log(newcomp);
	//console.log(checkdata);//??????inform tpr???????????????????????? IGS,CEP,RLC_INDIA,Regenersis_INDIA,????????????
	var obj_pro={

			model:model,
			descript:descript,
			newcomp:newcomp,
			econo:econo,
			checkdata:checkdata,
            rvalue:rvalue,

	};
	for(var x in obj_pro){
        //??????????????????????????????????????????xx is null
		if(obj_pro[x]==null||obj_pro[x]==""){
			alert(x+" is null");
			return;
		}
	}
	//obj_pro.newsys=newsys;
	$.ajax({
		type:"post",
		dataType:"json",
		url:"ECO_server.php",
		data:{flag:"Create",obj_pro:obj_pro},
		success:function(msg){
			console.log(msg);
			if(msg[0]==1111){
                //console.log(msg[1]);//????????????????????????model
				//Send_Mail(msg[1]);
                //alert('????????????????????????????????????ECO??????');
                //setTimeout(jump,3000);
			}else if(msg[0]=1040){
				alert("fail");
			}else if(msg[0]==1041){
				alert("Matrix table model is null");
			}else if(msg[0]==1043){
				alert("already add data")
			}
		},
		error:function(msg){
			console.log(msg);
		}
	})
}

function Send_Mail(msg){
	//var tpr=new Array("CGS");//??????????????????cgs?????????
    var choosetpr = document.getElementsByName('checkbox');
    var tpr = new Array();
    var i = 0;
    for(var j=0;j<choosetpr.length;j++ ){
        if(choosetpr[j].checked){
            tpr[i] = choosetpr[j].value;
            i++;
        }
    }
    console.log(tpr);
	$.ajax({
		type:'post',
		dataType:'json',
		url:"ECO_server.php",
		data:{flag:'Send_mail',mrk:'cr',tpr:tpr,msg:msg},
		success:function(msg){
			console.log(msg);

			if(msg==1){
				alert("create success,click and jump windows")
				window.open("Show.html","_blank");
			}else if(msg==0){
				alert("send mail fail");
			}
		},
		error:function(msg){
			console.log(msg);
		}
		})
}

function add_model(){
	window.open("Add_ECO.html","");
}
function jump() {

    window.location.href='Show.html';}

</script>
<style type="text/css">
body {
	background-image: url(../../../images/beijin.jpg);
}
</style>
</head>

<body onLoad="load()">
<nav class="nav" style="margin-left:30px;">
    <ul class="nav nav-tabs" style="border: none">
        <li class="nav-item">
            <a class="nav-link active" style="background-color:#CC6633" href="Show.php">home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="tips.html" style="background-color:#CC6633">[???????????????]</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="tipseng.html" style="background-color:#CC6633">[some tips]</a>
        </li>
    </ul>
</nav>

<div id="hidebox" onClick="hide();" class="loading">Send mail</div>

<div class="main-frame">

    <div class="col-11" style="text-align:center;width: 1000px;height: 550px;">
        <table class="table table-bordered" style=" margin-top:15px;margin-right: auto;margin-left: auto; height:100%;text-align:center;background-color:#FFF;width:1000px;word-break: keep-all;font-size: 14px;table-layout: fixed;border-collapse: collapse;border-spacing: 0">
            <tbody>
            <tr style="text-align: center;height: 60px" >
                <td style="width:250px;text-align: center;vertical-align: middle" colspan="1"><span style="text-align: center">Model</span></td>
                <td colspan="2"  style="text-align: center;vertical-align: middle">
                    <div class="row" >
                        <div class="col col-md-4" >
                            <select id="st-model" name="st-model"  onchange="change_old()" class="selectpicker form-control"  multiple="multiple"   data-live-search="false" title="please choose Model" style="margin-left: -205px;height: 26px;">

                            </select>
                        </div>
                        <div class="col col-md-4" >
                            <select id="st-DMname"   class="form-control" style="width:235px;margin-left: 45px;">
                                <option value="">DELL Market name</option>
                            </select>
                        </div>
                        <div class="col col-md-4">
                            <button type="button" onClick="add_model()" class="btn btn-secondary" style="margin-left:20px">Add Model</button>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="height: 60px">
                <td style="vertical-align: middle"><span>Description:</span></td>
                <td style="text-align: center;vertical-align: middle"><input type="text" id="Activity" style="border:none;border-bottom:1px solid #000;width:254px;margin-left: 0px"></td>
                <td width="50" style="text-align: center;vertical-align: middle"><input type="radio" value="FW" name="checkbox2">
                  FW
                  </input>
                <input type="radio" value="HW" name="checkbox2">
                    HW
                </input></td>
            </tr>
            <tr style="height: 80px">
                <td style="text-align: center;">

                    <div style="display: -webkit-flex;display: flex;flex-direction: row">
                        <div class="col col-md-3" style="margin-left: -20px;margin-top: 45px">
                            Last_ECO
                        </div>
                        <div class="col col-md-3" >
                            <select id="st-oldeco" name="st-oldeco" class="form-control" style="width:175px;margin-left: 8px;margin-top: 40px" ></select>
                        </div>
                    </div>

                </td>

                <td colspan="2" style="text-align: center;vertical-align: middle">
                    <div style="margin-left:363px;position: absolute">
                    <input type="text" id="Location" style="border:none;margin-left:-271px;position: absolute;border-bottom:1px solid #000;width:127px;float: left;margin-top: 33px" placeholder="location"/>
                    <input type="text" id="New-comp" style="border:none;margin-left:-111px;;position: absolute;border-bottom:1px solid #000;width:147px;float: left;margin-top: 33px" placeholder="input eco-materials">
                    <button type="button" class="btn btn-secondary" style="width: 230px;margin-left:55px;position: absolute;margin-top: 21px " id="add-station">Add ECO-materials</button>
                    </div>
                        <input type="text" name="staticPath" id="staticstation" style="margin-left: 266px;" />

                </td>
            </tr>
            <tr style="height: 60px">
                <td><span >ECO Number:</span></td>
                <td height="30px" colspan="2" style="vertical-align: bottom">
                    <input type="text" id="Eco-no" style="border:none;border-bottom:1px solid #000;width:254px;margin-left: -300px"/>

                </td>
            </tr>
            <tr style="height:50px">
                <td colspan="3">
                    <h4>Infrom TPR</h4>
                </td>
            </tr>
            <tr style="height: 75px">
                <td colspan="3">
                    <div class="col">
                        <div>
                            <input type="checkbox" value="CGS" disabled=disabled  name="checkbox">CGS</input><input type="checkbox" value="RLC_SH" name="checkbox">RLC-SH</input><input type="checkbox" value="IGS" name="checkbox">IGS</input><input type="checkbox" value="CEP" name="checkbox">CEP</input>
                        </div>
                        <div>
                            <input type="checkbox" value="CSAT" name="checkbox">CSAT</input><input type="checkbox" value="CEB" name="checkbox">CEB</input><input type="checkbox" value="RLC_INDIA" name="checkbox">RLC-INDIA</input><input type="checkbox" value="Regenersis_INDIA" name="checkbox">Regenersis-INDIA</input><input type="checkbox" value="TSI"   name="checkbox">TSI</input>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="height: 45px">
                <td colspan="3" style="vertical-align: middle">
                    <button type="button" class="btn btn-primary" onClick="submit()">sure</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
<script type="text/javascript">
    var ST=function (opt){
        var el=$(opt.el),
            holder = $('<span class="words-split" id="lb"></span>'),
            add=$('#add-station');
        //show=$('#sh_model');
        el.hide().after( holder );


        holder.on('click','label>em',function(){	//??????
            let l=$(this).parent().text().replace(" ", "");
            console.log(l);
            //document.getElementById(l+'-td').value="";
            //document.getElementById(l+'-td').setAttribute("disabled","disabled");
            $(this).parent().remove();
            if (holder.text()!="") {
                el.val(holder.text().match(/\S+/g).join(','));
            }

        });
        add.on('click',function(){
            let v = $("#New-comp").val();
            let LO = $('#Location').val();
            console.log(v);
           /* if($('#staticstation').val().indexOf(v)!==-1){
                alert("already add");
                return;
            }else{*/
                holder.append( $('<label class="station-lb" name="n-model">'+LO+':'+v+'<em></em></label>') );
                el.val( holder.text().match(/\S+/g).join(',') );
                $("#New-comp").val(' ');
                $('#Location').val(' ');
                //document.getElementById(v+'-td').disabled=false;
                    //let tdone =document.getElementById('tdone');
                    //tdone.style.whiteSpace = 'normal';


                /*let a = document.getElementById(v+'-td')
                console.log(a);*/
            //}
        });
    }
    ST({el:'#staticstation'});
</script>
</html>
