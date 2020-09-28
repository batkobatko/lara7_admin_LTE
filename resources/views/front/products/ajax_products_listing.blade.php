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
							<p>
								{{ $product['fabric'] }} 
							</p>
						</div>
					</div>
				</li>
				@endforeach
			</ul>
			<hr class="soft"/>
		</div>