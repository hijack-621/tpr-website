<?php
session_start();
$tpr = $_SESSION['utpr'];
$user = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="../../js/jquery-3.2.1.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../css/bootstrap.min.css"/>
  <link rel="stylesheet" href="../../../TPRindex/css/style.css"/>
  <title>Model Path Edit</title>
  <style>
body {
	background-color: #eee;
	padding-top: 40px;
	padding-bottom: 40px;
	text-align: center;
	
}
    a{
      color: #fff;
    }
    a:hover{
      color: #000;
    }
  </style>
  <script type="text/javascript">
    function load() {
        let geturl = window.location.search.substring(1);
        let r=new Array();
        let str_arr=geturl.split("&");
        for(let i = 0; i < str_arr.length; i ++) {
            r[i]=unescape(str_arr[i].split("=")[1]);
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "Controller.php",
            data: {action:'NPIController/getSopFile', urldata: r},
            success: function (msg) {
                console.log(msg);
                let tb=$('#tb-body');
                for (let i=0;i<msg.length;i++){
                    let link="../../NPI_System_file/"+msg[i]['primary_id']+"/"+msg[i]['file_id']+"/"+msg[i]['file_name'];
                   let tr=$("<tr><td>"+i+"</td><td><a href="+link+" style='color:green' download="+msg[i]['file_name']+">"+msg[i]['file_name']+"</a></td><td><button id="+msg[i]['file_id']+" onclick='del_file(this)' class='btn btn-danger'>del</button></td></tr>");
                    tb.append(tr);
                }
            },
            error: function (msg) {
                console.log(msg);
            }
        })
    }
function upload() {
    let tb=$('#tb-body');
    let tr=$('<tr><td><div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%;" id="probar"></div></div></td><td><input type="file" id="npi-file"/></td><td><button type="button" onclick="add()" class="btn btn-primary">upload</button></td></tr>');
    tb.append(tr);
    $('#upload').removeAttr('onclick');
    }
function add() {
    let file=document.getElementById("npi-file").files[0];
    let geturl = window.location.search.substring(1);
    let r=new Array();
    let str_arr=geturl.split("&");
    for(let i = 0; i < str_arr.length; i ++) {
        r[i]=unescape(str_arr[i].split("=")[1]);
    }
    let formdata=new FormData();
    formdata.append("action",'NPIController/upFile');
    formdata.append("file",file);
    formdata.append("id",r[0]);
    formdata.append("step",r[1]);
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: "Controller.php",
        contentType: false,
        processData: false,
        data:formdata,
        xhr:function(){
            myxhr=$.ajaxSettings.xhr();
            if(myxhr.upload){
                myxhr.upload.addEventListener('progress',progressHander,false);
            }
            return myxhr;
        },
        success: function (msg) {
            console.log(msg);
            if (msg==1111){
                alert("success");
                window.location.reload();
            }else if(msg==1007) {
                alert("this step needn't upload file");
            }else{
                alert("fail");
            }
        },
        error: function (msg) {
            console.log(msg);
        }
    })
}
function progressHander(e){
          if(e.lengthComputable){
              var persent=(e.loaded/e.total*100).toFixed(1);
              document.getElementById('probar').innerHTML=persent+"%";
              var probar=Math.floor(e.loaded/e.total*100)+'%';
              document.getElementById('probar').style.width=probar;
          }
      }
function del_file(obj) {
    let geturl = window.location.search.substring(1);
    let user = '<?php echo $user?>';
    if(user!=='Bruce'){
        alert('非管理员不可删除程式附件');
        return '';
    }
    let r=new Array();
    let str_arr=geturl.split("&");
    for(let i = 0; i < str_arr.length; i ++) {
        r[i]=unescape(str_arr[i].split("=")[1]);
    }
    let id_arr=new Array();
    id_arr[0]=r[0];
    id_arr[1]=obj.id;
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: "Controller.php",
        data: {action: 'NPIController/delFile', urldata: id_arr},
        success: function (msg) {
            console.log(msg);
            if (msg==1111){
                alert("success");
                window.location.reload();
            }else {
                alert("fail");
            }
        },
        error: function (msg) {
            console.log(msg);
        }
    })
}
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onload="load()">
<h3 >SOP File</h3>
<div style="width: 80%;margin: 15px auto">
  <div style="display: flex;display:-webkit-flex;flex-direction:row;align-items: center; width: 100%;height: 45px;">
    <div style=" border-radius: 3px;display: flex;justify-content: center;align-items: center;text-align: center;background-color: #317EF3;margin: 0 15px 0 15px;color: #fff;width: 80px;height: 35px;">
      <a style="text-decoration: none" href="javascript:void (0)" onclick="upload()" id="upload">
        upload
      </a>
    </div>
  </div>
  <table class="table table-bordered" id="tb-body">
    <thead>
    <td>num</td>
    <td>file name</td>
    <td>edit</td>
    </thead>
  </table>
</div>
</body>

</html>