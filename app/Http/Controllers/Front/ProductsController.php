<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    Public function listing($url){
    	//check url exist or not
    	$categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
    	if($categoryCount>0){
    		//echo "Category exist"; die;
    		$categoryDetails = Category::catDetails($url);
    		//dd($categoryDetails); die;
            $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->get()->toArray();
            //echo "<pre>"; print_r($categoryDetails); 
            //echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
    	}else{
    		abort(404);
    	}
    }
}
