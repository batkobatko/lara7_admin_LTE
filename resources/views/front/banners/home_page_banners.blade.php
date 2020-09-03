
<?php use App\Banner;
$getBanners = Banner::getBanners();
//Echo "<pre>"; print_r($getBanners); die;
?>

@if(isset($page_name) && $page_name=="index") <!--CALL BANNERS ALSO -->
<!--kada zelimo da pozovemo dio stranice potrebi -->
<div id="carouselBlk">
	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			@foreach($getBanners as $key => $banner)
			<!-- $key = check active/inactive-->
			<div class="item @if($key==0) active @endif">
				<div class="container">
					<a @if(!empty($banner['link'])) href="{{ url($banner['link']) }}" @else href="javascript:void(0)" @endif>
					  <?php $product_image_path = "dashboard/dist/img/banners_img/".$banner['image'] ?>
                      @if(!empty($banner['image']) && file_exists($product_image_path))
                      <img style="width: 100%;" src="{{ asset('dashboard/dist/img/banners_img/'.$banner['image']) }}" alt="{{ ($banner['alt']) }}" title="{{ ($banner['title']) }}">
                      @else
                      <img style="width: 110px;" src="{{ asset('dashboard/dist/img/product_img/small/no-image.png') }}">
                      @endif
					</a>
<!--Preeditovan kod-->
					  
				</div>
			</div>
			@endforeach
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>
</div>
@endif