$(document).ready(function(){
	//alert("test");
	
	/* $("#sort").on('change',function(){
		this.form.submit();
	}); */
	$("#sort").on('change',function(){
		var sort = $(this).val();
		var fabric = get_filter("fabric");
		var url =$("#url").val();
		$.ajax({
			url:url,
			method:"post",
			data:{fabric:fabric,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})
	});

	$(".fabric").on('click',function(){
		var fabric = get_filter(this);
		var sort = $("#sort option:selected").val();
		var url =$("#url").val();
		$.ajax({
			url:url,
			method:"post",
			data:{fabric:fabric,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})
	});

	/*
	$(".patern").on('click',function(){
		var patern = get_filter(this);
		var sort = $("#sort option:selected").text();
		var url =$("#url").val();
		$.ajax({
			url:url,
			method:"post",
			data:{patern:patern,sort:sort,url:url},
			success:function(data){
				$('.filter_products').html(data);
			}
		})
	});
	*/

	function get_filter(class_name){
		var filter = [];
		$('.'+class_name+':checked').each(function(){
			filter.push($(this).val());
		});
		return filter;
	}
});