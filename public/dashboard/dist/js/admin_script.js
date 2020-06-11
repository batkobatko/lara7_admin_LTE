$(document).ready(function() {
// Check Admin Password is corect or not
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		//alert(current_pwd);
		$.ajax({
			type:'post',
			//ruta koja ce biti naknadno unesena
			url:'/admin/check-current-pwd',
			//promjena lozinke, trenutna loz
			data:{current_pwd:current_pwd},
			success:function(resp){
			// alert(resp) -> izbacuje info na svaki uneseni znak, pravi break
			//	alert(resp); 
				if(resp=="false"){
					$("#chkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
				}else if(resp=="true"){
					$("#chkCurrentPwd").html("<font color=green>Current Password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});
});  