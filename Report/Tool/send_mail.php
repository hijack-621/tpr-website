<?php
error_reporting(0);
require 'phpmail/class.phpmailer.php';
$mail = new PHPMailer(true); //建立邮件发送类
$mail->CharSet = "UTF-8";//设置信息的编码类型
$mail->IsSMTP(); // 使用SMTP方式发送
$mail->Host = "smtp.163.com"; //使用163邮箱服务器
$mail->SMTPAuth = true; // 启用SMTP验证功能
$mail->Username = "13771992334@163.com"; //你的163服务器邮箱账号
$mail->Password = "qaz123456"; // 163邮箱密码
$mail->Port = 25;//邮箱服务器端口号
$mail->From = "13771992334@163.com"; //邮件发送者email地址
$mail->FromName = "Terry";//发件人名称
for ($i=0;$i<count($arr);$i++){
    $mail->AddAddress("$arr[$i]['mail']", "$arr[$i]['name']"); //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
}
//$mail->AddAttachment("D:\abc.txt"); // 添加附件(注意：路径不能有中文)
$mail->IsHTML(true);//是否使用HTML格式
$mail->Subject = "test1"; //邮件标题
$mail->Body = "this is test1 mail"; //邮件内容，上面设置HTML，则可以是HTML
if (!$mail->Send()) {
    echo json_encode($mail->ErrorInfo);
    exit;
}else{
    echo "111";
}
?>