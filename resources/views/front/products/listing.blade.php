 @extends('layouts.front_layout.front_layout')
 @section('content')
<div class="span9">
	<ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"><?php echo $categoryDetails['breadcrumbs']; ?></li>
	</ul>
	<h3>{{ $categoryDetails['catDetails']['category_name'] }} <small class="pull-right"> broj dostupnih artikala: <b>{{ count($categoryProducts) }}</b>  </small></h3>
	<hr class="soft"/>
	<p>
		{{ $categoryDetails['catDetails']['description'] }}
	</p>
	<hr class="soft"/>
	<form name="sortProducts" id="sortProducts" class="form-horizontal span6">
		<div class="control-group">
			<label class="control-label alignL">Sort By </label>
			<select name="sort" id="sort">
				<option value="">Select</option>
				<option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>Novi Artikli</option>
				<option value="product_name_a_z"  @if(isset($_GET['sort']) && $_GET['sort']=="product_name_a_z") selected="" @endif>Artikli A - Z</option>
				<option value="product_name_z_a"  @if(isset($_GET['sort']) && $_GET['sort']=="product_name_z_a") selected="" @endif>Artikli Z - A</option>
				<option value="price_lowest"  @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif>Sortiraj od najnize cijene</option> 
				<option value="price_highest"  @if(isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif>Sortiraj od najvise cijene</option> 
			</select>
		</div>
	</form>
	
	<div id="myTab" class="pull-right">
		<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
		<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
	</div>
	<br class="clr"/>
	<div class="tab-content">
		<div class="tab-pane" id="listView">
			@foreach($categoryProducts as $product )
			<div class="row">
				<div class="span2">
					@if(isset($product['main_image']))
						<?php $product_image_path = 'dashboard/dist/img/product_img/small/'.$product['main_image']; ?>
					@else
						<?php $product_image_path = ''; ?> 
					@endif
					@if(!empty($product['main_image']) && file_exists($product_image_path)) <img style="width: 250px; height: 200px;" src="{{ asset($product_image_path) }}" alt="">
					@else
						<img style="width: 350px;" src="{{ asset('dashboard/dist/img/product_img/small/no-image.png') }}" alt="">
					@endif
				</div>
				<div class="span4">
					<h3>{{ $product['product_name'] }}</h3>
					<hr class="soft"/>
					<h5>{{ $product['brand']['name'] }}</h5>
					<p>
						{{ $product['description'] }}

					</p>
					<a class="btn btn-small pull-right" href="product_details.html">View Details</a>
					<br class="clr"/>
				</div>
				<div class="span3 alignR">
					<form class="form-horizontal qtyFrm">
						<h3> {{ $product['product_price'] }}&nbsp;KM</a></h3>
						<label class="checkbox">
							<input type="checkbox">  Adds product to compair
						</label><br/>
						
						<a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
						<a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
						
					</form>
				</div>
			</div>
			<hr class="soft"/>
			@endforeach
			
		</div>
		<div class="tab-pane  active" id="blockView">
			<ul class="thumbnails">
				@foreach($categoryProducts as $product )
				<li class="span3">
					<div class="thumbnail">
						<a href="product_details.html">
							@if(isset($product['main_image']))
								<?php $product_image_path = 'dashboard/dist/img/product_img/small/'.$product['main_image']; ?>
							@else
								<?php $product_image_path = ''; ?> 
							@endif
								<?php $product_image_path = 'dashboard/dist/img/product_img/small/'.$product['main_image'];?>
							@if(!empty($product['main_image']) && file_exists($product_image_path)) <img style="width: 250px; height: 350px;" src="{{ asset($product_image_path) }}" alt="">
							@else
								<img style="width: 250px; height: 350px;" src="{{ asset('dashboard/dist/img/product_img/small/no-image.png') }}" alt="">
							@endif
						</a>
						<div class="caption">
							<h5>{{ $product['product_name'] }} {{ $product['id'] }}</h5>
							<p>
								{{ $product['brand']['name'] }} 
							</p>
							<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{ $product['product_price'] }}&nbsp;KM</a></h4>
						</div>
					</div>
				</li>
				@endforeach
			</ul>
			<hr class="soft"/>
		</div>
	</div>
	<a href="compair.html" class="btn btn-large pull-right">Uporedi artikle</a>
	<div class="pagination">
		@if(isset($_GET['sort'])  && !empty($_GET['sort']))
		 	{{ $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
		@else
			{{ $categoryProducts->links() }} 
		@endif 
	<br class="clr"/>
</div>
 @endsection