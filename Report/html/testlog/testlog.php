<?php
session_start();
$user = $_SESSION['uname'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TestLog </title>
<style type="text/css">
body {
	background-image: url(../../../images/bg.png)!important;
	background-color: #03F;
}
.YS01 {
	width:266px!important;
	height:55px;
	line-height:55px;
}
.YS0 {
	color: black;
	font-weight: bold;
	font-size: 24px;
}
a:link {
	color: #FFF;
	text-decoration: none;
}
a:visited {
	color: #FFF;
	text-decoration: none;
}
a:hover {
	color: #000;
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style>
<link rel="stylesheet" href="../../../TPRindex/css/style.css" type="text/css" media="screen" />
<script type='text/javascript'>
 let stval = setInterval(singleUsing,700);
function singleUsing(){
	let location = window.location.search.substring(0);
	let location1 = '';
	if(location!=''){

	location1 = window.location.search.substring(0).split('?')[1];	
	
	}
	$('#param').children('a').removeAttr('href');
	$('#param').children('a').attr('href','../check_fail_log/check_log.php'+'?'+location1);

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
</script>
</head>
<script type='text/javascript' src='../../../js/jquery-3.2.1.js' ></script>
<script type='text/javascript' src='../../../../layui/layui.all.js' ></script>
<body>
<div id="header-wrap">
    <header>
        <hgroup>
            <h1><a href="../../../index.php">Comppal</a></h1>
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

<p align="center" class="YS0" style='margin-top:150px!important'>TPR TestLog<br>
</p>
<table width="802" border="0"  cellpadding="20" cellspacing="7" style='margin-top:70px!important;margin-left:auto!important;margin-right:auto!important;'>
  <tr style='color:white'>
    <td  align="center" valign="middle" bgcolor="#FF6633" class="YS01" id='param'><a href="../check_fail_log/check_log.php" style='color:white' >TestLog Fail FACA</a></td>
    <td  align="center" valign="middle" bgcolor="#CC9966" class="YS01"><a href="../../web/SearchPPID/Search_PPID.html" style='color:white' >Search PPID TestLog </a></td>
    <td  align="center" valign="middle" bgcolor="#9999FF" class="YS01"><a href="../Search_Save/SearchPPIDExcelOneMonthA.html" style='color:white' >TPR Test Report</a></td>
    <td  align="center" valign="middle" bgcolor="#0099CC" class="YS01"><a href="../Test_Report/TPR_Test_Report.html" style='color:white'>TPR Check Report</a></td>
  </tr>
</table>
</body>
</html>
