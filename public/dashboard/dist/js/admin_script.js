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
	//$(".updateSectionStatus").click(function(){
	$(document).on("click",".updateSectionStatus",function(){
		var status = $(this).children("i").attr("status");
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
					$("#section-"+section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){ 
					$("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Update Brand Status
	//$(".updateBrandStatus").click(function(){
	$(document).on("click",".updateBrandStatus",function(){ 
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var brand_id = $(this).attr("brand_id");
		//	alert(status);
		//	alert(brand_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-brand-status',
			data:{status:status,brand_id:brand_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['brand_id']);
				if(resp['status']==0){
					$("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){ 
					$("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

		//Update Categories Status
		
		//$(".updateCategoryStatus").click(function(){
		$(document).on("click",".updateCategoryStatus",function(){ 
		//var status = $(this).text();
		var status = $(this).children("i").attr("status");
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
					$("#category-"+category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){ 
					$("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");

				}

			},error:function(){
				alert("Error");
			}
		});
	});

	//Update Banners Status
	//$(".updateBrandStatus").click(function(){
	$(document).on("click",".updateBannerStatus",function(){ 
		var status = $(this).children("i").attr("status");
		//alert(status); return false;
		var banner_id = $(this).attr("banner_id");
		//	alert(status);
		//	alert(banner_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-banner-status',
			data:{status:status,banner_id:banner_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['banner_id']);
				if(resp['status']==0){
					$("#banner-"+banner_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){ 
					$("#banner-"+banner_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
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
	//$(".updateProductStatus").click(function(){
	$(document).on("click",".updateProductStatus",function(){ 
		// var status = $(this).text();
		var status = $(this).children("i").attr("status");
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
					$("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
				}else if(resp['status']==1){ 
					$("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Update Attribute Status
	//$(".updateAttributeStatus").click(function(){
	$(document).on("click",".updateAttributeStatus",function(){ 
		var status = $(this).text();
		var attribute_id = $(this).attr("attribute_id");
		//	alert(status);
		//	alert(attribute_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-attribute-status',
			data:{status:status,attribute_id:attribute_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['attribute_id']);
				if(resp['status']==0){
					$("#attribute-"+attribute_id).html("Inactive");
				}else if(resp['status']==1){ 
					$("#attribute-"+attribute_id).html("Active");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Update Image Status
//	$(".updateImageStatus").click(function(){
	$(document).on("click",".updateImageStatus",function(){ 
		var status = $(this).text();
		var image_id = $(this).attr("image_id");
		//	alert(status);
		//	alert(image_id);
		$.ajax({
			type:'post', 
			url:'/admin/update-image-status',
			data:{status:status,image_id:image_id},
			success:function(resp){
		//		alert(resp['status']);
		//		alert(resp['image_id']);
				if(resp['status']==0){
					$("#image-"+image_id).html("Inactive");
				}else if(resp['status']==1){ 
					$("#image-"+image_id).html("Active");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Confirm Deletion with SweetAllert
	//$(".confirmDelete").click(function(){
	$(document).on("click",".confirmDelete",function(){ 
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

	// Product Attributes Add/Remove Script
    var maxField = 50; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style"height:10px;"></div><input type="text" name="size[]" style="width:120px" placeholder="Size" />&nbsp;<input type="text" name="sku[]" style="width:120px" placeholder="SKU" />&nbsp;<input type="text" name="price[]" style="width:120px" placeholder="Price" />&nbsp;<input type="text" name="stock[]" style="width:120px" placeholder="Stock"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
	//Once add button is clicked 
	$(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

});  