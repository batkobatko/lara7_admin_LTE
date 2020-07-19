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
	
	//Update Section Status
	$(".updateSectionStatus").click(function(){
		var status = $(this).text();
		var section_id = $(this).attr("section_id");
		//	alert(status);
		//	alert(section_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-section-status',
			data:{status:status,section_id:section_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['section_id']);
				if(resp['status']==0){
					$("#section-"+section_id).html(" <a class='updateSectionStatus' href='javascript:void(0)'> Inactive </a>");
				}else if(resp['status']==1){ 
					$("#section-"+section_id).html(" <a class='updateSectionStatus' href='javascript:void(0)'> Active </a>");

				}

			},error:function(){
				alert("Error");
			}
		});
	});
		//Update Categories Status
		$(".updateCategoryStatus").click(function(){
		var status = $(this).text();
		var category_id = $(this).attr("category_id");
		//	alert(status);
		//	alert(category_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-category-status',
			data:{status:status,category_id:category_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['category_id']);
				if(resp['status']==0){
					$("#category-"+category_id).html(" <a class='updateCategoryStatus' href='javascript:void(0)'> Inactive </a>");
				}else if(resp['status']==1){ 
					$("#category-"+category_id).html(" <a class='updateCategoryStatus' href='javascript:void(0)'> Active </a>");

				}

			},error:function(){
				alert("Error");
			}
		});
	});

	//Append Category Level
	$("#section_id").change(function(){
		var section_id = $(this).val();
		//alert(section_id);
		$.ajax({
			type:'post',
			url:'/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategoriesLevel").html(resp);	
			},error:function(){
				alert("Error");
			}
		});
	});

	//Confirm Deletion of Record
	/* $(".confirmDelete").click(function(){
		var name =$(this).attr("name");
		if(confirm("Are you sure to delete this "+name+"?")){
			return true;
		}
		return false;
	});*/

		//Update Product Status
		$(".updateProductStatus").click(function(){
		var status = $(this).text();
		var product_id = $(this).attr("product_id");
		//	alert(status);
		//	alert(product_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-product-status',
			data:{status:status,product_id:product_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['product_id']);
				if(resp['status']==0){
					$("#product-"+product_id).html(" <a class='updateProductStatus' href='javascript:void(0)'> Inactive </a>");
				}else if(resp['status']==1){ 
					$("#product-"+product_id).html(" <a class='updateProductStatus' href='javascript:void(0)'> Active </a>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Confirm Deletion With SweetAllert
	$(".confirmDelete").click(function(){
		var record =$(this).attr("record");
		var recordid =$(this).attr("recordid");
		Swal.fire({
  			title: 'Are you sure?',
  			text: "You won't be able to revert this!",
  			icon: 'warning',
  			showCancelButton: true,
  			confirmButtonColor: '#3085d6',
  			cancelButtonColor: '#d33',
 			confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
  				if (result.value) {

  			/*  Swal.fire(
     			 'Deleted!',
      			'Your file has been deleted.',
      			'success'
   				 )
   			Ovu linije koda sa informacijama o brisanju uklanjamo, 
   			vec imamo tu vrstu informacije 
  			*/

    	window.location.href="/admin/delete-"+record+"/"+recordid;
 			 }
		});
	});

});  