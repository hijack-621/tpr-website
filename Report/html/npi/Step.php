<?php
session_start();
$tpr = $_SESSION['utpr'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>NPI System Step</title>

    <style type="text/css">

    </style>

    <script src="../../js/jquery-3.2.1.js"></script>
    <script src="../../js/jquery.cookie.js"></script>
    <script src="./layui.js"></script>
    <script type="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../TPRindex/css/style.css" />
    <link rel="stylesheet" href="./layout.css" />
    <link rel="stylesheet" href="./layer.css" />
    <link rel="stylesheet" href="./layui.css" />
    <style type="text/css">
        li{
            overflow: hidden;
	        text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

    
</head>

<body onload="load()">
    <div id="header-wrap">
        <header>
            <hgroup>
                <h1>
                    <a href="../../../index.php"></a>
                </h1>

            </hgroup>
            <nav style="margin-top: 24px">
                <div>
                    <ul id="dh">
                        <li><a href="../../../index.php">Home</a></li>
                        <li><a href="../../../total_system_sop.html">Sop</a></li>
                        <li><a href="#">Our Works</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </nav>

        </header>
    </div>

    <div class="container">
        <div class="col">
            <div class="row">
                <div class="col col-md-2" style="position: absolute;margin-top: 105px;text-align: center; ;">
                    <li class="list-group-item" style="background-color:#CC6633"><a href='javascript:;' onclick="toindex()" >backindex</a></li>
                </div>
                <div class="col col-md-2" style="position: absolute;margin-top: 105px;margin-left: 160px;text-align: center;">
                    <li class="list-group-item" id="tpr"></li>
                </div>
                <div class="col col-md-2" style="position: absolute;margin-top: 105px;margin-left: 320px;text-align: center;">
                    <li class="list-group-item" id="model"><a href="javascript:void(0)" "></a></li>
                    </li>
                </div>
            </div>
            <div style='position: absolute;background-color: PINK;margin-top: 185px;right:30px ;' id='vmodel'></div>
            <table class="table table-bordered table-condensed" style="background-color:#F2F2F2;margin-top:185px;margin-left: -50px;" id="step-tb">
                <thead style="background-color: #F4987F;">
                    <td>Actvity</td>
                    <td>SOP</td>
                    <td>Begingtime</td>
                    <td>Checker</td>
                   
                    <td>remark</td>
                    <td style="background-color: #C60">Status</td>
                    <td>Endtime</td>
                </thead>

                <tbody>
                    <tr>
                        <td><textarea cols="20" rows="2" id="reason" style="border:none;background-color:#F2F2F2;resize:none" readonly="readonly"></textarea></td>
                        <td><a href="javascript:void (0);" onclick="load_file(this)" id="1">Attach</a></td>
                        <td id="1_bgtime"></td>
                        <td id="1_checker"></td>
                       
                        <td id="1_remark"></td>
                        <td id="1_status"></td>
                        <td id="1_edtime"></td>
                    </tr>
                    <tr>
                        <td>COMPAL PE Upload File</td>
                        <td id="step2"><a href="javascript:void (0);" onclick="load_file(this)" id="2">Attach</a></td>
                        <td id="2_bgtime"></td>
                        <td id="2_checker"></td>
                       
                        <td id="2_remark"></td>
                        <td id="2_status"></td>
                        <td id="2_edtime"></td>
                    </tr>
                    <tr>
                        <td>TPR Comfirm NPI Begin time</td>
                        <td></td>
                        <td id="3_bgtime"></td>
                        <td id="3_checker"></td>
                       
                        <td id="3_remark"></td>
                        <td id="3_status"></td>
                        <td id="3_edtime"></td>
                    </tr>
                    <tr>
                        <td>TPR PE Upload Reprot</td>
                        <td id="step4">
                            
                        </td>
                        <td id="4_bgtime"></td>
                        <td id="4_checker"></td>
                       
                        <td id="4_remark"></td>
                        <td id="4_status"></td>
                        <td id="4_edtime"></td>
                    </tr>
                    <tr>
                        <td>Compal PE check</td>
                        <td></td>
                        <td id="5_bgtime"></td>
                        <td id="5_checker"></td>
                      
                        <td id="5_remark"></td>
                        <td id="5_status"></td>
                        <td id="5_edtime"></td>
                    </tr>
                    <tr>
                        <td>Compal QA check</td>
                        <td></td>
                        <td id="6_bgtime"></td>
                        <td id="6_checker"></td>
                       
                        <td id="6_remark"></td>
                        <td id="6_status"></td>
                        <td id="6_edtime"></td>
                    </tr>
                </tbody>
            </table>
            <div class="runtest">
                <p id='time1'></p>

            </div>
        </div>
    </div>
</body>
<script>
    function toindex(){
        let tpr = '<?php echo $tpr?>';
        window.location.href="npi.php"+'?'+tpr;
    }
</script>
<script type="text/javascript">
        var LockButton = function(btnObjId, locksecends, randomcookiename) {
            //1.????????????????????????
            //2.?????? locksecends ??????????????????
            //3.???cookie??????????????????
            //4.?????????????????????cookie??????????????????
            //5.????????????????????????????????????????????????
            var djsendtime = $.cookie(randomcookiename);
            if (djsendtime == null || djsendtime == undefined || djsendtime == 'undefined' || djsendtime == 'null') {
                var now = new Date().getTime(); //???????????????
                var endtime = locksecends * 1000 + now; //???????????????
                $.cookie(randomcookiename, endtime); //????????????????????????cookie
            }
            //$(btnObjId).addClass('disabled').attr('disabled', 'disabled').text('(' + locksecends + ')??????????????????');
            $('body').off('click', '#btnSendSMS');
            var timer = setInterval(function() {
                locksecends--;
                let day = Math.floor(locksecends / (60 * 60 * 24));
                let hour = Math.floor((locksecends - day * 60 * 60 * 24) / (60 * 60));
                let min = Math.floor((locksecends - (day * 60 * 60 * 24 + hour * 60 * 60)) / 60);
                //console.log(day);
                if (randomcookiename.indexOf('ncookie') !== -1) {
                    $('#time1').text('TAT 4 day,Left:' + day + 'day' + '' + hour + 'h ' + '' + min + 'min');
                }
                //else if(randomcookiename.indexOf('5cookie')!==-1){
                //     $('#time2').text('step5:TPR PE TAT2 95 day,Left:' + day + 'day '+'' + hour + 'h '+'' + min + 'min');
                // }else if(randomcookiename.indexOf('7cookie')!==-1){
                //     $('#time3').text('step7:TPR QA TAT3 111 day,Left:' + day + 'day '+'' + hour + 'h '+'' + min + 'min');
                // }

                //$('#time').text('Left - Time:  ' + day + 'day '+'' + hour + 'h '+'' + min + 'min');
                if (locksecends <= 0) {
                    //?????????????????????cookie???
                    $.cookie(randomcookiename, null);
                    // $(btnObjId).removeClass('disabled').removeAttr('disabled').text('????????????');
                    //$('body').on('click', btnObjId);
                    //clearInterval(timer);
                }
            }, 1000);
        };



        function load() {
            let id = window.location.search.substring(1).split('?')[0];
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "Controller.php",
                data: {
                    action: 'NPIController/getStepTitle',
                    urldata: id
                },
                success: function(msg) {
                    console.log(msg);
                    document.getElementById('tpr').innerHTML = msg['TPR'];
                    document.getElementById('reason').innerHTML = msg['MEMO'];
                    document.getElementById('model').innerHTML = msg['Model'];
                    document.getElementById('model').title = msg['Model'];
                    document.getElementById('model').onclick = function(){
                        alert( msg['Model']);
                    }
                },
                error: function(msg) {}
            })
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "Controller.php",
                data: {
                    action: 'NPIController/getStepData',
                    urldata: id
                },
                success: function(msg) {
                    console.log(msg);
                    for (let i = 0; i < msg.length; i++) {
                        if (i == 0) {
                            if (i == 0) {
                                basetime = new Date(msg[i]['bgtime']);
                                //$nowtime = new Date().getTime();
                                let cookie2 = 'ncookie' + id;
                                // let cookie5 = '5cookie'+id;
                                // let cookie7 = '7cookie'+id;
                                let targettime2 = basetime.getTime() + 4 * 60 * 60 * 24 * 1000; //???????????? 4???
                                // let targettime5 = basetime.getTime()+95*60*60*24*1000;
                                // let targettime7 = basetime.getTime()+111*60*60*24*1000;
                                if ($.cookie(cookie2) != undefined && !isNaN($.cookie(cookie2))) {
                                    layui.use('layer', function() {
                                        let lay = layui.layer;
                                        lay.ready(function() {
                                            layer.open({
                                                type: 1,
                                                title: 'Sign Off Period',
                                                id: 'Lay_layer_debug',
                                                content: $('.runtest'),
                                                shade: false,
                                                offset: 'rt',
                                                area: ['200px', '100px'],
                                                resize: false,
                                                anim: 2,
                                                success: function(layero, index) {
                                                    layer.style(index, {
                                                        marginLeft: -10,
                                                        marginTop: 185

                                                    });
                                                    var djsendtime2 = $.cookie(cookie2);
                                                    // var djsendtime5 = $.cookie(cookie5);
                                                    // var djsendtime7 = $.cookie(cookie7);
                                                    var now = new Date().getTime(); //???????????????
                                                    var locksecends2 = parseInt((djsendtime2 - now) / 1000);
                                                    // var locksecends5 = parseInt((djsendtime5 - now) / 1000);
                                                    // var locksecends7 = parseInt((djsendtime7 - now) / 1000);
                                                    if (locksecends2 <= 0) {
                                                        $.cookie(cookie2, null);
                                                    } else {
                                                        LockButton('#Owner_btn', locksecends2, cookie2);
                                                    }
                                                    // if (locksecends5 <= 0) {
                                                    // 	$.cookie(cookie5, null);
                                                    // }else {
                                                    // 	LockButton('#Owner_btn', locksecends5,cookie5);
                                                    // }
                                                    // if (locksecends7 <= 0) {
                                                    // 	$.cookie(cookie7, null);
                                                    // }else {
                                                    // 	LockButton('#Owner_btn', locksecends7,cookie7);
                                                    // }
                                                }

                                            });
                                        });
                                    });
                                } else {

                                    $.cookie(cookie2, targettime2);
                                    // $.cookie(cookie5,targettime5);
                                    // $.cookie(cookie7,targettime7);
                                    layui.use('layer', function() {
                                        let lay = layui.layer;
                                        lay.ready(function() {
                                            layer.open({
                                                type: 1,
                                                title: '??????????????????',
                                                id: 'Lay_layer_debug',
                                                content: $('.runtest'),
                                                shade: false,
                                                area: ['200px', '100px'],
                                                offset: 'rt',
                                                resize: false,
                                                anim: 2,
                                                success: function(layero, index) {
                                                    layer.style(index, {
                                                        marginLeft: -10,
                                                        marginTop: 185

                                                    });

                                                    var now = new Date().getTime(); //???????????????
                                                    var locksecends2 = parseInt( (targettime2 - now) / 1000);
                                                    // var locksecends5 = parseInt((targettime5 - now) / 1000);
                                                    // var locksecends7 = parseInt((targettime7 - now) / 1000);
                                                    if (locksecends2 <= 0) {
                                                        $.cookie(cookie2, null);
                                                    } else {
                                                        LockButton('#Owner_btn', locksecends2, cookie2);
                                                    }
                                                    // if (locksecends5 <= 0) {
                                                    // 	$.cookie(cookie5, null);
                                                    // }else {
                                                    // 	LockButton('#Owner_btn', locksecends5,cookie5);
                                                    // }
                                                    // if (locksecends7 <= 0) {
                                                    // 	$.cookie(cookie7, null);
                                                    // }else {
                                                    // 	LockButton('#Owner_btn', locksecends7,cookie7);
                                                    // }
                                                }

                                            });
                                        });
                                    });

                                }
                            }
                        }
                        let tp = i + 1;
                        document.getElementById(tp + "_bgtime").innerHTML = msg[i]['bgtime'];
                        let check_td = document.createElement("a");
                        if (msg[i]['status'] == 0) {
                            document.getElementById(tp + "_status").style.backgroundColor = "#FFFF00";
                        } else if (msg[i]['status'] == 1) {
                            document.getElementById(tp + "_status").style.backgroundColor = "#00FF00";
                        } else if (msg[i]['status'] == 5) {
                            document.getElementById(tp + "_status").style.backgroundColor = "red";
                        }
                        check_td.innerHTML = msg[i]['checker'];
                        check_td.href = "Edit.html?" + "id=" + id + "&step=" + tp;
                        check_td.target = "_bank";
                        check_td.style.color = 'blue';
                        document.getElementById(tp + "_checker").appendChild(check_td);
                        document.getElementById(tp + "_remark").innerHTML = msg[i]['remark'];
                        document.getElementById(tp + "_status").innerHTML = msg[i]['status'];
                        document.getElementById(tp + "_edtime").innerHTML = msg[i]['edtime'];
                        if(tp==4){
                          $('#step'+tp).append('<a href="javascript:void (0);" onclick="load_file(this)" id="4">Attach</a>');
                        }
                    }
                    

                },
                error: function(msg) {
                    console.log(msg);
                }
            })
        }

        function load_file(obj) {
            let id = window.location.search.substring(1).split('?')[0];
            let step = obj.id;
            window.open("path_edit.php?" + "id=" + id + "&step=" + step);
        }
</script>
</html>