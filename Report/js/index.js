function load(){
	var flag="1";
	$.ajax({
		type:"post",
		url:"Report/server/index/old_index.php",
		data:{flag:flag},
		dataType:"json",
		success:function(msg){
			if(msg==0){
				//alert('please login ');
			location.href='login.php';
			}else if(msg==1){
				//��½�ɹ�
			}
		},
		error:function(msg){
			console.log(msg);
			//alert('link failure');
			location.href='login.php';
		}
	})
}