let xmselect1 = {},
    xmselect2 = {},
    xmselect3 = {};
(function() {
    xmselect1 = xmSelect.render({ //使用xm-select 百度 xm-select 官网有详细用法
        el: '#st-up',
        tips: 'choose npi',
        language: 'zn',
        height: '150px',
        theme: {
            color: '#5fb878',
        },
        data: [
            { name: 'NPI', value: 'NPI' }
        ],
    });
    xmselect2 = xmSelect.render({
        el: '#st-series',
        tips: 'choose model',
        language: 'zn',
        height: '150px',
        filterable: true,
        paging: true,
        theme: {
            color: '#5fb878',
        },
        data: [

        ],
    });
    xmselect3 = xmSelect.render({
        el: '#st-model',
        tips: 'choose series',
        language: 'zn',
        height: '150px',
        filterable: true,
        paging: true,
        theme: {
            color: '#5fb878',
        },
        data: [

        ],
    });


})()

function load() {
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: "Controller.php",
        data: { action: 'NPIController/getModel', flag: 'NPI' }, //从数据库获取model
        success: function(msg) {
            console.log(msg);
            msg.forEach(v => {
                v.filter(vv => {
                    return Object.assign(vv, { name: Object.values(vv)[0], value: Object.values(vv)[0] });
                    //属性合并 Object.assign
                })
            });
            console.log(msg);
            xmselect2.update({
                data: msg[0],
                AutoRow: true,
            })
            xmselect3.update({
                data: msg[1],
                AutoRow: true,
            })

        },
        error: function(msg) {
            console.log(msg);
        }
    })
}


function submit() {
    let flag = 'NPI';
    let up = xmselect1.getValue(),
        models = JSON.stringify(xmselect2.getValue()),
        series = JSON.stringify(xmselect3.getValue()),
        npi_path = 'Attach',
        reason = $('#reason').val(),
        action = "NPIController/Create",
        files = document.getElementById('sop-file').files,
        tprcheck = document.getElementsByName('tpr-box'),
        bdview = $('#bdinput').val();
    checkarr = new Array(),
        x = 0;
    for (var i = 0; i < tprcheck.length; i++) {
        if (tprcheck[i].checked) {
            checkarr[x] = tprcheck[i].value;
            x++;
        }
    }
    var checkdata = checkarr.join(',');
    let formdata = new FormData();
    formdata.append("flag", flag);
    formdata.append("action", action);
    formdata.append("up", up);
    formdata.append("reason", reason);
    formdata.append("checkdata", checkdata);
    formdata.append("npi_path", npi_path);
    formdata.append("models", models);
    formdata.append("series", series);

    if (bdview === '') {

    } else {
        formdata.append("bdview", bdview);
    }
    for (let x = 0; x < files.length; x++) {
        formdata.append("file" + x, files[x]);
    }
    for (var value of formdata.entries()) {
        //console.log(value);
        if (value == "" || value == undefined || value == " ") {
            alert("please fill in all the data");
            return false;
        }
    }
    document.getElementById('hint-up').innerHTML = "uploading";
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'Controller.php',
        contentType: false,
        processData: false,
        data: formdata,
        xhr: function() {
            myxhr = $.ajaxSettings.xhr();
            if (myxhr.upload) {
                myxhr.upload.addEventListener('progress', progressHander, false);
            }
            return myxhr;
        },

        success: function(msg) {
            console.log(msg);
            if (msg[2] == 1) {
                document.getElementById('hint-up').innerHTML = "upload success";
                document.getElementById('hint-up').style.color = "green";
            } else {
                document.getElementById('hint-up').innerHTML = "upload error";
                document.getElementById('hint-up').style.color = "red";
            }
            if (msg[0] == '1111') {
                alert("Create success");

                //Send_Mail(msg[1],msg[3],reason,msg[4]);//tpr,id,reason,model
                window.open("npi.php??CGS", "");
            } else {
                alert("error");
            }
        },
        error: function(msg) {
            console.log(msg);
            document.getElementById('hint-up').innerHTML = "upload error";
        }
    })

}

function progressHander(e) {
    if (e.lengthComputable) {
        if (e.total > 1024 * 1024) {
            var uploading = (Math.round(e.loaded * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        } else {
            var uploading = (Math.round(e.loaded * 100 / 1024) / 100).toString() + 'KB';
        }
        document.getElementById('file-up').innerHTML = uploading;
        var persent = (e.loaded / e.total * 100).toFixed(1);
        document.getElementById('probar').innerHTML = persent + "%";
        var probar = Math.floor(e.loaded / e.total * 100) + '%';
        document.getElementById('probar').style.width = probar;
    }
}

function Send_Mail(tpr, id, reason, model) {
    let hint = document.getElementById('hint-up');
    show_dialog();
    let mail_msg = new Array();
    mail_msg[0] = "C";
    mail_msg[1] = tpr;
    mail_msg[2] = id;
    mail_msg[3] = reason;
    mail_msg[4] = 'NPI';
    mail_msg[5] = model;
    console.log(mail_msg);
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: "Controller.php",
        data: { action: 'NPIController/SendMail', urldata: mail_msg },
        success: function(msg) {
            console.log(msg);
            hidden_dialog();
            if (msg == '1111') {
                hint.innerHTML = 'send mail success!';
                hint.style.color = "green";
                window.open("Shownpi.html", "");
            } else {
                alert('error');
                hint.innerHTML = 'send fail!';
                hint.style.color = "red";
            }
        },
        error: function(msg) {
            console.log(msg);
            hidden_dialog();
            alert("send error")
        }
    })
}

function fileselect() {
    let fileSize = 0;
    let files = document.getElementById('sop-file').files;
    var fbom = document.getElementById('bom');
    var ftp = document.getElementById('tp');
    var fct = document.getElementById('ct');
    var fcomt = document.getElementById('comt');
    var fgber = document.getElementById('gber');
    var fscil = document.getElementById('scil');
    var fprofile = document.getElementById('profile');
    var fnudd = document.getElementById('nudd');
    var fnpi = document.getElementById('npireport');

    let reg1 = new RegExp('Bom', 'i');
    let reg2 = new RegExp('part', 'i');
    let reg3 = new RegExp('Circuit', 'i');
    let reg4 = new RegExp('Components', 'i');
    let reg5 = new RegExp('Gerber', 'i');
    let reg6 = new RegExp('Stencil', 'i');
    let reg7 = new RegExp('Profile', 'i');
    let reg8 = new RegExp('NUDD', 'i');
    let reg9 = new RegExp('NPI', 'i');
    let count = 0;
    for (var i = 0; i < files.length; i++) {

        if ((files[i]['name'].match(reg1)) !== null) {
            count++;
            fbom.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg2)) !== null) {
            count++;
            ftp.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg3)) !== null) {
            count++;
            fct.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg4)) !== null) {
            count++;
            fcomt.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg5)) !== null) {
            count++;
            fgber.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg6)) !== null) {
            count++;
            fscil.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg7)) !== null) {
            count++;
            fprofile.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg8)) !== null) {
            count++;
            fnudd.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        } else if ((files[i]['name'].match(reg9)) !== null) {
            count++;
            fnpi.childNodes[1].style.background = "url(../../../images/label_2.png) no-repeat";
        }

        fileSize += files[i]['size'];

    }
    if (count == 0) {
        alert('请至少上传指定文件中的一个！');
        return false;
    }
    if (document.getElementById('sop-file').files[0] != null) {

        if (fileSize > 1024 * 1024) {
            fileSize = (Math.round(fileSize * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        } else {
            fileSize = (Math.round(fileSize * 100 / 1024) / 100).toString() + 'KB';
        }
    } else {
        fileSize = null;
    }
    document.getElementById('file-size').innerHTML = fileSize;





}

function show_dialog() {
    document.getElementById("hidebox").style.display = "block";
}

function hidden_dialog() {
    document.getElementById("hidebox").style.display = "none";
}

function show_hint() {
    let val = document.getElementById("st-up").value;
    if (val === "NPI") {
        console.log($('div[class="dis"]').removeClass('dis'));
        $('#se1').children('input').eq(0).attr('disabled', 'disabled');
        $('#sop').css('background-color', '#DBDBDB');
        $(".showFileName1").html("");
        document.getElementById('file-size').innerHTML = '';

    } else {
        if (!$('#dis1,#dis2').hasClass('dis')) {
            $('#dis1,#dis2').addClass('dis');
            $('#se1').children('input').eq(0).removeAttr('disabled');
            $('#sop').css('background-color', '#DBDBDB');
            $(".showFileName1").html("");
            document.getElementById('file-size').innerHTML = '';
        }
    }
}