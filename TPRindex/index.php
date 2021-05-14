<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compal TPR Management System</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" />
    <link rel="stylesheet" href="css/hint.css" type="text/css" />

    <!--[if lt IE 9]>
    <script src="./js/html5.js"></script>
    <![endif]-->

    <script src="./js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.6.1.min.js"><\/script>')</script>

    <script src="js/jquery.nivo.slider.pack.js"></script>
    <script src="js/jquery.easing-1.3.pack.js"></script>
    <script src="js/jquery.fancybox-1.3.4.pack.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TPR Management System</title>
<script type="text/javascript" src="./jquery.min.js"></script>
<link href="imgbubbles.css" rel="stylesheet" type="text/css" />
<link href="./css/indexcss.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="imgbubbles.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('ul#orbs').imgbubbles({factor:1.2}); //add bubbles effect to UL id="orbs"
	$('ul#orbs1').imgbubbles({factor:1.2}); //add bubbles effect to UL id="orbs"
	$('ul#squares').imgbubbles({factor:2.5,speed:1500}); //add bubbles effect to UL id="squares"
    // $('#imgtest').mouseenter(function(){
    //     $("#shownum").css('display','block');
    //     $("#shownum").animate({width:'87px'},450);
    // });
    // $("#imgtest").mouseleave(function(){
    //     $("#shownum").animate({width:'0px'},450);
    //     $("#shownum").css('display','none');
    // });


});

function getsomedata() {
    let flagno = 'facaecobios';
    let flagdelay = 'judgedelay';
    let tipg = 'green(No pending events) orange(pending events have not delay) red(pending events has been delayed)';
    let tipn = 'total of pending event';
    let imgurl ='./images/';
    let gimg = 'Status-green.png';
    let oimg = 'Status-orange.png';
    let rimg = 'Status-red.png';
    $.ajax({
        type:'post',
        dataType:'json',
        url:'../Report/newindexphp/return_index_data.php',
        data:{flag:flagno},

        success:function (msg) {
            console.log(msg);


            for(let i=0;i<msg.length;i++){
                if(msg[i]['tpr']=='CGS'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                       $('#facacgs').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facacgs').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cgsb').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cgsb').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cgse').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cgse').append(html);
                    }


                }else if(msg[i]['tpr']=='RLC_SH'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facarlc_sh').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facarlc_sh').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#rlc_shb').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#rlc_shb').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#rlc_she').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#rlc_she').append(html);
                    }

                }else if(msg[i]['tpr']=='CEP'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facacep').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facacep').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        console.log(msg[i]['biosno']);
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cepb').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cepb').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cepe').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cepe').append(html);
                    }
                }else if(msg[i]['tpr']=='TSI'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facatsi').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facatsi').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#tsib').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#tsib').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#tsie').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#tsie').append(html);
                    }
                }else if(msg[i]['tpr']=='IGS'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facaigs').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facaigs').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#igsb').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#igsb').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#igse').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#igse').append(html);
                    }
                }else if(msg[i]['tpr']=='CEB'){
                    if(msg[i]['facano']!=null){
                        let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facaceb').append(html);
                    }else{
                        msg[i]['facano'] = 0;
                        let html= "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#facaceb').append(html);
                    }
                    if(msg[i]['biosno']!=null){
                        let html = "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cebb').append(html);
                    }else{
                        msg[i]['biosno'] = 0;
                        let html= "<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cebb').append(html);
                    }
                    if(msg[i]['econo']!=null){
                        let html = "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cebe').append(html);
                    }else{
                        msg[i]['econo'] = 0;
                        let html= "<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                        $('#cebe').append(html);
                    }
                }
               /* if(msg[i]['facano'] >0){
                    let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                    if($('.circledivtestlog').eq(i).children().length<=0){
                        $('.circledivtestlog').eq(i).append(html);
                    }
                }
                else{
                    let html = "<a href='../Report/html/TestLog_Na/TestLog_FACA.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['facano']+':'+tipn+" ' ><img  src='"+imgurl+gimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                    if($('.circledivtestlog').eq(i).children().length<=0){
                        $('.circledivtestlog').eq(i).append(html);
                    }
                }
                if(msg[i]['biosno']== null ||msg[i]['biosno']== '' ){
                    msg[i]['biosno']=0;
                    let html ="<a href='../Report/web/BIOS_System/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['biosno']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                    if($('.circledivbios').eq(i).children().length<=0){
                        $('.circledivbios').eq(i).append(html);
                    }
                }
                if(msg[i]['econo']== null ||msg[i]['econo']== '' ){
                    msg[i]['econo']=0;
                    let html ="<a href='../Report/web/ECO_system/Show.html ' style='white-space: ' class='hint hint--top' data-hint='"+tipg+"\n"+msg[i]['econo']+':'+tipn+" ' ><img  src='"+imgurl+oimg+"' style='width: 55px;height: 55px' alt='' ></a>";
                    if($('.circlediveco').eq(i).children().length<=0){
                        $('.circlediveco').eq(i).append(html);
                    }
                }*/
            }
        },
        error:function(msg){
            console.log(msg);
        }

    });
    $.ajax({
            type:'post',
            dataType: 'json',
            url:'../Report/newindexphp/return_bios_status.php',
        data:{flag:flagdelay},
        success:function(msg){
          console.log(msg);
          let biosarr =  [];
          let bioscount = 0;
          for(let i = 0;i<msg.length;i++){
            if(msg[i]['2_Status']==5||msg[i]['3_Status']==5||msg[i]['4_Status']==5||msg[i]['5_Status']==5){
                console.log(msg[i]['TPR']);

            }
        }

        },
        error:function (msg) {
            console.log(msg)
        }

    });
    $.ajax({
        type:'post',
        dataType: 'json',
        url:'../Report/newindexphp/return_eco_status.php',
        data:{flag:flagdelay},
        success:function(msg){
            console.log(msg);

        },
        error:function (msg) {
            console.log(msg)
        }

    })


}


</script>

</head>

<body onload="getsomedata()">

<!-- header-wrap -->
<div id="header-wrap">
<header>
  <hgroup>
    <h1><a href="index.html">Compal</a></h1>
    <h3>Just Another Styleshout Template</h3>
  </hgroup>
  <nav>
        <div >
              <ul>
                <li><a href="#main">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Our Works</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="#styles">Styles</a></li>
                <li><a href="#contact">Contact Us</a></li>
              </ul>
      </div>
    </nav>

  </header>
 <div align="center">

 </div>
</div>
<div style="width: 850px;height: 500px;margin: 0 auto">
<h4 align="center" style="margin-top: 130px">WWW Repair Center Real-Time Status </h4>
<div style="width: 760px;height: 130px;margin:0 auto;">
  <ul id="orbs" class="bubblewrap"  >
<li style="margin-left: 25px"><a href="#"><img src="CGS.png" alt=""  /></a></li>
<li style="margin-left: 59px"><a href="#"><img src="RLC-SH.png" alt="" ></a></li>
<li style="margin-left: 59px"><a href="#"><img src="CEP.png" alt="" ></a></li>
<li style="margin-left: 59px"><a href="#"><img src="TSI.png" alt="" ></a></li>
<li style="margin-left: 59px"><a href="#"><img src="IGS.png" alt="" ></a></li>
<li style="margin-left: 59px"><a href="#"><img src="Bizcom.png" alt="" /></a></li>
</ul>
</div>
        <table  id="eee"  style="margin-left: auto;margin-right: auto;margin-top: -56px;position: relative;table-layout: fixed;width: 740px;height:362px" >

            <div class="circledivtestlog" style="margin-left:88px;margin-top: -48px" id="facacgs">

            </div>


           <!-- <div id="shownum" class="showno" >
                <p><span  style="font-size: 12px">To be done：666</span></p>
            </div>-->

            <div class="circledivtestlog" style="margin-left:211px;margin-top: -48px" id="facarlc_sh">

            </div>
            <div class="circledivtestlog" style="margin-left:335px;margin-top: -48px" id="facacep">

            </div>
            <div class="circledivtestlog" style="margin-left:458px;margin-top: -48px" id="facatsi">

            </div>
            <div class="circledivtestlog" style="margin-left:581px;margin-top: -48px" id="facaigs">

            </div>
            <div class="circledivtestlog" style="margin-left:704px;margin-top: -48px" id="facaceb">

            </div>



            <div class="circledivprogram" style="margin-left:88px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html" class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivprogram" style="margin-left:211px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html " class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivprogram" style="margin-left:335px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html " class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivprogram" style="margin-left:458px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html " class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivprogram" style="margin-left:581px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html " class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivprogram" style="margin-left:704px;margin-top: 170px">
                <a href="../Report/web/NPI_System/Show.html " class="hint hint--top" data-hint="Coming soon">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>



            <div class="circledivqualityreport" style="margin-left:88px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivqualityreport" style="margin-left:211px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivqualityreport" style="margin-left:335px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivqualityreport" style="margin-left:458px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivqualityreport" style="margin-left:581px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>
            <div class="circledivqualityreport" style="margin-left:704px;margin-top: 242px">
                <a href="../Report/html/Search_Report/search_VFIR.html " class="hint hint--top" data-hint="FACA TO DO:XXX">
                    <img id="imgtest" src="./images/Status-green.png" style="width: 55px;height: 55px" alt="" >
                </a>
            </div>



            <div class="circledivbios" style="margin-left:88px;margin-top: 24px" id="cgsb">

            </div>
            <div class="circledivbios" style="margin-left:211px;margin-top: 24px" id="rlc_shb">

            </div>
            <div class="circledivbios" style="margin-left:335px;margin-top: 24px" id="cepb">

            </div>
            <div class="circledivbios" style="margin-left:458px;margin-top: 24px" id="tsib">

            </div>
            <div class="circledivbios" style="margin-left:581px;margin-top: 24px" id="igsb">

            </div>
            <div class="circledivbios" style="margin-left:704px;margin-top: 24px" id="cebb">

            </div>



            <div class="circlediveco" style="margin-left:88px;margin-top: 96px" id="cgse">

            </div>
            <div class="circlediveco" style="margin-left:211px;margin-top: 96px" id="rlc_she">

            </div>
            <div class="circlediveco" style="margin-left:335px;margin-top: 96px" id="cepe">

            </div>
            <div class="circlediveco" style="margin-left:458px;margin-top: 96px" id="tsie">

            </div>
            <div class="circlediveco" style="margin-left:581px;margin-top: 96px" id="igse">

            </div>
            <div class="circlediveco" style="margin-left:704px;margin-top: 96px" id="cebe">

            </div>







            <tr>
<!--                <td><img src="十字架虛線.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>-->
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06" /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06" /></td>
            </tr>
            <tr>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06" /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
            </tr>
            <tr>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"   ></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"   ></td>
            </tr>
            <tr>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"   ></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"   class="YS06"   /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"   /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"    /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"   class="YS06"   /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"    /></td>
            </tr>
            <tr>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"   /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"  /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"   /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70" class="YS06"    /></td>
                <td><img src="./images/十字架虛線1.png" alt="shizijiaxuxian" width="126" height="70"  class="YS06"   /></td>
            </tr>
        </table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style="height: 340px;width: 30px;margin-top:-468px;margin-left: -26px" id="case"  >
<ul id="orbs1" class="bubblewrap" style="width: 50px;">
<li style="margin-top: -6px;"><a href="#"><img alt="" src="Testlog.png"></a></li>

<li style="margin-top: 3px"><a href="#"><img alt src="BIOS.png"></a></li>

<li style="margin-top: 4px"><a href="#"><img alt="" src="ECO.png" ></a></li>

<li style="margin-top: 5px"><a href="#"><img alt="" src="Program.png" ></a></li>

<li style="margin-top: 6px"><a href="#"><img alt="" src="Q-Report.png" ></a></li>
</ul>
</div>
</div>

<!-- content-wrap -->
<div class="content-wrap">

    <!-- main -->
  <section id="main">
    <div class="primary">

        <div class="row no-bottom-margin"></div>
        

    </div>
  </section>
  <section id="about-us" class="clearfix">
 
      <h1>About us.</h1>

      <div class="primary">

                <p class="intro">Maecenas eu neque erat, auctor feugiat enim. Sed libero risus, pretium vel
                elementum id, lacinia vel purus. Mauris semper, orci vitae aliquam vestibul,
                lorem nulla auctor nulla, gravida fermentum urna libero eget sapien. Quisque
                cursus, urna quis vestibulum egestas, nibh sem semper erat, a feugiat justo
                dolor eget libero. Quisque cursus, urna quis vestibulum egestas, nibh sem
                semper erat, a feugiat justo dolor eget libero
                </p>

                <h2>Template License</h2>

                <p>This work is released and licensed under the 
                Creative Commons Attribution 3.0 License</a>, which means that you are free to use and modify it for any
                personal or commercial purpose. All I ask is that you give me credit by including a link back to my
                website</a></p>

                <div class="row no-bottom-margin">

                    <section class="col first">

                        <h2>Our Process</h2>

                        <p>Nascetur augue hac platea enim, egestas pulvinar vut. Pulvinar cum, ac eu, tristie
                        acus duis in dictumst non integer! Elit, sed scelerisque odio tortor, sed platea dis? Quis
                        cursus parturient ac amet odio in? Nunc Amet urna scelerisque eu lectus placerat.</p>

                    </section>

                    <section class="col">

                        <h2>Our Approach</h2>

                        <p>Pellentesque magna mi, iaculis pharetra eu, fermentum ullamcorper nisi.
                        Integer fringilla magna ut quam vulputate erat. Pulvinar cum, ac eu augue ut sit amet
                        gravida lacinia, eros massa condimentum sem, a fermentum ligula lorem non.
                        Phasellus vulputate.</p>

                    </section>

                </div>

                <h2>Our Team</h2>

                <ul class="the-team">
                    <li class="odd">
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">Bruce_xu</a></p>
                        <p> Software   &amp; Test </p>
                    </li>
                    <li>
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">xxx_xxx</a></p>
                        <p>xxx_xxx</p>
                    </li>
                    <li class="odd">
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname">xxx_xxx</p>
                        <p>xxxx_xxx</p>
                    </li>
                    <li>
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">xxx_xxx</a></p>
                        <p>xxx_xxx</p>
                    </li>
                </ul>

      </div>

            <aside>

                    <h2>More about us</h2>

                    <p>Nascetur augue hac platea enim, egestas pulvinar vut. Pulvinar cum, ac eu, tristie
                    acus duis in dictumst non integer! Elit, sed scelerisque odio.</p>

                    <a href="#" class="download-btn">Download PDF</a>


                    <h2>Links</h2>


                    <ul class="link-list">
                        <li><a href="#" title="Site Templates">Themeforest</a></li>
                        <li><a href="#" title="Website Templates">4Templates</a></li>
                        <li><a href="#" title="Webhosting">Dreamhost</a></li>
                        <li><a href="#" title="Web Templates">Templatemonster</a></li>
                    </ul>


                    <h2>Testimonials</h2>

                    <div class="testimonials">
                        <blockquote>
                            <p>Donec sed odio dui. Nulla vitae elit libero, a pharetra augue.
                            Nullam id dolor id nibh ultricies vehicula ut id elit. </p>

                            <cite>&mdash; John Doe, XYZ Company</cite>
                        </blockquote>
                        <blockquote>
                            <p>Aenean lacinia bibendum nulla sed consectetur. Cras mattis
                            consectetur purus sit amet fermentum.</p>

                            <cite>&mdash; Jane Roe, ABC Corp</cite>
                        </blockquote>
                    </div>

            </aside>



            <a class="back-to-top" href="#main">Back to Top</a>

  </section>

      <!-- Styles -->
      <!-- contact -->
</div>

<!-- footer -->
<footer>
    <div class="footer-content">
        <ul class="footer-menu">
            <li><a href="#main">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#about-us">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <!-- <li class="rss-feed"><a href="#">RSS Feed</a></li> -->
        </ul>

        <p class="footer-text">&copy; Copyright &copy; 2020.Compal TPR Management System.Administrator:Bruce_xu.MB:+86 18936110464 32752.<a target="_blank" href="http://sc.chinaz.com/moban/"></a></p>
    </div>

</footer>

</body>
</html>
