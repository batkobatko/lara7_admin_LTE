<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    Public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                //echo "Category exist"; die;
                $categoryDetails = Category::catDetails($url);
                //dd($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                // If Fabric filter is selected 
                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryProducts->whereIn('products.fabric',$data['fabric']);
                }

                // If Sleeve filter is selected 
                if(isset($data['sleeve']) && !empty($data['sleeve'])){
                    $categoryProducts->whereIn('products.sleeve',$data['sleeve']);
                }

                // If Sleeve filter is selected 
                if(isset($data['pattern']) && !empty($data['pattern'])){
                    $categoryProducts->whereIn('products.pattern',$data['pattern']);
                }

                // If Sleeve filter is selected 
                if(isset($data['fit']) && !empty($data['fit'])){
                    $categoryProducts->whereIn('products.fit',$data['fit']);
                }

                // If Sleeve filter is selected 
                if(isset($data['occasion']) && !empty($data['occasion'])){
                    $categoryProducts->whereIn('products.occasion',$data['occasion']);
                }

                // check if Sort option is selected 
               if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort']=="product_latest") {
                        $categoryProducts->orderBy('id','Desc');
                        //desc - descending order
                    }else if($data['sort']=="product_name_a_z") {
                        $categoryProducts->orderBy('product_name','Asc');
                    }else if($data['sort']=="product_name_z_a") {
                        $categoryProducts->orderBy('product_name','Desc');
                    }else if($data['sort']=="price_lowest") {
                        $categoryProducts->orderBy('product_price','Asc');
                    }else if($data['sort']=="price_highest") {
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }

                $categoryProducts = $categoryProducts->paginate(30); 

                //echo "<pre>"; print_r($categoryDetails); 
                //echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
           }

        }else{
            $url = Route::getFacadeRoot()->current()->uri();
        	//check url exist or not
        	$categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        	if($categoryCount>0){
        		//echo "Category exist"; die;
        		$categoryDetails = Category::catDetails($url);
        		//dd($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                // check if Sort option select by user
 /*               if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort ']=="product_latest") {
                        $categoryProducts->orderBy('id','Desc');
                        //desc - descending order
                    }else if($_GET['sort']=="product_name_a_z") {
                        $categoryProducts->orderBy('product_name','Asc');
                    }
                    else if($_GET['sort']=="product_name_z_a") {
                        $categoryProducts->orderBy('product_name','Desc');
                    }
                    else if($_GET['sort']=="price_lowest") {
                        $categoryProducts->orderBy('product_price','Asc');
                    }
                    else if($_GET['sort']=="price_highest") {
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }
*/              
                $categoryProducts = $categoryProducts->paginate(30); 

                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray  = $productFilters['occasionArray'];
                //echo "<pre>"; print_r($categoryDetails); 
                //echo "<pre>"; print_r($categoryProducts); die;

                $page_name = "listing";

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','page_name'));
        	}else{
        		abort(404);
    	   }
        }

    }
}
