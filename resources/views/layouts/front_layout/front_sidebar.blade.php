<?php
use App\Section;
$sections =Section::sections();
//echo "<pre>"; print_r($sections); die;
?> 

<div id="sidebar" class="span3">
	<div class="well well-small"><a id="myCart" href="product_summary.html"><img src="{{ asset('images/front_images/ico-cart.png') }}" alt="cart">3 Items in your cart</a></div>
	<ul id="sideManu" class="nav nav-tabs nav-stacked">
		@foreach($sections as $section) 
			@if(count($section['categories'])>0)
				<li class="subMenu"><a>{{ $section['name'] }}</a>
					@foreach($section['categories'] as $category)
					<ul>
						<li><a href="{{ url($category['url']) }}"><i class="icon-chevron-right"></i><strong>{{ $category['category_name'] }}</strong></a></li>
						@foreach($category['subcategories'] as $subcategory)
						<li><a href="{{ url($subcategory['url']) }}"><i class="icon-chevron-right"></i>{{ $subcategory['category_name'] }}</a></li>
						@endforeach
					</ul>
					@endforeach
				</li>
			@endif
		@endforeach
	</ul>
	<br>
	@if(isset($page_name) && $page_name=="listing")
		<div class="well well-small">
			<h5>Materijal</h5>
			@foreach($fabricArray as $fabric)
			<input style="margin-top: -3px" type="checkbox" name="fabric[]" id="{{ $fabric }}" value="{{ $fabric }}">&nbsp;&nbsp;{{ $fabric }} <br>
			@endforeach

		</div>
		<div class="well well-small">
			<h5>Vrsta rukava</h5>
			@foreach($sleeveArray as $sleve)
			<input style="margin-top: -3px" type="checkbox" name="sleve[]" id="{{ $sleve }}" value="{{ $sleve }}">&nbsp;&nbsp;{{ $sleve }} <br>
			@endforeach
		</div>
		<div class="well well-small">
			<h5>Bod</h5>
			@foreach($patternArray as $patern)
			<input style="margin-top: -3px" type="checkbox" name="patern[]" id="{{ $patern }}" value="{{ $patern }}">&nbsp;&nbsp;{{ $patern }} <br>
			@endforeach
		</div>
		<div class="well well-small">
			<h5>Veličina</h5>
			@foreach($fitArray as $fit)
			<input style="margin-top: -3px" type="checkbox" name="fit[]" id="{{ $fit }}" value="{{ $fit }}">&nbsp;&nbsp;{{ $fit }} <br>
			@endforeach
		</div>
		<div class="well well-small">
			<h5>Still</h5>
			@foreach($occasionArray as $occasion)
			<input style="margin-top: -3px" type="checkbox" name="occasion[]" id="{{ $occasion }}" value="{{ $occasion }}">&nbsp;&nbsp;{{ $occasion }} <br>
			@endforeach
		</div>
	@endif
	<br/>
	<div class="thumbnail">
		<img src="{{ asset('images/front_images/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
		<div class="caption">
			<h5>Payment Methods</h5>
		</div>
	</div>
</div>