<?php
session_start();
$tpr = $_SESSION['utpr'];
$user = $_SESSION['uname'];
require_once './class.php/DAOMySQLi.class.php';
require_once './getDst.php';
$linkinfo = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'dbname' => 'compaluser',
    'port' => 3306,
];
$nowdata = date('Y-m-d');
$mysqli = DAOMySQLi::getSingleton($linkinfo);
$sql = "select DellWeek,FY from weekdate where date='$nowdata' " ;
$res = $mysqli->fetchAll($sql);
$_SESSION['week'] = $res[0]['DellWeek'];
$_SESSION['FY'] = $res[0]['FY'];
$usadst = isusaDst();
$_SESSION['usadst'] = $usadst;
$pdst = isusaDst();
$_SESSION['pdst'] = $pdst;
$mdst = isMEXDst();
$_SESSION['mdst'] = $mdst;
$BGtime = getBGtime();
$_SESSION['bgtime'] = $BGtime;
?>
<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]><html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]><html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Compal TPR Management System</title>

    <link rel="stylesheet" href="./TPRindex/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./TPRindex/css/nivo-slider.css" type="text/css" />
    <link rel="stylesheet" href="./TPRindex/css/jquery.fancybox-1.3.4.css" type="text/css" />
    <link rel="stylesheet" href="./TPRindex/css/hint.css" type="text/css" />
    <link rel="stylesheet" href="./TPRindex/css/hint1.css" type="text/css" />
    <link rel="stylesheet" href="./css/worldtime-time.css">


    <meta name="baidu_union_verify" content="b66f43225108b8008fc203260ee01ed8">
    <script type="text/javascript" src="./layui/layui.all.js"></script>
    <script type="text/javascript" src="./js/worldtime-clock.js"></script>
    <script type="text/javascript" src="./js/worldtime-direct.js"></script>
    <script type="text/javascript" src="./js/worldtime-style.js"></script>
    <script type="text/javascript" src="./js/worldtime-time.js"></script>
    <script type="text/javascript" src="./js/date.format.js"></script>
    <script type="text/javascript">var url=window.location.href;var uu=url.replace("www", "m");uaredirect(uu);</script>
    <!--[if lt IE 9]>
    <script src="./TPRindex/js/html5.js"></script>
    <![endif]-->

    <script src="./TPRindex/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="./TPRindex/js/jquery-1.6.1.min.js"><\/script>')</script>

    <script src="./TPRindex/js/jquery.nivo.slider.pack.js"></script>
    <script src="./TPRindex/js/jquery.easing-1.3.pack.js"></script>
    <script src="./TPRindex/js/jquery.fancybox-1.3.4.pack.js"></script>
    <script src="./js/date.format.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./images/logo.ico" type="image/x-icon">
    <title>TPR Management System</title>
    <script type="text/javascript" src="./TPRindex/jquery.min.js"></script>
    <link href="./TPRindex/imgbubbles.css" rel="stylesheet" type="text/css" />
    <link href="./TPRindex/css/indexcss1.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="./TPRindex/imgbubbles.js"></script>
    <script type="text/javascript">var url=window.location.href;var uu=url.replace("www", "m");uaredirect(uu);</script>
    <script type="text/javascript">
        $(document).ready(function(){
            let ltpr = '<?php echo $tpr;?>';

            if(ltpr=='Regenersis_INDIA'){
                ltpr='ICC-RGS';
            }else if(ltpr=='RLC_INDIA'){
                ltpr='ICC-RLG';
            }
            let user = '<?php echo $user;?>';
            if(user=='Regenersis_INDIAadmin'){
                user='RGSadmin';
            }else if(user=='RLC_INDIAadmin'){
                user='RLGadmin'
            }else if(user=='Bizcomadmin'){
                user='BMadmin'
            }
            let week = '<?php echo $_SESSION['week'];?>';
            let fy = '<?php echo $_SESSION['FY'];?>';
            let modules = ['testlog','bios','eco','program','report','npi'];
            let tpr = ['CGS','RLC_SH','CEP','TSI','IGS','CEB','ICC-RLG','CTDI','Bizcom'];//
            let html = '';
            let basedir = './TPRindex/images/tprimg/';
            let end = '.png';
            let tprsrc = '';
            let modulessrc = '';
            let mleft = '';
            let mtop = '';
            let mmtop = '';
            let stpr = '<?php echo $tpr;?>';
            let colorsrc = '';
            let baseasrc = 'Report/html/';
            if(stpr=='CGS'){
                colorsrc = './TPRindex/images/tprimg/green.png';
            }else{
                colorsrc = './TPRindex/images/tprimg/gray.png';
                // asrc = '#';
            }
            for(let i=0;i<modules.length;i++){ //modules

                for(let j=0;j<tpr.length;j++){
                    tprsrc = basedir+tpr[j]+end;
                    modulessrc =basedir+modules[i]+end;
                    if(stpr=='CGS'){
                        asrc =baseasrc+modules[i]+'/'+modules[i]+'.php'+'?'+tpr[j];
                    } else{
                        asrc = asrc =baseasrc+modules[i]+'/'+modules[i]+'.php'+'?'+stpr;
                    }

                    if(i==0){
                        if(j==0){ //

                            html = '<div style=\'width:200px;height:200px;position:absolute\'>\n' +
                                '        <div style=\'width:50%;height:50%;margin-left:50%;\'><a href="#"><img src="'+tprsrc+'" style=\'width:100px;padding-top:27px\'></img></a></div>\n' +
                                '        <div style=\'top:50%;width:50%;height:50%;padding-left:10px\'><img src="'+modulessrc+'" style=\'width:100px;\'></div>\n' +
                                '        <div style=\'margin-left:50%;margin-top:-50%;width:100px;display:flex;justify-content: center;align-items:center\'><img src="./TPRindex/images/tprimg/十字架虛線1.png" style=\'width:100px;height:75px;padding-top:10px\' alt="">\n' +
                                '            <div style=\'width:56px;height:56px;position:absolute;margin-left:-4px;\' name="'+tpr[j]+'"><a href="'+asrc+'" target="_blank"><img src="'+colorsrc+'" style=\'width:56px;height:56px\' alt=""></a></div>\n' +
                                '               <a href="'+asrc+'" target="_blank" style="width:56px;height:56px;display:block;line-height:50px;position:relative"><span class=\'nspan\'></span></a>\n' +
                                '        </div>\n' +
                                '       </div>';
                            $('#maindiv').append(html);
                        }else{
                            // asrc =baseasrc+modules[i]+'/'+modules[i]+'.php'+'?'+tpr[j];
                            if(j==1){
                                mleft = 205*j+'px';
                            }else{
                                mleft = 205+(105*(j-1))+'px';
                                mtop = -200*(1)+'px';
                            }

                            html = '<div style=\'width:100px;height:200px;margin-left:'+mleft+';margin-top:'+mtop+'\'>\n' +
                                '<div style=\'width:100%;height:50%;\'><a href="#"><img src="'+tprsrc+'" style=\'width:100px;padding-top:27px\'></img></a></div>\n' +
                                '<div style=\'width:100%;height:85px;display:flex;justify-content: center;align-items:center\'><img src="./TPRindex/images/tprimg/十字架虛線1.png" style=\'width:100px;height:75px;padding-top:10px\' alt="">\n' +
                                '<div style=\'width:56px;height:56px;position:absolute;margin-left:-4px;\' name="'+tpr[j]+'"><a href="'+asrc+'" target="_blank"><img src="'+colorsrc+'" style=\'width:56px;height:56px;\' alt=""></a></div>\n' +
                                '               <a href="'+asrc+'" target="_blank" style="width:56px;height:56px;display:block;line-height:50px"><span class=\'nspan\'></span></a>\n' +
                                '</div>\n' +
                                '</div>';
                            $('#maindiv').append(html);
                        }

                    }else{
                        mmtop = '-13px';
                        if(j==0){
                            html = '<div style=\'width:200px;height:100px;margin-top:'+mmtop+';position:relative\'>\n' +
                                '<div style=\'width:50%;height:100%;padding-left:10px;padding-bottom:2px\'><img src="'+modulessrc+'" style=\'width:100px;margin-top:-6px\'></div>\n' +
                                '<div style=\'width:50%;height:100%;position:absolute;left:50%;margin-top:-55%;display:flex;justify-content: center;align-items:center\'><img src="./TPRindex/images/tprimg/十字架虛線1.png" style=\'width:100px;height:75px;\' alt="">\n' +
                                '<div style=\'width:56px;height:56px;position:absolute;margin-left:-4px;\' name="'+tpr[j]+'"><a href="'+asrc+'" target="_blank"><img src="'+colorsrc+'" style=\'width:56px;height:56px\' alt=""></a></div>\n' +
                                '\n' +
                                '               <a href="'+asrc+'" target="_blank" style="width:56px;height:56px;display:block;line-height:50px"><span class=\'nspan\'></span></a>\n' +
                                '</div>\n' +
                                '</div>';
                            $('#maindiv').append(html);
                        }
                        else{
                            if(j==1){
                                mleft = 205*j+'px';
                                mmtop = -108*(1)+'px';
                            }else{
                                mleft = 100+105*(j)+'px';
                                mmtop = -50*2+'px';
                            }
                            html = '<div style=\'width:100px;height:100px;margin-top:'+mmtop+';margin-left:'+mleft+';position:relative\'>\n' +
                                '<div style=\'width:100%;height:100%;position:absolute;display:flex;justify-content: center;align-items:center\'><img src="./TPRindex/images/tprimg/十字架虛線1.png" style=\'width:100px;height:75px;\' alt="">\n' +
                                '<div style=\'width:56px;height:56px;position:absolute;margin-left:-4px;\' name="'+tpr[j]+'"><a href="'+asrc+'" target="_blank"><img src="'+colorsrc+'" style=\'width:56px;height:56px\' alt=""></a></div>\n' +
                                '               <a href="'+asrc+'" target="_blank" style="width:56px;height:56px;line-height:50px"><span class=\'nspan\'></span></a>\n' +
                                '</div>\n' +
                                '</div>';
                            $('#maindiv').append(html);
                        }
                    }

                }

            }
            let uhtml = '<span class="regard">Hi '+ltpr+':'+user+'</span><hr class="style0" /><span class="dellweek">DELL FY'+fy+' WEEK '+week+'</span><hr class="style" />';
            $('.getweektime').append(uhtml);
            let dthtml = '<div class="rowW">\n' +
                '<div class="rowt">\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="China" >\n' +
                '<div class="name"><b>China</b><span><img src="./images/cnmap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="cdate"></div>\n' +
                '<div class="time" id="Clockk1"><span class="hour">15</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="USA" >\n' +
                '<div class="name"><b>USA</b><span><img src="./images/usamap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="udate"></div>\n' +
                '<div class="time" id="Clockk2"><span class="hour">01</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="Poland" >\n' +
                '<div class="name"><b>Poland</b><span><img src="./images/polandmap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="pdate"></div>\n' +
                '<div class="time" id="Clockk3"><span class="hour">07</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="India" >\n' +
                '<div class="name"><b>India</b><span><img src="./images/indiamap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="idate"></div>\n' +
                '<div class="time" id="Clockk4"><span class="hour">14</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="Brazil">\n' +
                '<div class="name"><b>Brazil</b><span><img src="./images/baximap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="bdate"></div>\n' +
                '<div class="time" id="Clockk5"><span class="hour">13</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '<div class="clocks">\n' +
                '<a href="javascript:;" title="MEX" >\n' +
                '<div class="name"><b>MEX</b><span><img src="./images/moxigemap.png" width="24" height="20" /></span></div>\n' +
                '<div class="date" id="mdate"></div>\n' +
                '<div class="time" id="Clockk6"><span class="hour">13</span>:<span class="minute">39</span>:<span class="second">05</span></div>\n' +
                '</a>\n' +
                '</div>\n' +
                '\n' +
                '</div>\n' +
                '</div>';

            $('.getweektime').append(dthtml);


        })
        function getstatus(){
            let tpr = '<?php echo $tpr;?>';
            let user = '<?php echo $user;?>';
            //console.log(tpr);
            let modules = ['testlog','bios','eco','program','report','npi'];
            let flagno = 'facaecobios';
            let baseasrc = 'Report/html/';
            $.ajax({
                type:'post',
                dataType:'json',
                url:'./Report/newindexphp/return_index_data.php',
                data:{flag:flagno},
                beforeSend:function(){
                    if(tpr!=='CGS'){
                        if(tpr=='RLC_INDIA'){
                            tpr='ICC-RLG';

                        }else if(tpr=='Regenersis_INDIA'){
                            tpr='CTDI';
                        }
                        $('div[name='+tpr+']').each(function(i){ //i为索引，也就是each循环次数

                            $(this).children('a').attr('href',baseasrc+modules[i]+'/'+modules[i]+'.php'+'?'+tpr );
                            $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/green.png');
                        });

                    }
                },
                success:function(msg){
                    console.log(msg);
                    if(tpr!=='CGS'||(tpr=='CGS'&&user=='CGSadmin')){
                        for(let i=0;i<msg.length;i++){

                            if(msg[i]['tpr']=='RLC_INDIA'){
                                msg[i]['tpr']='ICC-RLG';

                            }else if(msg[i]['tpr']=='Regenersis_INDIA'){
                                msg[i]['tpr']='CTDI';
                            }
                            if(msg[i]['tpr']==tpr){

                                $('div[name='+tpr+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        //console.log(msg[i]['biosno']);
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });

                            }
                        }
                    }else{
                        for(let i=0;i<msg.length;i++){
                            if(msg[i]['tpr']=='CGS'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='RLC_SH'){

                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='CEP'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='TSI'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='IGS'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='CEB'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='RLC_INDIA'){
                                msg[i]['tpr']='ICC-RLG';
                                //console.log('aaa');
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='Regenersis_INDIA'){
                                msg[i]['tpr']='CTDI';
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }else if(msg[i]['tpr']=='Bizcom'){
                                $('div[name='+msg[i]['tpr']+']').each(function(p){
                                    //console.log(p); //i为索引，也就是each循环次数
                                    if(p==0&&msg[i]['facano']!==0&&msg[i]['facano']!==null){
                                        //console.log($(this).parent().children('span'));
                                        $(this).parent().children('a').children('span').text(msg[i]['facano']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==1&&msg[i]['biosno']!==0&&msg[i]['biosno']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['biosno']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }else if(p==2&&msg[i]['econo']!==0&&msg[i]['econo']!==null){
                                        $(this).parent().children('a').children('span').text(msg[i]['econo']);
                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                    }
                                });
                            }
                        }
                    }

                },
                complete:function(msg){
                    let flagdelay = 'bios';
                    //console.log(msg.statusText);
                    let tprarr = [];
                    $.ajax({
                        type:'post',
                        dataType:'json',
                        url:'./Report/newindexphp/return_bios_status.php',
                        data:{flag:flagdelay},
                        success:function(msg){
                            console.log(msg);
                            if(tpr=='CGS'){
                                for(let i=0;i<msg.length;i++){
                                    if(msg[i]['2_Status']==5||msg[i]['3_Status']==5||msg[i]['4_Status']==5||msg[i]['5_Status']==5){
                                        if(tprarr.indexOf(msg[i]['TPR']==-1)){
                                            tprarr.push(msg[i]['TPR']);
                                        }
                                    }
                                }
                                if(tprarr.length>=1){
                                    for(let j=0;j<tprarr.length;j++){

                                        if(tprarr[j]=='RLC_INDIA'){
                                            tprarr[j]='ICC-RLG';

                                        }else if(tprarr[j]=='Regenersis_INDIA'){
                                            tprarr[j]='CTDI';
                                        }

                                        $('div[name='+tprarr[j]+']').each(function(p){ //i为索引，也就是each循环次数
                                            if(p==1){
                                                $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/red.png');
                                            }


                                        });
                                    }
                                }
                            }else{

                                for(let i=0;i<msg.length;i++){
                                    if((msg[i]['2_Status']==5||msg[i]['3_Status']==5||msg[i]['4_Status']==5||msg[i]['5_Status']==5)&&msg[i]['TPR']==tpr){
                                        $('div[name='+tpr+']').each(function(p){ //i为索引，也就是each循环次数
                                            if(p==1){
                                                $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/red.png');
                                            }


                                        });
                                    }
                                }
                            }

                            //console.log(tprarr);
                        },
                        complete:function(){
                            let flagdelay = 'eco';
                            // console.log(msg.statusText);
                            let tprarr = [];
                            let tpr = '<?php echo $tpr?>';
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'./Report/newindexphp/return_eco_status.php',
                                data:{flag:flagdelay},
                                success:function(msg){
                                    console.log(msg);
                                    if(tpr=='CGS'){
                                        for(let i=0;i<msg.length;i++){
                                            if(msg[i]['2_Status']==5||msg[i]['3_Status']==5||msg[i]['4_Status']==5||msg[i]['5_Status']==5){
                                                if(tprarr.indexOf(msg[i]['TPR']==-1)){
                                                    tprarr.push(msg[i]['TPR']);
                                                }
                                            }
                                        }
                                        if(tprarr.length>=1){

                                            for(let j=0;j<tprarr.length;j++){

                                                $('div[name='+tprarr[j]+']').each(function(i){ //i为索引，也就是each循环次数

                                                    if(i==2){

                                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/red.png');
                                                    }


                                                });
                                            }
                                        }
                                    }else{
                                        for(let i=0;i<msg.length;i++){
                                            if(msg[i]['tpr']=='RLC_INDIA'){
                                                msg[i]['tpr']='ICC-RLG';

                                            }else if(msg[i]['tpr']=='Regenersis_INDIA'){
                                                msg[i]['tpr']='CTDI';
                                            }
                                            if((msg[i]['2_Status']==5||msg[i]['3_Status']==5||msg[i]['4_Status']==5||msg[i]['5_Status']==5 &&msg[i]['TPR']==tpr)&&msg[i]['TPR']==tpr){
                                                $('div[name='+tpr+']').each(function(p){ //i为索引，也就是each循环次数
                                                    if(p==2){
                                                        $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/red.png');
                                                    }


                                                });
                                            }
                                        }
                                    }

                                },
                                error:function(){

                                }
                            })
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                url:'./Report/newindexphp/return_programdata.php',
                                data:{flag:'program',tpr:tpr},
                                success:function(msg){
                                    console.log(msg);

                                    if(msg.length>=1){
                                        for(let i=0;i<msg.length;i++){
                                            if(msg[i]['tpr']=='RLC_INDIA'){
                                                msg[i]['tpr']='ICC-RLG';

                                            }else if(msg[i]['tpr']=='Regenersis_INDIA'){
                                                msg[i]['tpr']='CTDI';
                                            }
                                            $('div[name='+msg[i]['tpr']+']').each(function(p){
                                                if(p==3&&msg[i]['sort']=='Normal'){
                                                    $(this).parent().children('a').children('span').text(msg[i]['count']);
                                                    $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                                }else if(p==5&&msg[i]['sort']=='NPI'){
                                                    $(this).parent().children('a').children('span').text(msg[i]['count']);
                                                    $(this).children('a').children('img').attr('src','./TPRindex/images/tprimg/orange.png');
                                                }

                                            })
                                        }
                                    }
                                },
                                error:function(emsg){
                                    console.log(emsg);
                                }
                            })
                        },
                        error:function(emsg){
                            //console.log(emsg);
                        }
                    })
                },
                error:function(emsg){
                    console.log(emsg);
                }
            })
        }


        let stval = setInterval(getcookie,2000);
        let udst = '<?php echo $_SESSION['usadst'];?>';
        let pdst = '<?php echo $_SESSION['pdst'];?>';
        let mdst = '<?php echo $_SESSION['mdst'];?>';

        let usaoffset=0;
        let moffset=0;
        let pdoffset=0;
        let iaoffset = 2.5;
        let boffset = 11;
        if(udst==1){

            usaoffset=13;
        }else{

            usaoffset=14;
        }
        if(mdst==1){

            moffset=13;
        }else{

            moffset=14;
        }
        if(pdst==1){
            pdoffset=6
        }else{
            pdoffset=7;
        }

        var timerID; var past_time=0;
        function tzone(ts) { this.ct = new Date(0); this.ts = ts; }
        let ctime = (new Date().getTime()/1000);
        let utime  = ctime-usaoffset*3600;
        let ptime  = ctime-pdoffset*3600;
        let itime = ctime-iaoffset*3600;
        let btime = ctime-boffset*3600;
        let mtime = ctime-moffset*3600;
        let cymd = new Date().format('Y-m-d');
        let uymd = new Date(utime*1000).format('Y-m-d');
        let pymd = new Date(ptime*1000).format('Y-m-d');
        let iymd = new Date(itime*1000).format('Y-m-d');
        let bymd = new Date(btime*1000).format('Y-m-d');
        let mymd = new Date(mtime*1000).format('Y-m-d');


        // console.log($('#cdate'));
        function ClockString(dt) {
            var stemp ;
            var dt_hour = dt.getHours();
            var dt_minute = dt.getMinutes();
            var dt_second = dt.getSeconds();
            if (dt_hour < 10) dt_hour = '0' + dt_hour ;
            if (dt_minute < 10) dt_minute = '0' + dt_minute ;
            if (dt_second < 10) dt_second = '0' + dt_second ;
            //stemp = dt_month + '月' + dt_day + '日';
            stemp = ' <span  style="width: 25px;height: 25px">' + dt_hour + "</span>:<span style=\"width: 25px;height: 25px\">" + dt_minute + "</span>:<span style=\"width: 25px;height: 25px\">" + dt_second + "</span>";
            return stemp ;
        }
        function UpdateClocks() {
            past_time++;

            var ct =new Array(new tzone(ctime),new tzone(utime),new tzone(ptime),new tzone(itime),new tzone(btime),new tzone(mtime)) ;


            //console.log(ct);
            var dt = new Date() ;
            var startDST = new Date(dt.getFullYear(), 3, 1) ;
            while (startDST.getDay() != 0) startDST.setDate(startDST.getDate() + 1) ;
            var endDST = new Date(dt.getFullYear(), 9, 31) ;
            while (endDST.getDay() != 0) endDST.setDate(endDST.getDate() - 1) ;
            var ds_active ;
            if (startDST < dt && dt < endDST) ds_active = 1; else ds_active = 0;
            for (n=0 ; n<ct.length ; n++) {
                ct[n].ct = new Date((ct[n].ts+past_time) * 1000) ;
                // console.log(ct[n].ct);
            }
            //console.log(ct[0].ct);

            document.getElementById('Clockk1').innerHTML = ClockString(ct[0].ct);
            document.getElementById('Clockk2').innerHTML = ClockString(ct[1].ct);
            document.getElementById('Clockk3').innerHTML = ClockString(ct[2].ct);
            document.getElementById('Clockk4').innerHTML = ClockString(ct[3].ct);
            document.getElementById('Clockk5').innerHTML = ClockString(ct[4].ct);
            document.getElementById('Clockk6').innerHTML = ClockString(ct[5].ct);
            $('#cdate').html(cymd);
            $('#udate').html(uymd);
            $('#pdate').html(pymd);
            $('#idate').html(iymd);
            $('#bdate').html(bymd);
            $('#mdate').html(mymd);
            // console.log($('#cdate'));
            //console.log(cymd);
            timerID = window.setTimeout("UpdateClocks()", 1001);}
        function getcookie() {
            // console.log(111);

            // console.log(document.cookie.indexOf('sid'));
            let jcookie = document.cookie.indexOf('sid');
            let user = '<?php echo $user;?>';
            // console.log(jcookie);
            if(jcookie>0){
                let len  = document.cookie.length;
                let sid = document.cookie.slice(jcookie,jcookie+36);
                //console.log(sid);

                let rsid = sid.split('=')[1];
                //console.log(rsid);
                $.ajax({
                    type:'post',
                    url:'./SSO/getsid.php',
                    data:{rsid:rsid,user:user},
                    dataType:'json',
                    success:function (msg) {
                        //console.log(msg);
                        if(msg.length!=0){
                            //console.log('valid');
                        }else{
                            clearInterval(stval);
                            layui.use('layer',function () {

                                layer.confirm('this account is logged in other devices,please click sure and login in again', {
                                    title:'info',
                                    btn : [ 'sure', 'cancel' ],//按钮
                                    cancel:function(index,layero){
                                        alert('pop-up layer will close and webpage will locate to login page');
                                        window.location.href='./login.php';

                                    }
                                }, function(index1) {


                                    layer.close(index1);


                                    setTimeout(backlogin,1500);
                                    // console.log('aaa');
                                    //此处请求后台程序，下方是成功后的前台处理……
                                    // var index = layer.load(0,{shade: [0.7, '#393D49']}, {shadeClose: true}); //0代表加载的风格，支持0-2

                                },function () {
                                    alert('click cancel,webpage will jump to login page');
                                    window.location.href='./login.php';


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

            window.location.href = './login.php';
        }

    </script>
</head>

<body onload="getstatus();UpdateClocks()">

<!-- header-wrap -->
<div id="header-wrap">
    <header>
        <hgroup>
            <h1><a href="index.html">Compal</a></h1>
            <h3>Just Another Styleshout Template</h3>
        </hgroup>
        <nav>
            <div >
                <ul id="dh">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="total_system_sop.html">Sop</a></li>
                    <li><a href="#portfolio">Our Works</a></li>
                    <li><a href="#about-us">About Us</a></li>
                    <li><a href="login.php">Backlogin</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div align="center">

    </div>
</div>
<div style="width: 1220px;height: 500px;margin: 0 auto;position: relative" >
    <h4 align="center" style="margin-top: 110px;text-shadow: 1px  1px 0 rgba(255, 255, 255, 1); ">WWW Repair Center Real-Time Status </h4>
    <div style='width:1200;margin-left:-40px;margin-top:-20px' id='maindiv'>

    </div>
    <div class='getweektime'>

    </div>
    <div class='stable'>
        <table >
            <tr>
                <!-- td内的图片  垂直属性vertical-align属性要加载img标签内 -->
                <td class='tdimg'><img src="TPRindex/images/Status-green.png" style='vertical-align: middle' alt="1" width="20" height="20" ></td>
                <td><span class="YS061">No pending events</span></td>
            </tr>
            <tr>
                <td class='tdimg'><img src="TPRindex/images/Status-orange.png" style='vertical-align: middle' width="20" height="20" ></td>
                <td><span class="YS061">Pending events is normal</span></td>
            </tr>
            <tr>
                <td class='tdimg'><img src="TPRindex/images/Status-red.png"    style='vertical-align: middle' width="20" height="20" ></td>
                <td><span class="YS061"> events has been delayed</span></td>
            </tr>
        </table>
        <div>
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

                <p class="intro">Loading.....</p>

                <h2>&nbsp;</h2>

                <div class="row no-bottom-margin">

                    <section class="col first">

                        <h2>Our Process</h2>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>

                        <p>Loading....</p>

                    </section>
                </div>

                <h2 id="gp">Our Team</h2>

                <ul class="the-team">
                    <li class="odd">
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="./TPRindex/images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">Bruce_Xu</a></p>
                        <p> System software  Windows  Email:Bruce_xu@compal.com</p>
                    </li>
                    <li>
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="./TPRindex/images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">Amy_Yu</a></p>
                        <p>Q&amp;A Windows   Email:Amy_yu@compal.com</p>
                    </li>
                    <li class="odd">
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="./TPRindex/images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname">Dennis_Xu</p>
                        <p>P&amp;E Windows   Email:Dennis_xu@compal.com</p>
                    </li>
                    <li>
                        <div class="thumbnail">
                            <a href="#"><img alt="thumbnail" src="./TPRindex/images/thumb-pic.png" width="83" height="78"></a>
                        </div>
                        <p class="mname"><a href="#">xxx_xxx</a></p>
                        <p>xxx_xxx</p>
                    </li>
                </ul>

            </div>

            <aside><a href="total_system_sop.html" class="download-btn">System SOP</a>


                <h2>Links</h2>


                <ul class="link-list">
                    <li><a href="#" title="Site Templates">Chinese</a></li>
                    <li><a href="#" title="Website Templates">English</a></li>
                    <li><a href="#" title="Web Templates">Other</a></li>
                </ul>


                <h2>&nbsp;</h2>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <!-- <li class="rss-feed"><a href="#">RSS Feed</a></li> -->
            </ul>

            <p class="footer-text">&copy; Copyright &copy; 2020.Compal TPR Management System.Administrator:Bruce_xu.PH: +86 0512-57355000-32752.<a target="_blank" href="http://sc.chinaz.com/moban/"></a>MB:+86 18936110464</p>
        </div>

    </footer>

</body>
</html>
