<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register user</title>
<link type="text/css" rel="stylesheet" href="css/login.css">
<script type="text/javascript" src="./layui/layui.all.js"></script>
<script type="text/javascript" src="./layui/lay/modules/layer.js"></script>
<link rel="stylesheet" type="text/css" href="./layui/css/layui.css" />
<link rel="stylesheet" type="text/css" href="./layui/css/modules/layer/default/layer.css" />
<style type="text/css">
body {
	background: #CCCCFF;
	background: url(images/1.jpg);
}
</style>
<link rel="shortcut icon" href="./images/logo.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript">
function loginint(){
	document.getElementById('switch_a').style.backgroundColor="#0099cc";
	document.getElementById('switch_b').style.backgroundColor="#FFFFFF";
	var lg_btn=document.getElementById('login_int');
	var rg_btn=document.getElementById('register_int');

	lg_btn.style.display="block";
		rg_btn.style.display="none";
}
function useradd(){
	document.getElementById('switch_a').style.backgroundColor="#FFFFFF";
	document.getElementById('switch_b').style.backgroundColor="#0099cc";
    document.getElementById('addLogin').style.backgroundColor = '#485575';
	var lg_btn=document.getElementById('login_int');
	var rg_btn=document.getElementById('register_int');

		lg_btn.style.display="none";
		rg_btn.style.display="block";

}

$(function (){
     let ck = document.cookie;

    console.log(ck);
     //let sid = ck[1].split('=')[1];
   // console.log(ck[1].split('=')[1]);
	$('#Login_b').click(function(){
		var uname=$('#user_n').val();
		var pword=$('#user_p').val();
		if(uname==null||uname==''){
			alert("no username");
		}
        if (pword == null || pword == '') {
                alert("no password");
            }
            else {
                $.ajax({
                    type: "post",
                    url: "Report/server/rg_lg/login_server.php",
                    data: {uname: uname, pword: pword},
                    dataType: "json",
                    success: function (msg) {
                        console.log(msg);
                        if (msg== 1) {
                            layui.use('layer',function(){
                               let layer2=layui.layer;
                                layer2.msg('Login Success !',{
                                    icon:6
                                });
                            });
                            setTimeout(jump0,2000);
                        } else if (msg == 0) {
                            layui.use('layer',function(){
                                let      layer2=layui.layer;
                                layer2.msg('Sorry,password or username error',{
                                    icon:5
                                });
                            });
                            //  window.location.href='old_index.php';
                        }else if (msg == 3 ) {
                            layui.use('layer',function(){
                                let   layer2=layui.layer;
                                layer2.msg('Login Success !',{
                                    icon:6
                                });
                            });
                            setTimeout(jump2,2000);
                        }
                    },
                    error: function (msg) {
                        console.log(msg);
                        alert("login error");
                    }
                })
            }


	})
});
$(function (){
    $('#addLogin').click(function(){
        var username=$('#register_n').val();
        var password=$('#register_p').val();
        if(username==null||username==''){
            alert("no username");

        }else if(password==null||password==''){
                alert("no password");
        }else{
            $.ajax({
                type: "post",
                url: "Report/server/rg_lg/useradd.php",
                data: {username: username, password: password},
                dataType: "json",
                success: function (msg) {
                    console.log(msg);
                    if (msg.length == 0) {
                        alert(" username or password error");
                    }else {
                        layui.use('layer',function(){
                            layer2=layui.layer;
                            layer2.msg('login Success',{
                                icon:6
                            });
                        });
                        setTimeout(jump1,2000);
                    }
                        //  window.location.href='old_index.php';
                    // } else if (msg == 3) {
                    //     window.location.href = 'Report/application/temp_monitor/temp-monitor.html';
                    // }
                },
                error: function (msg) {
                    console.log(msg);
                    alert("login error");
                }
            })
        }


    })
});
function jump0() {

    window.location.href = 'index.php';}
function jump1() {

    window.location.href = './useraddindex.php';}
function jump2() {

    window.location.href = './Report/application/temp_monitor/temp-monitor.html';}

</script>
</head>
<body>
<h1 style="margin-top: 100px">
		Compal TPR Administrator System<sup>V2017</sup>
</h1>
	<div class="login_register" >
	<div class="header">
	<div class="switch" id="switch">
	<div class="switch_a" id="switch_a">
	<a class="switch_btn" id="switch_l" href="javascript:void(0)" tabindex="1" onclick="loginint()">Login</a>
	</div>
	<div class="switch_b" id="switch_b">
	<a class="switch_btn" id="switch_r" href="javascript:void(0)" tabindex="2" onclick="useradd()">User Add</a>
	</div>
	</div>

	</div>
	<!-- login -->
	<div class="login_int" id="login_int" >
	<div class="login_body">
	<div class="login_name">
	<lable class="un_t" for="u">User:</lable>
	<div class="un_input" >
	<input class="input_un" id="user_n" name="user_n"/>
	</div>
	</div>
	<div class="msg_input">
	<lable class="un_t" for="u">Pw:</lable>
	<div class="un_input" >
	<input class="input_un" id="user_p" name="user_p" type="password"/>
	</div>
	</div>
	<div class="sub_btn">
	<input type="button" value="Login" id="Login_b" class="sub_b" name="login_b" />
	</div>
	</div>
	</div>
	<!-- register -->
	<div class="register_int" id="register_int" >
	<div class="register_body">
	<div class="msg_inputi">
	<lable class="un_t" for="u">User :</lable>
	<div class="un_input" >
	<input class="input_un" id="register_n" name="register_n"/>
	</div>
	</div>
	<div class="msg_inputi">
	<lable class="un_t" for="u">Pw :</lable>
	<div class="un_input" >
	<input class="input_un" id="register_p" name="register_p" type="password"/>
	</div>
	</div>
        <div class="sub_btn">
            <input type="button" value="Login" id="addLogin" class="sub_b" name="addLogin" />
        </div>
	</div>
	</div>
</body>
</html>